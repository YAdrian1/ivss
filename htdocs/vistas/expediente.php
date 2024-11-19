<?php 
session_start();
if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Expedientes</title>
     <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <?php require_once "menu.php"; ?>
    <link rel="stylesheet" type="text/css" href="../css/personal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div   class="container">
        <h1 class="text-center">Gestión de Expedientes</h1>
        
        <div class="row">
            <div class="col-sm-4">
                <form  id="frmExpediente">
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
                Swal.fire({
                    icon: 'error',
                    title: 'Campos vacíos',
                    text: 'Por favor, llene todos los campos',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            datos = $('#frmExpediente').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "../procesos/expedientes/agregarExpediente.php",
                dataType: 'json',
                success: function(response){
                    console.log("Respuesta del servidor:", response);
                    try {
                        if(response.success){
                            $('#frmExpediente')[0].reset();
                            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    } catch (error) {
                        console.error('Error al procesar la respuesta:', error);
                        console.log('Respuesta raw:', response);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Advertencia',
                            text: 'El expediente parece haberse agregado, pero hubo un problema al procesar la respuesta. Por favor, verifica y recarga la página.',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                        });
                    }
                },
                error: function(xhr, status, error){
                    console.error('Error AJAX:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        });

        $('#btnSubirImagenes').click(function() {
            subirImagenes();
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
            beforeSend: function() {
                $('#contenedorImagenes').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-3x"></i></div>');
            },
            success: function(response) {
                $('#contenedorImagenes').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar imágenes:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar las imágenes',
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    }

    function subirImagenes() {
        var formData = new FormData($('#formAgregarImagenes')[0]);
        var files = $('#imagenes')[0].files;
        
        if (files.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor seleccione al menos una imagen',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Mostrar progreso
        $('.progress').show();
        $('#btnSubirImagenes').prop('disabled', true);

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
                console.log("Respuesta del servidor:", response);
                try {
                    let resultado = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if(resultado.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: resultado.message,
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            $('#modalAgregarImagenes').modal('hide');
                            $('#formAgregarImagenes')[0].reset();
                            if($('#id_expediente_agregar').val()) {
                                cargarImagenes($('#id_expediente_agregar').val());
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: resultado.message || 'Error al subir las imágenes',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                } catch(e) {
                    console.error('Error al procesar la respuesta:', e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al procesar la respuesta del servidor',
                        confirmButtonColor: '#3085d6'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al subir las imágenes: ' + error,
                    confirmButtonColor: '#3085d6'
                });
            },
            complete: function() {
                $('#btnSubirImagenes').prop('disabled', false);
                $('.progress').hide();
                $('.progress-bar').width('0%');
            }
        });
    }

    function eliminarExpediente(idExpediente) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: { id_expediente: idExpediente },
                    url: "../procesos/expedientes/eliminarExpediente.php",
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error AJAX:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al intentar eliminar: ' + error,
                            confirmButtonColor: '#3085d6'
                        });
                    }
                });
            }
        });
    }

    // Validación de archivos al seleccionarlos
    $('#imagenes').on('change', function() {
        const files = this.files;
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        let hasError = false;

        Array.from(files).forEach(file => {
            if (file.size > maxSize) {
                hasError = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `El archivo ${file.name} excede el tamaño máximo permitido de 5MB`,
                    confirmButtonColor: '#3085d6'
                });
            }
            if (!allowedTypes.includes(file.type)) {
                hasError = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `El archivo ${file.name} no es un tipo de imagen permitido`,
                    confirmButtonColor: '#3085d6'
                });
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
    </script>
</body>
</html>

<?php 
} else {
    header("location:../index.php");
}
?>