CREATE DATABASE IF NOT EXISTS Preguntados;
USE preguntados;

CREATE TABLE rol (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     nombre VARCHAR(50) NOT NULL -- 'jugador', 'editor', 'administrador'
);

INSERT INTO rol (nombre) VALUES ('jugador'), ('editor'), ('administrador');

CREATE TABLE usuario (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         nombre_completo VARCHAR(100) NOT NULL,
                         anio_nacimiento INT NOT NULL,
                         sexo ENUM('Masculino', 'Femenino', 'Prefiero no cargarlo') NOT NULL,
                         pais VARCHAR(100) NOT NULL,
                         ciudad VARCHAR(100) NOT NULL,
                         latitud DECIMAL(10, 8),
                         longitud DECIMAL(11, 8),
                         email VARCHAR(150) NOT NULL UNIQUE,
                         password VARCHAR(255) NOT NULL,
                         username VARCHAR(50) NOT NULL UNIQUE,
                         foto_perfil VARCHAR(255) DEFAULT 'default.png',
                         token_validacion VARCHAR(100) NULL,
                         esta_activo BOOLEAN DEFAULT FALSE,
                         id_rol INT DEFAULT 1,
                         puntaje_acumulado INT DEFAULT 0,
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (id_rol) REFERENCES rol(id)
);