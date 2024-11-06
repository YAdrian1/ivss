<?php
session_start();
require_once "../../clases/Conexion.php";

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

if (!isset($_POST['id_imagen'])) {
    echo json_encode(['success' => false, 'message' => 'ID de imagen no proporcionado']);
    exit;
}

$c = new conectar();
$conexion = $c->conexion();
$idImagen = mysqli_real_escape_string($conexion, $_POST['id_imagen']);

// Primero, obtener la ruta de la imagen
$sql = "SELECT ruta FROM imagenes_expediente WHERE id = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $idImagen);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $rutaImagen = '../../expedientes/imagenes/' . $row['ruta'];
    
    // Eliminar el registro de la base de datos
    $sqlDelete = "DELETE FROM imagenes_expediente WHERE id = ?";
    $stmtDelete = mysqli_prepare($conexion, $sqlDelete);
    mysqli_stmt_bind_param($stmtDelete, "i", $idImagen);
    
    if (mysqli_stmt_execute($stmtDelete)) {
        // Si se eliminó correctamente de la base de datos, intentar eliminar el archivo físico
        if (file_exists($rutaImagen) && unlink($rutaImagen)) {
            echo json_encode(['success' => true, 'message' => 'Imagen eliminada correctamente']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Imagen eliminada de la base de datos, pero no se pudo eliminar el archivo físico']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la imagen de la base de datos']);
    }
    
    mysqli_stmt_close($stmtDelete);
} else {
    echo json_encode(['success' => false, 'message' => 'Imagen no encontrada']);
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);