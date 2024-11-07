<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data'])) {
    $data = $_POST['data'];
    $filename = $_POST['filename'];

    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Llenar el objeto Spreadsheet con los datos editados
    foreach ($data as $rowIndex => $row) {
        foreach ($row as $colIndex => $cell) {
            $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $cell);
        }
    }

    // Guardar el archivo Excel
    $writer = new Xlsx($spreadsheet);
    $writer->save('uploads/' . $filename); // A