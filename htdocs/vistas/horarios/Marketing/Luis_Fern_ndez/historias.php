<?php
require '../../../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

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

// Colores asociados a los valores
$colores = [
    'D/L' => 'ffffff', // Verde claro
    'FER' => 'f95251', // Rojo
    'VAC' => 'c9bdd6', // Morado
    'PER' => 'f9d1b2', // Color claro
    'RM' => 'bdd298', // Verde oscuro
    'PC' => '0caeef', // Azul oscuro
     'LC' => '66fe97', // Verde claro
    'LDT' => 'b0afa6', // Rojo
    'lDTH' => '10f9f9', // Morado
    'Prad' => 'c7e7fa', // Color claro
    'DTS' => 'd4fe5b', // Verde oscuro
    'DM' => 'f9f9f9', // Azul oscuro
     'Denf' => 'f9c600', // Verde claro
    'DHD' => 'dba2a0', // Rojo
    'DO' => 'ffffff', // Morado
    'INAS' => '73f290', // Color claro
    'CM' => 'd59291', // Verde oscuro
    'AE' => 'ffffff', // Azul oscuro
];

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spreadsheet = IOFactory::load($archivo);
    $sheet = $spreadsheet->getActiveSheet();

    foreach ($celdas as $celda) {
        if (isset($_POST[$celda])) {
            $valor = $_POST[$celda];

            // Establecer el valor en la celda
            $sheet->setCellValue($celda, $valor);
            
                       // Establecer el color de fondo de la celda
            if (array_key_exists($valor, $colores)) {
                $color = $colores[$valor]; // Obtener el color asociado al valor
                $sheet->getStyle($celda)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $sheet->getStyle($celda)->getFill()->getStartColor()->setARGB($color); // Aplicar el color
            }
        }
    }

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($archivo);
}

// Cargar el archivo existente
$spreadsheet = IOFactory::load($archivo);
$sheet = $spreadsheet->getActiveSheet();

// Obtener el nombre de la carpeta actual
$carpetaActual = basename(__DIR__);

