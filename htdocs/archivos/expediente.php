<?php 
session_start();
if(isset($_SESSION['usuario'])){

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>articulos</title>
		<?php require_once "menu.php"; ?>
		<?php require_once "../clases/Conexion.php"; 
		?>
	</head>
	<body>
		<div class="container">
			<h1>A</h1>
			<div class="row">
				<div class="col-sm-4">
					<form  enctype="multipart/form-data">
						<label>Categoria</label>
						<select class="form-control input-sm"  name="categoriaSelect">
							<option value="A">Selecciona Categoria</option>
						</select>
						<label>Imagesssn</label>
						<input type="file"  name="imagen"><label>Imagesssn</label>
						<input type="file"  name="imagen"><label>Imagesssn</label>
						<input type="file"  name="imagen"><label>Imagesssn</label>
						<input type="file"  name="imagen"><label>Imagesssn</label>
						<input type="file"  name="imagen"><label>Imagesssn</label>
						<input type="file"  name="imagen"><label>Imagesssn</label>
						<input type="file"  name="imagen">
						<label>Imagesssn</label>
						<input type="file" id="imagen6" name="imagen">
						<p></p>
						<span id="btnAgregaArticulo" class="btn btn-primary">Agregar</span>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tablaArticulosLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->
		
		<!-- Modal -->
		<div class="modal fade" id="abremodalUpdateArticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Actualiza Articulo</h4>
					</div>
					<div class="modal-body">
						<form  enctype="multipart/form-data">
							<input type="text" id="idArticulo" hidden="" name="idArticulo">
							<label>Categoria</label>
							<select class="form-control input-sm"  name="categoriaSelectU">
								<option value="A">Selecciona Categoria</option>
							</select>
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
							<label>Descripcion</label>
							<input type="text" class="form-control input-sm" id="descripcionU" name="descripcionU">
							<label>Cantidad</label>
							<input type="text" class="form-control input-sm" id="cantidadU" name="cantidadU">
							<label>Precio</label>
							<input type="text" class="form-control input-sm" id="precioU" name="precioU">
							
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnActualizaarticulo" type="button" class="btn btn-warning" data-dismiss="modal">Actualizar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");	
			});	
	</script>
	<?php 
}else{
	header("location:../index.php");
}
?>




	
