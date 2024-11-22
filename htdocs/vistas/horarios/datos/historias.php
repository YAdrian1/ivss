<?php
require '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$archivo = 'madre.xlsx';

// Definir las celdas que se pueden editar
$celdas = [
    // Fila 8
    'B8', 'C8', 'D8', 'E8', 'F8', 'G8', 'H8', 'I8', 'J8', 'K8', 'L8', 'M8', 'N8', 'O8', 'P8', 'Q8', 'R8', 'S8', 'T8', 'U8', 'V8', 'W8', 'X8', 'Y8', 'Z8', 'AA8', 'AB8', 'AC8', 'AD8', 'AE8', 'AF8',
    // Fila 9
    'B9', 'C9', 'D9', 'E9', 'F9', 'G9', 'H9', 'I9', 'J9', 'K9', 'L9', 'M9', 'N9', 'O9', 'P9', 'Q9', 'R9', 'S9', 'T9', 'U9', 'V9', 'W9', 'X9', 'Y9', 'Z9', 'AA9', 'AB9', 'AC9', 'AD9', 'AE9', 'AF9',
    // Fila 10
    'B10', 'C10', 'D10', 'E10', 'F10', 'G10', 'H10', 'I10', 'J10', 'K10', 'L10', 'M10', 'N10', 'O10', 'P10', 'Q10', 'R10', 'S10', 'T10', 'U10', 'V10', 'W10', 'X10', 'Y10', 'Z10', 'AA10', 'AB10', 'AC10', 'AD10', 'AE10', 'AF10',
    // Fila 11
    'B11', 'C11', 'D11', 'E11', 'F11', 'G11', 'H11', 'I11', 'J11', 'K11', 'L11', 'M11', 'N11', 'O11', 'P11', 'Q11', 'R11', 'S11', 'T11', 'U11', 'V11', 'W11', 'X11', 'Y11', 'Z11', 'AA11', 'AB11', 'AC11', 'AD11', 'AE11', 'AF11',
    // Fila 12
    'B12', 'C12', 'D12', 'E12', 'F12', 'G12', 'H12', 'I12', 'J12', 'K12', 'L12', 'M12', 'N12', 'O12', 'P12', 'Q12', 'R12', 'S12', 'T12', 'U12', 'V12', 'W12', 'X12', 'Y12', 'Z12', 'AA12', 'AB12', 'AC12', 'AD12', 'AE12', 'AF12',
    // Fila 13
    'B13', 'C13', 'D13', 'E13', 'F13', 'G13', 'H13', 'I13', 'J13', 'K13', 'L13', 'M13', 'N13', 'O13', 'P13', 'Q13', 'R13', 'S13', 'T13', 'U13', 'V13', 'W13', 'X13', 'Y13', 'Z13', 'AA13', 'AB13', 'AC13', 'AD13', 'AE13', 'AF13',
    // Fila 14
    'B14', 'C14', 'D14', 'E14', 'F14', 'G14', 'H14', 'I14', 'J14', 'K14', 'L14', 'M14', 'N14', 'O14', 'P14', 'Q14', 'R14', 'S14', 'T14', 'U14', 'V14', 'W14', 'X14', 'Y14', 'Z14', 'AA14', 'AB14', 'AC14', 'AD14', 'AE14', 'AF14',
    // Fila 15
   'B15', 'C15', 'D15', 'E15', 'F15', 'G15', 'H15', 'I15', 'J15', 'K15', 'L15', 'M15', 'N15', 'O15', 'P15', 'Q15', 'R15', 'S15', 'T15', 'U15', 'V15', 'W15', 'X15', 'Y15', 'Z15', 'AA15', 'AB15', 'AC15', 'AD15', 'AE15', 'AF15',
    // Fila 16
    'B16', 'C16', 'D16', 'E16', 'F16', 'G16', 'H16', 'I16', 'J16', 'K16', 'L16', 'M16', 'N16', 'O16', 'P16', 'Q16', 'R16', 'S16', 'T16', 'U16', 'V16', 'W16', 'X16', 'Y16', 'Z16', 'AA16', 'AB16', 'AC16', 'AD16', 'AE16', 'AF16',
    // Fila 17
    'B17', 'C17', 'D17', 'E17', 'F17', 'G17', 'H17', 'I17', 'J17', 'K17', 'L17', 'M17', 'N17', 'O17', 'P17', 'Q17', 'R17', 'S17', 'T17', 'U17', 'V17', 'W17', 'X17', 'Y17', 'Z17', 'AA17', 'AB17', 'AC17', 'AD17', 'AE17', 'AF17',
    // Fila 18
    'B18', 'C18', 'D18', 'E18', 'F18', 'G18', 'H18', 'I18', 'J18', 'K18', 'L18', 'M18', 'N18', 'O18', 'P18', 'Q18', 'R18', 'S18', 'T18', 'U18', 'V18', 'W18', 'X18', 'Y18', 'Z18', 'AA18', 'AB18', 'AC18', 'AD18', 'AE18', 'AF18',
    // Fila 19
    'B19', 'C19', 'D19', 'E19', 'F19', 'G19', 'H19', 'I19', 'J19', 'K19', 'L19', 'M19', 'N19', 'O19', 'P19', 'Q19', 'R19', 'S19', 'T19', 'U19', 'V19', 'W19', 'X19', 'Y19', 'Z19', 'AA19', 'AB19', 'AC19', 'AD19', 'AE19', 'AF19',
];

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cargar el archivo existente
    $spreadsheet = IOFactory::load($archivo);
    $sheet = $spreadsheet->getActiveSheet();

    foreach ($celdas as $celda) {
        if (isset($_POST[$celda])) {
            $sheet->setCellValue($celda, $_POST[$celda]);
        }
    }

    // Guardar el archivo modificado
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($archivo);
    
    echo "<div>Los cambios han sido guardados.</div>";
}

// Cargar el archivo existente
$spreadsheet = IOFactory::load($archivo);
$sheet = $spreadsheet->getActiveSheet();

// Mostrar el formulario
echo '<style>
    table {
        border-collapse: collapse;
        width: 80%;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
    input[type="text"] {
        width: 80%;
        padding: 5px;
        margin: 5px 0;
        box-sizing: border-box;
    }
</style>';

echo '<form method="post">';
echo '<table>';
echo '<tr>';
echo '<th>Mes</th>'; // Encabezado para los meses
for ($dia = 1; $dia <= 31; $dia++) {
    echo '<th>' . $dia . '</th>'; // Encabezados para los días
}
echo '</tr>';

$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

foreach ($meses as $index => $mes) {
    echo '<tr>';
    echo '<td>' . $mes . '</td>'; // Mostrar el nombre del mes
    for ($dia = 1; $dia <= 31; $dia++) {
        $celdaIndex = $index * 31 + ($dia - 1); // Calcular el índice de la celda
        if ($celdaIndex < count($celdas)) { // Verificar que el índice esté dentro del rango
            $celda = $celdas[$celdaIndex]; // Obtener la celda correspondiente
            $valor = $sheet->getCell($celda)->getValue();
            echo '<td>';
            echo '<input type="text" name="' . $celda . '" value="' . htmlspecialchars($valor) . '">';
            echo '</td>';
        } else {
            echo '<td></td>'; // Si no hay celda, dejar la celda vacía
        }
    }
    echo '</tr>';
}

echo '</table>';
echo '<input type="submit" value="Guardar cambios">';
echo '</form>';
?>



