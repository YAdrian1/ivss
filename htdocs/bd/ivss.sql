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
                           'sintesis_curricular', 'Constancia', 'Permisos') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Categoría de imagen no válida';
    END IF;

       -- Validar tipo de imagen
    IF NEW.tipo_imagen NOT IN ('image/jpeg', 'image/png', 'image/gif') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Tipo de imagen no permitido';
    END IF;
END //

-- Trigger para validar imagen subida
CREATE TRIGGER validar_imagen_subida
BEFORE INSERT ON imagenes_subidas
FOR EACH ROW
BEGIN
    -- Validar extensión de archivo
    IF NEW.extension NOT IN ('jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'xls', 'xlsx') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Extensión de archivo no permitida';
    END IF;

    -- Validar tipo de imagen/documento
    IF NEW.tipo_imagen NOT IN ('image/jpeg', 'image/png', 'image/gif', 
                               'application/msword', 
                               'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                               'application/vnd.ms-excel',
                               'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Tipo de archivo no permitido';
    END IF;
END //

-- Trigger para limpiar ruta de carpeta antes de insertar
CREATE TRIGGER limpiar_ruta_carpeta
BEFORE INSERT ON expedientes
FOR EACH ROW
BEGIN
    SET NEW.ruta_carpeta = REPLACE(LOWER(NEW.ruta_carpeta), ' ', '_');
END //

-- Trigger para registrar eliminación de expediente
CREATE TRIGGER registrar_eliminacion_expediente
BEFORE DELETE ON expedientes
FOR EACH ROW
BEGIN
    INSERT INTO log_eliminaciones (tipo_registro, id_registro, fecha_eliminacion, usuario)
    VALUES ('expediente', OLD.id, NOW(), @usuario_actual);
END //

DELIMITER ;

-- Insertar usuario administrador por defecto
-- Nota: La contraseña debe ser hasheada antes de insertarla
INSERT INTO usuarios (nombre, apellido, email, password, fechaCaptura)
VALUES ('Admin', 'Sistema', 'admin@example.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', CURRENT_DATE)
ON DUPLICATE KEY UPDATE fechaCaptura = CURRENT_DATE;

-- Crear vistas

-- Vista para expedientes con cantidad de imágenes
CREATE OR REPLACE VIEW vista_expedientes_imagenes AS
SELECT 
    e.id,
    e.nombre,
    e.apellido,
    e.fecha_creacion,
    COUNT(i.id) as total_imagenes,
    COUNT(DISTINCT i.categoria) as total_categorias
FROM expedientes e
LEFT JOIN imagenes_expediente i ON e.id = i.id_expediente
GROUP BY e.id;

-- Vista para resumen de categorías por expediente
CREATE OR REPLACE VIEW vista_categorias_expediente AS
SELECT 
    id_expediente,
    categoria,
    COUNT(*) as total_imagenes,
    MIN(fecha_subida) as primera_imagen,
    MAX(fecha_subida) as ultima_imagen
FROM imagenes_expediente
GROUP BY id_expediente, categoria;

-- Configurar variables de sesión
SET GLOBAL max_allowed_packet = 16777216; -- 16MB
SET GLOBAL innodb_file_per_table = 1;
SET GLOBAL innodb_file_format = 'Barracuda';

-- Asegurar que los permisos estén correctamente configurados
GRANT EXECUTE ON PROCEDURE ivss.subir_imagen TO 'tu_usuario'@'localhost';
GRANT EXECUTE ON PROCEDURE ivss.obtener_imagen TO 'tu_usuario'@'localhost';
GRANT EXECUTE ON PROCEDURE ivss.eliminar_imagen TO 'tu_usuario'@'localhost';
GRANT EXECUTE ON PROCEDURE ivss.obtener_siguiente_id_imagen TO 'tu_usuario'@'localhost';
GRANT EXECUTE ON PROCEDURE ivss.reorganizar_ids_imagenes TO 'tu_usuario'@'localhost';

-- Crear un índice en la columna nombre de la tabla imagenes_subidas para búsquedas más rápidas
CREATE INDEX idx_nombre_imagen ON imagenes_subidas(nombre);

-- Optimizar la tabla después de todas las modificaciones
OPTIMIZE TABLE imagenes_subidas;

-- Crear tablas de áreas y personal
CREATE TABLE IF NOT EXISTS areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

    CREATE TABLE IF NOT EXISTS personal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    area_id INT,
    FOREIGN KEY (area_id) REFERENCES areas(id) ON DELETE SET NULL
);

-- Insertar datos de ejemplo en la tabla areas
INSERT INTO areas (nombre) VALUES ('Administración'), ('Finanzas'), ('Recursos Humanos'), ('IT'), ('Marketing')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- Insertar datos de ejemplo en la tabla personal
INSERT INTO personal (nombre, area_id) VALUES 
('Juan Pérez', 1),
('María López', 2),
('Carlos García', 3),
('Ana Martínez', 4),
('Luis Fernández', 5)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), area_id = VALUES(area_id);

-- Finalizar la creación de la base de datos
COMMIT;