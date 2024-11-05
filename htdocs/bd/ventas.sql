-- Crear la base de datos
CREATE SCHEMA `ventas` DEFAULT CHARACTER SET utf8mb4;

USE ventas;

-- Tabla de usuarios
CREATE TABLE usuarios(
    id_usuario INT AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    email VARCHAR(50),
    password TEXT(50),
    fechaCaptura DATE,
    PRIMARY KEY(id_usuario)
);

-- Tabla de imágenes
CREATE TABLE imagenes(
    id_imagen INT AUTO_INCREMENT,
    id_categoria INT NOT NULL,
    nombre VARCHAR(500),
    ruta VARCHAR(500),
    fechaSubida DATE,
    PRIMARY KEY(id_imagen)
);

-- Tabla de artículos
CREATE TABLE articulos(
    id_producto INT AUTO_INCREMENT,
    id_categoria INT NOT NULL,
    id_imagen INT NOT NULL,
    id_usuario INT NOT NULL,
    nombre VARCHAR(50),
    descripcion VARCHAR(500),
    cantidad INT,
    precio FLOAT,
    fechaCaptura DATE,
    PRIMARY KEY(id_producto)
);

-- Tabla modificada para archivos subidos (imágenes, documentos Word y Excel)
CREATE TABLE imagenes_subidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    imagen_data LONGBLOB,
    tipo_imagen VARCHAR(100),
    extension VARCHAR(10),
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla de categorías
CREATE TABLE categorias(
    id_categoria INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombreCategoria VARCHAR(150),
    fechaCaptura DATE,
    PRIMARY KEY(id_categoria)
);

-- Tabla de clientes
CREATE TABLE clientes(
    id_cliente INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombre VARCHAR(200),
    apellido VARCHAR(200),
    direccion VARCHAR(200),
    email VARCHAR(200),
    telefono VARCHAR(200),
    rfc VARCHAR(200),
    PRIMARY KEY(id_cliente)
);

-- Tabla de ventas
CREATE TABLE ventas(
    id_venta INT NOT NULL,
    id_cliente INT,
    id_producto INT,
    id_usuario INT,
    precio FLOAT,
    fechaCompra DATE,
    PRIMARY KEY(id_venta)
);

-- NUEVAS TABLAS PARA EXPEDIENTES --

-- Tabla para los expedientes
CREATE TABLE expedientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla para las imágenes de los expedientes
CREATE TABLE imagenes_expediente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_expediente INT NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nombre_original VARCHAR(255),
    tipo_imagen VARCHAR(100),
    FOREIGN KEY (id_expediente) REFERENCES expedientes(id) ON DELETE CASCADE
);

-- Índices para optimizar las búsquedas
CREATE INDEX idx_usuario ON usuarios(email);
CREATE INDEX idx_categoria ON categorias(nombreCategoria);
CREATE INDEX idx_cliente ON clientes(nombre, apellido);
CREATE INDEX idx_venta ON ventas(fechaCompra);
CREATE INDEX idx_archivo ON imagenes_subidas(nombre, extension);
CREATE INDEX idx_expediente ON expedientes(apellido, nombre);
CREATE INDEX idx_imagenes_exp ON imagenes_expediente(id_expediente);

-- Restricciones de clave foránea
ALTER TABLE articulos
ADD CONSTRAINT fk_categoria_articulo
FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE articulos
ADD CONSTRAINT fk_imagen_articulo
FOREIGN KEY (id_imagen) REFERENCES imagenes(id_imagen)
ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE articulos
ADD CONSTRAINT fk_usuario_articulo
FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE ventas
ADD CONSTRAINT fk_cliente_venta
FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE ventas
ADD CONSTRAINT fk_producto_venta
FOREIGN KEY (id_producto) REFERENCES articulos(id_producto)
ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE ventas
ADD CONSTRAINT fk_usuario_venta
FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
ON DELETE RESTRICT ON UPDATE CASCADE;

-- Procedimiento almacenado para limpiar archivos antiguos
DELIMITER //
CREATE PROCEDURE limpiar_archivos_antiguos()
BEGIN
    DELETE FROM imagenes_subidas 
    WHERE fecha_subida < DATE_SUB(NOW(), INTERVAL 1 YEAR);
    
    DELETE FROM imagenes_expediente 
    WHERE fecha_subida < DATE_SUB(NOW(), INTERVAL 1 YEAR);
END //
DELIMITER ;

-- Evento para ejecutar la limpieza automática
CREATE EVENT IF NOT EXISTS evento_limpieza_archivos
ON SCHEDULE EVERY 1 MONTH
DO CALL limpiar_archivos_antiguos();

-- Vistas útiles
CREATE VIEW vista_archivos_recientes AS
SELECT i.id, i.nombre, i.extension, i.fecha_subida, u.nombre as usuario
FROM imagenes_subidas i
JOIN usuarios u ON i.id_usuario = u.id_usuario
WHERE i.fecha_subida >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
ORDER BY i.fecha_subida DESC;

CREATE VIEW vista_expedientes_completos AS
SELECT 
    e.id,
    e.nombre,
    e.apellido,
    e.fecha_creacion,
    COUNT(ie.id) as total_imagenes,
    u.nombre as usuario_creador
FROM expedientes e
LEFT JOIN imagenes_expediente ie ON e.id = ie.id_expediente
LEFT JOIN usuarios u ON e.id_usuario = u.id_usuario
GROUP BY e.id;

-- Triggers para validación
DELIMITER //
CREATE TRIGGER validar_extension_archivo
BEFORE INSERT ON imagenes_subidas
FOR EACH ROW
BEGIN
    IF NEW.extension NOT IN ('jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Extensión de archivo no permitida';
    END IF;
END //
DELIMITER ;

-- Permisos básicos (ajustar según necesidades)
GRANT SELECT, INSERT, UPDATE, DELETE ON ventas.* TO 'usuario_app'@'localhost';
GRANT EXECUTE ON PROCEDURE ventas.limpiar_archivos_antiguos TO 'usuario_app'@'localhost';