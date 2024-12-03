<?php 
session_start();
if (isset($_SESSION['usuario'])) {
    require_once "../clases/Conexion.php"; // Asegúrate de que esta ruta es correcta

    $obj = new conectar();
    $conexion = $obj->conexion();

    // Asegúrate de que la conexión fue exitosa
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Consulta SQL para obtener todas las áreas y su personal asignado
    $sql = "SELECT a.id AS area_id, a.nombre AS area_nombre, GROUP_CONCAT(p.nombre SEPARATOR ', ') AS personal_asignado
            FROM areas a
            LEFT JOIN personal p ON a.id = p.area_id
            GROUP BY a.id";
    $result = mysqli_query($conexion, $sql);

    // Verificar si la consulta fue exitosa
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="../img/faviconn.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Áreas</title>
     <style>
        /* Estilo para ocultar la tabla inicialmente */
        #tablaAreas, #tablaPersonal {
            display: none; /* Ocultar inicialmente */
            position: absolute; /* Posición absoluta */
            z-index: 1000; /* Asegura que la tabla esté encima de otros elementos */
        }

        #tablaAreas {
            top: 54vh; /* Espaciado superior */
            left: 4%; /* Espaciado izquierdo (10px a la derecha del botón) */

        }

       #tablaPersonal {
    top: 54vh; /* Espaciado superior para que esté alineada verticalmente */
    left: 25%; /* Espaciado izquierdo (5px a la derecha de la tabla de áreas) */
    max-height: 300px; /* Altura máxima de la tabla */
    overflow-y: auto; /* Agregar desplazamiento vertical */
}

        /* Estilo para el botón */
        #toggleButton {
            position: fixed; /* Fijo en la parte inferior */
            bottom: 20px; /* Espaciado desde el fondo */
            left: 20px; /* Espaciado desde la izquierda */
            padding: 10px 15px; /* Espaciado interno */
            border-radius: 50%; /* Botón redondeado */
            background-color: #007bff; /* Color de fondo */
            color: white; /* Color del texto */
            border: none; /* Sin borde */
            cursor: pointer; /* Cursor de puntero */
            transition: background-color 0.3s; /* Transición suave para el color de fondo */
             z-index: 1000; /* Asegura que la tabla esté encima de otros elementos */
        }

        #toggleButton:hover {
            background-color: #0056b3; /* Color al pasar el mouse */
        }

        /* Estilo para la tabla */
        table {
            margin: 0; /* Sin margen */
            border-collapse: collapse; /* Borde de la tabla */

            background-color: white;
        }

        th, td {
            border: 1px solid #ddd; /* Borde de las celdas */
            padding: 8px; /* Espaciado interno */
            text-align: left; /* Alineación del texto */
            background-color: white;
        }

        th {
            background-color: #f9f9f9; /* Color de fondo de los títulos */
        }

        #historiasContainer {
            display: none; /* Ocultar inicialmente */
            margin: 0; /* Eliminar márgenes */
            padding: 15px; /* Espaciado interno */
            border: none; /* Borde */
                       background-color: white; /* Color de fondo */
            width: 100vw; /* Ancho del contenedor al 100% del viewport */
            height: 70vh; /* Alto del contenedor al 70% del viewport */
            position: fixed; /* Fijo en la pantalla */
            top: 9%; /* Espaciado desde la parte superior */
            left: -40%; /* Centrado horizontalmente */
            transform: translateX(40%); /* Ajustar el centro del contenedor */
            display: flex; /* Usar flexbox */
            flex-direction: column; /* Organizar los hijos en columna */
            align-items: center; /* Centrar horizontalmente */
            justify-content: flex-start; /* Alinear al inicio (parte superior) */
            overflow: hidden; /* Ocultar el scroll */
        }

        /* Estilo para el nuevo cuadro div */
        #cuadroDiv {
            background-color: white; /* Color de fondo */
            padding: 20px; /* Espaciado interno */
            height: 21vh;
            width: 100%; /* Ancho completo */
            position: fixed; /* Fijo en la parte inferior */
            bottom: 0; /* Al fondo */
            left: 0; /* A la izquierda */
            text-align: center; /* Centrar el texto */
        }
        /* Estilo para la barra de desplazamiento */
