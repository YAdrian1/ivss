<?php
session_start();
require_once "../../clases/Conexion.php";

if (!isset($_SESSION['usuario'])) {
    echo 0;
    exit();
}

$c = new conectar();
$conexion = $c->conexion();

$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
$id_usuario = $_SESSION['iduser'];

$sql = "INSERT INTO expedientes (nombre, apellido, id_usuario) 
        VALUES ('$nombre', '$apellido', '$id_usuario')";

if(mysqli_query($conexion, $sql)){
    echo 1; // Éxito
} else {
    echo 0; // Error
    // Para depuración, puedes usar:
    // echo mysqli_error($conexion);
}

mysqli_close($conexion);
?>