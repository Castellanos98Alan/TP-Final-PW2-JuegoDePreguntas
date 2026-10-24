-- =========================================================
-- 25 PREGUNTAS DE ONE PIECE
-- =========================================================


-- =======================
-- ONE PIECE - FACILES
-- =======================

INSERT INTO pregunta (
    enunciado,
    respuesta_a,
    respuesta_b,
    respuesta_c,
    respuesta_d,
    respuesta_correcta,
    anime_id,
    categoria_id,
    tipo_pregunta,
    recurso,
    dificultad
)
VALUES

(
    '¿Quién es el protagonista principal de One Piece?',
    'Monkey D. Luffy',
    'Roronoa Zoro',
    'Sanji',
    'Shanks',
    'A',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cuál es el sueño de Luffy?',
    'Ser el mejor espadachín',
    'Convertirse en Rey de los Piratas',
    'Encontrar el All Blue',
    'Ser almirante',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es el espadachín de los Sombrero de Paja?',
    'Usopp',
    'Sanji',
    'Zoro',
    'Franky',
    'C',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es el cocinero de la tripulación de Luffy?',
    'Brook',
    'Sanji',
    'Chopper',
    'Jinbe',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es la navegante de los Sombrero de Paja?',
    'Robin',
    'Nami',
    'Vivi',
    'Boa Hancock',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Qué tipo de animal es Chopper?',
    'Perro',
    'Gato',
    'Reno',
    'Oso',
    'C',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién utiliza tres espadas para combatir?',
    'Sanji',
    'Zoro',
    'Brook',
    'Shanks',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién fue el primer miembro en unirse a la tripulación de Luffy?',
    'Nami',
    'Usopp',
    'Zoro',
    'Sanji',
    'C',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),


-- =======================
-- ONE PIECE - MEDIAS
-- =======================

(
    '¿Cómo se llama el barco actual de los Sombrero de Paja?',
    'Going Merry',
    'Red Force',
    'Thousand Sunny',
    'Oro Jackson',
    'C',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién construyó el Thousand Sunny?',
    'Iceburg',
    'Franky',
    'Usopp',
    'Tom',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué miembro de la tripulación es arqueóloga?',
    'Nami',
    'Robin',
    'Vivi',
    'Carrot',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Cuál es el sueño de Sanji?',
    'Encontrar el One Piece',
    'Encontrar el All Blue',
    'Ser Rey de los Piratas',
    'Derrotar a Mihawk',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién entrenó a Zoro durante el salto temporal?',
    'Rayleigh',
    'Shanks',
    'Mihawk',
    'Garp',
    'C',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién entrenó a Luffy durante el salto temporal?',
    'Silvers Rayleigh',
    'Garp',
    'Shanks',
    'Dragon',
    'A',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Cuál era el nombre del primer barco de los Sombrero de Paja?',
    'Thousand Sunny',
    'Going Merry',
    'Moby Dick',
    'Polar Tang',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién es el músico de los Sombrero de Paja?',
    'Franky',
    'Brook',
    'Usopp',
    'Chopper',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué personaje es conocido como el Cirujano de la Muerte?',
    'Eustass Kid',
    'Trafalgar Law',
    'Doflamingo',
    'Crocodile',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),


-- =======================
-- ONE PIECE - DIFICILES
-- =======================

