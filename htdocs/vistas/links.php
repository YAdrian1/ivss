<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botones de Enlace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }
        .button-container {
            display: flex;
            flex-wrap: wrap; /* Permite que los botones se ajusten a la siguiente línea si no hay suficiente espacio */
            justify-content: center; /* Centra los botones horizontalmente */
        }
        button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Botones de Enlace</h1>
    <div class="button-container">
        <button onclick="window.location.href='#';">Botón 1</button>
        <button onclick="window.location.href='#';">Botón 2</button>
        <button onclick="window.location.href='#';">Botón 3</button>
        <button onclick="window.location.href='#';">Botón 4</button>
        <button onclick="window.location.href='#';">Botón 5</button>
        <button onclick="window.location.href='#';">Botón 6</button>
        <button onclick="window.location.href='#';">Botón 7</button>
        <button onclick="window.location.href='#';">Botón 8</button>
        <button onclick="window.location.href='#';">Botón 9</button>
        <button onclick="window.location.href='#';">Botón 10</button>
    </div>
</body>
</html>