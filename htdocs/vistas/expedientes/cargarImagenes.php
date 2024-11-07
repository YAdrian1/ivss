<?php
session_start();
require_once "../../clases/Conexion.php";

// Configuración de errores y logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

function logError($message) {
    $logFile = '../../logs/imagen_errors.log';
    $logDir = dirname($logFile);
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, $logFile);
}

// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
    logError("Usuario no autenticado");
    echo '<div class="alert alert-danger">Error: Usuario no autenticado</div>';
    exit;
}

// Verificar parámetro id_expediente
if (!isset($_POST['id_expediente'])) {
    logError("ID de expediente no proporcionado");
    echo '<div class="alert alert-danger">Error: No se proporcionó ID del expediente</div>';
    exit;
}

try {
    $c = new conectar();
    $conexion = $c->conexion();
    
    // Sanitizar el ID del expediente
    $idExpediente = filter_var($_POST['id_expediente'], FILTER_SANITIZE_NUMBER_INT);
    
    if (!$idExpediente) {
        throw new Exception("ID de expediente inválido");
    }

    // Registrar la consulta para debugging
    logError("Consultando imágenes para expediente ID: " . $idExpediente);

    // Consulta para obtener las imágenes agrupadas por categoría
    $sql = "SELECT id, categoria, ruta, nombre_original, fecha_subida 
            FROM imagenes_expediente 
            WHERE id_expediente = ? 
            ORDER BY categoria, fecha_subida DESC";
            
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "i", $idExpediente);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error ejecutando la consulta: " . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);
    
    // Agrupar imágenes por categoría
    $imagenesPorCategoria = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $imagenesPorCategoria[$row['categoria']][] = $row;
    }

    if (!empty($imagenesPorCategoria)) {
        foreach ($imagenesPorCategoria as $categoria => $imagenes) {
            echo '<div class="categoria-section mb-4">';
            echo '<h4 class="categoria-titulo">' . htmlspecialchars($categoria) . '</h4>';
            echo '<div class="row">';
            
            foreach ($imagenes as $row) {
                // Construir la ruta de la imagen
                $rutaImagen = '../expedientes/' . htmlspecialchars($row['ruta']);
                $nombreOriginal = htmlspecialchars($row['nombre_original']);
                $fechaSubida = date('d/m/Y H:i', strtotime($row['fecha_subida']));
                
                echo '<div class="col-md-4 col-sm-6 img-container" id="imagen_' . $row['id'] . '">';
                echo '<div class="card mb-4 shadow-sm">';
                
                // Contenedor de imagen con altura fija
                echo '<div class="image-wrapper">';
                echo '<img src="' . $rutaImagen . '" class="card-img-top" alt="' . $nombreOriginal . '">';
                echo '</div>';
                
                // Información de la imagen
                echo '<div class="card-body">';
                echo '<p class="card-text text-truncate" title="' . $nombreOriginal . '">' . $nombreOriginal . '</p>';
                echo '<p class="card-text"><small class="text-muted">Subido: ' . $fechaSubida . '</small></p>';
                
                // Botones de acción
                echo '<div class="d-flex justify-content-between align-items-center">';
                echo '<div class="btn-group">';
                echo '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="verImagenCompleta(\'' . $rutaImagen . '\')">Ver</button>';
                echo '<button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarImagen(' . $row['id'] . ')">Eliminar</button>';
                echo '</div>';
                echo '</div>';
                
                echo '</div>'; // Fin card-body
                echo '</div>'; // Fin card
                echo '</div>'; // Fin col
            }
            
            echo '</div>'; // Fin row
            echo '</div>'; // Fin categoria-section
        }
    } else {
        echo '<div class="alert alert-info text-center">
                <i class="fas fa-images fa-2x mb-3"></i>
                <p>No hay imágenes disponibles para este expediente.</p>
              </div>';
    }

} catch (Exception $e) {
    logError("Error: " . $e->getMessage());
    echo '<div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            Error al cargar las imágenes: ' . htmlspecialchars($e->getMessage()) . '
          </div>';
} finally {
    // Cerrar la declaración y la conexión
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    if (isset($conexion)) {
        mysqli_close($conexion);
    }
}
?>

