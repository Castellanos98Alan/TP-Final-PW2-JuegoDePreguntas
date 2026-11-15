<?php

namespace app\model;

class SugerirPreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getAnimesActivos()
    {
        $sql = "SELECT id, nombre FROM anime WHERE esta_activo = 1 ORDER BY nombre ASC";
        return $this->database->queryAll($sql);
    }

    public function obtenerIdCategoria($tipoPregunta = 'texto')
    {
        $nombreCategoria = 'Normal';
        if ($tipoPregunta === 'audio') {
            $nombreCategoria = 'Voz';
        } elseif ($tipoPregunta === 'imagen') {
            $nombreCategoria = 'Imagen';
        }

        $sql = "SELECT id FROM categoria WHERE LOWER(nombre) = LOWER(:nombre) LIMIT 1";
        $categoria = $this->database->queryOne($sql, ['nombre' => $nombreCategoria]);

        if ($categoria && !empty($categoria['id'])) {
            return (int)$categoria['id'];
        }

        $sqlFallback = "SELECT id FROM categoria ORDER BY id ASC LIMIT 1";
        $primera = $this->database->queryOne($sqlFallback);

        return $primera ? (int)$primera['id'] : 1;
    }

    public function crearPreguntaSugerida(
        $pregunta,
        $descripcion,
        $animeId,
        $dificultad = 'media',
        array $opciones = [],
        $correctaIndice = 0,
        $tipoPregunta = 'texto',
        $recurso = null
    ) {
        $respuestas = array_values($opciones);

        if (count($respuestas) !== 4 || !isset($respuestas[$correctaIndice])) {
            return false;
        }

        $letras = ['A', 'B', 'C', 'D'];
        $respuestaCorrecta = $letras[$correctaIndice];
        $categoriaId = $this->obtenerIdCategoria($tipoPregunta);

        $enunciadoFinal = $pregunta;
        if (!empty($descripcion)) {
            $enunciadoFinal .= " - " . $descripcion;
        }

        $sql = "INSERT INTO pregunta (
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
        ) VALUES (
            :enunciado,
            :respuesta_a,
            :respuesta_b,
            :respuesta_c,
            :respuesta_d,
            :respuesta_correcta,
            :anime_id,
            :categoria_id,
            :tipo_pregunta,
            :recurso,
            :dificultad,
            0,
            'Pendiente'
        )";

        return $this->database->execute($sql, [
            'enunciado'          => $enunciadoFinal,
            'respuesta_a'        => $respuestas[0],
            'respuesta_b'        => $respuestas[1],
            'respuesta_c'        => $respuestas[2],
            'respuesta_d'        => $respuestas[3],
            'respuesta_correcta' => $respuestaCorrecta,
            'anime_id'           => $animeId,
            'categoria_id'       => $categoriaId,
            'tipo_pregunta'      => $tipoPregunta,
            'recurso'            => $recurso,
            'dificultad'         => $dificultad
        ]);
    }
}
