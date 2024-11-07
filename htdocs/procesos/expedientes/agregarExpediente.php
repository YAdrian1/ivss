<?php
session_start();
require_once "../../clases/Conexion.php";

try {
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

    // Ruta base para los expedientes
    $rutaBase = $_SERVER['DOCUMENT_ROOT'] . '/expedientes/';
    $rutaExpediente = $rutaBase . $nombreCarpeta;

    // Estructura de carpetas a crear
    $carpetas = [
        'C.I',
        'RIF',
        'Titulo',
        'Declaracion_familiar',
        'Prima_profesional',
        'Certificado_de_salud_mental',
        'Certificado_de_salud',
        'Boletin_de_vacaciones',
        'Providencia',
        'Declaracion_jurada',
        'Reposos',
        'Constancia',
        'Permisos'
    ];

    // Crear la carpeta base si no existe
    if (!file_exists($rutaBase)) {
        if (!mkdir($rutaBase, 0777, true)) {
            throw new Exception("Error al crear el directorio base de expedientes");
        }
    }

    // Verificar si ya existe una carpeta con ese nombre
    if (file_exists($rutaExpediente)) {
        // Si existe, agregar un número al final
        $contador = 1;
        while (file_exists($rutaExpediente . '_' . $contador)) {
            $contador++;
        }
        $rutaExpediente .= '_' . $contador;
        $nombreCarpeta .= '_' . $contador;
    }

    // Crear la carpeta principal del expediente
    if (!mkdir($rutaExpediente, 0777, true)) {
        throw new Exception("Error al crear el directorio del expediente");
    }

    // Crear todas las subcarpetas
    foreach ($carpetas as $carpeta) {
        $rutaSubcarpeta = $rutaExpediente . '/' . $carpeta;
        if (!mkdir($rutaSubcarpeta, 0777, true)) {
            // Si falla la creación de una subcarpeta, eliminar todo lo creado
            removeDirectory($rutaExpediente);
            throw new Exception("Error al crear la subcarpeta: " . $carpeta);
        }

        // Crear un archivo index.html vacío en cada carpeta para proteger el listado de directorios
        file_put_contents($rutaSubcarpeta . '/index.html', '');
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO expedientes (nombre, apellido, ruta_carpeta) 
            VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        // Si falla la preparación de la consulta, eliminar las carpetas
        removeDirectory($rutaExpediente);
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "sss", $nombre, $apellido, $nombreCarpeta);
    
    if (!mysqli_stmt_execute($stmt)) {
        // Si falla la inserción, eliminar las carpetas
        removeDirectory($rutaExpediente);
        throw new Exception("Error en la consulta: " . mysqli_stmt_error($stmt));
    }

    // Registrar la creación en un archivo de log
    $logMessage = date('Y-m-d H:i:s') . " - Expediente creado: $nombreCarpeta para $nombre $apellido\n";
    file_put_contents($rutaBase . 'expedientes.log', $logMessage, FILE_APPEND);

    // Crear un archivo README.txt con información del expediente
    $readmeContent = "Expediente de: $nombre $apellido\n";
    $readmeContent .= "Creado el: " . date('Y-m-d H:i:s') . "\n";
    $readmeContent .= "Estructura de carpetas:\n\n";
    foreach ($carpetas as $carpeta) {
        $readmeContent .= "- $carpeta/\n";
    }
    file_put_contents($rutaExpediente . '/README.txt', $readmeContent);

    echo 1; // Éxito

} catch(Exception $e) {
    error_log("Error en agregarExpediente.php: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    if (isset($conexion)) {
        mysqli_close($conexion);
    }
}

// Función auxiliar para eliminar directorios y su contenido
function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    return rmdir($path);
}
?>