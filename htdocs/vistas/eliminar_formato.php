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
                    // Crear una tabla temporal con los nuevos IDs
                    $sql_reorganize = "
                        CREATE TEMPORARY TABLE temp_ids AS
                        SELECT id, (@row_number:=@row_number + 1) AS new_id
                        FROM imagenes_subidas, (SELECT @row_number:=0) AS t
                        WHERE id_usuario = ?
                        ORDER BY id;
                    ";
                    
                    $stmt_temp = mysqli_prepare($conexion, $sql_reorganize);
                    mysqli_stmt_bind_param($stmt_temp, "i", $_SESSION['iduser']);
                    mysqli_stmt_execute($stmt_temp);

                    // Actualizar los IDs usando la tabla temporal
                    $sql_update = "
                        UPDATE imagenes_subidas i
                        INNER JOIN temp_ids t ON i.id = t.id
                        SET i.id = t.new_id
                        WHERE i.id_usuario = ?;
                    ";
                    
                    $stmt_update = mysqli_prepare($conexion, $sql_update);
                    mysqli_stmt_bind_param($stmt_update, "i", $_SESSION['iduser']);
                    mysqli_stmt_execute($stmt_update);

                    // Eliminar la tabla temporal
                    mysqli_query($conexion, "DROP TEMPORARY TABLE IF EXISTS temp_ids");

                    // Si existe, eliminar el archivo físico
                    $ruta_archivo = "../uploads/" . $nombre_archivo . "." . $extension;
                    $archivo_eliminado = true;

                    if (file_exists($ruta_archivo)) {
                        $archivo_eliminado = unlink($ruta_archivo);
                    }

                    if ($archivo_eliminado) {
                        mysqli_commit($conexion);
                        echo json_encode([
                            'success' => true,
                            'message' => 'Formato eliminado correctamente y IDs reorganizados',
                            'id' => $id_formato
                        ]);
                    } else {
                        throw new Exception("Error al eliminar el archivo físico");
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
        error_log("Error en eliminar_formato.php: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    // Cerrar statements
    if (isset($stmt_select)) mysqli_stmt_close($stmt_select);
    if (isset($stmt_delete)) mysqli_stmt_close($stmt_delete);
    if (isset($stmt_temp)) mysqli_stmt_close($stmt_temp);
    if (isset($stmt_update)) mysqli_stmt_close($stmt_update);

} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>