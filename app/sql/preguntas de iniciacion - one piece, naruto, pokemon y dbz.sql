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

-- =========================================================
-- 25 PREGUNTAS DE DRAGON BALL
-- =========================================================

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

-- =======================
-- DRAGON BALL - FACILES
-- =======================

(
    '¿Quién es el protagonista principal de Dragon Ball?',
    'Vegeta',
    'Goku',
    'Piccolo',
    'Gohan',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cómo se llama la raza de Goku?',
    'Namekiano',
    'Saiyajin',
    'Humano',
    'Kaioshin',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es el príncipe de los Saiyajin?',
    'Goku',
    'Gohan',
    'Vegeta',
    'Trunks',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cómo se llama el hijo mayor de Goku?',
    'Goten',
    'Trunks',
    'Gohan',
    'Pan',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es el mejor amigo de Goku desde niño?',
    'Krillin',
    'Yamcha',
    'Tien',
    'Piccolo',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cómo se llaman los objetos que pueden conceder deseos?',
    'Esferas del Dragón',
    'Anillos del Tiempo',
    'Semillas del Ermitaño',
    'Pendientes Potara',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es la esposa de Goku?',
    'Bulma',
    'Chi-Chi',
    'Videl',
    'Android 18',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién es la esposa de Vegeta?',
    'Bulma',
    'Chi-Chi',
    'Videl',
    'Launch',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

-- =======================
-- DRAGON BALL - MEDIAS
-- =======================

(
    '¿Quién entrenó a Goku en el planeta de Kaio-sama?',
    'Maestro Roshi',
    'Kaio-sama',
    'Whis',
    'Kami',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué técnica utiliza Goku para aumentar temporalmente su poder?',
    'Kaioken',
    'Makankosappo',
    'Galick Ho',
    'Masenko',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién destruyó el planeta Vegeta?',
    'Cell',
    'Majin Buu',
    'Freezer',
    'Beerus',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién es el padre de Goku?',
    'King Vegeta',
    'Bardock',
    'Paragus',
    'Raditz',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién es el hermano de Goku?',
    'Nappa',
    'Raditz',
    'Bardock',
    'Broly',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Quién derrota finalmente a Cell?',
    'Goku',
    'Vegeta',
    'Gohan',
    'Trunks',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Cómo se llama la fusión de Goten y Trunks?',
    'Vegito',
    'Gogeta',
    'Gotenks',
    'Kefla',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué androide se casa con Krillin?',
    'Android 16',
    'Android 17',
    'Android 18',
    'Android 19',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

-- =======================
-- DRAGON BALL - DIFICILES
-- =======================

(
    '¿Cómo se llama la técnica especial de Piccolo?',
    'Kamehameha',
    'Makankosappo',
    'Final Flash',
    'Masenko',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién fue el maestro de Piccolo antes de fusionarse con él?',
    'Kami',
    'Nail',
    'Dende',
    'Guru',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién es el Dios de la Destrucción del Universo 7?',
    'Whis',
    'Beerus',
    'Champa',
    'Zeno',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién es el ángel encargado de entrenar a Beerus?',
    'Vados',
    'Whis',
    'Merus',
    'Shin',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué personaje proviene originalmente del Universo 6?',
    'Hit',
    'Jiren',
    'Toppo',
    'Dyspo',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién es el padre de Vegeta?',
    'Bardock',
    'King Vegeta',
    'Paragus',
    'Nappa',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cómo se llama la fusión de Goku y Vegeta mediante los pendientes Potara?',
    'Gogeta',
    'Vegito',
    'Gotenks',
    'Vegetto Jr.',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué Saiyajin sobreviviente es hijo de Paragus?',
    'Raditz',
    'Broly',
    'Nappa',
    'Tarble',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Quién es el Kaioshin del Universo 7?',
    'Shin',
    'Beerus',
    'Whis',
    'Kibito',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Dragon Ball'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
);



-- =========================================================
-- 25 PREGUNTAS DE POKÉMON
-- =========================================================

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

-- =======================
-- POKÉMON - FACILES
-- =======================

(
    '¿Cuál es el Pokémon principal de Ash?',
    'Charmander',
    'Pikachu',
    'Bulbasaur',
    'Squirtle',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿De qué tipo es Pikachu?',
    'Fuego',
    'Agua',
    'Eléctrico',
    'Planta',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cuál de estos es un Pokémon inicial de Kanto?',
    'Pikachu',
    'Bulbasaur',
    'Eevee',
    'Meowth',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿En qué evoluciona Charmander?',
    'Charizard',
    'Charmeleon',
    'Dragonite',
    'Magmar',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿En qué evoluciona Squirtle?',
    'Blastoise',
    'Wartortle',
    'Lapras',
    'Golduck',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Quién acompaña a Jessie y James en el Equipo Rocket?',
    'Pikachu',
    'Meowth',
    'Psyduck',
    'Eevee',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Qué objeto se utiliza normalmente para capturar Pokémon?',
    'Pokédex',
    'Poké Ball',
    'Poción',
    'Bicicleta',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

(
    '¿Cuál es la evolución final de Bulbasaur?',
    'Ivysaur',
    'Venusaur',
    'Vileplume',
    'Victreebel',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'facil'
),

-- =======================
-- POKÉMON - MEDIAS
-- =======================

(
    '¿Cuál es el número de Pikachu en la Pokédex Nacional?',
    '001',
    '025',
    '150',
    '151',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué Pokémon ocupa el número 001 de la Pokédex Nacional?',
    'Charmander',
    'Bulbasaur',
    'Squirtle',
    'Pikachu',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Cuál es la evolución de Magikarp?',
    'Milotic',
    'Gyarados',
    'Dragonair',
    'Lapras',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué tipo es especialmente efectivo contra los Pokémon de tipo Agua?',
    'Fuego',
    'Eléctrico',
    'Roca',
    'Tierra',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Cuál es la evolución final de Charmander?',
    'Charmeleon',
    'Charizard',
    'Dragonite',
    'Typhlosion',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué Pokémon legendario fue creado a partir del ADN de Mew?',
    'Moltres',
    'Mewtwo',
    'Lugia',
    'Celebi',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Cómo se llama la enfermera habitual de los Centros Pokémon?',
    'Misty',
    'Joy',
    'Jenny',
    'Delia',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

(
    '¿Qué personaje de Kanto es especialista en Pokémon de tipo Agua?',
    'Brock',
    'Misty',
    'Gary',
    'Tracey',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'media'
),

-- =======================
-- POKÉMON - DIFICILES
-- =======================

(
    '¿Cuál es el número de Mew en la Pokédex Nacional?',
    '149',
    '150',
    '151',
    '152',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué Pokémon es conocido por tener múltiples evoluciones posibles?',
    'Ditto',
    'Eevee',
    'Porygon',
    'Togepi',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cuál de estos Pokémon pertenece originalmente a la región de Johto?',
    'Totodile',
    'Squirtle',
    'Treecko',
    'Piplup',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cuál de estos Pokémon es de tipo Fantasma y Veneno?',
    'Gengar',
    'Alakazam',
    'Machamp',
    'Snorlax',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué Pokémon evoluciona a Dragonite?',
    'Dragonair',
    'Dratini',
    'Gyarados',
    'Salamence',
    'A',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Qué Pokémon es conocido como el Pokémon Genético?',
    'Mew',
    'Mewtwo',
    'Ditto',
    'Deoxys',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cuál es el nombre de la primera región presentada en el anime de Pokémon?',
    'Johto',
    'Hoenn',
    'Kanto',
    'Sinnoh',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cuál de estos Pokémon es una evolución de Eevee de tipo Psíquico?',
    'Umbreon',
    'Espeon',
    'Jolteon',
    'Glaceon',
    'B',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
),

(
    '¿Cuál de estos Pokémon es una evolución de Eevee de tipo Siniestro?',
    'Espeon',
    'Sylveon',
    'Umbreon',
    'Leafeon',
    'C',
    (SELECT id FROM anime WHERE nombre = 'Pokémon'),
    (SELECT id FROM categoria WHERE nombre = 'Normal'),
    'texto',
    NULL,
    'dificil'
);

-- =======================
-- POKÉMON - SILUETAS
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

-- =========================
-- FÁCILES
-- =========================

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Evee',
    'Raichu',
    'Pikachu',
    'Meowth',
    'C',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/pikachu.png',
    'facil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Charmeleon',
    'Charmander',
    'Bulbasaur',
    'Pikachu',
    'B',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/charmander.png',
    'facil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Squirtle',
    'Totodile',
    'Psyduck',
    'Mudkip',
    'A',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/squirtle.png',
    'facil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Turtwig',
    'Chikorita',
    'Oddish',
    'Bulbasaur',
    'D',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/bulbasaur.png',
    'facil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Charizard',
    'Dragonite',
    'Aerodactyl',
    'Salamence',
    'B',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/dragonite.png',
    'facil'
),

-- =========================
-- MEDIAS
-- =========================

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Sableye',
    'Haunter',
    'Gastly',
    'Gengar',
    'D',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/gengar.png',
    'media'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Zoroark',
    'Hawlucha',
    'Lucario',
    'Greninja',
    'C',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/lucario.png',
    'media'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Slaking',
    'Snorlax',
    'Ursaring',
    'Hariyama',
    'B',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/snorlax.png',
    'media'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Gyarados',
    'Milotic',
    'Dragonair',
    'Lapras',
    'A',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/gyarados.png',
    'media'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Lucario',
    'Froakie',
    'Inteleon',
    'Greninja',
    'D',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/greninja.png',
    'media'
),

-- =========================
-- DIFÍCILES
-- =========================

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Mewtwo',
    'Mew',
    'Deoxys',
    'Genesect',
    'A',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/mewtwo.png',
    'dificil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Gyarados',
    'Rayquaza',
    'Dragonair',
    'Serperior',
    'B',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/rayquaza.png',
    'dificil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Haxorus',
    'Salamence',
    'Garchomp',
    'Tyranitar',
    'C',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/garchomp.png',
    'dificil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Marshadow',
    'Zoroark',
    'Gengar',
    'Darkrai',
    'D',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/darkrai.png',
    'dificil'
),

(
    '¿Qué Pokémon aparece en esta silueta?',
    'Giratina',
    'Dialga',
    'Palkia',
    'Arceus',
    'A',
    8,
    2,
    'imagen',
    'public/img-siluetas/pokemon/giratina.png',
    'dificil'
);

-- =======================
-- OnePiece - SILUETAS
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

-- =========================
-- FÁCILES
-- =========================

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Sanji',
    'Luffy',
    'Zoro',
    'Usopp',
    'B',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/luffy.png',
    'facil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Nami',
    'Robin',
    'Zoro',
    'Chopper',
    'C',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/zoro.png',
    'facil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Sanji',
    'Franky',
    'Usopp',
    'Brook',
    'A',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/sanji.png',
    'facil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Robin',
    'Nami',
    'Vivi',
    'Perona',
    'B',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/nami.png',
    'facil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Usopp',
    'Chopper',
    'Brook',
    'Franky',
    'B',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/chopper.png',
    'facil'
),

