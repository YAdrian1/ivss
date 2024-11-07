<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar X en Excel</title>
</head>
<body>
    <h2>Subir Archivo Excel y Agregar X</h2>
    <form action="modify.php" method="post" enctype="multipart/form-data">
        <label for="file">Selecciona tu archivo Excel:</label>
        <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
        <label for="cell">Celda donde agregar X (ej. A1):</label>
        <input type="text" name="cell" id="cell" required>
        <button type="submit">Agregar X</button>
    </form>
</body>
</html>