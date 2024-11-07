<?php
session_start();
require_once "../../clases/Conexion.php";

header('Content-Type: application/json');

// Habilitar todos los errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para loggear errores
function logError($message) {
    $logFile = '../../logs/upload_errors.log';
    $logDir = dirname($logFile);
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, $logFile);
}

if (!isset($_SESSION['usuario'])) {
    logError("Usuario no autenticado");
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

if (!isset($_POST['id_expediente']) || !isset($_FILES['imagenes'])) {
    logError("Datos incompletos: " . print_r($_POST, true) . print_r($_FILES, true));
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$c = new conectar();
$conexion = $c->conexion();
$idExpediente = mysqli_real_escape_string($conexion, $_POST['id_expediente']);

$uploadDir = '../../expedientes/imagenes/';
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        logError("No se pudo crear el directorio de subida: " . $uploadDir);
        echo json_encode(['success' => false, 'message' => 'No se pudo crear el directorio de subida']);
        exit;
    }
}

$uploadedFiles = 0;
$errors = [];

foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
    $fileName = $_FILES['imagenes']['name'][$key];
    $fileSize = $_FILES['imagenes']['size'][$key];
    $fileError = $_FILES['imagenes']['error'][$key];
    $fileType = $_FILES['imagenes']['type'][$key];

    if ($fileError === UPLOAD_ERR_OK) {
        // Verificar el tamaño del archivo (ejemplo: máximo 5MB)
        if ($fileSize > 5000000) {
            $errors[] = "El archivo $fileName es demasiado grande (máximo 5MB)";
            continue;
        }

        // Verificar el tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Tipo de archivo no permitido para $fileName. Solo se permiten JPG, PNG y GIF.";
            continue;
        }

        $uniqueName = uniqid() . '_' . $fileName;
        $uploadFile = $uploadDir . $uniqueName;
        
        if (move_uploaded_file($tmp_name, $uploadFile)) {
            $sql = "INSERT INTO imagenes_expediente (id_expediente, ruta, nombre_original, tipo_imagen) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "isss", $idExpediente, $uniqueName, $fileName, $fileType);
            
            if (mysqli_stmt_execute($stmt)) {
                $uploadedFiles++;
            } else {
                logError("Error al guardar en la base de datos: " . mysqli_error($conexion));
                $errors[] = "Error al guardar en la base de datos: $fileName";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $phpFileUploadErrors = [
                0 => 'There is no error, the file uploaded with success',
                1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            ];
            $errorMessage = isset($phpFileUploadErrors[$fileError]) ? $phpFileUploadErrors[$fileError] : 'Unknown upload error';
            logError("Error al mover el archivo $fileName: " . $errorMessage);
            $errors[] = "Error al mover el archivo: $fileName";
        }
    } else {
        $phpFileUploadErrors = [
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        ];
        $errorMessage = isset($phpFileUploadErrors[$fileError]) ? $phpFileUploadErrors[$fileError] : 'Unknown upload error';
        logError("Error al subir el archivo $fileName: " . $errorMessage);
        $errors[] = "Error al subir el archivo $fileName: $errorMessage";
    }
}

if ($uploadedFiles > 0) {
    $message = $uploadedFiles . " imagen(es) subida(s) correctamente.";
    if (!empty($errors)) {
        $message .= " Algunos errores ocurrieron: " . implode(", ", $errors);
    }
    echo json_encode(['success' => true, 'message' => $message]);
} else {
    logError("No se pudo subir ninguna imagen. Errores: " . implode(", ", $errors));
    echo json_encode(['success' => false, 'message' => "No se pudo subir ninguna imagen. Errores: " . implode(", ", $errors)]);
}

mysqli_close($conexion);