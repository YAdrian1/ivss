<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear un nuevo Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Ruta base donde se encuentran las subcarpetas
    $baseDir = 'horarios/administracion';

    // Iterar a través de los directorios y archivos
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));

    foreach ($iterator as $file) {
        // Verificar si es un archivo Excel
        if ($file->isFile() && ($file->getExtension() === 'xlsx' || $file->getExtension() === 'xls')) {
            // Cargar el archivo Excel
            $spreadsheetTemp = IOFactory::load($file->getPathname());
            
            // Crear una nueva hoja en el archivo principal
            $newSheet = $spreadsheet->createSheet();
            
            // Obtener el nombre del archivo y truncarlo a 31 caracteres
            $sheetTitle = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            if (strlen($sheetTitle) > 31) {
                $sheetTitle = substr($sheetTitle, 0, 31);
            }
            
            $newSheet->setTitle($sheetTitle); // Usar el nombre del archivo como título de la hoja

            // Copiar los datos y estilos a la nueva hoja
            $sourceSheet = $spreadsheetTemp->getActiveSheet();
            $highestRow = $sourceSheet->getHighestRow();
            $highestColumn = $sourceSheet->getHighestColumn();

            for ($row = 1; $row <= $highestRow; $row++) {
                for ($col = 1; $col <= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); $col++) {
                    // Copiar valor
                    $cell = $sourceSheet->getCellByColumnAndRow($col, $row);
                    $newCell = $newSheet->getCellByColumnAndRow($col, $row);
                    $newCell->setValue($cell->getValue());

                    // Copiar estilos
                    $newStyle = $cell->getStyle();
                    $styleArray = [];

                    // Copiar fuentes
                    if ($newStyle->getFont()->getName()) {
                        $styleArray['font'] = [
                            'name' => $newStyle->getFont()->getName(),
                            'bold' => $newStyle->getFont()->getBold(),
                            'italic' => $newStyle->getFont()->getItalic(),
                            'underline' => $newStyle->getFont()->getUnderline(),
                            'size' => $newStyle->getFont()->getSize(),
                            'color' => ['argb' => $newStyle->getFont()->getColor()->getARGB()],
                        ];
                    }

                    // Copiar rellenos
                    if ($newStyle->getFill()->getFillType()) {
                        $styleArray['fill'] = [
                            'fillType' => $newStyle->getFill()->getFillType(),
                            'color' => ['argb' => $newStyle->getFill()->getStartColor()->getARGB()],
                        ];
                    }

                    // Copiar bordes
                    $borders = $newStyle->getBorders();
                    if ($borders) {
                        $borderStyles = [];
                        foreach (['top', 'bottom', 'left', 'right'] as $position) {
                            $border = $borders->{"get" . ucfirst($position)}();
                            if ($border && $border->getBorderStyle() !== null) {
                                $borderStyles[$position] = [
                                    'borderStyle' => $border->getBorderStyle(),
                                    'color' => ['argb' => $border->getColor()->getARGB()],
                                ];
                            }
                        }
                        if (!empty($borderStyles)) {
                            $styleArray['borders'] = $borderStyles;
                        }
                    }

                    // Copiar alineación
                    if ($newStyle->getAlignment()->getHorizontal()) {
                        $styleArray['alignment'] = [
                            'horizontal' => $newStyle->getAlignment()->getHorizontal(),
                            'vertical' => $newStyle->getAlignment()->getVertical(),
                        ];
                    }

                                      // Aplicar el estilo a la celda
                    if (!empty($styleArray)) {
                        $newSheet->getStyleByColumnAndRow($col, $row)->applyFromArray($styleArray);
                    }
                }
            }

            // Copiar celdas combinadas
            $mergedCells = $sourceSheet->getMergeCells();
            if ($mergedCells) {
                foreach ($mergedCells as $merge) {
                    // Verificar si el rango de celdas combinadas está dentro de los límites
                    $newSheet->mergeCells($merge);
                }
            }
        }
    }

    // Definir la ruta de salida
    $outputDir = 'Admhorarios'; // Cambiado a Admhorarios
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true); // Crea la carpeta si no existe
    }
    $outputFileName = $outputDir . '/Historias Medicas.xlsx';

    // Guardar el archivo combinado
    $writer = new Xlsx($spreadsheet);
    $writer->save($outputFileName);

    // Aquí se muestra la alerta y se redirige al usuario
    echo '<script>
            alert("Archivo generado en la parpeta compartida: ' . $outputFileName . '");
            window.location.href = "http://localhost/vistas/usuarios.php";
          </script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combinar Archivos Excel</title>
</head>
<body>
    <form method="post">
        <button type="submit">Combinar Archivos Excel</button>
    </form>
</body>
</html>