<?php
session_start();
require_once "../../clases/Conexion.php";

header('Content-Type: application/json');

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
        // Primero, obtener las rutas de las imágenes
        $sqlGetImagenes = "SELECT ruta FROM imagenes_expediente WHERE id_expediente = ?";
        $stmtGetImagenes = mysqli_prepare($conexion, $sqlGetImagenes);
        mysqli_stmt_bind_param($stmtGetImagenes, "i", $idExpediente);
        mysqli_stmt_execute($stmtGetImagenes);
        $resultImagenes = mysqli_stmt_get_result($stmtGetImagenes);

        // Eliminar los archivos físicos
        while ($row = mysqli_fetch_assoc($resultImagenes)) {
            $rutaArchivo = '../../expedientes/imagenes/' . $row['ruta'];
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
        }

        // Eliminar el expediente (esto eliminará automáticamente las imágenes en la BD debido a ON DELETE CASCADE)
        $sqlDeleteExpediente = "DELETE FROM expedientes WHERE id = ?";
        $stmtDeleteExpediente = mysqli_prepare($conexion, $sqlDeleteExpediente);
        mysqli_stmt_bind_param($stmtDeleteExpediente, "i", $idExpediente);
        
        if (!mysqli_stmt_execute($stmtDeleteExpediente)) {
            throw new Exception("Error al eliminar el expediente");
        }

        $affectedRows = mysqli_affected_rows($conexion);

        if ($affectedRows > 0) {
            // Si se afectaron filas, el expediente se eliminó correctamente
            mysqli_commit($conexion);
            echo json_encode(['success' => true, 'message' => 'Expediente eliminado correctamente']);
        } else {
            // Si no se afectaron filas, el expediente no existía
            throw new Exception("No se encontró el expediente para eliminar");
        }

    } catch (Exception $e) {
        // Si hay error, hacer rollback
        mysqli_rollback($conexion);
        throw $e;
    }

} catch (Exception $e) {
    error_log("Error en eliminarExpediente.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Cerrar statements y conexión
    if (isset($stmtGetImagenes)) mysqli_stmt_close($stmtGetImagenes);
    if (isset($stmtDeleteExpediente)) mysqli_stmt_close($stmtDeleteExpediente);
    if (isset($conexion)) mysqli_close($conexion);
}
?>