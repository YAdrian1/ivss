<?php
session_start();
require_once "../clases/Conexion.php";

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$c = new conectar();
$conexion = $c->conexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    
    if (empty($nombre) || !isset($_FILES['archivo'])) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    $archivo = $_FILES['archivo'];
    $nombreArchivo = $archivo['name'];
    $tipoArchivo = $archivo['type'];
    $tamanoArchivo = $archivo['size'];
    $tempArchivo = $archivo['tmp_name'];

    // Validar el tamaño del archivo (5MB máximo)
    $tamanoMaximo = 5 * 1024 * 1024;
    if ($tamanoArchivo > $tamanoMaximo) {
        echo json_encode(['success' => false, 'message' => 'El archivo es demasiado grande. Máximo 5MB.']);
        exit;
    }

    // Validar el tipo de archivo
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx'];
    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
    if (!in_array($extension, $extensionesPermitidas)) {
        echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido']);
        exit;
    }

    // Generar un nombre único para el archivo
    $nombreUnico = uniqid() . '.' . $extension;
    $rutaDestino = "../uploads/" . $nombreUnico;

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        // Mover el archivo
        if (!move_uploaded_file($tempArchivo, $rutaDestino)) {
            throw new Exception("Error al mover el archivo");
        }

        // Reorganizar IDs existentes
        $sql_reorg = "
            SET @count = 0;
            UPDATE imagenes_subidas 
            SET id = (@count:=@count+1) 
            WHERE id_usuario = ? 
            ORDER BY fecha_subida;
        ";
        
        // Ejecutar la reorganización
        mysqli_multi_query($conexion, $sql_reorg);
        while (mysqli_next_result($conexion)) {;} // Limpiar resultados pendientes
        
        // Obtener el siguiente ID disponible
        $sql_next_id = "SELECT COALESCE(MAX(id), 0) + 1 AS next_id 
                        FROM imagenes_subidas 
                        WHERE id_usuario = ?";
        $stmt_next_id = mysqli_prepare($conexion, $sql_next_id);
        mysqli_stmt_bind_param($stmt_next_id, "i", $_SESSION['iduser']);
        mysqli_stmt_execute($stmt_next_id);
        $result_next_id = mysqli_stmt_get_result($stmt_next_id);
        $next_id = mysqli_fetch_assoc($result_next_id)['next_id'];

        // Preparar la consulta SQL para insertar el nuevo formato
        $sql = "INSERT INTO imagenes_subidas (id, id_usuario, nombre, imagen_data, tipo_imagen, extension, fecha_subida) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conexion, $sql);

        // Leer el contenido del archivo
        $contenidoArchivo = file_get_contents($rutaDestino);

        mysqli_stmt_bind_param($stmt, "iissss", $next_id, $_SESSION['iduser'], $nombre, $contenidoArchivo, $tipoArchivo, $extension);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al insertar en la base de datos");
        }

        // Commit de la transacción
        mysqli_commit($conexion);

        // Eliminar el archivo temporal
        unlink($rutaDestino);

        echo json_encode([
            'success' => true, 
            'message' => 'Archivo subido correctamente',
            'id' => $next_id,
            'nombre' => $nombre,
            'extension' => $extension,
            'fecha' => date('Y-m-d H:i:s')
        ]);

    } catch (Exception $e) {
        mysqli_rollback($conexion);
        
        // Si existe, eliminar el archivo temporal
        if (file_exists($rutaDestino)) {
            unlink($rutaDestino);
        }
        
        error_log("Error en subir_formato.php: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    // Cerrar statements
    if (isset($stmt_next_id)) mysqli_stmt_close($stmt_next_id);
    if (isset($stmt)) mysqli_stmt_close($stmt);

} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>