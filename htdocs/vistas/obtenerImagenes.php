<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$id_expediente = $_POST['id_expediente'];

$sql = "SELECT id, ruta FROM imagenes_expediente WHERE id_expediente = '$id_expediente'";
$result = mysqli_query($conexion, $sql);

$imagenes = [];
while($row = mysqli_fetch_assoc($result)){
    $imagenes[] = $row;
}

echo json_encode(['success' => true, 'imagenes' => $imagenes]);