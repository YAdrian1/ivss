<?php 
session_start();
if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expedientes</title>
    <?php require_once "menu.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .imagen-miniatura {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin: 5px;
        }
        .btn-spinner {
            position: relative;
        }
        .btn-spinner.loading::after {
            content: '';
            position: absolute;
            width: 1em;
            height: 1em;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Expedientes</h1>
        
        <!-- Formulario para agregar expediente -->
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel panel-heading">
                        <h3 class="panel-title">Nuevo Expediente</h3>
                    </div>
                    <div class="panel panel-body">
                        <form id="frmExpediente">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control input-sm" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label>Apellido</label>
                                <input type="text" class="form-control input-sm" id="apellido" name="apellido" required>
                            </div>
                            <div class="form-group">
                                <label>Cédula</label>
                                <input type="text" class="form-control input-sm" id="cedula" name="cedula" required>
                            </div>
                            <button type="button" class="btn btn-primary btn-block btn-spinner" id="btnAgregarExpediente">
                                <i class="fas fa-save"></i> Agregar Expediente
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="panel panel-primary">
                    <div class="panel panel-heading">
                        <h3 class="panel-title">Lista de Expedientes</h3>
                    </div>
                    <div class="panel panel-body">
                        <div id="tablaExpedientesLoad"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para imágenes -->
    <div class="modal fade" id="modalImagenes" tabindex="-1" role="dialog" aria-labelledby="modalImagenesLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalImagenesLabel">Imágenes del Expediente</h4>
                </div>
                <div class="modal-body">
                    <form id="frmSubirImagen" enctype="multipart/form-data">
                        <input type="hidden" id="id_expediente" name="id_expediente">
                        <div class="form-group">
                            <label>Seleccionar Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Subir Imagen
                        </button>
                    </form>
                    <hr>
                    <div id="galeriaImagenes" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            // Cargar tabla inicial
            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");

            // Manejar el envío del formulario de expediente
            $('#btnAgregarExpediente').click(function(){
                var $btn = $(this);
                var vacios = validarFormVacio('frmExpediente');
                
                if(vacios > 0){
                    alertify.alert("Debes llenar todos los campos");
                    return false;
                }

                var datos = $('#frmExpediente').serialize();
                $btn.prop('disabled', true).addClass('loading');
                
                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../procesos/expedientes/agregarExpediente.php",
                    success: function(r){
                        if(r == 1){
                            $('#frmExpediente')[0].reset();
                            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                            alertify.success("Expediente agregado con éxito");
                        } else {
                            alertify.error("No se pudo agregar el expediente");
                        }
                    },
                    error: function(){
                        alertify.error("Error de conexión");
                    },
                    complete: function(){
                        $btn.prop('disabled', false).removeClass('loading');
                    }
                });
            });

            // Manejar el envío de imágenes
            $('#frmSubirImagen').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var $btn = $(this).find('button[type="submit"]');
                
                $btn.prop('disabled', true).addClass('loading');
                
                $.ajax({
                    type: "POST",
                    url: "../procesos/expedientes/subirImagen.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(r){
                        if(r == 1){
                            $('#imagen').val('');
                            cargarImagenes($('#id_expediente').val());
                            alertify.success("Imagen subida con éxito");
                        } else {
                            alertify.error("No se pudo subir la imagen");
                        }
                    },
                    error: function(){
                        alertify.error("Error al subir la imagen");
                    },
                    complete: function(){
                        $btn.prop('disabled', false).removeClass('loading');
                    }
                });
            });
        });

        function abrirModalImagenes(idExpediente){
            $('#id_expediente').val(idExpediente);
            $('#modalImagenes').modal('show');
            cargarImagenes(idExpediente);
        }

        function cargarImagenes(idExpediente){
            $.ajax({
                type: "POST",
                data: {id_expediente: idExpediente},
                url: "../procesos/expedientes/obtenerImagenes.php",
                               success: function(r){
                    $('#galeriaImagenes').html(r);
                },
                error: function(){
                    alertify.error("Error al cargar las imágenes");
                }
            });
        }

        function eliminarImagen(idImagen, idExpediente){
            alertify.confirm('¿Está seguro de eliminar esta imagen?', function(){ 
                $.ajax({
                    type: "POST",
                    data: {id_imagen: idImagen},
                    url: "../procesos/expedientes/eliminarImagen.php",
                    success: function(r){
                        if(r == 1){
                            cargarImagenes(idExpediente);
                            alertify.success("Imagen eliminada con éxito");
                        } else {
                            alertify.error("No se pudo eliminar la imagen");
                        }
                    },
                    error: function(){
                        alertify.error("Error al eliminar la imagen");
                    }
                });
            }, function(){
                alertify.error('Operación cancelada')
            });
        }

        function eliminarExpediente(idExpediente){
            alertify.confirm('¿Está seguro de eliminar este expediente?', function(){ 
                $.ajax({
                    type: "POST",
                    data: {id_expediente: idExpediente},
                    url: "../procesos/expedientes/eliminarExpediente.php",
                    success: function(r){
                        if(r == 1){
                            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                            alertify.success("Expediente eliminado con éxito");
                        } else {
                            alertify.error("No se pudo eliminar el expediente");
                        }
                    },
                    error: function(){
                        alertify.error("Error al eliminar el expediente");
                    }
                });
            }, function(){
                alertify.error('Operación cancelada')
            });
        }

        function editarExpediente(idExpediente){
            $.ajax({
                type: "POST",
                data: {id_expediente: idExpediente},
                url: "../procesos/expedientes/obtenerDatosExpediente.php",
                success: function(r){
                    datos = jQuery.parseJSON(r);
                    $('#idExpediente').val(datos['id_expediente']);
                    $('#nombreU').val(datos['nombre']);
                    $('#apellidoU').val(datos['apellido']);
                    $('#cedulaU').val(datos['cedula']);
                },
                error: function(){
                    alertify.error("Error al obtener datos del expediente");
                }
            });
        }

        $('#btnActualizarExpediente').click(function(){
            var datos = $('#frmExpedienteU').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "../procesos/expedientes/actualizarExpediente.php",
                success: function(r){
                    if(r == 1){
                        $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                        alertify.success("Expediente actualizado con éxito");
                    } else {
                        alertify.error("No se pudo actualizar el expediente");
                    }
                },
                error: function(){
                    alertify.error("Error al actualizar el expediente");
                }
            });
        });
    </script>
</body>
</html>
<?php 
} else {
    header("location:../index.php");
}
?>