<style>
.categoria-section {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.categoria-titulo {
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.img-container {
    margin-bottom: 20px;
}

.image-wrapper {
    height: 200px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.image-wrapper img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.btn-group {
    width: 100%;
}

.btn-group .btn {
    flex: 1;
}

.text-truncate {
    max-width: 100%;
}

/* Estilos para dispositivos móviles */
@media (max-width: 768px) {
    .col-md-4 {
        padding: 0 5px;
    }
    
    .card-body {
        padding: 0.5rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
}

/* Animación de carga */
.loading {
    text-align: center;
    padding: 20px;
}

.loading:after {

    content: " ";

    display: inline-block;

    width: 2rem;

    height: 2rem;

    border: 3px solid #f3f3f3;

    border-radius: 50%;

    border-top: 3px solid #3498db;

    animation: spin 1s linear infinite;

}


@keyframes spin {

    0% { transform: rotate(0deg); }

    100% { transform: rotate(360deg); }

}

</style>

<script>

// Función para ver la imagen en tamaño completo

function verImagenCompleta(rutaImagen) {

    // Crear modal para ver la imagen

    let modal = $('<div class="modal fade" id="modalImagenCompleta">');

    modal.html(`

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    h5 class="modal-title">Vista Completa</h5>

                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body text-center">
                    <img src="${rutaImagen}" class="img-fluid" style="max-height: 80vh;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="${rutaImagen}" class="btn btn-primary" download>Descargar</a>
                </div>
            </div>
        </div>
    `);

    // Agregar modal al body y mostrarlo
    modal.appendTo('body').modal('show');

    // Eliminar modal del DOM cuando se cierre
    modal.on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Función para confirmar eliminación de imagen
function confirmarEliminarImagen(idImagen) {
    return Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });
}

// Función para eliminar imagen
function eliminarImagen(idImagen) {
    confirmarEliminarImagen(idImagen).then((result) => {
        if (result.isConfirmed) {
            // Mostrar indicador de carga
            const contenedorImagen = $(`#imagen_${idImagen}`);
            contenedorImagen.addClass('loading');

            $.ajax({
                url: '../procesos/expedientes/eliminarImagen.php',
                type: 'POST',
                data: { id_imagen: idImagen },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Animar la eliminación del contenedor
                        contenedorImagen.fadeOut(300, function() {
                            $(this).remove();
                            // Si no quedan más imágenes, mostrar mensaje
                            if ($('.img-container').length === 0) {
                                $('#contenedorImagenes').html(`
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-images fa-2x mb-3"></i>
                                        <p>No hay imágenes disponibles para este expediente.</p>
                                    </div>
                                `);
                            }
                        });
                        
                        // Mostrar mensaje de éxito
                        Swal.fire(
                            '¡Eliminada!',
                            'La imagen ha sido eliminada correctamente.',
                            'success'
                        );
                    } else {
                        // Mostrar mensaje de error
                        Swal.fire(
                                                       'Error',
                            response.message || 'No se pudo eliminar la imagen',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al comunicarse con el servidor',
                        'error'
                    );
                },
                complete: function() {
                    // Quitar indicador de carga
                    contenedorImagen.removeClass('loading');
                }
            });
        }
    });
}

// Inicializar tooltips y popovers cuando se carga el contenido
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    // Manejar errores de carga de imágenes
    $('img').on('error', function() {
        $(this).attr('src', '../assets/img/imagen-no-disponible.png');
        $(this).attr('alt', 'Imagen no disponible');














   });

});

</script>


<style>

.img-container {

    margin-bottom: 20px;

}


.image-wrapper {

    height: 200px;

    overflow: hidden;

    display: flex;

    align-items: center;

    justify-content: center;

    background-color: #f8f9fa;

}


.image-wrapper img {

    max-width: 100%;

    max-height: 100%;

    object-fit: contain;

}


.card {

    transition: transform 0.2s ease-in-out;

}


.card:hover {

    transform: translateY(-5px);

    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;

}


.btn-group {

    width: 100%;

}


.btn-group .btn {

    flex: 1;

}


.text-truncate {

    max-width: 100%;

}


/* Estilos para dispositivos móviles */

@media (max-width: 768px) {

    .col-md-4 {

        padding: 0 5px;

    }

    

    .card-body {

        padding: 0.5rem;

    }

    

    .btn-group .btn {

        padding: 0.25rem 0.5rem;

        font-size: 0.875rem;

    }

}


/* Animación de carga */

.loading {

    text-align: center;

    padding: 20px;

}


.loading:after {

    content: " ";

    display: inline-block;

    width: 2rem;

    height: 2rem;

    border: 3px solid #f3f3f3;

    border-radius: 50%;

    border-top: 3px solid #3498db;

    animation: spin 1s linear infinite;

}


@keyframes spin {

    0% { transform: rotate(0deg); }

    100% { transform: rotate(360deg); }

}

</style>














