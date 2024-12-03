<?php
require_once "Conexion.php"; // Ruta correcta

$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id, nombre FROM areas"; // Cambia esto según tu estructura de base de datos
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion)); // Muestra el error
}
?>

<table class="table table-hover table-condensed table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre del Área</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>