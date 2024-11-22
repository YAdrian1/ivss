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
    $sql = "SELECT a.nombre AS area_nombre, GROUP_CONCAT(p.nombre SEPARATOR ', ') AS personal_asignado
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
            top: 55%; /* Espaciado superior */
            left: 5%; /* Espaciado izquierdo (10px a la derecha del botón) */
        }

        #tablaPersonal {
            top: 55%; /* Espaciado superior para que esté alineada verticalmente */
            left: 24%; /* Espaciado izquierdo (5px a la derecha de la tabla de áreas) */
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra */
            cursor: pointer; /* Cursor de puntero */
            transition: background-color 0.3s; /* Transición suave para el color de fondo */
        }

        #toggleButton:hover {
            background-color: #0056b3; /* Color al pasar el mouse */
        }

        /* Estilo para la tabla */
        table {
            margin: 0; /* Sin margen */
            border-collapse: collapse; /* Borde de la tabla */
            box-shadow: 0 8px 16px rgba(0, 123, 255, 0.5); /* Sombra */
        }

        th, td {
            border: 1px solid #ddd; /* Borde de las celdas */
            padding: 8px; /* Espaciado interno */
            text-align: left; /* Alineación del texto */
        }

        th {
            background-color: #f0f0f0; /* Color de fondo de los títulos */
            border-radius: 5px; /* Bordes redondeados para encabezados */
        }
    </style>
</head>

<body>
<?php require_once "menu.php"; ?>

<button id="toggleButton" class="btn">
    <i class="fas fa-chevron-right"></i> <!-- Icono de flecha hacia la derecha -->
</button>

<div id="tablaAreas" class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                                <th>Nombre del Área</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['area_nombre']); ?></td>
                    <td>
                        <button class="btn btn-info ver-personal" data-personal="<?php echo htmlspecialchars($row['personal_asignado']); ?>">
                            Ver Personal
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div id="tablaPersonal" class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre del Personal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="personalBody">
            <!-- Los datos del personal se agregarán aquí -->
        </tbody>
    </table>
</div>

<script src="../librerias/jquery-3.2.1.min.js"></script>
<script src="../librerias/bootstrap/js/bootstrap.js"></script>
<script>
    const toggleButton = document.getElementById("toggleButton");
    const tablaAreas = document.getElementById("tablaAreas");
    const tablaPersonal = document.getElementById("tablaPersonal");
    const personalBody = document.getElementById("personalBody");
    let timeoutId;

    // Función para mostrar la tabla de áreas
    function mostrarTablaAreas() {
        clearTimeout(timeoutId);
        tablaAreas.style.display = "block";
        tablaPersonal.style.display = "none"; // Asegurarse de que la tabla de personal esté oculta
    }

    // Función para ocultar la tabla de áreas
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
            mostrarPersonal(personal);
        });
    });

    // Función para mostrar el personal en la tabla
    function mostrarPersonal(personal) {
        personalBody.innerHTML = ""; // Limpiar la tabla de personal
        const personalArray = personal.split(', '); // Convertir la cadena en un array

        personalArray.forEach(nombre => {
            const row = `<tr>
                           <td>${nombre}</td>
                           <td>
                               <button class="btn btn-secondary no-accion" disabled>No Acción</button>
                           </td>
                       </tr>`;
            personalBody.innerHTML += row; // Agregar cada nombre a la tabla
        });

        tablaPersonal.style.display = "block"; // Mostrar la tabla de personal
    }

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

</body>
</html>

<?php
    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    header("location:../index.php");
}
?>