-- =========================
-- MEDIAS
-- =========================

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Brook',
    'Franky',
    'Jinbe',
    'Usopp',
    'D',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/usopp.png',
    'media'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Robin',
    'Nami',
    'Boa Hancock',
    'Vivi',
    'A',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/robin.png',
    'media'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Brook',
    'Jinbe',
    'Franky',
    'Chopper',
    'C',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/franky.png',
    'media'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Jinbe',
    'Brook',
    'Franky',
    'Sanji',
    'B',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/brook.png',
    'media'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Jinbe',
    'Arlong',
    'Hody Jones',
    'Kaido',
    'A',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/jinbe.png',
    'media'
),

-- =========================
-- DIFÍCILES
-- =========================

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Trafalgar Law',
    'Eustass Kid',
    'Shanks',
    'Sabo',
    'A',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/law.png',
    'dificil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Shanks',
    'Mihawk',
    'Sabo',
    'Ace',
    'D',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/ace.png',
    'dificil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Ace',
    'Sabo',
    'Marco',
    'Shanks',
    'B',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/sabo.png',
    'dificil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Mihawk',
    'Shanks',
    'Rayleigh',
    'Dragon',
    'A',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/mihawk.png',
    'dificil'
),

(
    '¿Qué personaje de One Piece aparece en esta silueta?',
    'Blackbeard',
    'Shanks',
    'Kaido',
    'Whitebeard',
    'C',
    1,
    2,
    'imagen',
    'public/img-siluetas/onepiece/kaido.png',
    'dificil'
);

-- =======================
-- DragonBall - SILUETAS
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

-- =========================
-- FÁCILES
-- =========================

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Vegeta',
    'Goku',
    'Gohan',
    'Trunks',
    'B',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/goku.png',
    'facil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Gohan',
    'Piccolo',
    'Vegeta',
    'Goku',
    'C',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/vegeta.png',
    'facil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Piccolo',
    'Krilin',
    'Tenshinhan',
    'Yamcha',
    'A',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/piccolo.png',
    'facil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Goku',
    'Trunks',
    'Gohan',
    'Goten',
    'C',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/gohan.png',
    'facil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Goten',
    'Trunks',
    'Gohan',
    'Vegeta',
    'B',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/trunks.png',
    'facil'
),

-- =========================
-- MEDIAS
-- =========================

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Cell',
    'Freezer',
    'Majin Buu',
    'Broly',
    'B',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/freezer.png',
    'media'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Majin Buu',
    'Cell',
    'Freezer',
    'Dabura',
    'B',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/cell.png',
    'media'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Broly',
    'Nappa',
    'Raditz',
    'Bardock',
    'C',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/raditz.png',
    'media'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Krilin',
    'Yamcha',
    'Tenshinhan',
    'Roshi',
    'A',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/krilin.png',
    'media'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Bills',
    'Whis',
    'Kaio-sama',
    'Shin',
    'A',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/bills.png',
    'media'
),

-- =========================
-- DIFÍCILES
-- =========================

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Bardock',
    'Raditz',
    'Nappa',
    'Turles',
    'A',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/bardock.png',
    'dificil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Vegito',
    'Gogeta',
    'Gotenks',
    'Broly',
    'B',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/gogeta.png',
    'dificil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Gogeta',
    'Gotenks',
    'Vegito',
    'Vegeta',
    'C',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/vegito.png',
    'dificil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Hit',
    'Jiren',
    'Toppo',
    'Dyspo',
    'B',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/jiren.png',
    'dificil'
),

(
    '¿Qué personaje de Dragon Ball aparece en esta silueta?',
    'Broly',
    'Kale',
    'Caulifla',
    'Cabba',
    'A',
    3,
    2,
    'imagen',
    'public/img-siluetas/dragonball/broly.png',
    'dificil'
);

-- =========================
-- Naruto - Siluetas
-- =========================



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

