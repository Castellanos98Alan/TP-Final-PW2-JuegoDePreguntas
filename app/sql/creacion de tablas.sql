-- =========================================================
-- BASE DE DATOS
-- =========================================================

DROP DATABASE IF EXISTS preguntados2;

CREATE DATABASE preguntados2
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE preguntados2;


-- =========================================================
-- TABLA ROL
-- =========================================================

CREATE TABLE rol (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(50) NOT NULL UNIQUE
);


INSERT INTO rol (id, nombre)
VALUES
    (1, 'jugador'),
    (2, 'editor'),
    (3, 'administrador');
    



-- =========================================================
-- TABLA USUARIO
-- =========================================================

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre_completo VARCHAR(100) NOT NULL,

    anio_nacimiento INT NOT NULL,

    sexo ENUM(
        'Masculino',
        'Femenino',
        'Prefiero no cargarlo'
    ) NOT NULL,

    pais VARCHAR(100) NOT NULL,

    ciudad VARCHAR(100) NOT NULL,

    latitud DECIMAL(10,8) NULL,

    longitud DECIMAL(11,8) NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    foto_perfil VARCHAR(255)
        DEFAULT 'default.png',

    token_validacion VARCHAR(100) NULL,

    esta_activo TINYINT(1)
        NOT NULL DEFAULT 1,

    id_rol INT
        NOT NULL DEFAULT 1,

    puntaje_acumulado INT
        NOT NULL DEFAULT 0,

    created_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_rol
        FOREIGN KEY (id_rol)
        REFERENCES rol(id)
);


-- =========================================================
-- USUARIOS DE PRUEBA
-- =========================================================

INSERT INTO usuario (
    nombre_completo,
    anio_nacimiento,
    sexo,
    pais,
    ciudad,
    email,
    username,
    password,
    foto_perfil,
    esta_activo,
    id_rol,
    puntaje_acumulado
)
VALUES (
    'Facundo Docente',
    1995,
    'Masculino',
    'Argentina',
    'Buenos Aires',
    'facu@unlam.edu.ar',
    'facu',
    MD5('1234'),
    'default.png',
    1,
    1,
    0
);

INSERT INTO usuario (
    nombre_completo,
    anio_nacimiento,
    sexo,
    pais,
    ciudad,
    email,
    username,
    password,
    foto_perfil,
    esta_activo,
    id_rol,
    puntaje_acumulado
)
VALUES (
    'Administrador',
    1995,
    'Masculino',
    'Argentina',
    'Buenos Aires',
    'admin@admin.com.ar',
    'admin',
    MD5('admin'),
    'default.png',
    1,
    3,
    0
);


INSERT INTO usuario (
    nombre_completo,
    anio_nacimiento,
    sexo,
    pais,
    ciudad,
    email,
    username,
    password,
    foto_perfil,
    esta_activo,
    id_rol,
    puntaje_acumulado
)
VALUES (
    'Editor',
    1995,
    'Masculino',
    'Argentina',
    'Buenos Aires',
    'editor@editor.edu.ar',
    'editor',
    MD5('editor'),
    'default.png',
    1,
    2,
    0
);


-- =========================================================
-- TABLA ANIME
-- =========================================================

CREATE TABLE anime (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100)
        NOT NULL UNIQUE,

    imagen VARCHAR(500)
        DEFAULT NULL,

    esta_activo TINYINT(1)
        NOT NULL DEFAULT 1
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
    ('Pokémon'),
    ('Fullmetal Alchemist'),
    ('Attack on Titan'),
    ('Hunter x Hunter');


-- =========================================================
-- TABLA CATEGORIA
-- =========================================================

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100)
        NOT NULL UNIQUE,

    descripcion VARCHAR(255)
        DEFAULT NULL,

    esta_activa TINYINT(1)
        NOT NULL DEFAULT 1
);


