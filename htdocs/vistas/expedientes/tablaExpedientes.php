<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id, nombre, apellido FROM expedientes ORDER BY apellido, nombre";
$result = mysqli_query($conexion, $sql);
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_array($result)): ?>
        <tr>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['apellido']; ?></td>
            <td>
                <button class="btn btn-primary btn-sm" onclick="abrirModalImagenes(<?php echo $row['id']; ?>)">
                    <i class="fas fa-images"></i> Imágenes
                </button>
                <button class="btn btn-danger btn-sm" onclick="eliminarExpediente(<?php echo $row['id']; ?>)">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>