-- =========================
-- FÁCILES
-- =========================

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Sasuke',
    'Naruto',
    'Kakashi',
    'Gaara',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/naruto.png',
    'facil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Kakashi',
    'Sasuke',
    'Naruto',
    'Neji',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/sasuke.png',
    'facil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Sakura',
    'Hinata',
    'Ino',
    'Tenten',
    'A',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/sakura.png',
    'facil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Iruka',
    'Kakashi',
    'Jiraiya',
    'Minato',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/kakashi.png',
    'facil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Kankuro',
    'Gaara',
    'Shikamaru',
    'Choji',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/gaara.png',
    'facil'
),

-- =========================
-- MEDIAS
-- =========================

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Neji',
    'Rock Lee',
    'Might Guy',
    'Shino',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/rocklee.png',
    'media'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Hinata',
    'Temari',
    'Ino',
    'Tenten',
    'A',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/hinata.png',
    'media'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Choji',
    'Shikamaru',
    'Kiba',
    'Sai',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/shikamaru.png',
    'media'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Orochimaru',
    'Jiraiya',
    'Kabuto',
    'Hiruzen',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/jiraiya.png',
    'media'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Itachi',
    'Obito',
    'Madara',
    'Shisui',
    'A',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/itachi.png',
    'media'
),

-- =========================
-- DIFÍCILES
-- =========================

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Minato',
    'Tobirama',
    'Hashirama',
    'Hiruzen',
    'A',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/minato.png',
    'dificil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Pain',
    'Obito',
    'Madara',
    'Nagato',
    'C',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/madara.png',
    'dificil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Kisame',
    'Zabuza',
    'Suigetsu',
    'Haku',
    'A',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/kisame.png',
    'dificil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Sasori',
    'Deidara',
    'Kakuzu',
    'Hidan',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/deidara.png',
    'dificil'
),

(
    '¿Qué personaje de Naruto aparece en esta silueta?',
    'Pain',
    'Obito',
    'Madara',
    'Kabuto',
    'B',
    2,
    2,
    'imagen',
    'public/img-siluetas/naruto/obito.png',
    'dificil'
);

-- =========================
-- Risas - one piece
-- =========================



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

-- =========================
-- FÁCILES
-- =========================

(
    '¿A qué personaje de One Piece pertenece esta risa?',
    'Luffy',
    'Brook',
    'Usopp',
    'Franky',
    'B',
    1,
    3,
    'audio',
    'public/audio/onepiece/brook.mp3',
    'facil'
),



(
    '¿A qué personaje de One Piece pertenece esta risa?',
    'Crocodile',
    'Buggy',
    'Doflamingo',
    'Moria',
    'C',
    1,
    3,
    'audio',
    'public/audio/onepiece/doflamingo.mp3',
    'dificil'
),


(
    '¿A qué personaje de One Piece pertenece esta risa?',
    'Big Mom',
    'Nami',
    'Robin',
    'Boa Hancock',
    'A',
    1,
    3,
    'audio',
    'public/audio/onepiece/bigmom.mp3',
    'facil'
),

-- =========================
-- MEDIAS
-- =========================

(
    '¿A qué personaje de One Piece pertenece esta risa?',
    'Crocodile',
    'Gecko Moria',
    'Doflamingo',
    'Caesar Clown',
    'B',
    1,
    3,
    'audio',
    'public/audio/onepiece/geckomoria.mp3',
    'media'
),

(
    '¿A qué personaje de One Piece pertenece esta risa?',
    'Caesar Clown',
    'Crocodile',
    'Enel',
    'Magellan',
    'A',
    1,
    3,
    'audio',
    'public/audio/onepiece/caesarclown.mp3',
    'media'
),

(
    '¿A qué personaje de One Piece pertenece este audio?',
    'Franky',
    'Tom',
    'Sengoku',
    'Chopper',
    'A',
    1,
    3,
    'audio',
    'public/audio/onepiece/franky.mp3',
    'facil'
),

-- =========================
-- DIFÍCILES
-- =========================

(
    '¿A qué personaje de One Piece pertenece este audio?',
    'Mihawk',
    'Sengoku',
    'Barba blanca',
    'Barba negra',
    'D',
    1,
    3,
    'audio',
    'public/audio/onepiece/barbanegra.mp3',
    'facil'
),

(
    '¿A qué personaje de One Piece pertenece este audio?',
    'Ace',
    'Luffy',
    'Sabo',
    'Crocodile',
    'B',
    1,
    3,
    'audio',
    'public/audio/onepiece/luffy.mp3',
    'facil'
);




-- =========================
-- VOCES . DRAGON BALL
-- =========================

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

-- =========================
-- FÁCILES
-- =========================

(
    '¿A qué personaje de Dragon Ball pertenece esta voz?',
    'Vegeta',
    'Goku',
    'Piccolo',
    'Gohan',
    'B',
    3,
    3,
    'audio',
    'public/audio/dragonball/goku.mp3',
    'facil'
),

(
    '¿A qué personaje de Dragon Ball pertenece esta voz?',
    'Krilin',
    'Piccolo',
    'Vegeta',
    'Yamcha',
    'C',
    3,
    3,
    'audio',
    'public/audio/dragonball/vegeta.mp3',
    'facil'
),


(
    '¿A qué personaje de Dragon Ball pertenece esta voz?',
    'Maestro Roshi',
    'Yamcha',
    'Krilin',
    'Tenshinhan',
    'C',
    3,
    3,
    'audio',
    'public/audio/dragonball/krilin.mp3',
    'facil'
),

(
    '¿A qué personaje de Dragon Ball pertenece esta voz?',
    'Cell',
    'Freezer',
    'Majin Buu',
    'Capitán Ginyu',
    'B',
    3,
    3,
    'audio',
    'public/audio/dragonball/freezer.mp3',
    'media'
),

(
    '¿A qué personaje de Dragon Ball pertenece esta voz?',
    'Freezer',
    'Majin Buu',
    'Cell',
    'Broly',
    'C',
    3,
    3,
    'audio',
    'public/audio/dragonball/cell.mp3',
    'dificil'
);


-- =========================
-- Audios POKEMON
-- =========================

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
        '¿Qué Pokémon produce este sonido?',
        'Meowth',
        'Pikachu',
        'Eevee',
        'Psyduck',
        'B',
        8,
        3,
        'audio',
        'public/audio/pokemon/pikachu.mp3',
        'facil'
    ),
    (
        '¿Qué  produce este sonido?',
        'Conseguir un shiny',
        'Subir de nivel los pokemones',
        'Curar tus pokemones',
        'Abrir la PC',
        'C',
        8,
        3,
        'audio',
        'public/audio/pokemon/curar.mp3',
        'facil'
    ),
    (
        '¿Qué  produce este sonido?',
        'Atrapar un pokemon',
        'Capturar un pokemon',
        'Derrotar a un pokemon',
        'Posee poca vida',
        'D',
        8,
        3,
        'audio',
        'public/audio/pokemon/pocavida.mp3',
        'media'
    ),

    (
        '¿Qué  produce este sonido?',
        'Atrapar un pokemon',
        'Capturar un pokemon',
        'Derrotar a un pokemon',
        'Posee poca vida',
        'D',
        8,
        3,
        'audio',
        'public/audio/pokemon/pocavida.mp3',
        'media'
    ),
    (
        '¿Qué  produce este sonido?',
        'Gana a un entrenador',
        'Recibe un item',
        'Gana a un lider del gimnasio',
        'Sube de nivel',
        'B',
        8,
        3,
        'audio',
        'public/audio/pokemon/recibeitem.mp3',
        'dificil'
    ),

    (
        '¿Qué  produce este sonido?',
        'Usar la pc',
        'usar surf',
        'usar fuerza',
        'usar la pokedex',
        'A',
        8,
        3,
        'audio',
        'public/audio/pokemon/pc.mp3',
        'dificil'
    );