(
    '¿Cuál era el nombre del barco de Gol D. Roger?',
    'Moby Dick',
    'Oro Jackson',
    'Red Force',
    'Victoria Punk',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién fue el carpintero que construyó el Oro Jackson?',
    'Franky',
    'Iceburg',
    'Tom',
    'Kaku',
    'C',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cómo se llama la isla donde nació Gol D. Roger?',
    'Loguetown',
    'Dawn Island',
    'God Valley',
    'Jaya',
    'A',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cuál es el nombre de la espada negra de Mihawk?',
    'Enma',
    'Yoru',
    'Shusui',
    'Wado Ichimonji',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué familia gobernaba Dressrosa antes del regreso de los Riku?',
    'Charlotte',
    'Vinsmoke',
    'Donquixote',
    'Nefertari',
    'C',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cómo se llama el padre de Sanji?',
    'Judge',
    'King',
    'Caesar',
    'Queen',
    'A',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué miembro de los Sombrero de Paja nació en Ohara?',
    'Nami',
    'Robin',
    'Franky',
    'Brook',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién era el capitán de los Piratas de Barbablanca?',
    'Marshall D. Teach',
    'Edward Newgate',
    'Marco',
    'Portgas D. Ace',
    'B',
    (SELECT id FROM anime WHERE nombre = 'One Piece'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
);



-- =========================================================
-- 25 PREGUNTAS DE NARUTO
-- =========================================================


-- =======================
-- NARUTO - FACILES
-- =======================

INSERT INTO pregunta (
    enunciado,
    respuesta_a,
    respuesta_b,
    respuesta_c,
    respuesta_d,
    respuesta_correcta,
    anime_id,
    categoria_id,
    tipo_pregunta,
    recurso,
    dificultad
)
VALUES

(
    '¿Quién es el protagonista de Naruto?',
    'Sasuke',
    'Naruto',
    'Kakashi',
    'Gaara',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cuál es el apellido de Naruto?',
    'Uchiha',
    'Hyuga',
    'Uzumaki',
    'Nara',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Qué bestia con cola está sellada dentro de Naruto?',
    'Shukaku',
    'Kurama',
    'Gyuki',
    'Matatabi',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es el maestro del Equipo 7?',
    'Iruka',
    'Jiraiya',
    'Kakashi',
    'Guy',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quiénes forman originalmente el Equipo 7 junto a Naruto?',
    'Sasuke y Sakura',
    'Neji y Tenten',
    'Shikamaru e Ino',
    'Kiba y Hinata',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿A qué clan pertenece Sasuke?',
    'Hyuga',
    'Uchiha',
    'Senju',
    'Uzumaki',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién fue el Cuarto Hokage?',
    'Hiruzen Sarutobi',
    'Tobirama Senju',
    'Minato Namikaze',
    'Kakashi Hatake',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cuál es el jutsu característico que Naruto aprende de Jiraiya?',
    'Chidori',
    'Rasengan',
    'Amaterasu',
    'Byakugan',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),


-- =======================
-- NARUTO - MEDIAS
-- =======================

(
    '¿Quién creó originalmente el Rasengan?',
    'Jiraiya',
    'Naruto',
    'Minato Namikaze',
    'Kakashi',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién es el padre de Naruto?',
    'Jiraiya',
    'Minato Namikaze',
    'Kakashi Hatake',
    'Hiruzen Sarutobi',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién es la madre de Naruto?',
    'Tsunade',
    'Kushina Uzumaki',
    'Mikoto Uchiha',
    'Konan',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué técnica utiliza principalmente Sasuke al comienzo de la serie?',
    'Rasengan',
    'Chidori',
    'Rasenshuriken',
    'Byakugan',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién enseñó el Chidori a Sasuke?',
    'Orochimaru',
    'Itachi',
    'Kakashi',
    'Jiraiya',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién se convierte en el Quinto Hokage?',
    'Jiraiya',
    'Kakashi',
    'Tsunade',
    'Danzo',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Cómo se llama el hermano mayor de Sasuke?',
    'Madara',
    'Obito',
    'Itachi',
    'Shisui',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué dojutsu posee el clan Hyuga?',
    'Sharingan',
    'Rinnegan',
    'Byakugan',
    'Mangekyo Sharingan',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),


-- =======================
-- NARUTO - DIFICILES
-- =======================

(
    '¿Quién fue el Segundo Hokage?',
    'Hashirama Senju',
    'Tobirama Senju',
    'Hiruzen Sarutobi',
    'Minato Namikaze',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién fue el maestro de Minato Namikaze?',
    'Orochimaru',
    'Jiraiya',
    'Hiruzen',
    'Tobirama',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién fundó Konoha junto a Hashirama Senju?',
    'Tobirama Senju',
    'Madara Uchiha',
    'Hiruzen Sarutobi',
    'Izuna Uchiha',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué miembro de Akatsuki utilizaba cinco corazones?',
    'Hidan',
    'Sasori',
    'Kakuzu',
    'Deidara',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién fue el jinchuriki del Ocho Colas durante Naruto Shippuden?',
    'Gaara',
    'Killer B',
    'Yagura',
    'Yugito',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cuál es el verdadero nombre del Pain principal que combate contra Naruto?',
    'Nagato',
    'Yahiko',
    'Obito',
    'Konan',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién fue el creador del Edo Tensei?',
    'Orochimaru',
    'Kabuto',
    'Tobirama Senju',
    'Madara Uchiha',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué miembro de Akatsuki era compañero de Hidan?',
    'Deidara',
    'Sasori',
    'Kakuzu',
    'Kisame',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién se convierte en el Sexto Hokage?',
    'Naruto Uzumaki',
    'Kakashi Hatake',
    'Danzo Shimura',
    'Shikamaru Nara',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Naruto'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
);