<?php
session_start();
header('Content-Type: application/json');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

// Conectar a la base de datos
require_once "../clases/Conexion.php"; // Asegúrate de que esta ruta es correcta
$c = new conectar();
$conexion = $c->conexion();

// Obtener datos del POST
$areas = $_POST['areas']; // Ahora es un array de áreas

// Ruta base donde se crearán las carpetas
$rutaBase = 'C:\\xampp\\htdocs\\vistas\\horarios\\'; // Ruta base
$rutaArchivos = $rutaBase . 'datos\\'; // Ruta donde están los archivos a copiar

$errores = []; // Array para almacenar errores
$mensajes = []; // Array para almacenar mensajes de éxito

foreach ($areas as $area) {
    $areaId = $area['id'];
    $areaNombre = $area['nombre'];
    $rutaCarpeta = $rutaBase . $areaNombre;

    // Crear la carpeta del área si no existe
    if (!file_exists($rutaCarpeta)) {
        if (mkdir($rutaCarpeta, 0777, true)) {
            $mensajes[] = "Carpeta '$areaNombre' creada exitosamente.";
        } else {
            $errores[] = "Error al crear la carpeta '$areaNombre'.";
        }
    } else {
        $mensajes[] = "La carpeta '$areaNombre' ya existe.";
    }

    // Consulta para obtener el personal de esta área
    $sqlPersonal = "SELECT nombre FROM personal WHERE area_id = ?";
    $stmt = mysqli_prepare($conexion, $sqlPersonal);
    mysqli_stmt_bind_param($stmt, "i", $areaId);
    mysqli_stmt_execute($stmt);
    $resultPersonal = mysqli_stmt_get_result($stmt);

    // Crear carpetas para cada miembro del personal
    while ($row = mysqli_fetch_assoc($resultPersonal)) {
        $personalNombre = preg_replace('/[^A-Za-z0-9_\-]/', '_', $row['nombre']); // Sanitizar nombre
        $rutaPersonal = $rutaCarpeta . '\\' . $personalNombre; // Ruta para la carpeta del personal

        // Crear la carpeta del personal si no existe
        if (!file_exists($rutaPersonal)) {
            if (mkdir($rutaPersonal, 0777, true)) {
                $mensajes[] = "Carpeta creada para: '$personalNombre' en '$rutaCarpeta'.";

                // Rutas de los archivos a copiar
                $archivoMadre = $rutaArchivos . 'madre.xlsx'; // Ruta del archivo Excel
                $archivoHistorias = $rutaArchivos . 'historias.php'; // Ruta del archivo historias.php
                $archivoXlsxMin = $rutaArchivos . 'xlsx.full.min.js'; // Ruta del archivo JavaScript

                // Copiar el archivo madre.xlsx a la carpeta del personal
                if (file_exists($archivoMadre) && copy($archivoMadre, $rutaPersonal . '\\madre.xlsx')) {
                    $mensajes[] = "Archivo 'madre.xlsx' copiado a '$rutaPersonal'.";
                } else {
                    $errores[] = "Error al copiar 'madre.xlsx' a '$rutaPersonal'. Archivo no encontrado.";
                }

                // Copiar el archivo historias.php desde la ubicación original
                if (file_exists($archivoHistorias) && copy($archivoHistorias, $rutaPersonal . '\\historias.php')) {
                    $mensajes[] = "Archivo 'historias.php' copiado a '$rutaPersonal'.";
                } else {
                    $errores[] = "Error al copiar 'historias.php' a '$rutaPersonal'. Archivo no encontrado.";
                }

                              // Copiar el archivo xlsx.full.min.js
                if (file_exists($archivoXlsxMin) && copy($archivoXlsxMin, $rutaPersonal . '\\xlsx.full.min.js')) {
                    $mensajes[] = "Archivo 'xlsx.full.min.js' copiado a '$rutaPersonal'.";
                } else {
                    $errores[] = "Error al copiar 'xlsx.full.min.js' a '$rutaPersonal'. Archivo no encontrado.";
                }
            } else {
                $errores[] = "Error al crear la carpeta para '$personalNombre'.";
            }
        }
    }
}

// Enviar la respuesta al cliente
$response = [
    'success' => empty($errores),
    'messages' => $mensajes,
    'errors' => $errores,
];

echo json_encode($response);
?>