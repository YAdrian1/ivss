<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id, nombre, apellido FROM expedientes ORDER BY apellido, nombre";
$result = mysqli_query($conexion, $sql);
?>

<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-success btn-sm" 
                                onclick="abrirModalAgregarImagenes(<?php echo $row['id']; ?>)">
                            <i class="fas fa-plus"></i> Agregar Imágenes
                        </button>
                        <button class="btn btn-primary btn-sm" 
                                onclick="abrirModalVerImagenes(<?php echo $row['id']; ?>)">
                            <i class="fas fa-images"></i> Ver Imágenes
                        </button>
                        <button class="btn btn-danger btn-sm" 
                                onclick="eliminarExpediente(<?php echo $row['id']; ?>)">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar imágenes -->
<div class="modal fade" id="modalAgregarImagenes" tabindex="-1" role="dialog" aria-labelledby="modalAgregarImagenesLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarImagenesLabel">Agregar Imágenes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAgregarImagenes" enctype="multipart/form-data">
                    <input type="hidden" name="id_expediente" id="id_expediente_agregar">
                    <div class="form-group">
                        <label for="categoria">Categoría de la imagen</label>
                        <select class="form-control" id="categoria" name="categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="C.I">C.I</option>
                            <option value="RIF">RIF</option>
                            <option value="Titulo">Título</option>
                            <option value="Declaracion_familiar">Declaración familiar</option>
                            <option value="Prima_profesional">Prima profesional</option>
                            <option value="Certificado_de_salud_mental">Certificado de salud mental</option>
                            <option value="Certificado_de_salud">Certificado de salud</option>
                            <option value="Boletin_de_vacaciones">Boletín de vacaciones</option>
                            <option value="Providencia">Providencia</option>
                            <option value="Declaracion_jurada">Declaración jurada</option>
                            <option value="Reposos">Reposos</option>
                            <option value="Constancia">Constancia</option>
                            <option value="Permisos">Permisos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="imagenes">Seleccionar Imágenes</label>
                        <input type="file" class="form-control-file" id="imagenes" name="imagenes[]" multiple accept="image/*" required>
                    </div>
                    <div class="progress mt-3" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="subirImagenes()">Subir Imágenes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver imágenes -->
<div class="modal fade" id="modalVerImagenes" tabindex="-1" role="dialog" aria-labelledby="modalVerImagenesLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVerImagenesLabel">Imágenes del Expediente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contenedorImagenes">
                <!-- Las imágenes se cargarán aquí dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
function abrirModalAgregarImagenes(idExpediente) {
    $('#id_expediente_agregar').val(idExpediente);
    $('#modalAgregarImagenes').modal('show');
}

function abrirModalVerImagenes(idExpediente) {
    $('#modalVerImagenes').modal('show');
    cargarImagenes(idExpediente);
}

function cargarImagenes(idExpediente) {
    $.ajax({
        url: 'expedientes/cargarImagenes.php',
        type: 'POST',
        data: { id_expediente: idExpediente },
        success: function(response) {
            $('#contenedorImagenes').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar imágenes:', error);
            alertify.error('Error al cargar las imágenes');
        }
    });
}

function subirImagenes() {
    // Validar que se haya seleccionado una categoría
    if(!$('#categoria').val()) {
        alertify.error('Por favor seleccione una categoría');
        return;
    }
    
    // Validar que se hayan seleccionado archivos
    if(!$('#imagenes').val()) {
        alertify.error('Por favor seleccione al menos una imagen');
        return;
    }
    
    var formData = new FormData($('#formAgregarImagenes')[0]);
    $('.progress').show();
    
    $.ajax({
        url: '../procesos/expedientes/subirImagenes.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                                       var percentComplete = (evt.loaded / evt.total) * 100;
                    $('.progress-bar').width(percentComplete + '%');
                }
            }, false);
            return xhr;
        },
        success: function(response) {
            try {
                var result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if(result.success) {
                    alertify.success(result.message);
                    $('#modalAgregarImagenes').modal('hide');
                    $('#formAgregarImagenes')[0].reset();
                    cargarImagenes($('#id_expediente_agregar').val());
                } else {
                    alertify.error(result.message || 'Error al subir las imágenes');
                }
            } catch(e) {
                console.error('Error al procesar la respuesta:', e);
                alertify.error('Error al procesar la respuesta del servidor');
            }
            $('.progress').hide();
            $('.progress-bar').width('0%');
        },
        error: function(xhr, status, error) {
            console.error('Error AJAX:', error);
            alertify.error('Error al subir las imágenes: ' + error);
            $('.progress').hide();
                        $('.progress-bar').width('0%');
        },
        complete: function() {
            // Resetear la barra de progreso y habilitar el botón de subida
            $('.progress').hide();
            $('.progress-bar').width('0%');
            $('#btnSubirImagenes').prop('disabled', false);
        }
    });
}

function eliminarExpediente(idExpediente) {
    alertify.confirm('¿Desea eliminar este expediente?', 
        function() { 
            $.ajax({
                type: "POST",
                data: { id_expediente: idExpediente },
                url: "../procesos/expedientes/eliminarExpediente.php",
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                        alertify.success(response.message);
                    } else {
                        alertify.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX:", error);
                    alertify.error("Error al intentar eliminar: " + error);
                }
            });
        },
        function() { 
            alertify.error('Operación cancelada');
        }
    );
}

// Validación de archivos al seleccionarlos
$('#imagenes').on('change', function() {
    const files = this.files;
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    let hasError = false;

    Array.from(files).forEach(file => {
        if (file.size > maxSize) {
            alertify.error(`El archivo ${file.name} excede el tamaño máximo permitido de 5MB`);
            hasError = true;
        }
        if (!allowedTypes.includes(file.type)) {
            alertify.error(`El archivo ${file.name} no es un tipo de imagen permitido`);
            hasError = true;
        }
    });

    if (hasError) {
        this.value = ''; // Limpiar la selección si hay errores
    }
});

// Limpiar el formulario cuando se cierre el modal
$('#modalAgregarImagenes').on('hidden.bs.modal', function () {
    $('#formAgregarImagenes')[0].reset();
    $('.progress').hide();
    $('.progress-bar').width('0%');
});

// Prevenir que se cierren los modales al hacer clic fuera mientras se suben archivos
$('#modalAgregarImagenes').data('bs.modal')._config.backdrop = 'static';
$('#modalVerImagenes').data('bs.modal')._config.backdrop = 'static';
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

.progress {
    margin-top: 10px;
    height: 20px;
}

.progress-bar {
    transition: width 0.3s ease-in-out;
}
</style>