-- =========================
-- Audios Naruto
-- =========================


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
    '¿A qué personaje de Naruto pertenece esta voz?',
    'Sasuke',
    'Naruto',
    'Kakashi',
    'Gaara',
    'B',
    2,
    3,
    'audio',
    'public/audio/naruto/naruto.mp3',
    'facil'
    ),



    (
    '¿A qué personaje de Naruto pertenece esta voz?',
    'Sasuke',
    'Neji',
    'Itachi',
    'Shisui',
    'C',
    2,
    3,
    'audio',
    'public/audio/naruto/itachi.mp3',
    'media'
    ),

    (
    '¿¿Qué  produce este sonido?',
    'Jutsu Sexy',
    'Byakugan',
    'Clones',
    'Genjutsu',
    'C',
    2,
    3,
    'audio',
    'public/audio/naruto/clon.mp3',
    'dificil'
    ),


    (
    '¿¿Qué  produce este sonido?',
    'Jutsu',
    'Invocacion',
    'Sharingan',
    'Genjutsu',
    'A',
    2,
    3,
    'audio',
    'public/audio/naruto/jutsu.mp3',
    'media'
    );

-- RECOMPENSAS


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
        '¿A qué personaje de One Piece pertenece esta recompensa?',
        'Zoro',
        'Luffy',
        'Sanji',
        'Jinbe',
        'B',
        1,
        5,
        'imagen',
        'public/img-recompensas/luffy.png',
        'facil'
    ),

    (
        '¿A qué personaje de One Piece pertenece esta recompensa?',
        'Sanji',
        'Robin',
        'Zoro',
        'Jinbe',
        'C',
        1,
        5,
        'imagen',
        'public/img-recompensas/zoro.png',
        'facil'
    ),

    (
        '¿A qué personaje de One Piece pertenece esta recompensa?',
        'Jinbe',
        'Sanji',
        'Zoro',
        'Franky',
        'A',
        1,
        5,
        'imagen',
        'public/img-recompensas/jinbe.png',
        'media'
    ),

    (
        '¿A qué personaje de One Piece pertenece esta recompensa?',
        'Brook',
        'Sanji',
        'Usopp',
        'Franky',
        'B',
        1,
        5,
        'imagen',
        'public/img-recompensas/sanji.png',
        'media'
    ),

    (
        '¿A qué personaje de One Piece pertenece esta recompensa?',
        'Nami',
        'Robin',
        'Boa Hancock',
        'Vivi',
        'B',
        1,
        5,
        'imagen',
        'public/img-recompensas/robin.png',
        'dificil'
    );


USE preguntados2;

-- =========================
-- Imagenes One piece
-- =========================

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
        '¿A qué personaje pertenece este objeto?',
        'Sanji',
        'Monkey D. Luffy',
        'Usopp',
        'Ace',
        'B',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/sombrero_luffy.png',
        'facil'
    ),

    (
        '¿Cómo se llama esta espada?',
        'Wado Ichimonji',
        'Shusui',
        'Enma',
        'Sandai Kitetsu',
        'C',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/enma.png',
        'media'
    ),

    (
        '¿A qué personaje pertenece este objeto?',
        'Robin',
        'Nami',
        'Vivi',
        'Perona',
        'B',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/clima_tact.png',
        'facil'
    ),

    (
        '¿Qué personaje utiliza esta arma?',
        'Franky',
        'Usopp',
        'Brook',
        'Chopper',
        'B',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/kabuto.png',
        'media'
    ),

    (
        '¿A qué personaje pertenece esta espada?',
        'Roronoa Zoro',
        'Shanks',
        'Dracule Mihawk',
        'Silvers Rayleigh',
        'C',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/yoru.png',
        'facil'
    ),

    (
        '¿Cómo se llama este objeto utilizado para navegar por Grand Line?',
        'Eternal Compass',
        'Log Pose',
        'Vivre Card',
        'Den Den Mushi',
        'B',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/log_pose.png',
        'media'
    ),

    (
        '¿Cómo se llama este papel que permite localizar a una persona?',
        'Wanted Poster',
        'Vivre Card',
        'Road Poneglyph',
        'Log Pose',
        'B',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/vivre_card.png',
        'media'
    ),

    (
        '¿Cómo se llama este dispositivo utilizado para comunicarse?',
        'Log Pose',
        'Transponder',
        'Den Den Mushi',
        'Vivre Card',
        'C',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/den_den_mushi.png',
        'facil'
    ),

    (
        '¿Qué Fruta del Diablo representa esta imagen?',
        'Mera Mera no Mi',
        'Ope Ope no Mi',
        'Gomu Gomu no Mi',
        'Yami Yami no Mi',
        'C',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/gomu_gomu.png',
        'media'
    ),

    (
        '¿Qué material se utiliza en estas esposas para debilitar a usuarios de Frutas del Diablo?',
        'Acero',
        'Piedra marina',
        'Adamantium',
        'Piedra de poneglyph',
        'B',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/kairoseki.png',
        'dificil'
    ),

    (
        '¿Qué Fruta del Diablo aparece en la imagen?',
        'Gomu Gomu no Mi',
        'Mera Mera no Mi',
        'Yami Yami no Mi',
        'Ope Ope no Mi',
        'B',
        1,
        4,
        'imagen',
        'public/img-objetos/onepiece/mera_mera.png',
        'facil'
    );

-- =========================
-- Imagenes Pokemon
-- =========================

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
        '¿Qué objeto de Pokémon aparece en la imagen?',
        'Poké Ball',
        'Master Ball',
        'Super Ball',
        'Ultra Ball',
        'A',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/pokeball.png',
        'facil'
    ),

    (
        '¿Qué tipo de Poké Ball aparece en la imagen?',
        'Ultra Ball',
        'Master Ball',
        'Super Ball',
        'Premier Ball',
        'B',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/masterball.png',
        'facil'
    ),

    (
        '¿Cómo se llama este dispositivo utilizado por los entrenadores?',
        'Pokégear',
        'Pokédex',
        'PokéNav',
        'Rotom Phone',
        'B',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/pokedex.png',
        'facil'
    ),

    (
        '¿Qué objeto permite recuperar puntos de salud de un Pokémon?',
        'Antídoto',
        'Revivir',
        'Poción',
        'Éter',
        'C',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/pocion.png',
        'facil'
    ),

    (
        '¿Qué objeto aparece en la imagen?',
        'Caramelo Raro',
        'Revivir',
        'Máximo Elixir',
        'Pepita',
        'A',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/caramelo_raro.png',
        'media'
    ),

    (
        '¿Qué piedra evolutiva aparece en la imagen?',
        'Piedra Agua',
        'Piedra Trueno',
        'Piedra Fuego',
        'Piedra Hoja',
        'B',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/piedra_trueno.png',
        'media'
    ),

    (
        '¿Qué piedra evolutiva aparece en la imagen?',
        'Piedra Fuego',
        'Piedra Lunar',
        'Piedra Agua',
        'Piedra Alba',
        'C',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/piedra_agua.png',
        'media'
    ),

    (
        '¿Qué objeto se utiliza para revivir a un Pokémon debilitado?',
        'Revivir',
        'Poción',
        'Antídoto',
        'Restaurar Todo',
        'A',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/revivir.png',
        'media'
    ),

    (
        '¿Qué objeto permite compartir experiencia con otros Pokémon?',
        'Huevo Suerte',
        'Repartir Experiencia',
        'Amuleto',
        'Campana Alivio',
        'B',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/repartir_experiencia.png',
        'dificil'
    ),

    (
        '¿Qué tipo de Poké Ball aparece en la imagen?',
        'Super Ball',
        'Poké Ball',
        'Ultra Ball',
        'Master Ball',
        'C',
        8,
        4,
        'imagen',
        'public/img-objetos/pokemon/ultraball.png',
        'media'
    );

