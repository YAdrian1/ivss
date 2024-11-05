<?php
session_start();
require_once "../../clases/Conexion.php";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Verificar si se recibió el ID del expediente
if (!isset($_POST['id_expediente'])) {
    echo json_encode(['success' => false, 'message' => 'ID de expediente no proporcionado']);
    exit;
}

$c = new conectar();
$conexion = $c->conexion();

// Obtener y validar el ID del expediente
$id_expediente = filter_var($_POST['id_expediente'], FILTER_VALIDATE_INT);
if ($id_expediente === false) {
    echo json_encode(['success' => false, 'message' => 'ID de expediente inválido']);
    exit;
}

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {
    // Primero, obtener las rutas de las imágenes asociadas
    $sql_imagenes = "SELECT ruta_imagen FROM imagenes_expediente WHERE id_expediente = ?";
    $stmt_imagenes = mysqli_prepare($conexion, $sql_imagenes);
    mysqli_stmt_bind_param($stmt_imagenes, "i", $id_expediente);
    mysqli_stmt_execute($stmt_imagenes);
    $resultado_imagenes = mysqli_stmt_get_result($stmt_imagenes);
    
    // Array para almacenar las rutas de las imágenes
    $rutas_imagenes = [];
    while ($row = mysqli_fetch_assoc($resultado_imagenes)) {
        $rutas_imagenes[] = $row['ruta_imagen'];
    }

    // Eliminar registros de imágenes de la base de datos
    $sql_delete_imagenes = "DELETE FROM imagenes_expediente WHERE id_expediente = ?";
    $stmt_delete_imagenes = mysqli_prepare($conexion, $sql_delete_imagenes);
    mysqli_stmt_bind_param($stmt_delete_imagenes, "i", $id_expediente);
    mysqli_stmt_execute($stmt_delete_imagenes);

    // Eliminar el expediente
    $sql_delete_expediente = "DELETE FROM expedientes WHERE id_expediente = ? AND id_usuario = ?";
    $stmt_delete_expediente = mysqli_prepare($conexion, $sql_delete_expediente);
    mysqli_stmt_bind_param($stmt_delete_expediente, "ii", $id_expediente, $_SESSION['iduser']);
    mysqli_stmt_execute($stmt_delete_expediente);

    // Verificar si se eliminó el expediente
    if (mysqli_stmt_affected_rows($stmt_delete_expediente) > 0) {
        // Eliminar archivos físicos de imágenes
        foreach ($rutas_imagenes as $ruta) {
            $ruta_completa = "../../uploads/expedientes/" . $ruta;
            if (file_exists($ruta_completa)) {
                unlink($ruta_completa);
            }
        }

        // Confirmar transacción
        mysqli_commit($conexion);
        echo json_encode(['success' => true, 'message' => 'Expediente eliminado correctamente']);
    } else {
        throw new Exception("No se encontró el expediente o no tiene permisos para eliminarlo");
    }

} catch (Exception $e) {
    // Revertir cambios en caso de error
    mysqli_rollback($conexion);
    error_log("Error en eliminarExpediente.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Cerrar statements
    if (isset($stmt_imagenes)) mysqli_stmt_close($stmt_imagenes);
    if (isset($stmt_delete_imagenes)) mysqli_stmt_close($stmt_delete_imagenes);
    if (isset($stmt_delete_expediente)) mysqli_stmt_close($stmt_delete_expediente);
    
    // Cerrar conexión
    mysqli_close($conexion);
}
?>