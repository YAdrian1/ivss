


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
     <link rel="icon" href="../img/faviconn.ico" type="image/x-icon">
    <?php require_once "menu.php"; ?>
    <link rel="stylesheet" type="text/css" href="../css/personal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        
        .upload-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;

        }
        .imagen-miniatura {
        
            width: 40px;
            height: 40px;
            object-fit: cover;

        }
        .loading {

            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div  class="container">
        <div style="margin-top: 20px;" class="upload-section">
            <h2>Subir Formato</h2>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre del Formato:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="archivo">Seleccionar Archivo:</label>
                    <input type="file" class="form-control-file" id="archivo" name="archivo" 
                           accept=".jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" required>
                    <small class="form-text text-muted">Formatos permitidos: JPG, JPEG, PNG, DOC, DOCX, XLS, XLSX</small>
                    <small class="form-text text-muted">Tamaño máximo: 5MB</small>
                </div>
                <button type="submit" class="btn btn-primary">Subir Formato</button>
            </form>
        </div>

        <div class="table-section">
            <h2>Formatos Disponibles</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="text-align: center;">Nombre del Formato</th>
                            <th style="text-align: center;">Vista Previa</th>
                            <th style="text-align: center;">Fecha de Subida</th>
                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sql = "SELECT id, nombre, extension, fecha_subida 
                                   FROM imagenes_subidas 
                                   WHERE id_usuario = ? 
                                   ORDER BY fecha_subida DESC";
                            
                            if ($stmt = mysqli_prepare($conexion, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $_SESSION['iduser']);
                                
                                if (mysqli_stmt_execute($stmt)) {
                                    $resultado = mysqli_stmt_get_result($stmt);
                                    
                                    while ($fila = mysqli_fetch_assoc($resultado)) {
                                        echo "<tr style='text-align:center;' data-id='".$fila['id']."'>";
                                        echo "<td>".$fila['id']."</td>";
                                        echo "<td >".$fila['nombre']."</td>";
                                        echo "<td >";
                                        
                                        if(in_array(strtolower($fila['extension']), ['jpg', 'jpeg', 'png'])) {
                                            echo "<img src='mostrar_imagen.php?id=".$fila['id']."' 
                                                  alt='".$fila['nombre']."' class='imagen-miniatura'>";
                                        } elseif(in_array(strtolower($fila['extension']), ['doc', 'docx'])) {
                                            echo "<i class='fas fa-file-word' style='font-size: 40px; color: #2b579a;'></i>";
                                        } elseif(in_array(strtolower($fila['extension']), ['xls', 'xlsx'])) {
                                            echo "<i class='fas fa-file-excel' style='font-size: 40px; color: #217346;'></i>";
                                        }
                                        
                                        echo "</td>";
                                        echo "<td>".$fila['fecha_subida']."</td>";
                                        echo "<td>
                                                <div class='btn-group'>
                                                    <button style='margin-right:4px;  left:4%;' type='button' class='btn btn-danger btn-sm' 
                                                            onclick='eliminarFormato(".$fila['id'].")'>
                                                        <i class='fas fa-trash'></i> Eliminar
                                                    </button>
                                                    <button style=' left:4%;' type='button' class='btn btn-primary btn-sm' 
                                                            onclick='descargarArchivo(".$fila['id'].", 
                                                            \"".htmlspecialchars($fila['nombre'])."\", 
                                                            \"".htmlspecialchars($fila['extension'])."\")'>
                                                        <i class='fas fa-download'></i> Descargar
                                                    </button>
                                                </div>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Error al ejecutar la consulta</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<tr><td colspan='5'>Error en la preparación de la consulta</td></tr>";
                            }
                        } catch (Exception $e) {
                            echo "<tr><td colspan='5'>Error: " . $e->getMessage() . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function mostrarCargando() {
            Swal.fire({
                title: 'Procesando...',
                html: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

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
                    mostrarCargando();
                    $.ajax({
                        url: 'eliminar_formato.php',
                        type: 'POST',
                        data: {id_formato: id},
                        dataType: 'json',
                                                success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado!',
                                    text: response.message
                                }).then(() => {
                                    $(`tr[data-id="${id}"]`).remove();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Hubo un problema al comunicarse con el servidor'
                            });
                        }
                    });
                }
            });
        }

        function descargarArchivo(id, nombre, extension) {
            if(['jpg', 'jpeg', 'png'].includes(extension.toLowerCase())) {
                window.open(`mostrar_imagen.php?id=${id}`, '_blank');
            } else {
                window.location.href = `descargar_archivo.php?id=${id}&nombre=${encodeURIComponent(nombre)}`;
            }
        }

        $(document).ready(function() {
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();
                
                let formData = new FormData(this);
                mostrarCargando();

                $.ajax({
                    url: 'subir_formato.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'Archivo subido correctamente'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Hubo un error al subir el archivo'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error en la comunicación con el servidor'
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

                if(archivo) {
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
                }
            });
        });
    </script>
</body>
</html>

<?php 
} else {
    header("location:../index.php");
    exit();
}
?>