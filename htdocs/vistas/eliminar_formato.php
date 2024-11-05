<?php
session_start();
require_once "../clases/Conexion.php";

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$c = new conectar();
$conexion = $c->conexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_formato = filter_input(INPUT_POST, 'id_formato', FILTER_VALIDATE_INT);

    if (!$id_formato) {
        echo json_encode(['success' => false, 'message' => 'ID de formato inválido']);
        exit;
    }

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        // Primero, obtener la información del archivo
        $sql_select = "SELECT nombre, extension FROM imagenes_subidas WHERE id = ? AND id_usuario = ?";
        $stmt_select = mysqli_prepare($conexion, $sql_select);
        mysqli_stmt_bind_param($stmt_select, "ii", $id_formato, $_SESSION['iduser']);
        mysqli_stmt_execute($stmt_select);
        $resultado = mysqli_stmt_get_result($stmt_select);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            $nombre_archivo = $fila['nombre'];
            $extension = $fila['extension'];

            // Eliminar el registro de la base de datos
            $sql_delete = "DELETE FROM imagenes_subidas WHERE id = ? AND id_usuario = ?";
            $stmt_delete = mysqli_prepare($conexion, $sql_delete);
            mysqli_stmt_bind_param($stmt_delete, "ii", $id_formato, $_SESSION['iduser']);
            
            if (mysqli_stmt_execute($stmt_delete)) {
                // Verificar si se eliminó realmente algún registro
                $affected_rows = mysqli_stmt_affected_rows($stmt_delete);
                
                if ($affected_rows > 0) {
                    // Si se eliminó correctamente de la base de datos, intentar eliminar el archivo físico
                    $ruta_archivo = "../uploads/" . $nombre_archivo . "." . $extension;
                    if (file_exists($ruta_archivo)) {
                        if (unlink($ruta_archivo)) {
                            mysqli_commit($conexion);
                            echo json_encode([
                                'success' => true, 
                                'message' => 'Formato eliminado correctamente', 
                                'id' => $id_formato
                            ]);
                        } else {
                            throw new Exception("No se pudo eliminar el archivo físico");
                        }
                    } else {
                        // Si el archivo no existe, aún consideramos exitosa la operación
                        mysqli_commit($conexion);
                        echo json_encode([
                            'success' => true, 
                            'message' => 'Formato eliminado de la base de datos', 
                            'id' => $id_formato
                        ]);
                    }
                } else {
                    throw new Exception("No se encontró el formato para eliminar");
                }
            } else {
                throw new Exception("Error al eliminar el registro de la base de datos");
            }
        } else {
            throw new Exception("No se encontró el formato especificado");
        }

    } catch (Exception $e) {
        mysqli_rollback($conexion);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    // Cerrar statements
    if (isset($stmt_select)) mysqli_stmt_close($stmt_select);
    if (isset($stmt_delete)) mysqli_stmt_close($stmt_delete);

} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>