// Mostrar el formulario
echo '<style>
    table { border-collapse: collapse; width: 95%; margin-top: 10vh; margin-left:2.5%;}
    th, td { border: 1px solid black; text-align: center; width: 40px; height: 2vh; } 
    th { background-color: #f2f2f2; }
    tr:hover { background-color: #f1f1f1; }
    .editable-cell { cursor: pointer; }
    .selected { background-color: #d1e7dd; }
    .month-cell { height: 34px; }
</style>';

echo '<form method="post">';
echo '<table id="dataTable">';
echo '<tr>';
echo '<th>Mes</th>'; // Encabezado para los meses
for ($dia = 1; $dia <= 31; $dia++) {
    echo '<th>' . $dia . '</th>'; // Encabezados para los días
}
echo '</tr>';

$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

foreach ($meses as $index => $mes) {
    echo '<tr>';
    echo '<td class="month-cell">' . $mes . '</td>'; // Mostrar el nombre del mes
    for ($dia = 1; $dia <= 31; $dia++) {
        $celdaIndex = $index * 31 + ($dia - 1);
        if ($celdaIndex < count($celdas)) {
            $celda = $celdas[$celdaIndex];
            $valor = $sheet->getCell($celda)->getValue();
            $color = ''; // Inicializa el color

            // Solo permite hacer clic si la celda está vacía
            if (empty($valor)) {
                echo '<td class="editable-cell" onclick="toggleCell(this)" title="Haz clic para seleccionar">';
                echo '<span>' . htmlspecialchars($valor) . '</span>'; // Mostrar el valor
                echo '<input type="hidden" name="' . $celda . '" value="' . htmlspecialchars($valor) . '">'; // Campo oculto
                echo '</td>';
            } else {
                // Si la celda no está vacía, muestra el valor y el color
                $color = $sheet->getStyle($celda)->getFill()->getStartColor()->getARGB(); // Obtener el color de la celda
                echo '<td class="non-editable-cell" style="background-color: #' . substr($color, 2) . ';" title="Celda no editable">'; // Establecer el color de fondo
                echo '<span>' . htmlspecialchars($valor) . '</span>'; // Mostrar el valor
                echo '</td>';
            }
        } else {
            echo '<td></td>';
        }
    }
    echo '</tr>';
}
echo '</table>';

echo '</form>';

// Cuadro para mostrar el nombre de la carpeta actual
echo '<div style="position: absolute; top: 1vh; right: 80vh; font-size: 18px; padding: 10px; margin-top: 20px; margin-bottom: 20px; border: 1px solid #ddd; background-color: #f9f9f9;">';
echo ' ' . htmlspecialchars($carpetaActual);
echo '</div>';

?>

<div id="cuadroDiv" style="position: fixed; top: 78vh; left: 0; right: 0; background-color: white; padding: 20px; display: flex; flex-wrap: wrap; justify-content: center;">
    <div style="text-align: center; display: flex; flex-direction: column; align-items: center; width: 30%;">
  <div style="position: fixed; left: 4vh; margin-top: 12vh;">
    <a href="http://localhost/vistas/areas.php" style="text-decoration: none;">
        <button style="
            padding: 10px 13px; /* Espaciado interno */
            border-radius: 50%; /* Botón redondeado */
            background-color: #007bff; /* Color de fondo */
            color: white; /* Color del texto */
            border: none; /* Sin borde */
            cursor: pointer; /* Cursor de puntero */
            transition: background-color 0.3s; /* Transición suave para el color de fondo */
        " onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">
            <i class="fas fa-chevron-left" style="font-size: 20px;"></i> <!-- Icono de flecha hacia la izquierda -->
        </button>
    </a>
</div>

<!-- Asegúrate de incluir Font Awesome en tu <head> si aún no lo has hecho -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
          <button onclick="copyAndSubmit('D/L', '#ffffff')"  style="background-color: #ffffff; color: black; border: 1px solid black; width: 100px; height: 20px; margin-left: 30%;">D/L</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día Laborado</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('FER', '#f95251')" style="background-color:#f95251; color: black; border: 1px solid black; width: 42px; height: 20px; margin-left: 15%;">FER</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Feriado</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('VAC', '#c9bdd6')" style="margin-left: 25%;background-color: #c9bdd6; color: black; border: 1px solid black; width: 80px;  height: 20px; ">VAC</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Vacaciones</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('PER', '#f9d1b2')" style="margin-left: 17%;background-color:#f9d1b2; color: black; border: 1px solid black; width: 41px; height: 20px;">PER</button>
            <span  style="color: black; margin-left: 5px; white-space: nowrap;">Permiso</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('RM', '#bdd298')" style="margin-left: 32%; background-color: #bdd298; color: black; border: 1px solid black; width: 108px; height: 20px; color: black;">RM</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Reposo Medico</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('PC', '#0caeef')" style="margin-left: 39%;background-color: #0caeef; color: black; border: 1px solid black; width: 180px; height: 20px;color: black;">PC</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Permiso por cuido familiar</span>
        </div>
    </div>
    
    <div style="text-align: center; display: flex; flex-direction: column; align-items: center; width: 30%;">
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
                       <button onclick="copyAndSubmit('LC', '#66fe97')" style="background-color: #66fe97; color: black; border: 1px solid black; width: 40px; height: 20px;">LC</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Libre por Cumpleaños</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('LDT', '#b0afa6')" style="margin-left: 20%;background-color:#b0afa6; color: black; border: 1px solid black; width: 102px; height: 20px;">LDT</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Libre día del Técnico Radiólogo</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('lDTH', '#10f9f9')" style="margin-left: 36.5%;background-color: #10f9f9; color: black; border: 1px solid black; width: 50px; height: 20px;">LDTH</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Libre día del Técnico Historias Médicas</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  onclick="copyAndSubmit('Prad', '#c7e7fa')" style="margin-left: -6%;background-color: #c7e7fa; color: black; border: 1px solid black; width: 38px; height: 20px;">Prad</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Permiso Radiólogico</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  onclick="copyAndSubmit('DTS', '#d4fe5b')" style="margin-left: 9%;background-color: #d4fe5b; color: black; border: 1px solid black; width: 60px; height: 20px;">DTS</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día del Trabajador Social</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  onclick="copyAndSubmit('DM', '#f9f9f9')"style="margin-left: -31%;background-color: #f9f9f9; color: black; border: 1px solid black; width: 39px; height: 20px;">DM</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día del Médico</span>
        </div>
    </div>

    <div style="text-align: center; display: flex; flex-direction: column; align-items: center; width: 30%;">
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('Denf', '#f9c600')" style="background-color: #f9c600; color: black; border: 1px solid black; width: 40px; height: 20px;">Denf</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día de la Enfermera</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('DHD', '#dba2a0')" style="margin-left: 17%;background-color: #dba2a0; color: black; border: 1px solid black; width: 85px; height: 20px;">DHD</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día de la Higienista Dental</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('DO', '#ffffff')" style="margin-left: -1%;background-color: #ffffff; color: black; border: 1px solid black; width: 40px; height: 20px;">DO</button>
                       <span style="color: black; margin-left: 5px; white-space: nowrap;">Día del Odontólogo</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('INAS', '#73f290')" style="margin-left: -45%;background-color: #73f290; color: black; border: 1px solid black; width: 40px; height: 20px;">INAS</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Inasistencia</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('CM', '#d59291')" style="margin-left: -4%;background-color: #d59291; color: black; border: 1px solid black; width: 40px; height: 20px;">CM</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Constancia Médica</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button onclick="copyAndSubmit('AE', '#ffffff')" style="background-color: #ffffff; color: black; border: 1px solid black; width: 40px; height: 20px; margin-left: 0.7vh;">AE</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Asistencia Educativa</span>
        </div>
    </div>
</div>

<script>
function toggleCell(cell) {
    // Cambiar el estado de selección de la celda
    if (cell.classList.contains('selected')) {
        cell.classList.remove('selected');
    } else {
        cell.classList.add('selected');
    }
}

function copyAndSubmit(value, color) {
    // Encuentra la celda seleccionada
    const selectedCells = document.querySelectorAll('.selected');
    selectedCells.forEach(cell => {
        // Establecer el valor en el campo oculto
        const input = cell.querySelector('input[type="hidden"]');
        if (input) {
            input.value = value; // Asigna el valor al input oculto
        }

        // Cambiar el color de fondo de la celda
        cell.style.backgroundColor = color;
    });

    // Enviar el formulario
    document.forms[0].submit();
}
</script>