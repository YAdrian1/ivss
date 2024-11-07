<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['file'])) {
    $file = 'uploads/' . $_POST['file'];

    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Mostrar los datos en un formulario HTML
    echo '<h1>Editar Datos del Archivo Excel</h1>';
    echo '<form action="save.php" method="post">';
    echo '<table border="1">';
    foreach ($sheetData as $rowIndex => $row) {
        echo '<tr>';
        foreach ($row as $colIndex => $cell) {
            echo '<td><input type="text" name="data[' . $rowIndex . '][' . $colIndex . ']" value="' . htmlspecialchars($cell) . '"></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '<input type="hidden" name="filename" value="' . htmlspecialchars($_POST['file']) . '">';
    echo '<input type="submit" value="Guardar Cambios">';
    echo '</form>';
} else {
    echo 'No se ha cargado ningún archivo.';
}
?>