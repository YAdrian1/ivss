<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$id_expediente = $_POST['id_expediente'];
$imagen = $_FILES['imagen'];

$nombre_imagen = uniqid() . '_' . $imagen['name'];
$ruta = '../../expedientes/imagenes/' . $nombre_imagen;

if(move_uploaded_file($imagen['tmp_name'], $ruta)){
    $sql = "INSERT INTO imagenes_expediente (id_expediente, ruta) VALUES ('$id_expediente', '$nombre_imagen')";
    if(mysqli_query($conexion, $sql)){
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error al subir la imagen']);
}