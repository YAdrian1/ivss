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

// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
    logError("Usuario no autenticado");
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

// Verificar datos requeridos
if (!isset($_POST['id_expediente']) || !isset($_POST['categoria']) || empty($_FILES['imagenes'])) {
    logError("Datos incompletos: " . print_r($_POST, true) . print_r($_FILES, true));
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$c = new conectar();
$conexion = $c->conexion();
$idExpediente = mysqli_real_escape_string($conexion, $_POST['id_expediente']);
$categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);

// Obtener información del expediente
$sqlExpediente = "SELECT ruta_carpeta FROM expedientes WHERE id = ?";
$stmtExpediente = mysqli_prepare($conexion, $sqlExpediente);
mysqli_stmt_bind_param($stmtExpediente, "i", $idExpediente);
mysqli_stmt_execute($stmtExpediente);
$resultExpediente = mysqli_stmt_get_result($stmtExpediente);
$expediente = mysqli_fetch_assoc($resultExpediente);

if (!$expediente) {
    logError("Expediente no encontrado: " . $idExpediente);
    echo json_encode(['success' => false, 'message' => 'Expediente no encontrado']);
    exit;
}

$rutaBase = '../../expedientes/';
$rutaExpediente = $rutaBase . $expediente['ruta_carpeta'];

// Crear la carpeta del expediente si no existe
if (!file_exists($rutaExpediente)) {
    if (!mkdir($rutaExpediente, 0777, true)) {
        logError("No se pudo crear el directorio del expediente: " . $rutaExpediente);
        echo json_encode(['success' => false, 'message' => 'No se pudo crear el directorio del expediente']);
        exit;
    }
}

// Crear la subcarpeta de la categoría si no existe
$rutaCategoria = $rutaExpediente . '/' . $categoria;
if (!file_exists($rutaCategoria)) {
    if (!mkdir($rutaCategoria, 0777, true)) {
        logError("No se pudo crear el directorio de la categoría: " . $rutaCategoria);
        echo json_encode(['success' => false, 'message' => 'No se pudo crear el directorio de la categoría']);
        exit;
    }
}

$uploadedFiles = 0;
$errors = [];
$maxFileSize = 5 * 1024 * 1024; // 5MB
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

// Procesar cada archivo
foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
    $fileName = $_FILES['imagenes']['name'][$key];
    $fileSize = $_FILES['imagenes']['size'][$key];
    $fileType = $_FILES['imagenes']['type'][$key];
    $fileError = $_FILES['imagenes']['error'][$key];

    // Validaciones
    if ($fileError !== UPLOAD_ERR_OK) {
        $errors[] = "Error al subir $fileName: " . getUploadErrorMessage($fileError);
        continue;
    }

    if ($fileSize > $maxFileSize) {
        $errors[] = "El archivo $fileName excede el tamaño máximo permitido de 5MB";
        continue;
    }

    if (!in_array($fileType, $allowedTypes)) {
        $errors[] = "Tipo de archivo no permitido para $fileName. Solo se permiten JPG, PNG y GIF";
        continue;
    }

    // Generar nombre único para el archivo
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $uniqueName = uniqid() . '_' . time() . '.' . $extension;
    $uploadFile = $rutaCategoria . '/' . $uniqueName;

    if (move_uploaded_file($tmp_name, $uploadFile)) {
        try {
            $sql = "INSERT INTO imagenes_expediente (id_expediente, categoria, ruta, nombre_original, tipo_imagen, fecha_subida) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
            
            $stmt = mysqli_prepare($conexion, $sql);
            $rutaRelativa = $expediente['ruta_carpeta'] . '/' . $categoria . '/' . $uniqueName;
            mysqli_stmt_bind_param($stmt, "issss", $idExpediente, $categoria, $rutaRelativa, $fileName, $fileType);
            
            if (mysqli_stmt_execute($stmt)) {
                $uploadedFiles++;
            } else {
                throw new Exception("Error al guardar en la base de datos: " . mysqli_error($conexion));
            }
            
            mysqli_stmt_close($stmt);
        } catch (Exception $e) {
            $errors[] = "Error con el archivo $fileName: " . $e->getMessage();
            if (file_exists($uploadFile)) {
                unlink($uploadFile);
            }
        }
    } else {
        $errors[] = "Error al mover el archivo $fileName al directorio final";
    }
}

// Preparar respuesta
if ($uploadedFiles > 0) {
    $message = $uploadedFiles . " imagen(es) subida(s) correctamente.";
    if (!empty($errors)) {
        $message .= " Algunos errores ocurrieron: " . implode(", ", $errors);
    }
    echo json_encode(['success' => true, 'message' => $message]);
} else {
    $errorMessage = "No se pudo subir ninguna imagen. ";
    if (!empty($errors)) {
        $errorMessage .= "Errores: " . implode(", ", $errors);
    }
    logError($errorMessage);
    echo json_encode(['success' => false, 'message' => $errorMessage]);
}

// Cerrar la conexión
mysqli_close($conexion);

// Función auxiliar para obtener mensajes de error de subida
function getUploadErrorMessage($errorCode) {
    $phpFileUploadErrors = array(
        UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido por PHP',
        UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo permitido por el formulario',
        UPLOAD_ERR_PARTIAL => 'El archivo solo fue subido parcialmente',
        UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo',
        UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal',
        UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir el archivo en el disco',
        UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida del archivo.',
    );

    return isset($phpFileUploadErrors[$errorCode]) ? $phpFileUploadErrors[$errorCode] : 'Error desconocido al subir el archivo';
}