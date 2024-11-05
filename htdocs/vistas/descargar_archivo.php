<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header("HTTP/1.0 403 Forbidden");
    exit;
}

require_once "../clases/Conexion.php";

// Función para obtener la extensión MIME correcta
function getMimeType($extension) {
    $mimeTypes = [
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
    return isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';
}

try {
    // Validar parámetros
    if(!isset($_GET['id']) || !isset($_GET['nombre'])) {
        throw new Exception('Parámetros incorrectos');
    }

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $nombre = filter_var($_GET['nombre'], FILTER_SANITIZE_STRING);

    if($id === false) {
        throw new Exception('ID de archivo inválido');
    }

    // Conectar a la base de datos
    $c = new conectar();
    $conexion = $c->conexion();

    // Preparar y ejecutar la consulta
    $query = "SELECT imagen_data, tipo_imagen, extension, nombre 
              FROM imagenes_subidas 
              WHERE id = ? AND id_usuario = ?";
    
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['iduser']);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if($fila = mysqli_fetch_assoc($resultado)) {
        // Verificar que sea un documento Word o Excel
        $extension = strtolower($fila['extension']);
        if(!in_array($extension, ['doc', 'docx', 'xls', 'xlsx'])) {
            throw new Exception('Tipo de archivo no permitido');
        }

        // Limpiar cualquier salida anterior
        if(ob_get_level()) ob_end_clean();

        // Configurar headers para la descarga
        header('Content-Type: ' . getMimeType($extension));
        header('Content-Disposition: attachment; filename="' . $fila['nombre'] . '.' . $extension . '"');
        header('Content-Length: ' . strlen($fila['imagen_data']));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        // Enviar archivo
        echo $fila['imagen_data'];
        exit;

    } else {
        throw new Exception('Archivo no encontrado');
    }

} catch (Exception $e) {
    // Log del error
    error_log("Error en descargar_archivo.php: " . $e->getMessage());
    
    // Redirigir a una página de error o mostrar mensaje
    header("HTTP/1.0 404 Not Found");
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 50px;
            }
            .error-container {
                max-width: 500px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f8f8f8;
            }
            .error-message {
                color: #721c24;
                background-color: #f8d7da;
                border: 1px solid #f5c6cb;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            .back-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            .back-button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-message">
                <?php echo htmlspecialchars($e->getMessage()); ?>
            </div>
            <a href="formatos.php" class="back-button">Volver a Formatos</a>
        </div>
    </body>
    </html>
    <?php
}

// Cerrar la conexión
if(isset($stmt)) mysqli_stmt_close($stmt);
if(isset($conexion)) mysqli_close($conexion);
?>