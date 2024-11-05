<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$id_imagen = $_POST['id_imagen'];

$sql = "SELECT ruta FROM imagenes_expediente WHERE id = '$id_imagen'";
$result = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($result);

if($row){
    $ruta_imagen = '../../expedientes/imagenes/' . $row['ruta'];
    if(file_exists($ruta_imagen)){
        unlink($ruta_imagen);
    }

    $sql_delete = "DELETE FROM imagenes_expediente WHERE id = '$id_imagen'";
    if(mysqli_query($conexion, $sql_delete)){
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Imagen no encontrada']);
}