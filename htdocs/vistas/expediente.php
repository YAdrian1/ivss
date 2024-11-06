<?php 
session_start();
if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Expedientes</title>
    <?php require_once "menu.php"; ?>
    <!-- Asegúrate de que estas dependencias estén incluidas -->
    <link rel="stylesheet" type="text/css" href="../librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../librerias/alertifyjs/css/themes/default.css">
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

    <script type="text/javascript">
        $(document).ready(function(){
            // Cargar tabla inicial
            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");

            $('#btnAgregarExpediente').click(function(){
                if($('#nombre').val() == '' || $('#apellido').val() == ''){
                    alertify.alert("Debes llenar todos los campos!");
                    return false;
                }

                datos = $('#frmExpediente').serialize();
                console.log("Datos a enviar:", datos); // Debug

                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../procesos/expedientes/agregarExpediente.php",
                    success: function(r){
                        console.log("Respuesta del servidor:", r); // Debug
                        if(r == 1){
                            $('#frmExpediente')[0].reset();
                            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                            alertify.success("Expediente agregado con éxito");
                        }else{
                            alertify.error("No se pudo agregar el expediente");
                        }
                    },
                    error: function(xhr, status, error){
                        console.log("Error en AJAX:", error); // Debug
                        alertify.error("Error en la petición AJAX");
                    }
                });
            });
        });

        function eliminarExpediente(idExpediente){
            alertify.confirm('¿Desea eliminar este expediente?', function(){ 
                $.ajax({
                    type: "POST",
                    data: "idExpediente=" + idExpediente,
                    url: "../procesos/expedientes/eliminarExpediente.php",
                    success: function(r){
                        if(r == 1){
                            $('#tablaExpedientesLoad').load("expedientes/tablaExpedientes.php");
                            alertify.success("Eliminado con éxito!");
                        }else{
                            alertify.error("No se pudo eliminar");
                        }
                    }
                });
            }, function(){ 
                alertify.error('Cancelado')
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