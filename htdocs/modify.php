<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se ha subido un archivo
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        $fileType = $_FILES['file']['type'];

        // Validar el tipo de archivo
        if (in_array($fileType, $allowedTypes)) {
            $targetPath = 'uploads/' . basename($_FILES['file']['name']);
            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                // Cargar el archivo Excel
                $spreadsheet = IOFactory::load($targetPath);

                // Obtener la celda donde se agregará la "X"
                $cell = strtoupper(trim($_POST['cell'])); // Asegurarse de que la celda esté en mayúsculas

                // Agregar "X" en la celda especificada
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue($cell, 'X');

                // Guardar el archivo modificado
                $writer = new Xlsx($spreadsheet);
                $writer->save($targetPath);

                echo "Se ha agregado una 'X' en la celda $cell correctamente.";
            } else {
                echo "Hubo un error al subir el archivo.";
            }
        } else {
            echo "Tipo de archivo no permitido. Solo se permiten archivos Excel.";
        }
    } else {
        echo "No se ha subido ningún archivo o hubo un error en la carga.";
    }
}
?>