INSERT INTO categoria (
    nombre,
    descripcion
)
VALUES
(
    'Normal',
    'Pregunta tradicional de conocimiento'
),
(
    'Silueta',
    'Identificar un personaje mediante una silueta'
),
(
    'Voz',
    'Identificar un personaje mediante un audio'
),
(
    'Imagen',
    'Responder una pregunta utilizando una imagen'
),
(
    'Recompensa',
    'Identificar información mediante un cartel de recompensa'
);


-- =========================================================
-- TABLA PREGUNTA
-- =========================================================

CREATE TABLE pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,

    enunciado VARCHAR(500)
        NOT NULL,

    respuesta_a VARCHAR(255)
        NOT NULL,

    respuesta_b VARCHAR(255)
        NOT NULL,

    respuesta_c VARCHAR(255)
        NOT NULL,

    respuesta_d VARCHAR(255)
        NOT NULL,

    respuesta_correcta CHAR(1)
        NOT NULL,

    anime_id INT
        NOT NULL,

    categoria_id INT
        NOT NULL,

    tipo_pregunta ENUM(
        'texto',
        'imagen',
        'audio'
    ) NOT NULL DEFAULT 'texto',

    recurso VARCHAR(500)
        DEFAULT NULL,

    dificultad ENUM(
        'facil',
        'media',
        'dificil'
    ) NOT NULL,

    esta_activa TINYINT(1)
        NOT NULL DEFAULT 1,

    created_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_pregunta_anime
        FOREIGN KEY (anime_id)
        REFERENCES anime(id),

    CONSTRAINT fk_pregunta_categoria
        FOREIGN KEY (categoria_id)
        REFERENCES categoria(id),

    CONSTRAINT chk_respuesta_correcta
        CHECK (
            respuesta_correcta IN (
                'A',
                'B',
                'C',
                'D'
            )
        )
);


-- =========================================================
-- TABLA PARTIDA
-- =========================================================

CREATE TABLE partida (
    id INT AUTO_INCREMENT PRIMARY KEY,

    id_usuario INT
        NOT NULL,

    puntaje INT
        NOT NULL DEFAULT 0,

    resultado ENUM(
        'Ganada',
        'Perdida'
    ) NOT NULL,

    created_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_partida_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuario(id)
);


-- =========================================================
-- TABLA USUARIO_PREGUNTA
-- =========================================================

CREATE TABLE usuario_pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT
        NOT NULL,

    pregunta_id INT
        NOT NULL,

    respondida_correctamente TINYINT(1)
        DEFAULT NULL,

    fecha_respuesta TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT uq_usuario_pregunta
        UNIQUE (
            usuario_id,
            pregunta_id
        ),

    CONSTRAINT fk_usuario_pregunta_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuario(id),

    CONSTRAINT fk_usuario_pregunta_pregunta
        FOREIGN KEY (pregunta_id)
        REFERENCES pregunta(id)
);

-- =========================================================
-- Introducir las imagenes
-- =========================================================

UPDATE anime SET imagen = 'OnePiece.png' WHERE id = 1;
UPDATE anime SET imagen = 'Naruto.png' WHERE id = 2;
UPDATE anime SET imagen = 'DragonBallZ.png' WHERE id = 3;
UPDATE anime SET imagen = 'Bleach.png' WHERE id = 4;
UPDATE anime SET imagen = 'JujutsuKaisen.png' WHERE id = 5;
UPDATE anime SET imagen = 'KimetsuNoYaiba.png' WHERE id = 6;
UPDATE anime SET imagen = 'DeathNote.png' WHERE id = 7;
UPDATE anime SET imagen = 'Pokemon.png' WHERE id = 8;
UPDATE anime SET imagen = 'FullMetalAlchemist.png' WHERE id = 9;
UPDATE anime SET imagen = 'ShingekiNoKyojin.png' WHERE id = 10;
UPDATE anime SET imagen = 'HunterXHunter.png' WHERE id = 11;
UPDATE anime SET imagen = 'Frieren.png' WHERE id = 12;

UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '4');
UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '5');
UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '6');
UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '7');
UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '9');
UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '10');
UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '11');
UPDATE `preguntados2`.`anime` SET `esta_activo` = '0' WHERE (`id` = '12');
