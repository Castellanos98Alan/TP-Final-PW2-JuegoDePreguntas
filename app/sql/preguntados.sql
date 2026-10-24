CREATE DATABASE IF NOT EXISTS preguntados;
USE preguntados;

CREATE TABLE IF NOT EXISTS rol (id INT AUTO_INCREMENT PRIMARY KEY,nombre VARCHAR(50) NOT NULL);

INSERT IGNORE INTO rol (id, nombre) VALUES (1, 'jugador'), (2, 'editor'), (3, 'administrador');

CREATE TABLE IF NOT EXISTS usuario (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       nombre_completo VARCHAR(100) NOT NULL,
    anio_nacimiento INT NOT NULL,
    sexo ENUM('Masculino', 'Femenino', 'Prefiero no cargarlo') NOT NULL,
    pais VARCHAR(100) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    latitud DECIMAL(10,8) NULL,
    longitud DECIMAL(11,8) NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT 'default.png',
    token_validacion VARCHAR(100) NULL,
    esta_activo TINYINT(1) DEFAULT 1,
    id_rol INT DEFAULT 1,
    puntaje_acumulado INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES rol(id)
    );

INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, username, password, foto_perfil, esta_activo, id_rol, puntaje_acumulado)
VALUES ('Facundo Docente', 1995, 'Masculino', 'Argentina', 'Buenos Aires', 'facu@unlam.edu.ar', 'facu', MD5('1234'), 'default.png', 1, 1, 0)
    ON DUPLICATE KEY UPDATE password = MD5('1234'), esta_activo = 1;

INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, username, password, foto_perfil, esta_activo, id_rol, puntaje_acumulado)
VALUES ('Administrador', 1995, 'Masculino', 'Argentina', 'Buenos Aires', 'admin@admin.com.ar', 'admin', MD5('admin'), 'default.png', 1, 3, 0)
    ON DUPLICATE KEY UPDATE password = MD5('1234'), esta_activo = 1;

INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, username, password, foto_perfil, esta_activo, id_rol, puntaje_acumulado)
VALUES ('Editor', 1995, 'Masculino', 'Argentina', 'Buenos Aires', 'editor@editor.edu.ar', 'editor', MD5('editor'), 'default.png', 1, 2, 0)
    ON DUPLICATE KEY UPDATE password = MD5('1234'), esta_activo = 1;

CREATE TABLE IF NOT EXISTS partida (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       id_usuario INT NOT NULL,
                                       puntaje INT DEFAULT 0,
                                       resultado VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
    );

INSERT INTO partida (id_usuario, puntaje, resultado)
VALUES
    (
        (SELECT id FROM usuario WHERE username = 'facu'),
        100,
        'Ganada'
    ),
    (
        (SELECT id FROM usuario WHERE username = 'facu'),
        0,
        'Perdida'
    ),
    (
        (SELECT id FROM usuario WHERE username = 'facu'),
        120,
        'Ganada'
    );

CREATE TABLE IF NOT EXISTS anime (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     nombre VARCHAR(100) NOT NULL UNIQUE,
    imagen VARCHAR(500) DEFAULT NULL,
    esta_activo TINYINT(1) DEFAULT 1
    );



INSERT INTO anime (nombre)
VALUES
    ('One Piece'),
    ('Naruto'),
    ('Dragon Ball'),
    ('Bleach'),
    ('Jujutsu Kaisen'),
    ('Demon Slayer'),
    ('Death Note'),
    ('Pokémon');


CREATE TABLE IF NOT EXISTS pregunta (
                                        id INT AUTO_INCREMENT PRIMARY KEY,

                                        enunciado VARCHAR(500) NOT NULL,

    respuesta_a VARCHAR(255) NOT NULL,
    respuesta_b VARCHAR(255) NOT NULL,
    respuesta_c VARCHAR(255) NOT NULL,
    respuesta_d VARCHAR(255) NOT NULL,

    respuesta_correcta CHAR(1) NOT NULL,

    anime_id INT NOT NULL,

    tipo_pregunta ENUM(
                          'normal',
                          'silueta',
                          'voz',
                          'recompensa',
                          'imagen'
                      ) NOT NULL DEFAULT 'normal',

    recurso VARCHAR(500) DEFAULT NULL,

    dificultad ENUM(
                       'facil',
                       'media',
                       'dificil'
                   ) NOT NULL,

    esta_activa TINYINT(1) DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (anime_id) REFERENCES anime(id)
    );

CREATE TABLE usuario_pregunta (
                                  id INT AUTO_INCREMENT PRIMARY KEY,

                                  usuario_id INT NOT NULL,
                                  pregunta_id INT NOT NULL,

                                  respondida_correctamente TINYINT(1) DEFAULT NULL,

                                  fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                                  UNIQUE(usuario_id, pregunta_id),

                                  FOREIGN KEY (usuario_id)
                                      REFERENCES usuario(id),

                                  FOREIGN KEY (pregunta_id)
                                      REFERENCES pregunta(id)
);