#tablaPersonal::-webkit-scrollbar {
    width: 8px; /* Ancho de la barra de desplazamiento */
}

#tablaPersonal::-webkit-scrollbar-thumb {
    background: #888; /* Color del "thumb" de la barra */
    border-radius: 10px; /* Bordes redondeados */
}

#tablaPersonal::-webkit-scrollbar-thumb:hover {
    background: #555; /* Color del "thumb" al pasar el mouse */
}
    </style>
</head>

<body>
<?php require_once "menu.php"; ?>

<button id="toggleButton" class="btn">
    <i class="fas fa-chevron-right"></i> <!-- Icono de flecha hacia la derecha -->
</button>

<div id="tablaAreas" class="table-responsive" style="width: 20%; overflow-x: hidden; box-sizing: border-box;">
    <table class="table table-bordered" style="width: 200%; table-layout: auto;">
        <thead>
            <tr>
                <th style="white-space: nowrap;">Nombre del Área</th>
                <th style="text-align: center; white-space: nowrap;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="word-wrap: break-word; white-space: normal;"><?php echo htmlspecialchars($row['area_nombre']); ?></td>
                    <td style="text-align: center;">
                        <button style="background-color: transparent; border: none; padding: 0;" class="btn ver-personal" data-personal="<?php echo htmlspecialchars($row['personal_asignado']); ?>" data-area="<?php echo htmlspecialchars($row['area_nombre']); ?>">
                            <span class="glyphicon glyphicon-menu-right" style="color: #e94537;"></span>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div id="tablaPersonal" class="table-responsive" style="width: 24%; overflow-x: hidden; box-sizing: border-box; max-height: 214px; overflow-y: auto;">
    <input type="text" id="buscadorPersonal" placeholder="Buscar Personal" style="position: relative; width: 48%; top: 10vh; left: 1.2vh;" />
    <table class="table table-bordered" style="width: 100%; table-layout: auto;">
        <thead>
            <tr>
                <th style="white-space: nowrap;">Nombre del Personal</th>
                <th style="text-align: center; white-space: nowrap;">Acciones</th>
            </tr>
        </thead>
        <tbody id="personalBody" style="word-wrap: break-word; white-space: normal;">
            <!-- Los datos del personal se agregarán aquí -->
        </tbody>
    </table>
</div>
<script>
    // Función para filtrar el personal
    document.getElementById('buscadorPersonal').addEventListener('input', function() {
        const filter = this.value.toLowerCase(); // Obtener el texto del buscador
        const rows = personalBody.getElementsByTagName('tr'); // Obtener todas las filas de la tabla

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td'); // Obtener las celdas de la fila actual
            if (cells.length > 0) {
                const nombrePersonal = cells[0].textContent || cells[0].innerText; // Obtener el nombre del personal
                // Verificar si el nombre contiene el texto del buscador
                if (nombrePersonal.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = ""; // Mostrar la fila si coincide
                } else {
                    rows[i].style.display = "none"; // Ocultar la fila si no coincide
                }
            }
        }
    });
</script>
<div id="historiasContainer">
    <!-- El contenido de historias.php se cargará aquí -->
</div>

<script src="../librerias/jquery-3.2.1.min.js"></script>
<script>
    const toggleButton = document.getElementById("toggleButton");
    const tablaAreas = document.getElementById("tablaAreas");
    const tablaPersonal = document.getElementById("tablaPersonal");
    const personalBody = document.getElementById("personalBody");
    const historiasContainer = document.getElementById("historiasContainer");
    let timeoutId;

    // Función para mostrar la tabla de áreas
    function mostrarTablaAreas() {
        clearTimeout(timeoutId);
        tablaAreas.style.display = "block";
        tablaPersonal.style.display = "none"; // Asegurarse de que la tabla de personal esté oculta
    }

    // Función para ocultar las tablas
    function ocultarTablas() {
        timeoutId = setTimeout(() => {
            tablaAreas.style.display = "none";
            tablaPersonal.style.display = "none";
        }, 1000);
    }

    // Mostrar la tabla de áreas al pasar el mouse sobre el botón
    toggleButton.addEventListener("mouseenter", mostrarTablaAreas);
    toggleButton.addEventListener("mouseleave", ocultarTablas);

        // Mostrar el personal en la tabla al hacer clic en el botón "Ver Personal"
    document.querySelectorAll('.ver-personal').forEach(button => {
        button.addEventListener('click', function() {
            const personal = this.getAttribute('data-personal');
            const area = this.getAttribute('data-area');
            mostrarPersonal(personal, area);
        });
    });

    // Función para mostrar el personal en la tabla
