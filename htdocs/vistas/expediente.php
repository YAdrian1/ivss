<?php 
session_start();
if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Expedientes</title>
    <?php require_once "menu.php"; ?>
    <link rel="stylesheet" type="text/css" href="../librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../librerias/alertifyjs/css/themes/default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../librerias/alertifyjs/alertify.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Gestión de Expedientes</h1>
        
        <div class="row">
            <div class="col-sm-4">
                <form id="frmExpediente">
                    <label>Nombre</label>
                    <input type="text" class="form-control input-sm" id="nombre" name="nombre" required>
                    <label>Apellido</label>
                    <input type="text" class="form-control input-sm" id="apellido" name="apellido" required>
                    <p></p>
                    <button type="button" class="btn btn-primary" id="btnAgregarExpediente">Agregar</button>
                </form>
            </div>
            
            <div class="col-sm-8">
                <div id="tablaExpedientesLoad"></div>
            </div>
        </div>
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
                            <label for="imagenes">Seleccionar Imágenes</label>
                            <input type="file" class="form-control-file" id="imagenes" name="imagenes[]" multiple accept="image/*">
                        </div>
                        <div class="progress mt-3" style="display: none;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnSubirImagenes">Subir Imágenes</button>
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

    <script type="text/javascript">
    $(document).ready(function(){
        $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");

        $('#btnAgregarExpediente').click(function(){
            if($('#nombre').val() == '' || $('#apellido').val() == ''){
                alertify.alert("Debes llenar todos los campos!");
                return false;
            }

            datos = $('#frmExpediente').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "../procesos/expedientes/agregarExpediente.php",
                success: function(r){
                    if(r == 1){
                        $('#frmExpediente')[0].reset();
                        $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                        alertify.success("Expediente agregado con éxito");
                    }else{
                        alertify.error("No se pudo agregar el expediente");
                    }
                }
            });
        });

        $('#btnSubirImagenes').off('click').on('click', function(e) {
            e.preventDefault();
            
            var files = $('#imagenes')[0].files;
            if (files.length === 0) {
                alertify.error('Por favor seleccione al menos una imagen');
                return;
            }

            var formData = new FormData($('#formAgregarImagenes')[0]);
            
            $(this).prop('disabled', true);
            $('.progress').show();
            $('.progress-bar').width('0%');
            
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
                            
                            if($('#id_expediente_agregar').val()) {
                                cargarImagenes($('#id_expediente_agregar').val());
                            }
                        } else {
                            alertify.error(result.message || 'Error al subir las imágenes');
                        }
                    } catch(e) {
                        console.error('Error al procesar la respuesta:', e);
                        alertify.error('Error al procesar la respuesta del servidor');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    alertify.error('Error al subir las imágenes: ' + error);
                },
                               complete: function() {
                    $('#btnSubirImagenes').prop('disabled', false);
                    $('.progress').hide();
                    $('.progress-bar').width('0%');
                }
            });
        });

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
                this.value = '';
            }
        });

        // Limpiar el formulario cuando se cierre el modal
        $('#modalAgregarImagenes').on('hidden.bs.modal', function () {
            $('#formAgregarImagenes')[0].reset();
            $('.progress').hide();
            $('.progress-bar').width('0%');
            $('#btnSubirImagenes').prop('disabled', false);
        });
    });

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

    function eliminarExpediente(idExpediente) {
        alertify.confirm('¿Desea eliminar este expediente?', function(){ 
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
        }, function(){ 
            alertify.error('Operación cancelada');
        });
    }
    </script>
</body>
</html>

<?php 
} else {
    header("location:../index.php");
}
?>