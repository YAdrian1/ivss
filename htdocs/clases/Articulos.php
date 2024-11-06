<?php 
class articulos{
    public function agregaImagen($datos){
        $c=new conectar();
        $conexion=$c->conexion();

        $fecha=date('Y-m-d');

        $sql="INSERT into imagenes (id_categoria,
                                    nombre,
                                    ruta,
                                    fechaSubida)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$fecha')";
        $result=mysqli_query($conexion,$sql);

        return mysqli_insert_id($conexion);
    }
    public function insertaArticulo($datos){
        $c=new conectar();
        $conexion=$c->conexion();

        $fecha=date('Y-m-d');

        $sql="INSERT into articulos (id_categoria,
                                    id_imagen,
                                    id_usuario,
                                    nombre,
                                    descripcion,
                                    cantidad,
                                    precio,
                                    fechaCaptura) 
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]',
                                '$datos[4]',
                                '$datos[5]',
                                '$datos[6]',
                                '$fecha')";
        return mysqli_query($conexion,$sql);
    }

    public function obtenDatosArticulo($idarticulo){
        $c=new conectar();
        $conexion=$c->conexion();

        $sql="SELECT id_producto, 
                    id_categoria, 
                    nombre,
                    descripcion,
                    cantidad,
                    precio 
            from articulos 
            where id_producto='$idarticulo'";
        $result=mysqli_query($conexion,$sql);

        $ver=mysqli_fetch_row($result);

        $datos=array(
                "id_producto" => $ver[0],
                "id_categoria" => $ver[1],
                "nombre" => $ver[2],
                "descripcion" => $ver[3],
                "cantidad" => $ver[4],
                "precio" => $ver[5]
                    );

        return $datos;
    }

    public function actualizaArticulo($datos){
        $c=new conectar();
        $conexion=$c->conexion();

        $sql="UPDATE articulos set id_categoria='$datos[1]', 
                                    nombre='$datos[2]',
                                    descripcion='$datos[3]',
                                    cantidad='$datos[4]',
                                    precio='$datos[5]'
                    where id_producto='$datos[0]'";

        return mysqli_query($conexion,$sql);
    }

    public function eliminaArticulo($idarticulo){
        $c = new conectar();
        $conexion = $c->conexion();

        // Iniciar transacción
        mysqli_begin_transaction($conexion);

        try {
            // Obtener información de la imagen
            $idimagen = self::obtenIdImg($idarticulo);
            $ruta = self::obtenRutaImagen($idimagen);

            // Eliminar el artículo
            $sql = "DELETE FROM articulos WHERE id_producto = '$idarticulo'";
            $result = mysqli_query($conexion, $sql);

            if($result) {
                // Si se eliminó el artículo, eliminar la imagen asociada
                if($idimagen) {
                    $sql = "DELETE FROM imagenes WHERE id_imagen = '$idimagen'";
                    $result = mysqli_query($conexion, $sql);
                    
                    if($result && file_exists($ruta)) {
                        unlink($ruta); // Eliminar el archivo físico
                    }
                }
                
                // Confirmar la transacción
                mysqli_commit($conexion);
                return 1;
            } else {
                // Si algo falla, revertir la transacción
                mysqli_rollback($conexion);
                return 0;
            }
        } catch (Exception $e) {
            // Si ocurre algún error, revertir la transacción
            mysqli_rollback($conexion);
            return 0;
        }
    }

    public function obtenIdImg($idProducto){
        $c= new conectar();
        $conexion=$c->conexion();

        $sql="SELECT id_imagen 
                from articulos 
                where id_producto='$idProducto'";
        $result=mysqli_query($conexion,$sql);

        return mysqli_fetch_row($result)[0];
    }

    public function obtenRutaImagen($idImg){
        $c= new conectar();
        $conexion=$c->conexion();

        $sql="SELECT ruta 
                from imagenes 
                where id_imagen='$idImg'";

        $result=mysqli_query($conexion,$sql);

        return mysqli_fetch_row($result)[0];
    }

}
?>