-- =========================
-- Imagenes Dragon Ball
-- =========================

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
        '¿Qué objeto de Dragon Ball aparece en la imagen?',
        'Radar del Dragón',
        'Scouter',
        'Control de cápsulas',
        'Detector de ki',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/radar_dragon.png',
        'facil'
    ),

    (
        '¿Cómo se llama este objeto utilizado para almacenar vehículos y otros elementos?',
        'Cápsula Hoi-Poi',
        'Semilla del Ermitaño',
        'Radar del Dragón',
        'Potara',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/capsula_hoi_poi.png',
        'facil'
    ),

    (
        '¿Cómo se llama este bastón utilizado por Goku cuando era niño?',
        'Bastón Mágico',
        'Báculo Sagrado',
        'Bastón del Kaioshin',
        'Espada Z',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/baston_magico.png',
        'facil'
    ),

    (
        '¿Qué objeto puede recuperar rápidamente la energía y curar heridas?',
        'Semilla del Ermitaño',
        'Fruta del Árbol Sagrado',
        'Agua Ultra Divina',
        'Medicina del corazón',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/semilla_ermitanio.png',
        'facil'
    ),

    (
        '¿Cómo se llama este objeto que Goku utiliza para volar durante gran parte de su infancia?',
        'Nube Kinton',
        'Nube Kaioshin',
        'Nube Sagrada',
        'Nube Shenlong',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/nube_kinton.png',
        'media'
    ),

    (
        '¿A qué personaje pertenece esta espada?',
        'Trunks',
        'Gohan',
        'Goku',
        'Vegeta',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/espada_trunks.png',
        'facil'
    ),

    (
        '¿Cómo se llaman estos pendientes utilizados para realizar una fusión?',
        'Potara',
        'Aretes Z',
        'Pendientes del Tiempo',
        'Pendientes de Bills',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/potara.png',
        'media'
    ),

    (
        '¿Cómo se llama este objeto utilizado por los Kaioshin para viajar a través del tiempo?',
        'Anillo del Tiempo',
        'Anillo Potara',
        'Anillo de Zeno',
        'Anillo del Dragón',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/anillo_tiempo.png',
        'dificil'
    ),

    (
        '¿Qué vehículo aparece en la imagen?',
        'Máquina del Tiempo de Trunks',
        'Nave Saiyajin',
        'Nave de Freezer',
        'Cápsula espacial de Bulma',
        'A',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/maquina_tiempo.png',
        'media'
    ),

    (
        '¿Qué Bola de Dragón aparece en la imagen?',
        'Bola de 1 estrella',
        'Bola de 4 estrellas',
        'Bola de 5 estrellas',
        'Bola de 7 estrellas',
        'B',
        3,
        4,
        'imagen',
        'public/img-objetos/dragonball/dragonball_4_estrellas.png',
        'facil'
    );


-- =========================
-- Imagenes Naruto
-- =========================


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
        '¿Qué arma ninja aparece en la imagen?',
        'Shuriken',
        'Kunai',
        'Senbon',
        'Kusarigama',
        'B',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/kunai.png',
        'facil'
    ),

    (
        '¿Qué arma ninja aparece en la imagen?',
        'Kunai',
        'Shuriken',
        'Tantō',
        'Senbon',
        'B',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/shuriken.png',
        'facil'
    ),

    (
        '¿Qué objeto utilizan los ninjas para representar su aldea?',
        'Banda ninja',
        'Cinturón de chakra',
        'Máscara ANBU',
        'Protector de brazo',
        'A',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/banda_ninja.png',
        'facil'
    ),

    (
        '¿Qué objeto ninja aparece en la imagen?',
        'Pergamino de invocación',
        'Sello explosivo',
        'Papel de chakra',
        'Sello maldito',
        'B',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/sello_explosivo.png',
        'media'
    ),

    (
        '¿Qué objeto se utiliza frecuentemente para almacenar técnicas, armas o realizar invocaciones?',
        'Pergamino',
        'Banda ninja',
        'Sello explosivo',
        'Campana',
        'A',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/pergamino.png',
        'media'
    ),

    (
        '¿Cómo se llama esta espada perteneciente a los Siete Espadachines de la Niebla?',
        'Kubikiribōchō',
        'Samehada',
        'Kusanagi',
        'Hiramekarei',
        'B',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/samehada.png',
        'media'
    ),

    (
        '¿Cómo se llama esta arma utilizada por Madara Uchiha?',
        'Gunbai',
        'Samehada',
        'Kubikiribōchō',
        'Bashōsen',
        'A',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/gunbai.png',
        'dificil'
    ),

    (
        '¿Cómo se llama esta espada asociada principalmente a Orochimaru y Sasuke?',
        'Samehada',
        'Espada Kusanagi',
        'Kubikiribōchō',
        'Nuibari',
        'B',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/kusanagi.png',
        'media'
    ),

    (
        '¿Qué objeto permite descubrir la naturaleza elemental del chakra de un ninja?',
        'Sello explosivo',
        'Papel de chakra',
        'Pergamino',
        'Etiqueta de sellado',
        'B',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/papel_chakra.png',
        'dificil'
    ),

    (
        '¿A qué organización pertenece este tipo de anillo?',
        'ANBU',
        'Akatsuki',
        'Siete Espadachines',
        'Raíz',
        'B',
        2,
        4,
        'imagen',
        'public/img-objetos/naruto/anillo_akatsuki.png',
        'media'
    );
INSERT INTO partida (id_usuario, puntaje, resultado)
VALUES
    ((SELECT id FROM usuario WHERE username = 'facu2'), 180, 'Ganada'),
    ((SELECT id FROM usuario WHERE username = 'facu3'), 150, 'Ganada'),
    ((SELECT id FROM usuario WHERE username = 'facu4'), 90,  'Ganada'),
    ((SELECT id FROM usuario WHERE username = 'facu5'), 60,  'Ganada'),
    ((SELECT id FROM usuario WHERE username = 'facu6'), 30,  'Ganada');

-- =========================================================
-- DATOS PRE-CARGADOS PARA EL RANKING (MESES Y AÑOS: 2024, 2025, 2026)
-- =========================================================

