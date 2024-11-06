<?php
session_start();
require_once "../../clases/Conexion.php";

try {
    $c = new conectar();
    $conexion = $c->conexion();

    // Validar que los datos no estén vacíos
    if(empty($_POST['nombre']) || empty($_POST['apellido'])) {
        throw new Exception("Datos incompletos");
    }

    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);

    $sql = "INSERT INTO expedientes (nombre, apellido) VALUES ('$nombre', '$apellido')";
    
    $resultado = mysqli_query($conexion, $sql);
    
    if($resultado) {
        echo 1;
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }

} catch(Exception $e) {
    error_log("Error en agregarExpediente.php: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
}
?>