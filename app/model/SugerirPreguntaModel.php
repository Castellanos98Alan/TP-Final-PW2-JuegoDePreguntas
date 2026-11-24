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

    public function getCategoriasActivas()
    {
        return $this->database->queryAll("SELECT id, nombre FROM categoria WHERE esta_activa = 1 ORDER BY nombre");
    }

    public function crearPreguntaSugerida(
        $pregunta,
        $descripcion,
        $animeId,
        $dificultad = 'media',
        array $opciones = [],
        $correctaIndice = 0,
        $tipoPregunta = 'texto',
        $recurso = null,
        $categoriaId = 0
    ) {
        $respuestas = array_values($opciones);

        if (count($respuestas) !== 4 || !isset($respuestas[$correctaIndice])) {
            return false;
        }

        $letras = ['A', 'B', 'C', 'D'];
        $respuestaCorrecta = $letras[$correctaIndice];
        $categoria = $this->database->queryOne("SELECT id FROM categoria WHERE id = :id AND esta_activa = 1", ['id' => $categoriaId]);
        if (!$categoria) return false;

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
