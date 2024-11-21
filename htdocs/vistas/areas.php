<?php
require_once "../clases/Conexion.php"; // Asegúrate de que esta ruta es correcta
$obj = new conectar();
$conexion = $obj->conexion();

// Asegúrate de que la conexión fue exitosa
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta SQL para obtener todas las áreas
$sql = "SELECT * FROM areas";
$result = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Obtener el número de filas
$num_rows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas</title>
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/index.css"> <!-- Enlace a tu archivo CSS -->
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Lista de Áreas</h1>

    <?php if ($num_rows > 0): ?>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th> <!-- Solo mantener la columna de acciones -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td>
    <a href="#" class="icon-button" onclick="alert('Funcionalidad no implementada');">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</td>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No se encontraron áreas.</p>
    <?php endif; ?>
</div>

<script src="librerias/jquery-3.2.1.min.js"></script>
<script src="librerias/bootstrap/js/bootstrap.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>