function mostrarPersonal(personal, area) {
    personalBody.innerHTML = ""; // Limpiar la tabla de personal
    const personalArray = personal.split(', '); // Convertir la cadena en un array

    // Ordenar el array de nombres
    personalArray.sort((a, b) => {
        // Comparar los nombres directamente
        return a.localeCompare(b); // Ordenar alfabéticamente
    });

    personalArray.forEach(nombre => {
        const row = `<tr>
            <td>${nombre}</td>
            <td style="text-align:center;">
                <div style="display: flex; align-items: center;">
                    <button style="background-color: transparent; border: none; padding: 0; margin-right: 10px;" class="btn no-accion" onclick="abrirHistorias('${area}', '${nombre}')">
                        Reflejar
                        <span class="glyphicon glyphicon-eye-open" style="color:#f44336; margin-left: 5px;"></span> <!-- Ícono de reflejar -->
                    </button>
                    <div style="border-left: 1px solid #ccc; height: 20px; margin-right: 10px;"></div> <!-- Línea de separación -->
                    <button style="background-color: transparent; border: none; padding: 0;" class="btn no-accion" onclick="visualizarHistorias('${area}', '${nombre}')">
                        Editar
                        <span class="glyphicon glyphicon-calendar" style="color: #007bff; margin-left: 5px;"></span> <!-- Ícono de editar -->
                    </button>
                </div>
            </td>
        </tr>`;
        personalBody.innerHTML += row; // Agregar cada nombre a la tabla
    });

    tablaPersonal.style.display = "block"; // Mostrar la tabla de personal
}
    // Función para abrir historias.php en la carpeta del personal
    function abrirHistorias(area, nombrePersonal) {
        const baseUrl = '../vistas/horarios/'; // Ruta base donde se encuentran las carpetas
        const url = `${baseUrl}${area}/${nombrePersonal}/historias.php`; // Construir la URL

        // Usar AJAX para cargar el contenido de historias.php
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                // Mostrar el contenido en el div
                historiasContainer.innerHTML = data; // Cargar el contenido
                historiasContainer.style.display = "block"; // Mostrar el contenedor de historias
                
                // Guardar la URL en localStorage
                localStorage.setItem('lastHistoriasUrl', url);
            },
            error: function() {
                alert('Error al cargar las historias.'); // Manejo de errores
            }
        });
    }

    // Nueva función para visualizar historias.php directamente
    function visualizarHistorias(area, nombrePersonal) {
        const baseUrl = '../vistas/horarios/'; // Ruta base donde se encuentran las carpetas
        const url = `${baseUrl}${area}/${nombrePersonal}/historias.php`; // Construir la URL

        // Redirigir a la página de historias
        window.location.href = url;
    }

    // Al cargar la página, verificar si hay una URL guardada en localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const lastUrl = localStorage.getItem('lastHistoriasUrl');
        if (lastUrl) {
            // Usar AJAX para cargar el contenido de la última URL guardada
            $.ajax({
                url: lastUrl,
                method: 'GET',
                success: function(data) {
                    historiasContainer.innerHTML = data; // Cargar el contenido
                    historiasContainer.style.display = "block"; // Mostrar el contenedor de historias
                },
                error: function() {
                    console.error('Error al cargar el contenido de la última historia.'); // Manejo de errores
                }
            });
        }
    });

    // Asegurarse de que la tabla de áreas se mantenga visible si el mouse está sobre ella
    tablaAreas.addEventListener("mouseenter", () => {
        clearTimeout(timeoutId); // Cancelar el temporizador si el mouse está sobre la tabla de áreas
    });

    tablaAreas.addEventListener("mouseleave", ocultarTablas); // Ocultar cuando el mouse sale

    // Asegurarse de que la tabla de personal se mantenga visible si el mouse está sobre ella
    tablaPersonal.addEventListener("mouseenter", () => {
        clearTimeout(timeoutId); // Cancelar el temporizador si el mouse está sobre la tabla de personal
    });

    tablaPersonal.addEventListener("mouseleave", ocultarTablas); // Ocultar cuando el mouse sale
