-- Crear la base de datos
CREATE SCHEMA `ventas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ventas;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    fechaCaptura DATE,
    PRIMARY KEY(id_usuario)
) ENGINE=InnoDB;

-- Tabla de categorías
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombreCategoria VARCHAR(150) NOT NULL,
    fechaCaptura DATE,
    PRIMARY KEY(id_categoria),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- Tabla de imágenes
CREATE TABLE imagenes (
    id_imagen INT AUTO_INCREMENT,
    id_categoria INT NOT NULL,
    nombre VARCHAR(500) NOT NULL,
    ruta VARCHAR(500) NOT NULL,
    fechaSubida DATE,
    PRIMARY KEY(id_imagen),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
) ENGINE=InnoDB;

-- Tabla de expedientes
CREATE TABLE expedientes (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla de imágenes de expedientes
CREATE TABLE imagenes_expediente (
    id INT AUTO_INCREMENT,
    id_expediente INT NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    nombre_original VARCHAR(255) NOT NULL,
    tipo_imagen VARCHAR(100) NOT NULL,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY (id_expediente) REFERENCES expedientes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla para los clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    apellido VARCHAR(200) NOT NULL,
    direccion VARCHAR(200),
    email VARCHAR(200),
    telefono VARCHAR(200),
    rfc VARCHAR(200),
    PRIMARY KEY(id_cliente),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- Tabla para artículos/productos
CREATE TABLE articulos (
    id_producto INT AUTO_INCREMENT,
    id_categoria INT NOT NULL,
    id_imagen INT NOT NULL,
    id_usuario INT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(500),
    cantidad INT,
    precio FLOAT,
    fechaCaptura DATE,
    PRIMARY KEY(id_producto),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_imagen) REFERENCES imagenes(id_imagen),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- Tabla para ventas
CREATE TABLE ventas (
    id_venta INT NOT NULL,
    id_cliente INT,
    id_producto INT,
    id_usuario INT,
    precio FLOAT,
    fechaCompra DATE,
    PRIMARY KEY(id_venta),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_producto) REFERENCES articulos(id_producto),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- Índices para optimizar las búsquedas
CREATE INDEX idx_expediente_usuario ON expedientes(id_usuario);
CREATE INDEX idx_expediente_nombre ON expedientes(nombre, apellido);
CREATE INDEX idx_imagen_expediente ON imagenes_expediente(id_expediente);
CREATE INDEX idx_imagen_categoria ON imagenes_expediente(categoria);
CREATE INDEX idx_usuario_email ON usuarios(email);
CREATE INDEX idx_cliente_nombre ON clientes(nombre, apellido);

-- Procedimientos almacenados

DELIMITER //

-- Procedimiento para crear un nuevo expediente
CREATE PROCEDURE crear_expediente(
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_id_usuario INT
)
BEGIN
    INSERT INTO expedientes (nombre, apellido, id_usuario)
    VALUES (p_nombre, p_apellido, p_id_usuario);
        SELECT LAST_INSERT_ID() as id_expediente;
END //

-- Procedimiento para agregar imagen a expediente
CREATE PROCEDURE agregar_imagen_expediente(
    IN p_id_expediente INT,
    IN p_categoria VARCHAR(50),
    IN p_ruta VARCHAR(255),
    IN p_nombre_original VARCHAR(255),
    IN p_tipo_imagen VARCHAR(100)
)
BEGIN
    INSERT INTO imagenes_expediente (id_expediente, categoria, ruta, nombre_original, tipo_imagen)
    VALUES (p_id_expediente, p_categoria, p_ruta, p_nombre_original, p_tipo_imagen);
END //

-- Procedimiento para eliminar expediente y sus imágenes
CREATE PROCEDURE eliminar_expediente(
    IN p_id_expediente INT
)
BEGIN
    DELETE FROM expedientes WHERE id = p_id_expediente;
END //

-- Procedimiento para obtener imágenes de un expediente
CREATE PROCEDURE obtener_imagenes_expediente(
    IN p_id_expediente INT
)
BEGIN
    SELECT id, categoria, ruta, nombre_original, tipo_imagen, fecha_subida
    FROM imagenes_expediente
    WHERE id_expediente = p_id_expediente
    ORDER BY fecha_subida DESC;
END //

DELIMITER ;

-- Triggers

DELIMITER //

-- Trigger para validar categoría y tipo de imagen
CREATE TRIGGER validar_categoria_y_tipo_imagen
BEFORE INSERT ON imagenes_expediente
FOR EACH ROW
BEGIN
    -- Validar categoría de imagen
    IF NEW.categoria NOT IN ('C.I', 'RIF', 'Titulo', 'Declaracion_familiar', 
                           'Prima_profesional', 'Certificado_de_salud_mental',
                           'Certificado_de_salud', 'Boletin_de_vacaciones',
                           'Providencia', 'Declaracion_jurada', 'Reposos',
                           'Constancia', 'Permisos') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Categoría de imagen no válida';
    END IF;

    -- Validar tipo de imagen
    IF NEW.tipo_imagen NOT IN ('image/jpeg', 'image/png', 'image/gif') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Tipo de imagen no permitido';
    END IF;
END //

DELIMITER ;

-- Insertar usuario administrador por defecto
-- Nota: La contraseña debe ser hasheada antes de insertarla
INSERT INTO usuarios (nombre, apellido, email, password, fechaCaptura)
VALUES ('Admin', 'Sistema', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', CURRENT_DATE);