INSERT INTO partida (id_usuario, puntaje, resultado, created_at)
VALUES
    -- =====================================================
    -- AÑO 2024
    -- =====================================================
    -- Enero 2024
    ((SELECT id FROM usuario WHERE username = 'facu'),   25, 'Ganada',  '2024-01-12 14:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  20, 'Ganada',  '2024-01-15 16:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  15, 'Perdida', '2024-01-20 18:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  10, 'Perdida', '2024-01-25 20:00:00'),

    -- Febrero 2024
    ((SELECT id FROM usuario WHERE username = 'facu2'),  30, 'Ganada',  '2024-02-05 10:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  25, 'Ganada',  '2024-02-14 17:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   15, 'Perdida', '2024-02-18 19:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  10, 'Perdida', '2024-02-22 12:00:00'),

    -- Marzo 2024
    ((SELECT id FROM usuario WHERE username = 'facu3'),  35, 'Ganada',  '2024-03-08 11:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   25, 'Ganada',  '2024-03-12 15:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  20, 'Ganada',  '2024-03-19 18:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  10, 'Perdida', '2024-03-24 21:10:00'),

    -- Abril 2024
    ((SELECT id FROM usuario WHERE username = 'facu4'),  30, 'Ganada',  '2024-04-04 09:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  25, 'Ganada',  '2024-04-11 16:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  15, 'Perdida', '2024-04-18 14:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   10, 'Perdida', '2024-04-26 22:30:00'),

    -- Mayo 2024
    ((SELECT id FROM usuario WHERE username = 'facu5'),  25, 'Ganada',  '2024-05-06 13:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   20, 'Ganada',  '2024-05-13 17:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  15, 'Ganada',  '2024-05-21 19:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  10, 'Perdida', '2024-05-28 11:50:00'),

    -- Junio 2024
    ((SELECT id FROM usuario WHERE username = 'facu6'),  30, 'Ganada',  '2024-06-03 15:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  20, 'Ganada',  '2024-06-12 18:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   15, 'Perdida', '2024-06-20 20:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  10, 'Perdida', '2024-06-27 10:00:00'),

    -- Julio 2024
    ((SELECT id FROM usuario WHERE username = 'facu'),   30, 'Ganada',  '2024-07-09 14:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  25, 'Ganada',  '2024-07-16 16:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  20, 'Ganada',  '2024-07-22 18:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  10, 'Perdida', '2024-07-29 21:00:00'),

    -- Agosto 2024
    ((SELECT id FROM usuario WHERE username = 'facu2'),  35, 'Ganada',  '2024-08-05 11:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  20, 'Ganada',  '2024-08-14 15:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   15, 'Perdida', '2024-08-20 19:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  10, 'Perdida', '2024-08-27 13:40:00'),

    -- Septiembre 2024
    ((SELECT id FROM usuario WHERE username = 'facu3'),  30, 'Ganada',  '2024-09-07 10:50:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  25, 'Ganada',  '2024-09-15 16:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  15, 'Perdida', '2024-09-21 17:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  10, 'Perdida', '2024-09-28 20:00:00'),

    -- Octubre 2024
    ((SELECT id FROM usuario WHERE username = 'facu'),   35, 'Ganada',  '2024-10-04 12:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  25, 'Ganada',  '2024-10-13 14:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  15, 'Perdida', '2024-10-22 18:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  10, 'Perdida', '2024-10-29 21:10:00'),

    -- Noviembre 2024
    ((SELECT id FROM usuario WHERE username = 'facu2'),  30, 'Ganada',  '2024-11-06 15:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  20, 'Ganada',  '2024-11-14 17:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   15, 'Perdida', '2024-11-20 19:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  10, 'Perdida', '2024-11-26 11:30:00'),

    -- Diciembre 2024
    ((SELECT id FROM usuario WHERE username = 'facu3'),  40, 'Ganada',  '2024-12-08 16:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   25, 'Ganada',  '2024-12-16 18:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  20, 'Ganada',  '2024-12-23 20:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  10, 'Perdida', '2024-12-30 14:00:00'),

    -- =====================================================
    -- AÑO 2025
    -- =====================================================
    -- Enero 2025
    ((SELECT id FROM usuario WHERE username = 'facu'),   35, 'Ganada',  '2025-01-09 13:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  25, 'Ganada',  '2025-01-14 17:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  20, 'Ganada',  '2025-01-21 19:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  10, 'Perdida', '2025-01-27 21:40:00'),

    -- Febrero 2025
    ((SELECT id FROM usuario WHERE username = 'facu2'),  40, 'Ganada',  '2025-02-06 10:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  30, 'Ganada',  '2025-02-12 14:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  15, 'Perdida', '2025-02-19 16:50:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   10, 'Perdida', '2025-02-25 18:20:00'),

    -- Marzo 2025
    ((SELECT id FROM usuario WHERE username = 'facu3'),  35, 'Ganada',  '2025-03-05 11:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   30, 'Ganada',  '2025-03-15 15:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  20, 'Ganada',  '2025-03-22 18:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  15, 'Perdida', '2025-03-28 20:30:00'),

    -- Abril 2025
    ((SELECT id FROM usuario WHERE username = 'facu5'),  30, 'Ganada',  '2025-04-03 09:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  25, 'Ganada',  '2025-04-11 14:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   20, 'Ganada',  '2025-04-18 16:50:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  10, 'Perdida', '2025-04-25 19:20:00'),

    -- Mayo 2025
    ((SELECT id FROM usuario WHERE username = 'facu4'),  35, 'Ganada',  '2025-05-07 12:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  25, 'Ganada',  '2025-05-14 16:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  20, 'Ganada',  '2025-05-20 18:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   10, 'Perdida', '2025-05-27 21:00:00'),

    -- Junio 2025
    ((SELECT id FROM usuario WHERE username = 'facu'),   40, 'Ganada',  '2025-06-04 14:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  25, 'Ganada',  '2025-06-12 17:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  20, 'Ganada',  '2025-06-19 19:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  15, 'Perdida', '2025-06-26 11:00:00'),

    -- Julio 2025
    ((SELECT id FROM usuario WHERE username = 'facu2'),  35, 'Ganada',  '2025-07-08 13:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   30, 'Ganada',  '2025-07-15 15:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  20, 'Ganada',  '2025-07-23 18:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  10, 'Perdida', '2025-07-30 20:20:00'),

    -- Agosto 2025
    ((SELECT id FROM usuario WHERE username = 'facu3'),  40, 'Ganada',  '2025-08-06 10:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  25, 'Ganada',  '2025-08-13 14:50:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  20, 'Ganada',  '2025-08-20 17:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   10, 'Perdida', '2025-08-27 19:40:00'),

    -- Septiembre 2025
    ((SELECT id FROM usuario WHERE username = 'facu6'),  35, 'Ganada',  '2025-09-04 11:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   25, 'Ganada',  '2025-09-12 15:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  20, 'Ganada',  '2025-09-19 18:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  10, 'Perdida', '2025-09-26 21:00:00'),

    -- Octubre 2025
    ((SELECT id FROM usuario WHERE username = 'facu'),   45, 'Ganada',  '2025-10-05 12:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  30, 'Ganada',  '2025-10-14 16:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  20, 'Ganada',  '2025-10-21 19:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  15, 'Perdida', '2025-10-28 21:15:00'),

    -- Noviembre 2025
    ((SELECT id FROM usuario WHERE username = 'facu2'),  35, 'Ganada',  '2025-11-03 14:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  25, 'Ganada',  '2025-11-11 16:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  20, 'Ganada',  '2025-11-18 18:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   15, 'Perdida', '2025-11-25 20:50:00'),

    -- Diciembre 2025
    ((SELECT id FROM usuario WHERE username = 'facu3'),  40, 'Ganada',  '2025-12-07 10:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   35, 'Ganada',  '2025-12-15 15:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  20, 'Ganada',  '2025-12-22 17:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  15, 'Perdida', '2025-12-29 19:40:00'),

    -- =====================================================
    -- AÑO 2026
    -- =====================================================
    -- Enero 2026
    ((SELECT id FROM usuario WHERE username = 'facu'),   35, 'Ganada',  '2026-01-08 14:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  30, 'Ganada',  '2026-01-15 16:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  20, 'Ganada',  '2026-01-22 18:50:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  10, 'Perdida', '2026-01-29 20:30:00'),

    -- Febrero 2026
    ((SELECT id FROM usuario WHERE username = 'facu3'),  35, 'Ganada',  '2026-02-05 11:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   30, 'Ganada',  '2026-02-12 15:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  20, 'Ganada',  '2026-02-19 17:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  15, 'Perdida', '2026-02-26 19:45:00'),

    -- Marzo 2026
    ((SELECT id FROM usuario WHERE username = 'facu2'),  40, 'Ganada',  '2026-03-04 10:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  25, 'Ganada',  '2026-03-11 14:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   20, 'Ganada',  '2026-03-18 16:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  10, 'Perdida', '2026-03-25 18:50:00'),

    -- Abril 2026
    ((SELECT id FROM usuario WHERE username = 'facu5'),  35, 'Ganada',  '2026-04-06 12:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  25, 'Ganada',  '2026-04-13 15:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  20, 'Ganada',  '2026-04-20 18:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   15, 'Perdida', '2026-04-27 20:20:00'),

    -- Mayo 2026
    ((SELECT id FROM usuario WHERE username = 'facu'),   40, 'Ganada',  '2026-05-05 13:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  30, 'Ganada',  '2026-05-12 16:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  20, 'Ganada',  '2026-05-19 18:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  10, 'Perdida', '2026-05-26 21:00:00'),

    -- Junio 2026
    ((SELECT id FROM usuario WHERE username = 'facu6'),  35, 'Ganada',  '2026-06-03 10:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  30, 'Ganada',  '2026-06-10 14:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   20, 'Ganada',  '2026-06-17 16:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  10, 'Perdida', '2026-06-24 19:10:00'),

    -- Julio 2026
    ((SELECT id FROM usuario WHERE username = 'facu3'),  40, 'Ganada',  '2026-07-07 11:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   30, 'Ganada',  '2026-07-14 15:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  25, 'Ganada',  '2026-07-21 17:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  15, 'Perdida', '2026-07-28 20:00:00'),

    -- Agosto 2026
    ((SELECT id FROM usuario WHERE username = 'facu2'),  35, 'Ganada',  '2026-08-04 12:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  25, 'Ganada',  '2026-08-11 14:50:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  20, 'Ganada',  '2026-08-18 17:10:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   10, 'Perdida', '2026-08-25 19:30:00'),

    -- Septiembre 2026
    ((SELECT id FROM usuario WHERE username = 'facu4'),  35, 'Ganada',  '2026-09-02 10:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   30, 'Ganada',  '2026-09-10 14:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  20, 'Ganada',  '2026-09-17 16:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  15, 'Perdida', '2026-09-24 19:20:00'),

    -- Octubre 2026
    ((SELECT id FROM usuario WHERE username = 'facu'),   45, 'Ganada',  '2026-10-06 11:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  30, 'Ganada',  '2026-10-13 15:40:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  20, 'Ganada',  '2026-10-20 18:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  15, 'Perdida', '2026-10-27 20:15:00'),

    -- Noviembre 2026 (Mes actual)
    ((SELECT id FROM usuario WHERE username = 'facu2'),  45, 'Ganada',  '2026-11-04 12:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   35, 'Ganada',  '2026-11-10 14:30:00'),
    ((SELECT id FROM usuario WHERE username = 'facu3'),  25, 'Ganada',  '2026-11-16 17:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu5'),  20, 'Ganada',  '2026-11-20 19:15:00'),
    ((SELECT id FROM usuario WHERE username = 'facu4'),  15, 'Perdida', '2026-11-24 11:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  10, 'Perdida', '2026-11-25 16:30:00'),

    -- Diciembre 2026
    ((SELECT id FROM usuario WHERE username = 'facu3'),  40, 'Ganada',  '2026-12-05 13:00:00'),
    ((SELECT id FROM usuario WHERE username = 'facu'),   30, 'Ganada',  '2026-12-12 15:20:00'),
    ((SELECT id FROM usuario WHERE username = 'facu2'),  25, 'Ganada',  '2026-12-19 17:45:00'),
    ((SELECT id FROM usuario WHERE username = 'facu6'),  15, 'Perdida', '2026-12-26 20:00:00');


-- PREGUNTAS DE DEMON SLAYER

USE preguntados2;

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
    dificultad,
    esta_activa,
    estado_revision
) VALUES

-- ==========================================
-- 10 PREGUNTAS FÁCILES
-- ==========================================

('¿Cuál es el apellido de Tanjiro?',
 'Agatsuma', 'Kamado', 'Hashibira', 'Tomioka',
 'B', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Cómo se llama la hermana de Tanjiro?',
 'Kanao', 'Shinobu', 'Mitsuri', 'Nezuko',
 'D', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué personaje utiliza una máscara de jabalí?',
 'Inosuke', 'Zenitsu', 'Genya', 'Tanjiro',
 'A', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Quién es el principal antagonista de Demon Slayer?',
 'Akaza', 'Rui', 'Muzan Kibutsuji', 'Enmu',
 'C', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué respiración utiliza principalmente Zenitsu?',
 'Respiración del Agua', 'Respiración del Trueno',
 'Respiración del Viento', 'Respiración de la Bestia',
 'B', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué objeto lleva Nezuko en la boca?',
 'Un trozo de bambú', 'Una cuerda', 'Una piedra', 'Una venda',
 'A', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Quién es el Pilar de la Llama?',
 'Giyu Tomioka', 'Tengen Uzui', 'Obanai Iguro', 'Kyojuro Rengoku',
 'D', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué respiración desarrolló Inosuke?',
 'Respiración de la Niebla', 'Respiración del Amor',
 'Respiración de la Bestia', 'Respiración del Sonido',
 'C', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿En qué se convierte Nezuko al comienzo de la historia?',
 'En un demonio', 'En un Pilar', 'En una espada', 'En un espíritu',
 'A', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué sentido tiene especialmente desarrollado Tanjiro?',
 'La vista', 'El olfato', 'El oído', 'El gusto',
 'B', 6, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),


-- ==========================================
-- 10 PREGUNTAS MEDIAS
-- ==========================================

('¿Quién entrenó a Tanjiro antes de la Selección Final?',
 'Jigoro Kuwajima', 'Giyu Tomioka',
 'Sakonji Urokodaki', 'Kagaya Ubuyashiki',
 'C', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿De qué color es la primera espada Nichirin de Tanjiro?',
 'Negro', 'Rojo', 'Azul', 'Verde',
 'A', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué posición ocupa Akaza entre las Lunas Superiores?',
 'Primera', 'Segunda', 'Cuarta', 'Tercera',
 'D', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Cómo se llama el hermano menor de Sanemi Shinazugawa?',
 'Muichiro', 'Genya', 'Sabito', 'Senjuro',
 'B', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué demonios comparten la posición de Luna Superior Seis en el Distrito del Entretenimiento?',
 'Akaza y Doma', 'Rui y Enmu',
 'Daki y Gyutaro', 'Gyokko y Hantengu',
 'C', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué respiración utiliza Mitsuri Kanroji?',
 'Respiración del Amor', 'Respiración de la Flor',
 'Respiración del Insecto', 'Respiración de la Serpiente',
 'A', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Cómo se llama el herrero que fabrica la primera espada de Tanjiro?',
 'Kozo Kanamori', 'Kotetsu', 'Tecchin', 'Hotaru Haganezuka',
 'D', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué Pilar acompaña a Tanjiro en el Distrito del Entretenimiento?',
 'Obanai Iguro', 'Tengen Uzui',
 'Gyomei Himejima', 'Sanemi Shinazugawa',
 'B', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Quién es la hermana mayor de Shinobu Kocho?',
 'Kanao Tsuyuri', 'Aoi Kanzaki', 'Kanae Kocho', 'Tamayo',
 'C', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué demonio controla los sueños durante el arco del Tren Infinito?',
 'Enmu', 'Rui', 'Doma', 'Gyokko',
 'A', 6, 1, 'texto', NULL, 'media', 1, 'Aprobada'),


-- ==========================================
-- 10 PREGUNTAS DIFÍCILES
-- Contienen spoilers del manga.
-- ==========================================

('¿Cuál era el nombre humano de Kokushibo?',
 'Yoriichi Tsugikuni', 'Hakuji', 'Keizo', 'Michikatsu Tsugikuni',
 'D', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cuál era el nombre de Akaza antes de convertirse en demonio?',
 'Hakuji', 'Michikatsu', 'Ume', 'Kaigaku',
 'A', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cómo se llamaba la esposa de Yoriichi Tsugikuni?',
 'Koyuki', 'Tamayo', 'Uta', 'Amane',
 'C', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Qué instrumento utiliza Nakime para controlar el Castillo Infinito?',
 'Un shamisen', 'Un biwa', 'Un koto', 'Una flauta',
 'B', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Qué emoción representa el clon Sekido de Hantengu?',
 'Alegría', 'Tristeza', 'Placer', 'Ira',
 'D', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cómo se llama la undécima postura de la Respiración del Agua creada por Giyu?',
 'Calma absoluta', 'Rueda de agua',
 'Dragón del cambio', 'Cascada descendente',
 'A', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Qué flor buscaba Muzan para superar su debilidad ante el sol?',
 'Glicina blanca', 'Loto rojo',
 'Lirio araña azul', 'Crisantemo negro',
 'C', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cómo se llamaba el hermano gemelo de Muichiro Tokito?',
 'Senjuro', 'Yuichiro', 'Takeo', 'Sabito',
 'B', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cómo se llamaba la prometida de Akaza cuando era humano?',
 'Uta', 'Kanae', 'Amane', 'Koyuki',
 'D', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Qué tipo de arma utiliza Gyomei Himejima?',
 'Un hacha y una maza unidos por una cadena',
 'Dos espadas dentadas',
 'Una espada flexible',
 'Una lanza de doble filo',
 'A', 6, 1, 'texto', NULL, 'dificil', 1, 'Aprobada');

-- PREGUNTAS DE JUJUTSU KAISEN

USE preguntados2;

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
    dificultad,
    esta_activa,
    estado_revision
) VALUES

-- ==========================================
-- 10 PREGUNTAS FÁCILES
-- ==========================================

('¿Cómo se llama el protagonista de Jujutsu Kaisen?',
 'Megumi Fushiguro', 'Yuji Itadori',
 'Yuta Okkotsu', 'Toge Inumaki',
 'B', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué objeto consume Yuji al comienzo de la historia?',
 'Una espada maldita', 'Un talismán',
 'Un ojo maldito', 'Un dedo de Sukuna',
 'D', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Quién es conocido como el Rey de las Maldiciones?',
 'Ryomen Sukuna', 'Mahito', 'Jogo', 'Suguru Geto',
 'A', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué profesor suele llevar los ojos cubiertos?',
 'Kento Nanami', 'Masamichi Yaga',
 'Satoru Gojo', 'Atsuya Kusakabe',
 'C', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué herramientas utiliza principalmente Nobara?',
 'Una katana y una lanza', 'Un martillo y clavos',
 'Un arco y flechas', 'Una cadena y un cuchillo',
 'B', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Qué apariencia tiene Panda?',
 'Un oso panda', 'Un tigre', 'Un lobo', 'Un gorila',
 'A', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Cuántos dedos de Sukuna existen originalmente?',
 '5', '10', '15', '20',
 'D', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Quién utiliza la Técnica de las Diez Sombras?',
 'Yuji Itadori', 'Aoi Todo',
 'Megumi Fushiguro', 'Kento Nanami',
 'C', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Cuál es el apellido de Nobara?',
 'Kugisaki', 'Zenin', 'Ieiri', 'Miwa',
 'A', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),

('¿Quién es el protagonista de Jujutsu Kaisen 0?',
 'Satoru Gojo', 'Yuta Okkotsu',
 'Yuji Itadori', 'Suguru Geto',
 'B', 5, 1, 'texto', NULL, 'facil', 1, 'Aprobada'),


-- ==========================================
-- 10 PREGUNTAS MEDIAS
-- ==========================================

('¿Cómo se llama la técnica innata de Aoi Todo?',
 'Black Flash', 'Infinity',
 'Boogie Woogie', 'Divergent Fist',
 'C', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué proporción utiliza la técnica maldita de Nanami?',
 '7:3', '5:5', '8:2', '6:4',
 'A', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Quién es el padre de Megumi Fushiguro?',
 'Suguru Geto', 'Naobito Zenin',
 'Kento Nanami', 'Toji Fushiguro',
 'D', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué técnica utiliza Toge Inumaki?',
 'Manipulación de sangre', 'Discurso maldito',
 'Manipulación de sombras', 'Manipulación de almas',
 'B', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Cómo se llama la hermana gemela de Maki Zenin?',
 'Kasumi', 'Shoko', 'Mai', 'Utahime',
 'C', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Quién creó a Panda?',
 'Masamichi Yaga', 'Satoru Gojo',
 'Yoshinobu Gakuganji', 'Suguru Geto',
 'A', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué personaje utiliza la técnica de Transfiguración Ociosa?',
 'Jogo', 'Hanami', 'Dagon', 'Mahito',
 'D', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Cómo se llama la amiga de la infancia de Yuta Okkotsu?',
 'Riko Amanai', 'Rika Orimoto',
 'Tsumiki Fushiguro', 'Maki Zenin',
 'B', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Qué técnica maldita utiliza Suguru Geto?',
 'Manipulación de sangre', 'Construcción',
 'Manipulación de espíritus malditos', 'Discurso maldito',
 'C', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),

('¿Cuál era el nombre real de Ultimate Mechamaru?',
 'Kokichi Muta', 'Takuma Ino',
 'Junpei Yoshino', 'Kiyotaka Ijichi',
 'A', 5, 1, 'texto', NULL, 'media', 1, 'Aprobada'),


-- ==========================================
-- 10 PREGUNTAS DIFÍCILES
-- Contienen spoilers del manga.
-- ==========================================

('¿Cuánto dura la energía maldita ilimitada de Hakari después de conseguir un premio mayor?',
 '3 minutos y 30 segundos',
 '5 minutos y 11 segundos',
 '4 minutos exactos',
 '4 minutos y 11 segundos',
 'D', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿A quién pertenecía originalmente la técnica antigravedad utilizada por Kenjaku?',
 'Kaori Itadori', 'Yuki Tsukumo',
 'Suguru Geto', 'Shoko Ieiri',
 'A', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Qué profesión tenía Hiromi Higuruma antes de convertirse en hechicero?',
 'Médico', 'Profesor', 'Abogado', 'Policía',
 'C', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cuál es la propiedad especial de la energía maldita de Hajime Kashimo?',
 'El calor', 'La electricidad', 'El magnetismo', 'La gravedad',
 'B', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Quién utiliza la técnica de manipulación del cielo?',
 'Yorozu', 'Uraume', 'Mei Mei', 'Takako Uro',
 'D', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Qué propiedad puede añadir Yuki Tsukumo a su cuerpo mediante su técnica?',
 'Masa virtual', 'Temperatura',
 'Velocidad ilimitada', 'Electricidad',
 'A', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cómo se llama el ataque de energía maldita característico de Ryu Ishigori?',
 'Maximum Meteor', 'Hollow Purple',
 'Granite Blast', 'Piercing Blood',
 'C', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Quién posee una técnica capaz de materializar aquello que considera gracioso?',
 'Kinji Hakari', 'Fumihiko Takaba',
 'Hiromi Higuruma', 'Hajime Kashimo',
 'B', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Cuál es el nombre del shikigami que actúa como juez en el dominio de Higuruma?',
 'Mahoraga', 'Garuda', 'Rika', 'Judgeman',
 'D', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada'),

('¿Qué técnica innata utiliza Yorozu?',
 'Construcción', 'Manipulación de sangre',
 'Manipulación de hielo', 'Técnica de proyección',
 'A', 5, 1, 'texto', NULL, 'dificil', 1, 'Aprobada');
