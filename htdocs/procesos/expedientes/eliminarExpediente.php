<?php
session_start();
require_once "../../clases/Conexion.php";

header('Content-Type: application/json');

// Función para loggear errores
function logError($message) {
    $logFile = '../../logs/expediente_errors.log';
    $logDir = dirname($logFile);
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, $logFile);
}

// Función para eliminar un directorio y su contenido
function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    return rmdir($path);
}

try {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario'])) {
        throw new Exception("Usuario no autenticado");
    }

    // Verificar si se recibió el ID del expediente
    if (!isset($_POST['id_expediente'])) {
        throw new Exception("ID de expediente no proporcionado");
    }

    $c = new conectar();
    $conexion = $c->conexion();

    $idExpediente = mysqli_real_escape_string($conexion, $_POST['id_expediente']);

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        // Obtener la ruta de la carpeta del expediente
        $sqlGetExpediente = "SELECT ruta_carpeta FROM expedientes WHERE id = ?";
        $stmtGetExpediente = mysqli_prepare($conexion, $sqlGetExpediente);
        mysqli_stmt_bind_param($stmtGetExpediente, "i", $idExpediente);
        mysqli_stmt_execute($stmtGetExpediente);
        $resultExpediente = mysqli_stmt_get_result($stmtGetExpediente);
        $expediente = mysqli_fetch_assoc($resultExpediente);

        if (!$expediente) {
            throw new Exception("No se encontró el expediente para eliminar");
        }

        $rutaCarpeta = '../../expedientes/' . $expediente['ruta_carpeta'];

        // Eliminar el expediente de la base de datos
        $sqlDeleteExpediente = "DELETE FROM expedientes WHERE id = ?";
        $stmtDeleteExpediente = mysqli_prepare($conexion, $sqlDeleteExpediente);
        mysqli_stmt_bind_param($stmtDeleteExpediente, "i", $idExpediente);
        
        if (!mysqli_stmt_execute($stmtDeleteExpediente)) {
            throw new Exception("Error al eliminar el expediente de la base de datos");
        }

        $affectedRows = mysqli_affected_rows($conexion);

        if ($affectedRows > 0) {
            // Si se eliminó el registro, intentar eliminar la carpeta física
            if (file_exists($rutaCarpeta)) {
                if (!removeDirectory($rutaCarpeta)) {
                    // Si no se puede eliminar la carpeta, hacer rollback y lanzar excepción
                    mysqli_rollback($conexion);
                    throw new Exception("No se pudo eliminar la carpeta del expediente");
                }
            }

            // Si todo salió bien, hacer commit
            mysqli_commit($conexion);
            echo json_encode(['success' => true, 'message' => 'Expediente eliminado correctamente']);
        } else {
            // Si no se afectaron filas, el expediente no existía en la base de datos
            mysqli_rollback($conexion);
            throw new Exception("No se encontró el expediente para eliminar en la base de datos");
        }

    } catch (Exception $e) {
        // Si hay error, hacer rollback
        mysqli_rollback($conexion);
        throw $e;
    }

} catch (Exception $e) {
    logError("Error en eliminarExpediente.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Cerrar statements y conexión
    if (isset($stmtGetExpediente)) mysqli_stmt_close($stmtGetExpediente);
    if (isset($stmtDeleteExpediente)) mysqli_stmt_close($stmtDeleteExpediente);
    if (isset($conexion)) mysqli_close($conexion);
}
?>