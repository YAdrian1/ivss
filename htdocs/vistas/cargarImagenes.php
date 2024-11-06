<?php
session_start();
require_once "../../clases/Conexion.php";

if (!isset($_POST['id_expediente'])) {
    echo "Error: No se proporcionó ID del expediente";
    exit;
}

$c = new conectar();
$conexion = $c->conexion();
$idExpediente = mysqli_real_escape_string($conexion, $_POST['id_expediente']);

$sql = "SELECT id, ruta, nombre_original FROM imagenes_expediente WHERE id_expediente = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $idExpediente);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="row">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-4 img-container" id="imagen_' . $row['id'] . '">';
        echo '<img src="../expedientes/imagenes/' . $row['ruta'] . '" class="img-fluid" alt="' . htmlspecialchars($row['nombre_original']) . '">';
        echo '<button class="btn-eliminar" onclick="eliminarImagen(' . $row['id'] . ')">&times;</button>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p class="text-center">No hay imágenes disponibles para este expediente.</p>';
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>