</script>

<div id="cuadroDiv" style="position: fixed; top: 78vh; left: 0; right: 0; background-color: white; padding: 20px; display: flex; flex-wrap: wrap; justify-content: center;">
    <div style="text-align: center; display: flex; flex-direction: column; align-items: center; width: 30%;">


<!-- Asegúrate de incluir Font Awesome en tu <head> si aún no lo has hecho -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
          <button   style="background-color: #ffffff; color: black; border: 1px solid black; width: 100px; height: 20px; margin-left: 30%;">D/L</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día Laborado</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="background-color:#f95251; color: black; border: 1px solid black; width: 42px; height: 20px; margin-left: 16%;">FER</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Feriado</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: 26%;background-color: #c9bdd6; color: black; border: 1px solid black; width: 83px;  height: 20px; ">VAC</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Vacaciones</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: 17%;background-color:#f9d1b2; color: black; border: 1px solid black; width: 41px; height: 20px;">PER</button>
            <span  style="color: black; margin-left: 5px; white-space: nowrap;">Permiso</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: 32%; background-color: #bdd298; color: black; border: 1px solid black; width: 108px; height: 20px; color: black;">RM</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Reposo Medico</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: 39%;background-color: #0caeef; color: black; border: 1px solid black; width: 174px; height: 20px;color: black;">PC</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Permiso por cuido familiar</span>
        </div>
    </div>
    
    <div style="text-align: center; display: flex; flex-direction: column; align-items: center; width: 30%;">
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
                       <button style="background-color: #66fe97; color: black; border: 1px solid black; width: 40px; height: 20px;">LC</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Libre por Cumpleaños</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: 20%;background-color:#b0afa6; color: black; border: 1px solid black; width: 102px; height: 20px;">LDT</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Libre día del Técnico Radiólogo</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: 37%;background-color: #10f9f9; color: black; border: 1px solid black; width: 40px; height: 20px;">lDTH</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Libre día del Técnico Historias Médicas</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: -6%;background-color: #c7e7fa; color: black; border: 1px solid black; width: 40px; height: 20px;">Prad</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Permiso Radiólogico</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button   style="margin-left: 9%;background-color: #d4fe5b; color: black; border: 1px solid black; width: 60px; height: 20px;">DTS</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día del Trabajador Social</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: -32%;background-color: #f9f9f9; color: black; border: 1px solid black; width: 40px; height: 20px;">DM</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día del Médico</span>
        </div>
    </div>

    <div style="text-align: center; display: flex; flex-direction: column; align-items: center; width: 30%;">
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="background-color: #f9c600; color: black; border: 1px solid black; width: 40px; height: 20px;">Denf</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día de la Enfermera</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: 18%;background-color: #dba2a0; color: black; border: 1px solid black; width: 40px; height: 20px;">DHD</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Día de la Higienista Dental</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: -2%;background-color: #ffffff; color: black; border: 1px solid black; width: 40px; height: 20px;">DO</button>
                       <span style="color: black; margin-left: 5px; white-space: nowrap;">Día del Odontólogo</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: -45%;background-color: #73f290; color: black; border: 1px solid black; width: 40px; height: 20px;">INAS</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Inasistencia</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="margin-left: -4%;background-color: #d59291; color: black; border: 1px solid black; width: 40px; height: 20px;">CM</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Constancia Médica</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-width: 120px;">
            <button  style="background-color: #ffffff; color: black; border: 1px solid black; width: 40px; height: 20px; margin-left: 0.5vh;">AE</button>
            <span style="color: black; margin-left: 5px; white-space: nowrap;">Asistencia Educativa</span>
        </div>
    </div>
</div>

</body>
</html>

<script src="../librerias/jquery-3.2.1.min.js"></script>

<?php

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    header("location:../index.php");
}
?>