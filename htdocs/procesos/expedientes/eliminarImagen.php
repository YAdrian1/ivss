<?php
session_start();
require_once "../../clases/Conexion.php";

header('Content-Type: application/json');

// Función para loggear errores
function logError($message) {
    $logFile = '../../logs/imagen_errors.log';
    $logDir = dirname($logFile);
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, $logFile);
}

try {
    // Verificar autenticación
    if (!isset($_SESSION['usuario'])) {
        throw new Exception('Usuario no autenticado');
    }

    // Verificar ID de imagen
    if (!isset($_POST['id_imagen'])) {
        throw new Exception('ID de imagen no proporcionado');
    }

    $c = new conectar();
    $conexion = $c->conexion();
    $idImagen = mysqli_real_escape_string($conexion, $_POST['id_imagen']);

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        // Primero, obtener la información de la imagen
        $sql = "SELECT i.ruta, e.ruta_carpeta 
                FROM imagenes_expediente i 
                INNER JOIN expedientes e ON i.id_expediente = e.id 
                WHERE i.id = ?";
        
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idImagen);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Construir la ruta completa del archivo
            $rutaImagen = '../../expedientes/' . $row['ruta'];
            
            // Eliminar el registro de la base de datos
            $sqlDelete = "DELETE FROM imagenes_expediente WHERE id = ?";
            $stmtDelete = mysqli_prepare($conexion, $sqlDelete);
            mysqli_stmt_bind_param($stmtDelete, "i", $idImagen);
            
            if (!mysqli_stmt_execute($stmtDelete)) {
                throw new Exception('Error al eliminar la imagen de la base de datos');
            }

            // Verificar si se eliminó el registro
            if (mysqli_affected_rows($conexion) > 0) {
                // Si el archivo existe, intentar eliminarlo
                if (file_exists($rutaImagen)) {
                    if (!unlink($rutaImagen)) {
                        // Si no se puede eliminar el archivo, hacer rollback
                        throw new Exception('No se pudo eliminar el archivo físico');
                    }

                    // Verificar si la carpeta de la categoría está vacía
                    $dirCategoria = dirname($rutaImagen);
                    if (is_dir($dirCategoria) && count(glob("$dirCategoria/*")) === 0) {
                        // Si está vacía, eliminar la carpeta de la categoría
                        rmdir($dirCategoria);
                    }
                }

                // Si todo salió bien, hacer commit
                mysqli_commit($conexion);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Imagen eliminada correctamente'
                ]);
            } else {
                throw new Exception('No se encontró la imagen para eliminar');
            }
        } else {
            throw new Exception('Imagen no encontrada en la base de datos');
        }

    } catch (Exception $e) {
        mysqli_rollback($conexion);
        throw $e;
    }

} catch (Exception $e) {
    logError("Error en eliminarImagen.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
} finally {
    // Cerrar statements y conexión
    if (isset($stmt)) mysqli_stmt_close($stmt);
    if (isset($stmtDelete)) mysqli_stmt_close($stmtDelete);
    if (isset($conexion)) mysqli_close($conexion);
}
?>