<?php
session_start();
require_once "../../clases/Conexion.php";

header('Content-Type: application/json');

// Función para loggear errores
function logError($message) {
    $logFile = '../../logs/expediente_errors.log';
    $logDir = dirname($logFile);
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, $logFile);
}

try {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario'])) {
        throw new Exception("Usuario no autenticado");
    }

    $c = new conectar();
    $conexion = $c->conexion();

    // Validar que los datos no estén vacíos
    if(empty($_POST['nombre']) || empty($_POST['apellido'])) {
        throw new Exception("Datos incompletos");
    }

    // Sanitizar y formatear nombre y apellido
    $nombre = trim(mysqli_real_escape_string($conexion, $_POST['nombre']));
    $apellido = trim(mysqli_real_escape_string($conexion, $_POST['apellido']));

    // Formatear el nombre de la carpeta principal
    $nombreCarpeta = strtolower(
        preg_replace('/[^a-zA-Z0-9]/', '_', 
        $apellido . '_' . $nombre)
    );

    // Verificar si ya existe un expediente con ese nombre
    $sqlVerificar = "SELECT id FROM expedientes WHERE ruta_carpeta = ?";
    $stmtVerificar = mysqli_prepare($conexion, $sqlVerificar);
    mysqli_stmt_bind_param($stmtVerificar, "s", $nombreCarpeta);
    mysqli_stmt_execute($stmtVerificar);
    mysqli_stmt_store_result($stmtVerificar);

    if (mysqli_stmt_num_rows($stmtVerificar) > 0) {
        // Si existe, agregar un número al final
        $contador = 1;
        $nombreCarpetaOriginal = $nombreCarpeta;
        do {
            $nombreCarpeta = $nombreCarpetaOriginal . '_' . $contador;
            mysqli_stmt_bind_param($stmtVerificar, "s", $nombreCarpeta);
            mysqli_stmt_execute($stmtVerificar);
            mysqli_stmt_store_result($stmtVerificar);
            $contador++;
        } while (mysqli_stmt_num_rows($stmtVerificar) > 0);
    }
    mysqli_stmt_close($stmtVerificar);

    // Insertar en la base de datos
    $sql = "INSERT INTO expedientes (nombre, apellido, ruta_carpeta) VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "sss", $nombre, $apellido, $nombreCarpeta);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error en la consulta: " . mysqli_stmt_error($stmt));
    }

    $idExpediente = mysqli_insert_id($conexion);

    // Registrar la creación en un archivo de log
    $logMessage = date('Y-m-d H:i:s') . " - Expediente creado: $nombreCarpeta para $nombre $apellido\n";
    file_put_contents('../../logs/expedientes.log', $logMessage, FILE_APPEND);

    echo json_encode([
        'success' => true, 
        'id' => $idExpediente, 
        'message' => 'Expediente creado correctamente',
        'nombre_carpeta' => $nombreCarpeta
    ]);

} catch(Exception $e) {
    logError("Error en agregarExpediente.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    if (isset($conexion)) {
        mysqli_close($conexion);
    }
}
?>