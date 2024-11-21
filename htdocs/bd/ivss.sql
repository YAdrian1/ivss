-- Crear la base de datos
CREATE SCHEMA `ivss` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ivss;

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

-- Crear la tabla areas sin la columna id_area y usando nombre como identificador
CREATE TABLE IF NOT EXISTS areas (
    nombre VARCHAR(100) NOT NULL UNIQUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(nombre)  -- Establecer nombre como clave primaria
) ENGINE=InnoDB;

-- Insertar datos por defecto
INSERT INTO areas (nombre) VALUES 
('Administración'),
('Rayos X'),
('Historias Medicas'),
('Odontologia'),
('Laboratorio');

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
    ruta_carpeta VARCHAR(255) NOT NULL,
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

-- Nueva tabla de imágenes subidas con modificación
DROP TABLE IF EXISTS imagenes_subidas;

CREATE TABLE imagenes_subidas (
    id INT NOT NULL,
    id_usuario INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    extension VARCHAR(10) NOT NULL,
    imagen_data MEDIUMBLOB NOT NULL,
    tipo_imagen VARCHAR(100) NOT NULL,
    fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id, id_usuario),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- Tabla de logs
CREATE TABLE log_eliminaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_registro VARCHAR(50) NOT NULL,
    id_registro INT NOT NULL,
    fecha_eliminacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario VARCHAR(50)
) ENGINE=InnoDB;

-- Índices para optimizar las búsquedas
CREATE INDEX idx_expediente_usuario ON expedientes(id_usuario);
CREATE INDEX idx_expediente_nombre ON expedientes(nombre, apellido);
CREATE INDEX idx_imagen_expediente ON imagenes_expediente(id_expediente);
CREATE INDEX idx_imagen_categoria ON imagenes_expediente(categoria);
CREATE INDEX idx_usuario_email ON usuarios(email);
CREATE INDEX idx_imagen_subida_fecha ON imagenes_subidas(fecha_subida);

-- Procedimientos almacenados
DELIMITER //

-- Procedimiento para crear un nuevo expediente
CREATE PROCEDURE crear_expediente(
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_id_usuario INT,
    IN p_ruta_carpeta VARCHAR(255)
)
BEGIN
    INSERT INTO expedientes (nombre, apellido, id_usuario, ruta_carpeta)
    VALUES (p_nombre, p_apellido, p_id_usuario, p_ruta_carpeta);
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
    DELETE FROM imagenes_expediente WHERE id_expediente = p_id_expediente;
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

-- Procedimiento para obtener imágenes por categoría
CREATE PROCEDURE obtener_imagenes_por_categoria(
    IN p_id_expediente INT,
    IN p_categoria VARCHAR(50)
)
BEGIN
    SELECT id, ruta, nombre_original, tipo_imagen, fecha_subida
    FROM imagenes_expediente
    WHERE id_expediente = p_id_expediente 
    AND categoria = p_categoria
    ORDER BY fecha_subida DESC;
END //

-- Procedimiento para obtener el siguiente ID disponible
CREATE PROCEDURE obtener_siguiente_id_imagen(
    IN p_id_usuario INT,
    OUT p_siguiente_id INT
)
BEGIN
    SELECT COALESCE(MAX(id), 0) + 1 
    INTO p_siguiente_id
    FROM imagenes_subidas 
    WHERE id_usuario = p_id_usuario;
END //

-- Procedimiento modificado para subir imagen con ID secuencial
DROP PROCEDURE IF EXISTS subir_imagen //
CREATE PROCEDURE subir_imagen(
    IN p_id_usuario INT,
    IN p_nombre VARCHAR(255),
    IN p_extension VARCHAR(10),
    IN p_imagen_data MEDIUMBLOB,
    IN p_tipo_imagen VARCHAR(100)
)
BEGIN
    DECLARE siguiente_id INT;
    
    -- Obtener el siguiente ID disponible
    CALL obtener_siguiente_id_imagen(p_id_usuario, siguiente_id);
    
    -- Insertar la nueva imagen
    INSERT INTO imagenes_subidas (id, id_usuario, nombre, extension, imagen_data, tipo_imagen)
    VALUES (siguiente_id, p_id_usuario, p_nombre, p_extension, p_imagen_data, p_tipo_imagen);
    
    -- Devolver el ID asignado
    SELECT siguiente_id as id_imagen;
END //

-- Procedimiento para reorganizar IDs
CREATE PROCEDURE reorganizar_ids_imagenes(
    IN p_id_usuario INT
)
BEGIN
    SET @count = 0;
    UPDATE imagenes_subidas 
    SET id = (@count:=@count+1) 
    WHERE id_usuario = p_id_usuario 
    ORDER BY fecha_subida;
END //

-- Procedimiento para obtener una imagen
CREATE PROCEDURE obtener_imagen(
    IN p_id_imagen INT,
    IN p_id_usuario INT
)
BEGIN
    SELECT id, nombre, extension, imagen_data, tipo_imagen, fecha_subida
    FROM imagenes_subidas
    WHERE id = p_id_imagen AND id_usuario = p_id_usuario;
END //

-- Procedimiento para eliminar una imagen
CREATE PROCEDURE eliminar_imagen(
    IN p_id_imagen INT,
    IN p_id_usuario INT
)
BEGIN
    DELETE FROM imagenes_subidas 
    WHERE id = p_id_imagen AND id_usuario = p_id_usuario;
    
    -- Reorganizar los IDs después de la eliminación
    CALL reorganizar_ids_imagenes(p_id_usuario);
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

-- Trigger para actualizar la fecha de subida al insertar una imagen
DELIMITER //
CREATE TRIGGER actualizar_fecha_subida
BEFORE INSERT ON imagenes_expediente
FOR EACH ROW
BEGIN
    SET NEW.fecha_subida = NOW();
END //

DELIMITER ;

-- Trigger para manejar la eliminación de imágenes
DELIMITER //
CREATE TRIGGER manejar_eliminacion_imagen
AFTER DELETE ON imagenes_expediente
FOR EACH ROW
BEGIN
    DECLARE ruta_completa VARCHAR(255);
    
    -- Construir la ruta completa de la imagen
    SET ruta_completa = CONCAT('../../expedientes/', OLD.ruta);
    
    -- Intentar eliminar el archivo físico
    IF (SELECT COUNT(*) FROM imagenes_expediente WHERE id_expediente = OLD.id_expediente) = 0 THEN
        -- Si no quedan imágenes, eliminar la carpeta de la categoría
        IF EXISTS (SELECT * FROM imagenes_expediente WHERE ruta = ruta_completa) THEN
            IF (SELECT COUNT(*) FROM imagenes_expediente WHERE ruta = OLD.ruta) = 0 THEN
                -- Eliminar la carpeta si está vacía
                SET @dir_categoria = CONCAT('../../expedientes/', OLD.categoria);
                IF (SELECT COUNT(*) FROM imagenes_expediente WHERE categoria = OLD.categoria) = 0 THEN
                    RENAME @dir_categoria TO '/dev/null'; -- Simulación de eliminación
                END IF;
            END IF;
        END IF;
    END IF;
END //

DELIMITER ;