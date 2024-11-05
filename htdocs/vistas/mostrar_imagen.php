<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header("HTTP/1.0 403 Forbidden");
    exit;
}

require_once "../clases/Conexion.php";

try {
    // Validar el parámetro ID
    if(!isset($_GET['id'])) {
        throw new Exception('ID de imagen no proporcionado');
    }

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if($id === false) {
        throw new Exception('ID de imagen inválido');
    }

    // Conectar a la base de datos
    $c = new conectar();
    $conexion = $c->conexion();

    // Preparar y ejecutar la consulta
    $query = "SELECT imagen_data, tipo_imagen, extension 
              FROM imagenes_subidas 
              WHERE id = ? AND id_usuario = ?";
    
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['iduser']);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if($fila = mysqli_fetch_assoc($resultado)) {
        // Verificar que sea una imagen
        $extension = strtolower($fila['extension']);
        $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
        
        if(!in_array($extension, $extensiones_permitidas)) {
            throw new Exception('Tipo de archivo no permitido');
        }

        // Limpiar cualquier salida anterior
        if(ob_get_level()) ob_end_clean();

        // Configurar headers para la imagen
        header('Content-Type: ' . $fila['tipo_imagen']);
        header('Content-Length: ' . strlen($fila['imagen_data']));
        header('Cache-Control: public, max-age=86400'); // Cache por 24 horas
        header('Pragma: public');

        // Enviar imagen
        echo $fila['imagen_data'];
        exit;

    } else {
        throw new Exception('Imagen no encontrada');
    }

} catch (Exception $e) {
    // Log del error
    error_log("Error en mostrar_imagen.php: " . $e->getMessage());
    
    // Mostrar imagen de error
    $imagen_error = imagecreatetruecolor(200, 200);
    $color_fondo = imagecolorallocate($imagen_error, 255, 255, 255);
    $color_texto = imagecolorallocate($imagen_error, 255, 0, 0);
    
    imagefill($imagen_error, 0, 0, $color_fondo);
    
    // Centrar el texto de error
    $texto = "Error: Imagen no disponible";
    $fuente = 3; // Fuente incorporada de GD
    $bbox = imagettfbbox(10, 0, $fuente, $texto);
    $x = ceil((200 - $bbox[2]) / 2);
    $y = ceil((200 - $bbox[1]) / 2);
    
    imagestring($imagen_error, $fuente, $x, $y, $texto, $color_texto);
    
    // Enviar imagen de error
    header('Content-Type: image/png');
    imagepng($imagen_error);
    imagedestroy($imagen_error);
}

// Cerrar la conexión y el statement
if(isset($stmt)) mysqli_stmt_close($stmt);
if(isset($conexion)) mysqli_close($conexion);
?>