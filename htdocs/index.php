<?php 
	
	require_once "clases/Conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$sql="SELECT * from usuarios where email='admin'";
	$result=mysqli_query($conexion,$sql);
	$validar=0;
	if(mysqli_num_rows($result) > 0){
		$validar=1;
	}
 ?>


<!DOCTYPE html>
<html>
<head>
	 <link rel="icon" href="../img/faviconn.ico" type="image/x-icon">
	<title>Inicio de Secion</title>
	<link rel="stylesheet" type="text/css" href="css.index.css">
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<script src="librerias/jquery-3.2.1.min.js"></script>
	<script src="js/funciones.js"></script>
</head>
<body style="background-image: url(img/fondo.png); background-repeat: no-repeat; background-size: 100% 120%;">
	<br><br><br>
	<div style="margin-top: 80px;" class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div  class="panel panel-heading" style="text-align: center;">IVSS</div>
					<div class="panel panel-body">
						<p>
							<img src="img\logo1.png"  height="200px" width="200px" style="margin-left: 20%">
						</p>
						<form id="frmLogin">
							<label style="margin-left: 40%">Usuario</label>
							<input type="text" class="form-control input-sm" name="usuario" id="usuario">
							<label style="margin-left: 36%">Contraseña</label>
							<input type="password" name="password" id="password" class="form-control input-sm">
							<p></p>
							<span class="btn btn-primary btn-sm" id="entrarSistema">Entrar</span>
							<?php  if(!$validar): ?>
							<a href="registro.php" class="btn btn-danger btn-sm">Registrar</a>
							<?php endif; ?>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#entrarSistema').click(function(){

		vacios=validarFormVacio('frmLogin');

			if(vacios > 0){
				alert("Debes llenar todos los campos!!");
				return false;
			}

		datos=$('#frmLogin').serialize();
		$.ajax({
			type:"POST",
			data:datos,
			url:"procesos/regLogin/login.php",
			success:function(r){

				if(r==1){
					window.location="vistas/inicio.php";
				}else{
					alert("No se pudo acceder :(");
				}
			}
		});
	});
	});
</script>