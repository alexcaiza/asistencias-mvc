-- Crear base de datos
CREATE DATABASE IF NOT EXISTS asistenciasdb;
USE asistenciasdb;

-- Tabla de roles
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar roles
INSERT INTO roles (nombre) VALUES ('administrador'), ('trabajador');

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    dni VARCHAR(20) UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de asistencias
CREATE TABLE IF NOT EXISTS asistencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME NOT NULL,
    hora_salida TIME DEFAULT NULL,
    estado VARCHAR(20) NOT NULL, -- 'A tiempo', 'Tarde', 'Faltó'
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar usuarios de prueba (Password: password123)
-- Hash generado con password_hash('password123', PASSWORD_BCRYPT)
INSERT INTO usuarios (rol_id, nombre, apellido, dni, email, password, status) VALUES 
(1, 'Admin', 'Sistemas', '12345678', 'admin@mail.com', '$2y$10$EFB6O6d1lqDvBG47Z2tmuOlUv9lYocXIGMQGLfSX7M9qfyfsATlOa', 1),
(2, 'Juan', 'Pérez', '87654321', 'trabajador@mail.com', '$2y$10$EFB6O6d1lqDvBG47Z2tmuOlUv9lYocXIGMQGLfSX7M9qfyfsATlOa', 1);

-- Agregar campo dni a tabla existente (ejecutar solo si la tabla ya existe)
-- ALTER TABLE usuarios ADD COLUMN dni VARCHAR(20) UNIQUE AFTER rol_id;
