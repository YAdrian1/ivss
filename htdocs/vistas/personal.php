<?php 

session_start();

if(isset($_SESSION['usuario'])){

?>



<!DOCTYPE html>
<html lang="es">
<head>
	 <link rel="icon" href="../img/faviconn.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/personal.css">
    <title>inicio</title>
    <?php require_once "menu.php"; ?>


			
</head>
<body>
    



<div  class="container shadow-lg p-3 mb-5 mt-5 bg-body rounded">
        <div  style="border:none; text-align: center;" class="row">
            <div class="col">
                <table   id="myTable" class="table table-striped dataTable no-footer" style="width:100%;">
                  		<thead>
					<tr>
						<th style="text-align: center;">nombre_cargo</th>
						<th style="text-align: center;">apellido</th>
						<th style="text-align: center;">nombre1</th>
						<th style="text-align: center;">cedula1</th>
						<th style="text-align: center;">descripcionTE</th>
						<th style="text-align: center;">fecha_ingreso</th>
					</tr>
				</thead>
					<tbody>
						
					<tr>
						<td>ALMACENISTA II</td>
						<td>ANDARA</td>
						<td>ELENA</td>
						<td>6100540</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/01/1996</td>
					</tr>
					<tr>
						<td>ALMACENISTA II</td>
						<td>CAMACARO</td>
						<td>JORGE</td>
						<td>10115652</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>15/10/2003</td>
					</tr>
					<tr>
						<td>ALMACENISTA II</td>
						<td>VALDERRAMA</td>
						<td>MAIRA</td>
						<td>16627392</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>15/08/2007</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO III</td>
						<td>TORO</td>
						<td>JOSE</td>
						<td>17080111</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/08/2002</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO III</td>
						<td>GARCIA</td>
						<td>YESENIA</td>
						<td>15986652</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>16/07/2012</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO III</td>
						<td>MORENO</td>
						<td>NANCY</td>
						<td>10745641</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/01/2004</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO III</td>
						<td>BRICEÑO</td>
						<td>MARY CARMEN</td>
						<td>15605583</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/09/2022</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO III</td>
						<td>ALVARADO</td>
						<td>YANETH</td>
						<td>11200791</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/08/2002</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO III</td>
						<td>MARTINEZ</td>
						<td>LENNY</td>
						<td>6360293</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>16/01/2005</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO III</td>
						<td>MARTINEZ</td>
						<td>SHERYL</td>
						<td>20096415</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>19/11/2020</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO IV</td>
						<td>ORTIZ</td>
						<td>SOLANGE</td>
						<td>11675375</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/12/2006</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO IV</td>
						<td>TORRES</td>
						<td>MAIGUALIDA</td>
						<td>16331545</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>16/02/2017</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO IV</td>
						<td>VASQUEZ</td>
						<td>GERMAN</td>
						<td>9221694</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>02/01/2008</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO IV</td>
						<td>HERNANDEZ</td>
						<td>DAYMAR</td>
						<td>16900810</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>16/08/2014</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO IV</td>
						<td>COLMENARES</td>
						<td>MARTHA</td>
						<td>14195624</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/06/2007</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO V</td>
						<td>VASQUEZ</td>
						<td>YANITZA</td>
						<td>13432060</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>30/05/2022</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO V</td>
						<td>CORONADO</td>
						<td>CARLA</td>
						<td>11940553</td>
						<td>ALTO NIVEL</td>
						<td>01/08/2002</td>
					</tr>
					<tr>
						<td>ASISTENTE  ADMINISTRATIVO V</td>
						<td>COLMENARES</td>
						<td>CARMEN</td>
						<td>6342283</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>13/12/2021</td>
					</tr>
					<tr>
						<td>ASISTENTE DE ANALISTA III</td>
						<td>ALGARA</td>
						<td>KEIDY</td>
						<td>28444622</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>16/06/2023</td>
					</tr>
					<tr>
						<td>CONTADOR I</td>
						<td>AZUAJE</td>
						<td>SOLANYER</td>
						<td>11944839</td>
						<td>ALTO NIVEL</td>
						<td>01/07/2001</td>
					</tr>
					<tr>
						<td>SECRETARIO EJECUTIVO II</td>
						<td>LUCENA</td>
						<td>LUCECITA</td>
						<td>6254982</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>14/05/2021</td>
					</tr>
					<tr>
						<td>SECRETARIO EJECUTIVO II</td>
						<td>ORTEGA</td>
						<td>KATOUSCHA</td>
						<td>14721048</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>17/11/2020</td>
					</tr>
					<tr>
						<td>SECRETARIO EJECUTIVO II</td>
						<td>ALBORNOZ</td>
						<td>EMELY</td>
						<td>21438410</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/10/2018</td>
					</tr>
					<tr>
						<td>SECRETARIO EJECUTIVO III</td>
						<td>RUDA</td>
						<td>AYDE</td>
						<td>10828312</td>
						<td>ADMIN-EMPLEADOS-FIJOS</td>
						<td>01/02/2006</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MORA</td>
						<td>ADRIAN</td>
						<td>27569533</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>01/10/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>NAVA</td>
						<td>JOHANDRY</td>
						<td>29720306</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>01/12/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>NUÑEZ</td>
						<td>LEIDY</td>
						<td>6032401</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>19/02/2020</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>RIVAS</td>
						<td>MAJAUYURI</td>
						<td>13583646</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>16/04/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>CORTEZ</td>
						<td>JENNIFER</td>
						<td>17476834</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>01/12/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>CACERES</td>
						<td>JEANOSKY</td>
						<td>30990409</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>01/10/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>GONZALEZ</td>
						<td>FRANCYS</td>
						<td>24203903</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>01/11/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MANCHEGO</td>
						<td>LEIDY</td>
						<td>17693559</td>
						<td>ADMIN-EMPLEADOS-CONTRATADOS</td>
						<td>15/04/2023</td>
					</tr>
					<tr>
						<td>MEDICO I</td>
						<td>PAREDES</td>
						<td>JESUS</td>
						<td>19153419</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>13/12/2021</td>
					</tr>
					<tr>
						<td>MEDICO I</td>
						<td>SIMANCA</td>
						<td>NORVYS</td>
						<td>20630942</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>13/12/2021</td>
					</tr>
					<tr>
						<td>MEDICO I</td>
						<td>SIMANCAS</td>
						<td>LISETH</td>
						<td>15738450</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>13/12/2021</td>
					</tr>
					<tr>
						<td>MEDICO I</td>
						<td>VARGAS DE</td>
						<td>CARMEN</td>
						<td>16233432</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>31/01/2022</td>
					</tr>
					<tr>
						<td>MEDICO II</td>
						<td>MAIZO</td>
						<td>CESAR</td>
						<td>4577781</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>01/07/1993</td>
					</tr>
					<tr>
						<td>MEDICO II</td>
						<td>RANGEL</td>
						<td>AIDEE</td>
						<td>6687225</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>02/02/2007</td>
					</tr>
					<tr>
						<td>ODONTOLOGO II</td>
						<td>CARMONA</td>
						<td>VIRGINIA</td>
						<td>10380294</td>
						<td>ASIST-ODONTOLOGOS-FIJOS</td>
						<td>01/10/1999</td>
					</tr>
					<tr>
						<td>ODONTOLOGO III</td>
						<td>OMAÑA</td>
						<td>OMAIRA</td>
						<td>5431836</td>
						<td>ASIST-ODONTOLOGOS-FIJOS</td>
						<td>13/05/2019</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA I</td>
						<td>ALVAREZ</td>
						<td>LISBETH</td>
						<td>12378697</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>15/04/2023</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>GOTTBERG</td>
						<td>OLGA</td>
						<td>10719571</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>16/09/2012</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>VILLEGAS</td>
						<td>OSWALDO</td>
						<td>6525210</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>16/09/2016</td>
					</tr>
					<tr>
						<td>MEDICO ADJUNTO II</td>
						<td>GODOY</td>
						<td>JONELLY</td>
						<td>12591074</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>01/01/2010</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA I</td>
						<td>HERRADA</td>
						<td>CESAR</td>
						<td>6861966</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>01/03/2018</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>LEAL</td>
						<td>RAFAEL</td>
						<td>7560869</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>01/01/2008</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>REAL</td>
						<td>FRANCIA</td>
						<td>8532594</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>01/01/2008</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>PEREZ</td>
						<td>MARIA</td>
						<td>3969416</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>01/05/2002</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>BERMUDEZ</td>
						<td>JUAN</td>
						<td>5426691</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>16/01/2002</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>VIVAS</td>
						<td>ALBERTO</td>
						<td>3626870</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>05/09/1994</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>RAMIREZ</td>
						<td>ANGEL</td>
						<td>4251980</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>16/08/2018</td>
					</tr>
					<tr>
						<td>MEDICO ESPECIALISTA II</td>
						<td>LAU</td>
						<td>MAGDALENA</td>
						<td>5218258</td>
						<td>ASIST-MEDICOS-FIJOS</td>
						<td>10/10/1995</td>
					</tr>
					<tr>
						<td>ASISTENTE DE FARMACIA I</td>
						<td>MENDOZA</td>
						<td>ZULAY</td>
						<td>15928657</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/09/2022</td>
					</tr>
					<tr>
						<td>ASISTENTE DE FARMACIA II</td>
						<td>CASTRO</td>
						<td>ACNERYS</td>
						<td>11692904</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/12/2008</td>
					</tr>
					<tr>
						<td>ASISTENTE DE FARMACIA II</td>
						<td>GONZALEZ</td>
						<td>RIGOBERTO</td>
						<td>10809540</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/08/2002</td>
					</tr>
					<tr>
						<td>ASISTENTE DE FARMACIA II</td>
						<td>VILLAMIZAR</td>
						<td>SOLYMAR</td>
						<td>10528062</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/11/2002</td>
					</tr>
					<tr>
						<td>AYUDANTE DE ALMACEN</td>
						<td>BRITO</td>
						<td>RICHARD</td>
						<td>16023152</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>01/02/2007</td>
					</tr>
					<tr>
						<td>ASISTENTE DE LABORATORIO CLINICO I</td>
						<td>VILLALBA</td>
						<td>YELITZA</td>
						<td>13969420</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/09/2013</td>
					</tr>
					<tr>
						<td>ASISTENTE DE LABORATORIO CLINICO II</td>
						<td>GIL</td>
						<td>LUIS</td>
						<td>6296074</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/12/2012</td>
					</tr>
					<tr>
						<td>ASISTENTE DE LABORATORIO CLINICO II</td>
						<td>SILVA</td>
						<td>MARIA</td>
						<td>24940807</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/02/2020</td>
					</tr>
					<tr>
						<td>ASISTENTE DE LABORATORIO CLINICO II</td>
						<td>QUINTERO</td>
						<td>ILENNY</td>
						<td>18222507</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/05/2014</td>
					</tr>
					<tr>
						<td>AUXILIAR DE LABORATORIO</td>
						<td>BRICENO</td>
						<td>NORJEISY</td>
						<td>20827435</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>01/09/2015</td>
					</tr>
					<tr>
						<td>RECEPCIONISTA</td>
						<td>DIAZ</td>
						<td>YOCCY</td>
						<td>22522302</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>15/10/2019</td>
					</tr>
					<tr>
						<td>RECEPCIONISTA</td>
						<td>FIGUEREDO</td>
						<td>MAIREG</td>
						<td>26279109</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>10/06/2019</td>
					</tr>
					<tr>
						<td>CAMARERA</td>
						<td>BRITO</td>
						<td>ROSA</td>
						<td>12061087</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>16/12/2008</td>
					</tr>
					<tr>
						<td>CAMARERA</td>
						<td>LOPEZ</td>
						<td>MARVIN</td>
						<td>14675919</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>02/03/2022</td>
					</tr>
					<tr>
						<td>CAMARERA</td>
						<td>NUÑEZ</td>
						<td>SOLXIRE</td>
						<td>15928406</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>02/03/2022</td>
					</tr>
					<tr>
						<td>CAMARERA</td>
						<td>BOLIVAR</td>
						<td>ANNYS</td>
						<td>19689843</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>01/07/2022</td>
					</tr>
					<tr>
						<td>CAMARERA</td>
						<td>NARVAEZ</td>
						<td>MIROSLABA</td>
						<td>12820519</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>14/08/2020</td>
					</tr>
					<tr>
						<td>CAMILLERO</td>
						<td>PERAZA</td>
						<td>JESUS</td>
						<td>15313278</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>01/04/2019</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) I</td>
						<td>PEREZ</td>
						<td>ROSANA</td>
						<td>20606620</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/11/2022</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) I</td>
						<td>SILVA</td>
						<td>ROXI</td>
						<td>14017800</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>15/04/2023</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) I</td>
						<td>CABAÑA</td>
						<td>YOLIMAR</td>
						<td>16028028</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>02/03/2022</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) I</td>
						<td>MONTERO</td>
						<td>DOANY</td>
						<td>26994288</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/06/2022</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) I</td>
						<td>VASQUEZ</td>
						<td>KATHERINE</td>
						<td>22748017</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/01/2023</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>AMARO</td>
						<td>RAQUEL</td>
						<td>17390583</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>06/03/2019</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>IRISA</td>
						<td>RUTH</td>
						<td>15930086</td>
						<td>ALTO NIVEL</td>
						<td>01/09/2006</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>PEREZ</td>
						<td>KEYLA</td>
						<td>17478184</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>10/06/2019</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>REYES</td>
						<td>YRIANTHANAIS</td>
						<td>13463217</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>25/04/2022</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>SILVA</td>
						<td>CARMEN</td>
						<td>17100646</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/04/2019</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>TREJO</td>
						<td>LEYDA</td>
						<td>15421101</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>23/06/2021</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>CASTRO</td>
						<td>YORLIN</td>
						<td>16662418</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>31/01/2022</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>GERVIS</td>
						<td>NAIROVIS</td>
						<td>12861132</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>20/10/2021</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>RANGEL</td>
						<td>LAURA</td>
						<td>12112517</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/08/2022</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>RANGEL</td>
						<td>GREGORI</td>
						<td>12418096</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>15/03/2023</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>CASTILLO</td>
						<td>YOLANI</td>
						<td>15186873</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>06/03/2020</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>PORTILLA</td>
						<td>YULY</td>
						<td>13888724</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>02/07/2020</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>SULBARAN</td>
						<td>SOLIANNY</td>
						<td>15793476</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/07/2019</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>HERNANDEZ</td>
						<td>DAYANA</td>
						<td>13088009</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>27/11/2018</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) II</td>
						<td>BARRIENTOS</td>
						<td>YOLIMAR</td>
						<td>12112334</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/12/2006</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>VEGA</td>
						<td>MARIBEL</td>
						<td>11932378</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/08/2011</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>BRAVO</td>
						<td>VIANEY</td>
						<td>14584744</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/12/2008</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>LOPEZ</td>
						<td>EURIDICE</td>
						<td>12295551</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/12/2008</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>GARCIA</td>
						<td>YUNEIKA</td>
						<td>16265019</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/06/2007</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>LOZADA</td>
						<td>ENA</td>
						<td>10398382</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/10/2013</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>LOZADA</td>
						<td>IRIA</td>
						<td>9172578</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>06/03/2003</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>MENDEZ</td>
						<td>YUMARI</td>
						<td>6728071</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/02/1994</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>CHOURIO</td>
						<td>MARIA</td>
						<td>10239643</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/09/2018</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>FUENTES</td>
						<td>ROCIO</td>
						<td>15343391</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/04/2007</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>QUEVEDO</td>
						<td>NORELKIS</td>
						<td>17556457</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>26/06/2020</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>CASTILLO</td>
						<td>YELITZA</td>
						<td>14277969</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/04/2007</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>GONZALEZ</td>
						<td>TERESA</td>
						<td>12419356</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/12/2006</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>MONTILLA</td>
						<td>FRANCIS</td>
						<td>15421595</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/12/2008</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>SULBARAN</td>
						<td>YOLI</td>
						<td>13253354</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/12/2008</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) III</td>
						<td>CHANGAROTTI</td>
						<td>YAJAIRA</td>
						<td>9954268</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/09/2006</td>
					</tr>
					<tr>
						<td>ENFERMERA(O) IV</td>
						<td>VELASCO</td>
						<td>GLADYS</td>
						<td>6035636</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/09/2006</td>
					</tr>
					<tr>
						<td>HIGIENISTA DENTAL I</td>
						<td>GOMEZ</td>
						<td>MILAGROS</td>
						<td>10224368</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>07/09/2000</td>
					</tr>
					<tr>
						<td>HIGIENISTA DENTAL II</td>
						<td>LOPEZ</td>
						<td>CERLIN</td>
						<td>17390847</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/10/2021</td>
					</tr>
					<tr>
						<td>TECNICO RADIOLOGO II</td>
						<td>PEREIRA</td>
						<td>MARYELY</td>
						<td>6450856</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>31/01/2022</td>
					</tr>
					<tr>
						<td>TECNICO RADIOLOGO III</td>
						<td>ABACHE</td>
						<td>JOSE</td>
						<td>6730383</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/12/2020</td>
					</tr>
					<tr>
						<td>TECNICO RADIOLOGO III</td>
						<td>HERRERA</td>
						<td>MARIA</td>
						<td>14547215</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>04/08/2005</td>
					</tr>
					<tr>
						<td>TECNICO RADIOLOGO IV</td>
						<td>CASTILLO</td>
						<td>JOSE</td>
						<td>12375256</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>23/10/2000</td>
					</tr>
					<tr>
						<td>TERAPEUTA OCUPACIONAL III</td>
						<td>JIMENEZ</td>
						<td>YOLIMAR</td>
						<td>22918241</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/01/2023</td>
					</tr>
					<tr>
						<td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD I</td>
						<td>GOMEZ</td>
						<td>ANGIE</td>
						<td>26838763</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/09/2022</td>
					</tr>
					<tr>
						<td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD I</td>
						<td>COLINA</td>
						<td>LUZ</td>
						<td>18030756</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/07/2022</td>
					</tr>
					<tr>
						<td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>COLLADO</td>
						<td>EVELYSSE</td>
						<td>7926926</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/03/2008</td>
					</tr>
					<tr>
						<td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>ARRECHEDERA</td>
						<td>ALEJANDRA</td>
						<td>11198437</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/08/2007</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td>
						<td>GARCIA</td>
						<td>ABELICIA</td>
						<td>14454612</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/08/2007</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td>
						<td>SANCHEZ</td>
						<td>SONIA</td>
						<td>6203067</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/07/2002</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td>
						<td>SEGOVIA</td>
						<td>CAROLINA</td>
						<td>13395270</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/10/2022</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td>
						<td>ZORRILLA</td>
						<td>WENDY</td>
						<td>14875370</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/08/2007</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>BRITO</td>
						<td>HEIDI</td>
						<td>13851822</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/12/2016</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>MEJIAS</td>
						<td>MARIA</td>
						<td>16856053</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>07/09/2021</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>AGUILAR</td>
						<td>LELLYMAR</td>
						<td>11935797</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>16/04/2007</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>PENALVER</td>
						<td>DUBIA</td>
						<td>15421608</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>04/08/2005</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>MARQUINAS</td>
						<td>LILIANA</td>
						<td>12957466</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>30/05/2022</td>
					</tr>
					<tr>
						<td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td>
						<td>RODRIGUEZ</td>
						<td>ELIANA</td>
						<td>21172391</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>01/11/2013</td>
					</tr>
					<tr>
						<td>ASEADOR</td>
						<td>BARAONES</td>
						<td>GENESIS</td>
						<td>24901864</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>10/06/2019</td>
					</tr>
					<tr>
						<td>ASEADOR</td>
						<td>OLIVARES</td>
						<td>FRANCIS</td>
						<td>20098724</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>29/06/2020</td>
					</tr>
					<tr>
						<td>AYUDANTE DE SERVICIOS  GENERALES</td>
						<td>SALAZAR</td>
						<td>OSCAR</td>
						<td>17563610</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>10/06/2019</td>
					</tr>
					<tr>
						<td>CHOFER DE TRANSPORTE</td>
						<td>RIVAS</td>
						<td>WALDO</td>
						<td>6122480</td>
						<td>ASIST-OBREROS-FIJOS</td>
						<td>01/12/2006</td>
					</tr>
					<tr>
						<td>TECNICO DE REPARACION Y MANTENIMIENTO  I</td>
						<td>SEPULVEDA</td>
						<td>GERALD</td>
						<td>12115405</td>
						<td>ASIST-EMPLEADOS-FIJOS</td>
						<td>15/09/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>DIAZ</td>
						<td>CARMEN</td>
						<td>4140621</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>31/01/2022</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>NIÑO</td>
						<td>ROSMARY</td>
						<td>27333797</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>15/04/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>AVILA</td>
						<td>LUISA</td>
						<td>12377132</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>15/04/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>BRITO</td>
						<td>HECTOR</td>
						<td>31089664</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>16/10/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>BRITO</td>
						<td>KEILIMAR</td>
						<td>25215458</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>01/07/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>LOPEZ</td>
						<td>LEONOR</td>
						<td>6462147</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>29/11/2021</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>RIVAS</td>
						<td>JOHANNA</td>
						<td>15039518</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>16/04/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>BEOMON</td>
						<td>ALIS</td>
						<td>5070819</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>18/02/2021</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>GAINZA</td>
						<td>LISBEH</td>
						<td>12282196</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>01/08/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>GARCIA</td>
						<td>DANELYS</td>
						<td>10804152</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>15/02/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>GARCIA</td>
						<td>LISBETH</td>
						<td>11944505</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>01/06/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>OSORIO</td>
						<td>ROSMERI</td>
						<td>16030049</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>01/05/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>PINEDA</td>
						<td>ZAIDA</td>
						<td>7942818</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>01/06/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>CANACHE</td>
						<td>ROSANGEL</td>
						<td>13457920</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>10/07/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>FUENTES</td>
						<td>MARIANELA</td>
						<td>14421737</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>15/08/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MACHADO</td>
						<td>YENNIFER</td>
						<td>10814064</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>15/06/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MARCANO</td>
						<td>AGNERIS</td>
						<td>16116989</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>16/10/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>ROSALES</td>
						<td>ADEL</td>
						<td>6446373</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>01/07/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>ROSALES</td>
						<td>DENIS</td>
						<td>17266267</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>15/09/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>SANCHEZ</td>
						<td>FRANCIS</td>
						<td>12418981</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>01/07/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>ESCALONA</td>
						<td>ELIA</td>
						<td>12772778</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>10/07/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>GONZALEZ</td>
						<td>ANA</td>
						<td>16021376</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>15/07/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>GONZALEZ</td>
						<td>MARY</td>
						<td>14535054</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>01/10/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MANRIQUE</td>
						<td>YACKELIN</td>
						<td>22880147</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>15/04/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MARTINEZ</td>
						<td>JOSE</td>
						<td>10693236</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>16/03/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MARTINEZ</td>
						<td>JOSE</td>
						<td>11916412</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>01/05/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MELENDEZ</td>
						<td>LISMARI</td>
						<td>17974607</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>15/08/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>MONTILLA</td>
						<td>JOSE</td>
						<td>6061434</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>01/01/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>PALACIOS</td>
						<td>MARISOL</td>
						<td>4834825</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>30/07/2021</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>HENRIQUEZ</td>
						<td>WILLIAM</td>
						<td>9097828</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>01/01/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>HENRIQUEZ</td>
						<td>NORELKIS</td>
						<td>14471502</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>01/12/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>HERNANDEZ</td>
						<td>LUZ</td>
						<td>12292520</td>
						<td>ASIST-OBREROS-CONTRATADOS</td>
						<td>15/02/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>HERNANDEZ</td>
						<td>JULIMAR</td>
						<td>19452767</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>01/10/2023</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>COLMENARES</td>
						<td>YVIS</td>
						<td>17168886</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>16/10/2024</td>
					</tr>
					<tr>
						<td>CONTRATADO</td>
						<td>ESPARRAGOZA</td>
						<td>ABEL</td>
						<td>31249385</td>
						<td>ASIST-EMPLEADOS-CONTRATADOS</td>
						<td>01/10/2024</td>
					</tr>
					<tr>
						<td>MEDICO CONTRATADO</td>
						<td>GONZALEZ</td>
						<td>JOSE</td>
						<td>12784702</td>
						<td>ASIST-MED-CONTRATADOS</td>
						<td>24/10/2024</td>
					</tr>
					<tr>
						<td></td>
						<td>&nbsp</td>
						<td>&nbsp</td>
						<td>&nbsp</td>
						<td>&nbsp</td>
						<td>&nbsp</td>
					</tr>
				</tbody></table>          
            
            </div>
        </div>
    </div>

 

 <!-- jquery y bootstrap -->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
 
 <!-- datatables con bootstrap -->
 <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> 
 <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

 <!-- Para usar los botones -->
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>


<!-- Para los estilos en Excel     -->
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js"></script>
<script>
$(document).ready(function () {
    $("#myTable").DataTable({
        dom: "Bfrtip",
        buttons:{
            dom: {
                button: {
                    className: 'btn'
                }
            },
            buttons: [
            {
                //definimos estilos del boton de excel
                extend: "excel",
                text:'Exportar a Excel',
                className:'btn btn-outline-success',

                // 1 - ejemplo básico - uso de templates pre-definidos
                //definimos los parametros al exportar a excel
                
              
                
 

            }
            ]            
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

