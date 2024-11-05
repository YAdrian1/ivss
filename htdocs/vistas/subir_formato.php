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

        // Encontrar el ID más bajo disponible
        $sql_find_id = "SELECT MIN(t1.id + 1) AS next_id
                        FROM imagenes_subidas t1
                        LEFT JOIN imagenes_subidas t2 ON t1.id + 1 = t2.id
                        WHERE t2.id IS NULL";
        $result_find_id = mysqli_query($conexion, $sql_find_id);
        $row = mysqli_fetch_assoc($result_find_id);
        $next_id = $row['next_id'] ?? 1;

        // Preparar la consulta SQL
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
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    // Cerrar statement
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>