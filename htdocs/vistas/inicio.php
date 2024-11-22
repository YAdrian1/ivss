<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
         <link rel="icon" href="../img/faviconn.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="../css/personal.css">
	<title>inicio</title>
	<?php require_once "menu.php"; ?>

 <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .calendario {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Fijar 4 columnas */
            gap: 10px; /* Espacio entre los meses */
        }

        .mes {
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 4px; /* Reducir el padding */
            font-size: 0.9em; /* Tamaño de fuente más pequeño */
            display: flex;
            flex-direction: column; /* Para alinear el contenido verticalmente */
            height: 190px; /* Altura fija para los meses */
        }

        .mes h2 {
            text-align: center;
            color: #007BFF;
            margin-top: 1px; /* Espacio debajo del título */
        }

        .dias {
            text-align: center;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            margin-top: 1px; /* Reducir el margen superior */
        }

        .dias span:nth-child(7n+1) {
            color: red; /* Domingo */
        }

        .dias span:nth-child(7n) {
            color: blue; /* Sábado */
        }

        .dias span.empty {
            background-color: #f4f4f4; /* Color de los espacios vacíos */
        }
    </style>
    <link rel="icon" href="../img/faviconn.ico" type="image/x-icon">
</head>
<body>
<h1>Calendario del Año <?php echo date("Y"); ?></h1>

<div class="calendario">
    <?php
    // Obtener el año actual
    $anio = date("Y");

    // Array con los nombres de los meses
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    // Array con los días de la semana
    $diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

    foreach ($meses as $numero => $nombre): ?>
        <div class="mes">
            <h2><?php echo $nombre; ?></h2>
            <div class="dias">
                <?php foreach ($diasSemana as $dia): ?>
                    <span><?php echo $dia; ?></span>
                <?php endforeach; ?>
                <?php 
                // Calcular el número de días en el mes
                $dias = cal_days_in_month(CAL_GREGORIAN, $numero, $anio);
                $primerDia = date('w', strtotime("$anio-$numero-01"));
                
                for ($i = 0; $i < $primerDia; $i++): ?>
                    <span class="empty"></span>
                <?php endfor; ?>

                <?php for ($dia = 1; $dia <= $dias; $dia++): ?>
                    <span><?php echo $dia; ?></span>
                <?php endfor; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>





</body>
</html>
<?php 
	}else{
		header("location:../index.php");
	}
 ?>