<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Codigos</title>
<body>
<style type="text/css">
	table.tableizer-table {
		font-size: 12px;
		border: 1px solid #CCC; 
		font-family: Arial, Helvetica, sans-serif;
	} 
	.tableizer-table td {
		padding: 4px;
		margin: 3px;
		border: 1px solid #CCC;
	}
	.tableizer-table th {
		background-color: #104E8B; 
		color: #FFF;
		font-weight: bold;
	}
</style>
<table class="tableizer-table">
<thead><tr class="tableizer-firstrow"><th>SERVICIO</th><th>CODIGO</th></tr></thead><tbody>
 <tr><td>MEDICINA GENERAL</td><td>SFC001</td></tr>
 <tr><td>CIRUGIA</td><td>SFC002</td></tr>
 <tr><td>GINECOLOGIA</td><td>SFC003</td></tr>
 <tr><td>PEDRIATRIA</td><td>SFC004</td></tr>
 <tr><td>ODONTOLOGIA</td><td>SFC005</td></tr>
 <tr><td>TRAUMATOLOGIA</td><td>SFC007</td></tr>
 <tr><td>ESP/MEDICINA FAMILIAR</td><td>SFC008</td></tr>
 <tr><td>MEDICINA INTERNA</td><td>SFC009</td></tr>
 <tr><td>OBSTETRICIA</td><td>SFC010</td></tr>
 <tr><td>FARMACIA</td><td>SAC002</td></tr>
 <tr><td>LABORATORIO</td><td>SAC003</td></tr>
 <tr><td>RAYOS X</td><td>SAC004</td></tr>
 <tr><td>APOYO DE RED</td><td>AR</td></tr>
 <tr><td>ADMINISTRACIÓN</td><td>SAC005</td></tr>
</tbody></table>

</body>
</html>
<?php 
	}else{
		header("location:../../index.php");
	}
 ?>