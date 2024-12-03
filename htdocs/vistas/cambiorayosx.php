<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baseDir = 'horarios/RayosX';

    if (isset($_POST['renameToFolder'])) {
        // Renombrar archivos a nombre de la carpeta
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));

        foreach ($iterator as $file) {
            // Verificar si es un archivo Excel
            if ($file->isFile() && ($file->getExtension() === 'xlsx' || $file->getExtension() === 'xls')) {
                // Obtener el nombre de la carpeta padre
                $parentDir = $file->getPathInfo()->getFilename();
                $newFileName = $parentDir . '.' . $file->getExtension();

                // Cambiar el nombre del archivo
                $newFilePath = $file->getPath() . DIRECTORY_SEPARATOR . $newFileName;
                rename($file->getPathname(), $newFilePath);
            }
        }
        echo "Los archivos han sido renombrados exitosamente a sus nombres de carpeta.";
    } elseif (isset($_POST['renameToMadre'])) {
        // Renombrar todos los archivos a "madre"
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));

        foreach ($iterator as $file) {
            // Verificar si es un archivo Excel
            if ($file->isFile() && ($file->getExtension() === 'xlsx' || $file->getExtension() === 'xls')) {
                $newFileName = 'madre.' . $file->getExtension();

                // Cambiar el nombre del archivo
                $newFilePath = $file->getPath() . DIRECTORY_SEPARATOR . $newFileName;
                rename($file->getPathname(), $newFilePath);
            }
        }
        echo "Los archivos han sido renombrados exitosamente a 'madre'.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renombrar Archivos Excel</title>
    <style>

        body {

            font-family: Arial, sans-serif;

            text-align: center; /* Centra el texto del body */

            margin: 20px; /* Margen alrededor del cuerpo */

        }

        .container {

            display: flex;

            justify-content: center; /* Centra el contenido horizontalmente */

            align-items: center; /* Centra el contenido verticalmente */

            flex-direction: column; /* Coloca los elementos en columna */

            height: 100vh; /* Altura completa de la ventana */

        }

        .text {

            margin: 10px 0; /* Espacio vertical entre los textos */

        }

        .button-container {

            margin-bottom: 20px; /* Espacio inferior para los botones */

        }

        .box {

            border: 1px solid #ccc; /* Borde del cuadro */

            border-radius: 5px; /* Bordes redondeados */

            padding: 20px; /* Espaciado interno */

            background-color: #f9f9f9; /* Color de fondo */

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra del cuadro */

            display: flex; /* Usar flexbox para alinear elementos */

            justify-content: center; /* Centra horizontalmente los elementos */

            align-items: center; /* Centra verticalmente los elementos */

        }

        .vertical-line {

            width: 2px; /* Ancho de la línea vertical */

            background-color: #ccc; /* Color de la línea */

            height: 100px; /* Altura de la línea */

            margin: 0 20px; /* Margen horizontal alrededor de la línea */

        }

        .button-text-pair {

            display: flex;

            flex-direction: column; /* Coloca el botón y el texto uno encima del otro */

            align-items: center; /* Centra los elementos horizontalmente */

        }

        .additional-info {

            background-color: #e9ecef; /* Color de fondo del div adicional */

            padding: 10px; /* Espaciado interno */

            border-radius: 5px; /* Bordes redondeados */

            margin-top: 20px; /* Espacio superior */

        }

    </style>
</head>
<body>
    <div class="box">
        <div class="button-text-pair">
            <form method="post">
                <button type="submit" name="renameToFolder">Renombrar Archivos Excel al Nombre del Trabajador</button>
            </form>
            <div class="text">Colocar Nombre del Personal a los arhivos Excel</div>
        </div>

        <div class="vertical-line"></div> <!-- Línea vertical -->

        <div class="button-text-pair">
            <form method="post">
                <button type="submit" name="renameToMadre">Renombrar Todos los Archivos a "madre"</button>
            </form>
            <div class="text">Colocar el Nombre que usa el Sistema</div>
        </div>
    </div>

    <div class="additional-info">
      Siempre al descargar el archivo primero "Colocar Nombre del Personal a los arhivos Excel" y luego "Colocar el Nombre que usa el Sistema" para que el Sistema puedo funcionar con normalidad , Solo hay que usar el primer boton 1 vez y luego el segundo con eso ya tendrias el archivo excel en la carpeta compartida lista para ser editada     :)
    </div>
</body>
</html>