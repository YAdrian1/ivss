<?php 
session_start();
if(isset($_SESSION['usuario']) and $_SESSION['usuario']=='admin'){
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>usuarios</title>
		 <link rel="icon" href="../img/faviconn.ico" type="image/x-icon">
		<?php require_once "menu.php"; ?>
		<link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.css">
		<script src="../librerias/jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	</head>
	<body>
		<div class="container">
			<h1>Administrar usuarios</h1>
			
			<div class="row">
				<div class="col-sm-4">
					<form id="frmRegistro">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" name="nombre" id="nombre">
						<label>Apellido</label>
						<input type="text" class="form-control input-sm" name="apellido" id="apellido">
						<label>Usuario</label>
						<input type="text" class="form-control input-sm" name="usuario" id="usuario">
						<label>Password</label>
						<input type="text" class="form-control input-sm" name="password" id="password">
						<p></p>
						<span class="btn btn-primary" id="registro">Registrar</span>
					</form>
				</div>
				<div class="col-sm-7">
					<div id="tablaUsuariosLoad"></div>
				</div>
			</div>

	<style>

        .button-container {

            position: fixed;

            left: 0; /* Alineado a la izquierda */

            bottom: 0; /* Alineado al fondo */

            display: flex;

            flex-direction: column; /* Coloca los grupos de botones en columnas */

            align-items: flex-start; /* Alinea los botones a la izquierda */

            margin: 10px; /* Espacio alrededor de los botones */

        }


        .button-row {

            display: flex; /* Muestra los botones en una fila */

            margin-bottom: 10px; /* Espacio entre las filas de botones */

        }


        button {

            margin-right: 10px; /* Espacio entre los botones en la misma fila */

        }
  .margin-custom {
    	position: fixed;
    	left: 80%;
        top: 92%; /* Ajusta el valor según sea necesario */
    }
    </style>

</head>

<body>

    <div class="button-container">

        <div class="button-row">

            <button onclick="window.location.href='Administracion.php';">Combinar Administracion</button>

            <button onclick="window.location.href='Odontologia.php';">Combinar Odontologia</button>

            <button onclick="window.location.href='rayosx.php';">Combinar Rayos X</button>

            <button onclick="window.location.href='Laboratorio.php';">Combinar Historias Medicas</button>

            <button onclick="window.location.href='Medicas.php';">Combinar Laboratorio</button>

        </div>

        <div class="button-row">

            <button  onclick="window.location.href='cambioadministracion.php';">Nombrar Administracion</button>

            <button  style="margin-left: 8px;" onclick="window.location.href='cambioodontologia.php';">Nombrar Odontologia</button>

            <button  style="margin-left: 6px;" onclick="window.location.href='cambiorayosx.php';">Nombrar Rayos X</button>

            <button  style="margin-left: 8px;" onclick="window.location.href='cambiohistorias.php';">Nombrar Historias Medicas</button>

            <button  style="margin-left: 6px;" onclick="window.location.href='cambiolaboratorio.php';">Nombrar Laboratorio</button>

        </div>

    </div>
<!-- Botón para crear carpetas en la parte inferior derecha -->
<div class="text-right margin-custom">
    <button id="crear-carpetas" class="btn btn-success">Crear Carpetas para Todas las Áreas</button>
</div>

		</div>

		<!-- Modal -->
		<div class="modal fade" id="actualizaUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Actualiza Usuario</h4>
					</div>
					<div class="modal-body">
						<form id="frmRegistroU">
							<input type="text" hidden="" id="idUsuario" name="idUsuario">
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" name="nombreU" id="nombreU">
							<label>Apellido</label>
							<input type="text" class="form-control input-sm" name="apellidoU" id="apellidoU">
							<label>Usuario</label>
							<input type="text" class="form-control input-sm" name="usuarioU" id="usuarioU">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnActualizaUsuario" type="button" class="btn btn-warning" data-dismiss="modal">Actualiza Usuario</button>
					</div>
				</div>
			</div>
		</div>

		<script>
			$(document).ready(function() {
				$('#crear-carpetas').click(function() {
					// Recopilar todas las áreas en un array
					var areas = [];
					<?php 
					// Conectar a la base de datos para obtener las áreas
					require_once "../clases/Conexion.php"; 
					$c = new conectar();
					$conexion = $c->conexion();
									$sql = "SELECT id, nombre FROM areas";
					$result = mysqli_query($conexion, $sql);
					while ($row = mysqli_fetch_assoc($result)): ?>
						areas.push({ id: <?php echo $row['id']; ?>, nombre: '<?php echo htmlspecialchars($row['nombre']); ?>' });
					<?php endwhile; ?>

					$.ajax({
						url: 'crear_carpetas.php', // Asegúrate de que esta ruta es correcta
						type: 'POST',
						data: { areas: areas },
						success: function(response) {
							if (response.success) {
								// Mostrar alerta de éxito
								swal("¡Éxito!", "Las carpetas se han creado exitosamente.", "success");
							} else {
								// Mostrar alerta de error
								swal("¡Error!", response.errors.join(", "), "error");
							}
						},
						error: function() {
							swal("¡Error!", "Error al crear las carpetas.", "error");
						}
					});
				});
			});
		</script>

		<script type="text/javascript">
			function agregaDatosUsuario(idusuario){
				$.ajax({
					type:"POST",
					data:"idusuario=" + idusuario,
					url:"../procesos/usuarios/obtenDatosUsuario.php",
					success:function(r){
						dato=jQuery.parseJSON(r);
						$('#idUsuario').val(dato['id_usuario']);
						$('#nombreU').val(dato['nombre']);
						$('#apellidoU').val(dato['apellido']);
						$('#usuarioU').val(dato['email']);
					}
				});
			}

			function eliminarUsuario(idusuario){
				alertify.confirm('¿Desea eliminar este usuario?', function(){ 
					$.ajax({
						type:"POST",
						data:"idusuario=" + idusuario,
						url:"../procesos/usuarios/eliminarUsuario.php",
						success:function(r){
							if(r==1){
								$('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');
								alertify.success("Eliminado con exito!!");
							}else{
								alertify.error("No se pudo eliminar :(");
							}
						}
					});
				}, function(){ 
					alertify.error('Cancelo !')
				});
			}

			$(document).ready(function(){
				$('#btnActualizaUsuario').click(function(){
					datos=$('#frmRegistroU').serialize();
					$.ajax({
						type:"POST",
						data:datos,
						url:"../procesos/usuarios/actualizaUsuario.php",
						success:function(r){
							if(r==1){
								$('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');
								alertify.success("Actualizado con exito :D");
							}else{
								alertify.error("No se pudo actualizar :(");
							}
						}
					});
				});
			});

			$(document).ready(function(){
				$('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');

				$('#registro').click(function(){
					vacios=validarFormVacio('frmRegistro');

					if(vacios > 0){
						alertify.alert("Debes llenar todos los campos!!");
						return false;
					}

					datos=$('#frmRegistro').serialize();
					$.ajax({
						type:"POST",
						data:datos,
						url:"../procesos/regLogin/registrarUsuario.php",
						success:function(r){
							if(r==1){
								$('#frmRegistro')[0].reset();
								$('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');
								alertify.success("Agregado con exito");
							}else{
								alertify.error("Fallo al agregar :(");
							}
						}
					});
				});
			});
		</script>

	<?php 
	mysqli_close($conexion);
} else {
	header("location:../index.php");
}
?>