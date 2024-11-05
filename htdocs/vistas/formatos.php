<?php 
session_start();
if(isset($_SESSION['usuario'])){
    require_once "../clases/Conexion.php";
    $c = new conectar();
    $conexion = $c->conexion();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formatos</title>
    <?php require_once "menu.php"; ?>
    <link rel="stylesheet" type="text/css" href="../css/personal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        .imagen-miniatura {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .upload-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="upload-section">
            <h2>Subir Formato</h2>
            <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre del Formato:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="archivo">Seleccionar Archivo:</label>
                    <input type="file" class="form-control-file" id="archivo" name="archivo" 
                           accept=".jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" required>
                    <small class="form-text text-muted">Formatos permitidos: JPG, JPEG, PNG, DOC, DOCX, XLS, XLSX</small>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Subir Formato</button>
            </form>
        </div>

        <div class="table-section">
            <h2>Formatos Disponibles</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Formato</th>
                        <th>Vista Previa</th>
                        <th>Fecha de Subida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, nombre, extension, fecha_subida FROM imagenes_subidas WHERE id_usuario = ? ORDER BY fecha_subida DESC";
                    $stmt = mysqli_prepare($conexion, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION['iduser']);
                    mysqli_stmt_execute($stmt);
                    $resultado = mysqli_stmt_get_result($stmt);
                    
                    while($fila = mysqli_fetch_assoc($resultado)){
                        echo "<tr data-id='".$fila['id']."'>";
                        echo "<td>".$fila['id']."</td>";
                        echo "<td>".$fila['nombre']."</td>";
                        echo "<td>";
                        if(in_array($fila['extension'], ['jpg', 'jpeg', 'png'])) {
                            echo "<img src='mostrar_imagen.php?id=".$fila['id']."' alt='".$fila['nombre']."' class='imagen-miniatura'>";
                        } elseif(in_array($fila['extension'], ['doc', 'docx'])) {
                            echo "<i class='fas fa-file-word' style='font-size: 40px; color: #2b579a;'></i>";
                        } elseif(in_array($fila['extension'], ['xls', 'xlsx'])) {
                            echo "<i class='fas fa-file-excel' style='font-size: 40px; color: #217346;'></i>";
                        }
                        echo "</td>";
                        echo "<td>".$fila['fecha_subida']."</td>";
                        echo "<td>
                                <div class='btn-group'>
                                    <button type='button' class='btn btn-danger btn-sm' onclick='eliminarFormato(".$fila['id'].")'>
                                        <span class='glyphicon glyphicon-trash'></span> Eliminar
                                    </button>
                                    <button type='button' class='btn btn-primary btn-sm' onclick='imprimirArchivo(".$fila['id'].", \"".htmlspecialchars($fila['nombre'])."\", \"".htmlspecialchars($fila['extension'])."\")'>
                                        <span class='glyphicon glyphicon-download-alt'></span> Descargar
                                    </button>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                    mysqli_stmt_close($stmt);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function eliminarFormato(id) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData();
                    formData.append('id_formato', id);
                    
                    fetch('eliminar_formato.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire(
                                'Eliminado!',
                                data.message,
                                'success'
                            ).then(() => {
                                // Eliminar la fila de la tabla sin recargar la página
                                $(`tr[data-id="${data.id}"]`).remove();
                            });
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            error.message || 'Hubo un error al eliminar el formato',
                            'error'
                        );
                    });
                }
            });
        }

        function imprimirArchivo(id, nombre, extension) {
            if(['jpg', 'jpeg', 'png'].includes(extension.toLowerCase())) {

                    let ventanaImpresion = window.open('', '_blank');

                    ventanaImpresion.document.write(`

                        <!DOCTYPE html>

                        <html>

                        <head>

                            <title>Imprimir ${nombre}</title>

                            <style>

                                body { margin: 0; padding: 20px; text-align: center; }

                                img { max-width: 100%; height: auto; }

                                .header { margin-bottom: 20px; }

                            </style>

                        </head>

                        <body>

                            <div class="header">

                                <h2>${nombre}</h2>

                                <p>Fecha de impresión: ${new Date().toLocaleDateString()}</p>

                            </div>

                            <img src="mostrar_imagen.php?id=${id}" alt="${nombre}">

                        </body>

                        </html>

                    `);

                    ventanaImpresion.document.close();

                    ventanaImpresion.onload = function() {

                        ventanaImpresion.print();

                    }

                } else {

                    window.location.href = `descargar_archivo.php?id=${id}&nombre=${nombre}`;

                }

        }


        $(document).ready(function() {

            const urlParams = new URLSearchParams(window.location.search);

            const status = urlParams.get('status');

            

            if(status === 'success') {

                Swal.fire({

                    icon: 'success',

                    title: 'Éxito',

                    text: 'Formato agregado correctamente'

                }).then(() => {

                    window.history.replaceState({}, document.title, window.location.pathname);

                });

            } else if(status === 'error') {

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: 'Hubo un error al procesar su solicitud'

                }).then(() => {

                    window.history.replaceState({}, document.title, window.location.pathname);

                });

            } else if(status === 'deleted') {

                Swal.fire({

                    icon: 'success',

                    title: 'Éxito',

                    text: 'Formato eliminado correctamente'

                }).then(() => {

                    window.history.replaceState({}, document.title, window.location.pathname);

                });

            }


            // Manejar la subida de archivos

            $('#uploadForm').on('submit', function(e) {

                e.preventDefault();

                

                let formData = new FormData(this);

                

                Swal.fire({

                    title: 'Subiendo archivo...',

                    text: 'Por favor espere',

                    allowOutsideClick: false,

                    allowEscapeKey: false,

                    allowEnterKey: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });


                $.ajax({

                    url: $(this).attr('action'),

                    type: 'POST',

                    data: formData,

                    processData: false,

                    contentType: false,

                    success: function(response) {

                        Swal.close();

                        if(response.success) {

                            Swal.fire({

                                icon: 'success',

                                title: 'Éxito',

                                text: 'Archivo subido correctamente'

                            }).then(() => {

                                window.location.reload();

                            });

                        } else {

                            Swal.fire({

                                icon: 'error',

                                title: 'Error',

                                text: response.message || 'Hubo un error al subir el archivo'

                            });

                        }

                    },

                    error: function() {

                        Swal.close();

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: 'Hubo un error en la comunicación con el servidor'

                        });

                    }

                });

            });


            // Validación del tamaño y tipo de archivo

            $('#archivo').on('change', function() {

                const archivo = this.files[0];

                const maxSize = 5 * 1024 * 1024; // 5MB

                const tiposPermitidos = [

                    'image/jpeg',

                    'image/png',

                    'application/msword',

                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

                    'application/vnd.ms-excel',

                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'

                ];


                if(archivo.size > maxSize) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'El archivo no debe superar los 5MB'

                    });

                    this.value = '';

                    return;

                }


                if(!tiposPermitidos.includes(archivo.type)) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Tipo de archivo no permitido'

                    });

                    this.value = '';

                    return;

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
                