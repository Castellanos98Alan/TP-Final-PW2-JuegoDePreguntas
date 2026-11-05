<?php

namespace app\model;

class EditorModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }
    public function getPreguntasPendientes()
    {
        $sql = "SELECT 
                p.id,
                p.enunciado AS descripcion,
                c.nombre AS categoria,
                'Sugerida' AS creador
            FROM pregunta p
            LEFT JOIN categoria c ON p.categoria_id = c.id
            WHERE p.estado_revision = 'Pendiente'
            ORDER BY p.id DESC";

        return $this->database->queryAll($sql);
    }

    public function getPreguntasActivas()
    {
        $sql = "SELECT 
                p.id,
                p.enunciado AS descripcion,
                c.nombre AS categoria
            FROM pregunta p
            LEFT JOIN categoria c ON p.categoria_id = c.id
            WHERE p.esta_activa = 1
            ORDER BY p.id DESC";

        return $this->database->queryAll($sql);
    }

    public function getPreguntaPorId($idPregunta)
    {
        $sql = "SELECT
                p.id,
                p.enunciado AS descripcion,
                p.anime_id,
                p.categoria_id,
                c.nombre AS categoria,
                p.dificultad,
                p.esta_activa,
                p.respuesta_a,
                p.respuesta_b,
                p.respuesta_c,
                p.respuesta_d,
                p.respuesta_correcta
            FROM pregunta p
            LEFT JOIN categoria c ON p.categoria_id = c.id
            WHERE p.id = :id";

        $pregunta = $this->database->queryOne($sql, [
            'id' => $idPregunta
        ]);

        if ($pregunta) {
            $pregunta['opciones'] = [
                [
                    'id' => 'A',
                    'descripcion' => $pregunta['respuesta_a'],
                    'es_correcta' => $pregunta['respuesta_correcta'] === 'A'
                ],
                [
                    'id' => 'B',
                    'descripcion' => $pregunta['respuesta_b'],
                    'es_correcta' => $pregunta['respuesta_correcta'] === 'B'
                ],
                [
                    'id' => 'C',
                    'descripcion' => $pregunta['respuesta_c'],
                    'es_correcta' => $pregunta['respuesta_correcta'] === 'C'
                ],
                [
                    'id' => 'D',
                    'descripcion' => $pregunta['respuesta_d'],
                    'es_correcta' => $pregunta['respuesta_correcta'] === 'D'
                ]
            ];
        }

        return $pregunta ?: null;
    }

    public function actualizarPregunta(
        $idPregunta,
        $descripcion,
        $animeId,
        $categoriaId,
        $dificultad,
        array $opciones,
        $idOpcionCorrecta
    ) {
        if (
            !isset($opciones['A'], $opciones['B'], $opciones['C'], $opciones['D']) ||
            !in_array($idOpcionCorrecta, ['A', 'B', 'C', 'D'], true)
        ) {
            return false;
        }

        $sql = "UPDATE pregunta SET
                enunciado = :enunciado,
                respuesta_a = :respuesta_a,
                respuesta_b = :respuesta_b,
                respuesta_c = :respuesta_c,
                respuesta_d = :respuesta_d,
                respuesta_correcta = :respuesta_correcta,
                anime_id = :anime_id,
                categoria_id = :categoria_id,
                dificultad = :dificultad
            WHERE id = :id";

        return $this->database->execute($sql, [
            'enunciado' => $descripcion,
            'respuesta_a' => $opciones['A'],
            'respuesta_b' => $opciones['B'],
            'respuesta_c' => $opciones['C'],
            'respuesta_d' => $opciones['D'],
            'respuesta_correcta' => $idOpcionCorrecta,
            'anime_id' => $animeId,
            'categoria_id' => $categoriaId,
            'dificultad' => $dificultad,
            'id' => $idPregunta
        ]);
    }

    public function getReportesPendientes()
    {
        $sql = "SELECT 
                r.id AS reporte_id,
                r.motivo,
                r.descripcion AS comentario,
                r.pregunta_id,
                p.enunciado AS pregunta_descripcion,
                c.nombre AS categoria
            FROM reporte_pregunta r
            INNER JOIN pregunta p ON r.pregunta_id = p.id
            LEFT JOIN categoria c ON p.categoria_id = c.id
            WHERE r.estado = 'Pendiente'
            ORDER BY r.id DESC";

        return $this->database->queryAll($sql);
    }

    public function resolverReporte($idReporte, $accion = 'resuelto')
    {
        $estado = ($accion === 'descartado') ? 'Descartado' : 'Revisado';

        $sql = "UPDATE reporte_pregunta
            SET estado = :estado
            WHERE id = :id";

        return $this->database->execute($sql, [
            'estado' => $estado,
            'id' => $idReporte
        ]);
    }

    public function aprobarPregunta($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET esta_activa = 1,
                estado_revision = 'Aprobada'
            WHERE id = :id";

        return $this->database->execute($sql, [
            'id' => $idPregunta
        ]);
    }

    public function rechazarPregunta($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET esta_activa = 0,
                estado_revision = 'Rechazada'
            WHERE id = :id";

        return $this->database->execute($sql, [
            'id' => $idPregunta
        ]);
    }


    public function crearPreguntaConOpciones(
        $descripcion,
        $animeId,
        $categoriaId,
        $dificultad,
        array $opciones,
        $correctaIndice
    ) {
        $respuestas = array_values($opciones);

        if (count($respuestas) !== 4 || !isset($respuestas[$correctaIndice])) {
            return false;
        }

        $letras = ['A', 'B', 'C', 'D'];
        $respuestaCorrecta = $letras[$correctaIndice];

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
            'texto',
            :dificultad,
            0,
            'Pendiente'
        )";

        return $this->database->execute($sql, [
            'enunciado' => $descripcion,
            'respuesta_a' => $respuestas[0],
            'respuesta_b' => $respuestas[1],
            'respuesta_c' => $respuestas[2],
            'respuesta_d' => $respuestas[3],
            'respuesta_correcta' => $respuestaCorrecta,
            'anime_id' => $animeId,
            'categoria_id' => $categoriaId,
            'dificultad' => $dificultad
        ]);
    }

    public function getAnimesActivos()
    {
        $sql = "SELECT id, nombre
            FROM anime
            WHERE esta_activo = 1
            ORDER BY nombre ASC";

        return $this->database->queryAll($sql);
    }

    public function getCategoriasActivas()
    {
        $sql = "SELECT id, nombre
            FROM categoria
            WHERE esta_activa = 1
            ORDER BY nombre ASC";

        return $this->database->queryAll($sql);
    }
}