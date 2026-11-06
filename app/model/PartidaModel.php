<?php

namespace app\model;

class PartidaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    /*
     * Obtiene todos los animes disponibles
     * para mostrarlos antes de comenzar la partida.
     */
    public function obtenerAnimes()
    {
        $sql = "SELECT id, nombre, imagen
                FROM anime
                WHERE esta_activo = 1
                ORDER BY nombre ASC";

        return $this->database->queryAll($sql);
    }


    /*
     * Arma las 15 preguntas de la partida:
     *
     * 5 fáciles
     * 5 medias
     * 5 difíciles
     */
    public function obtenerPreguntasDePartida(
        $animesSeleccionados,
        $usuarioId
    )
    {
        $preguntasFaciles = $this->obtenerPreguntasDistribuidas(
            'facil',
            5,
            $animesSeleccionados,
            $usuarioId
        );

        $preguntasMedias = $this->obtenerPreguntasDistribuidas(
            'media',
            5,
            $animesSeleccionados,
            $usuarioId
        );

        $preguntasDificiles = $this->obtenerPreguntasDistribuidas(
            'dificil',
            5,
            $animesSeleccionados,
            $usuarioId
        );

        return array_merge(
            $preguntasFaciles,
            $preguntasMedias,
            $preguntasDificiles
        );
    }


    /*
     * Distribuye las preguntas entre los animes
     * seleccionados por el usuario.
     */
    private function obtenerPreguntasDistribuidas(
        $dificultad,
        $cantidad,
        $animesSeleccionados,
        $usuarioId
    )
    {
        $preguntas = [];

        if (empty($animesSeleccionados)) {
            return $preguntas;
        }

        /*
         * Evitamos que siempre tengan prioridad
         * los mismos animes.
         */
        shuffle($animesSeleccionados);

        $cantidadAnimes = count($animesSeleccionados);

        $cantidadBase = intdiv(
            $cantidad,
            $cantidadAnimes
        );

        $restantes = $cantidad % $cantidadAnimes;

        foreach ($animesSeleccionados as $index => $animeId) {

            $cantidadParaAnime = $cantidadBase;

            if ($index < $restantes) {
                $cantidadParaAnime++;
            }

            /*
             * Puede pasar que haya más animes
             * seleccionados que preguntas necesarias.
             */
            if ($cantidadParaAnime <= 0) {
                continue;
            }

            $preguntasAnime = $this->obtenerPreguntasDeAnime(
                $dificultad,
                $cantidadParaAnime,
                $animeId,
                $usuarioId
            );

            $preguntas = array_merge(
                $preguntas,
                $preguntasAnime
            );
        }

        shuffle($preguntas);

        return $preguntas;
    }


    /*
     * Obtiene las preguntas de un anime.
     *
     * Primero busca preguntas que el usuario
     * todavía no haya visto.
     *
     * Si no alcanza la cantidad necesaria,
     * completa con preguntas que ya vio.
     */
    private function obtenerPreguntasDeAnime(
        $dificultad,
        $cantidad,
        $animeId,
        $usuarioId
    )
    {
        $preguntasNuevas =
            $this->obtenerPreguntasNoVistas(
                $dificultad,
                $cantidad,
                $animeId,
                $usuarioId
            );

        /*
         * Si conseguimos todas las necesarias,
         * las devolvemos directamente.
         */
        if (count($preguntasNuevas) >= $cantidad) {
            return $preguntasNuevas;
        }

        /*
         * Si no alcanzaron las nuevas,
         * calculamos cuántas faltan.
         */
        $cantidadFaltante =
            $cantidad - count($preguntasNuevas);

        /*
         * Guardamos sus IDs para no traer
         * esas mismas preguntas nuevamente.
         */
        $idsExcluir = [];

        foreach ($preguntasNuevas as $pregunta) {
            $idsExcluir[] = $pregunta['id'];
        }

        $preguntasRepetidas =
            $this->obtenerPreguntasRepetidas(
                $dificultad,
                $cantidadFaltante,
                $animeId,
                $idsExcluir
            );

        return array_merge(
            $preguntasNuevas,
            $preguntasRepetidas
        );
    }


    /*
     * Busca exclusivamente preguntas que
     * este usuario todavía no haya visto.
     */
    private function obtenerPreguntasNoVistas(
        $dificultad,
        $cantidad,
        $animeId,
        $usuarioId
    )
    {
        $sql = "SELECT
                    p.id,
                    p.enunciado,
                    p.respuesta_a,
                    p.respuesta_b,
                    p.respuesta_c,
                    p.respuesta_d,
                    p.tipo_pregunta,
                    p.recurso,
                    p.dificultad,
                    a.nombre AS anime,
                    c.nombre AS categoria

                FROM pregunta p

                JOIN anime a
                    ON p.anime_id = a.id
                JOIN categoria c
                    ON p.categoria_id = c.id

                LEFT JOIN usuario_pregunta up
                    ON p.id = up.pregunta_id
                    AND up.usuario_id = :usuarioId

                WHERE p.dificultad = :dificultad

                AND p.anime_id = :animeId

                AND p.esta_activa = 1

                AND up.pregunta_id IS NULL

                ORDER BY RAND()

                LIMIT " . intval($cantidad);

        return $this->database->queryAll(
            $sql,
            [
                'usuarioId' => $usuarioId,
                'dificultad' => $dificultad,
                'animeId' => $animeId
            ]
        );
    }


    /*
     * Solamente se utiliza cuando ya no quedan
     * suficientes preguntas nuevas.
     */
    private function obtenerPreguntasRepetidas(
        $dificultad,
        $cantidad,
        $animeId,
        $idsExcluir = []
    )
    {
        $sql = "SELECT
                    p.id,
                    p.enunciado,
                    p.respuesta_a,
                    p.respuesta_b,
                    p.respuesta_c,
                    p.respuesta_d,
                    p.tipo_pregunta,
                    p.recurso,
                    p.dificultad,
                    a.nombre AS anime,
                    c.nombre AS categoria

                FROM pregunta p

                JOIN anime a
                    ON p.anime_id = a.id
                JOIN categoria c
                    ON p.categoria_id = c.id

                WHERE p.dificultad = :dificultad

                AND p.anime_id = :animeId

                AND p.esta_activa = 1";

        $parametros = [
            'dificultad' => $dificultad,
            'animeId' => $animeId
        ];

        /*
         * Evitamos volver a obtener una de las
         * preguntas nuevas que ya seleccionamos.
         */
        if (!empty($idsExcluir)) {

            $placeholders = [];

            foreach ($idsExcluir as $index => $preguntaId) {

                $clave = 'preguntaExcluir' . $index;

                $placeholders[] = ':' . $clave;

                $parametros[$clave] = $preguntaId;
            }

            $sql .= " AND p.id NOT IN (" .
                implode(', ', $placeholders) .
                ")";
        }

        $sql .= " ORDER BY RAND()
                  LIMIT " . intval($cantidad);

        return $this->database->queryAll(
            $sql,
            $parametros
        );
    }


    /*
     * Comprueba si la opción A, B, C o D
     * elegida por el usuario es correcta.
     */
    public function validarRespuesta(
        $idPregunta,
        $respuestaUsuario
    )
    {
        $sql = "SELECT respuesta_correcta
                FROM pregunta
                WHERE id = :idPregunta
                AND esta_activa = 1";

        $pregunta = $this->database->queryOne(
            $sql,
            [
                'idPregunta' => $idPregunta
            ]
        );

        if (!$pregunta) {
            return false;
        }

        return strtoupper($respuestaUsuario)
            === strtoupper(
                $pregunta['respuesta_correcta']
            );
    }


    /*
     * Nos permite saber cuál era la respuesta
     * correcta si el jugador se equivoca.
     */
    public function obtenerRespuestaCorrecta(
        $idPregunta
    )
    {
        $sql = "SELECT respuesta_correcta
                FROM pregunta
                WHERE id = :id";

        $resultado = $this->database->queryOne(
            $sql,
            [
                'id' => $idPregunta
            ]
        );

        return $resultado
            ? $resultado['respuesta_correcta']
            : null;
    }


    /*
     * Registra que el jugador ya vio/respondió
     * determinada pregunta.
     */
    public function registrarPreguntaVista(
        $usuarioId,
        $preguntaId
    )
    {
        $sql = "INSERT INTO usuario_pregunta
                (
                    usuario_id,
                    pregunta_id,
                    respondida_correctamente
                )
            VALUES
                (
                    :usuarioId,
                    :preguntaId,
                    NULL
                )
            ON DUPLICATE KEY UPDATE
                pregunta_id = pregunta_id";

        $this->database->execute(
            $sql,
            [
                'usuarioId' => $usuarioId,
                'preguntaId' => $preguntaId
            ]
        );
    }


    public function registrarResultadoPregunta(
        $usuarioId,
        $preguntaId,
        $fueCorrecta
    )
    {
        // Actualizamos el resultado en usuario_pregunta
        $sql = "UPDATE usuario_pregunta
            SET respondida_correctamente = :fueCorrecta,
                fecha_respuesta = CURRENT_TIMESTAMP
            WHERE usuario_id = :usuarioId
            AND pregunta_id = :preguntaId";

        $this->database->execute($sql, [
            'usuarioId' => $usuarioId,
            'preguntaId' => $preguntaId,
            'fueCorrecta' => $fueCorrecta ? 1 : 0
        ]);

        // Guardamos la respuesta en el historial
        $sqlHistorial = "INSERT INTO historial_respuesta
                    (usuario_id, pregunta_id, fue_correcta)
                    VALUES
                    (:usuarioId, :preguntaId, :fueCorrecta)";




        $this->database->execute($sqlHistorial, [
            'usuarioId' => $usuarioId,
            'preguntaId' => $preguntaId,
            'fueCorrecta' => $fueCorrecta ? 1 : 0
        ]);

        $this->actualizarDificultadPregunta($preguntaId);
        
    }


    /** Guarda un reporte enviado por un jugador. */
    public function guardarReporte($usuarioId, $preguntaId, $motivo, $descripcion)
    {
        $sql = "INSERT INTO reporte_pregunta
                    (usuario_id, pregunta_id, motivo, descripcion)
                VALUES
                    (:usuarioId, :preguntaId, :motivo, :descripcion)";

        return $this->database->execute($sql, [
            'usuarioId' => $usuarioId,
            'preguntaId' => $preguntaId,
            'motivo' => $motivo,
            'descripcion' => $descripcion
        ]);
    }

    public function guardarPartida(
        $usuarioId,
        $puntaje,
        $resultado
    )
    {
        $sql = "INSERT INTO partida
                (
                    id_usuario,
                    puntaje,
                    resultado
                )
            VALUES
                (
                    :usuarioId,
                    :puntaje,
                    :resultado
                )";

        $this->database->execute(
            $sql,
            [
                'usuarioId' => $usuarioId,
                'puntaje' => $puntaje,
                'resultado' => $resultado
            ]
        );
    }



    public function actualizarDificultadPregunta($preguntaId)
    {
        // Contamos todas las respuestas de la pregunta.
        $sql = "SELECT COUNT(*) AS total
            FROM historial_respuesta
            WHERE pregunta_id = :preguntaId";

        $resultado = $this->database->queryOne(
            $sql,
            ['preguntaId' => $preguntaId]
        );

        $totalRespuestas = (int) $resultado['total'];

        // Las primeras 15 respuestas son de evaluación.
        if ($totalRespuestas < 15) {
            return;
        }

        // Obtenemos las últimas 15 respuestas.
        $sql = "SELECT fue_correcta
            FROM historial_respuesta
            WHERE pregunta_id = :preguntaId
            ORDER BY id DESC
            LIMIT 15";

        $respuestas = $this->database->queryAll(
            $sql,
            ['preguntaId' => $preguntaId]
        );

        // Contamos las respuestas correctas.
        $correctas = 0;

        foreach ($respuestas as $respuesta) {
            if ($respuesta['fue_correcta'] == 1) {
                $correctas++;
            }
        }

        // Calculamos el porcentaje de aciertos.
        $porcentaje = ($correctas / 15) * 100;

        // Determinamos la dificultad.
        if ($porcentaje > 66) {
            $dificultad = 'facil';
        } elseif ($porcentaje < 33) {
            $dificultad = 'dificil';
        } else {
            $dificultad = 'media';
        }

        // Actualizamos la dificultad en MySQL.
        $sql = "UPDATE pregunta
            SET dificultad = :dificultad
            WHERE id = :preguntaId";

        $this->database->execute(
            $sql,
            [
                'dificultad' => $dificultad,
                'preguntaId' => $preguntaId
            ]
        );
    }




    public function obtenerNivelJugador($usuarioId)
    {
        // Contamos todas las respuestas del usuario.
        $sql = "SELECT COUNT(*) AS total
            FROM historial_respuesta
            WHERE usuario_id = :usuarioId";

        $resultado = $this->database->queryOne(
            $sql,
            ['usuarioId' => $usuarioId]
        );

        $total = (int) $resultado['total'];

        // Primeras 15 respuestas: etapa inicial.
        if ($total < 15) {
            return 'inicial';
        }

        // Buscamos solamente las últimas 15 respuestas.
        $sql = "SELECT fue_correcta
            FROM historial_respuesta
            WHERE usuario_id = :usuarioId
            ORDER BY id DESC
            LIMIT 15";

        $respuestas = $this->database->queryAll(
            $sql,
            ['usuarioId' => $usuarioId]
        );

        // Contamos las respuestas correctas.
        $correctas = 0;

        foreach ($respuestas as $respuesta) {
            if ($respuesta['fue_correcta'] == 1) {
                $correctas++;
            }
        }

        // Calculamos el porcentaje.
        $porcentaje = ($correctas / 15) * 100;

        if ($porcentaje > 66) {
            return 'alto';
        } elseif ($porcentaje < 33) {
            return 'bajo';
        } else {
            return 'medio';
        }
    }




    public function obtenerSiguientePregunta(
        $animesSeleccionados,
        $usuarioId,
        $preguntasUsadas = [],
        $numeroPregunta = 0
    )
    {
        if (empty($animesSeleccionados)) {
            return null;
        }

        // 1. Obtenemos el nivel del jugador.
        $nivel = $this->obtenerNivelJugador($usuarioId);

        if ($nivel === 'inicial') {
            $dificultades = ['facil', 'media', 'dificil'];
            $dificultad = $dificultades[$numeroPregunta % 3];

        } elseif ($nivel === 'alto') {
            $dificultad = 'dificil';

        } elseif ($nivel === 'bajo') {
            $dificultad = 'facil';

        } else {
            $dificultad = 'media';
        }

        // 2. Preparamos los animes seleccionados.
        $parametros = [
            'usuarioId' => $usuarioId,
            'dificultad' => $dificultad
        ];

        $placeholdersAnime = [];

        foreach ($animesSeleccionados as $indice => $animeId) {
            $clave = 'anime' . $indice;

            $placeholdersAnime[] = ':' . $clave;
            $parametros[$clave] = (int)$animeId;
        }

        $sql = "SELECT
                p.id,
                p.enunciado,
                p.respuesta_a,
                p.respuesta_b,
                p.respuesta_c,
                p.respuesta_d,
                p.tipo_pregunta,
                p.recurso,
                p.dificultad,
                a.nombre AS anime,
                c.nombre AS categoria

            FROM pregunta p

            JOIN anime a
                ON p.anime_id = a.id

            JOIN categoria c
                ON p.categoria_id = c.id

            LEFT JOIN usuario_pregunta up
                ON p.id = up.pregunta_id
                AND up.usuario_id = :usuarioId

            WHERE p.esta_activa = 1

            AND p.anime_id IN (" .
            implode(', ', $placeholdersAnime) .
            ")";


// 3. Excluimos SIEMPRE las preguntas
// que aparecieron en esta partida.

        if (!empty($preguntasUsadas)) {
            $excluidas = [];

            foreach ($preguntasUsadas as $indice => $preguntaId) {
                $clave = 'excluir' . $indice;

                $excluidas[] = ':' . $clave;
                $parametros[$clave] = (int)$preguntaId;
            }

            $sql .= " AND p.id NOT IN (" .
                implode(', ', $excluidas) . ")";
        }

// 4. Primero buscamos preguntas nunca
// vistas por el usuario, sin importar
// si son fáciles, medias o difíciles.

        $sqlNuevas = $sql . "
    AND up.pregunta_id IS NULL

    ORDER BY
        CASE
            WHEN p.dificultad = :dificultad
            THEN 0
            ELSE 1
        END,
        RAND()

    LIMIT 1";

        $pregunta = $this->database->queryOne(
            $sqlNuevas,
            $parametros
        );

        if ($pregunta) {
            return $pregunta;
        }

// 5. Si el usuario ya vio todas las preguntas
// disponibles, reciclamos preguntas de
// partidas anteriores, pero NUNCA una que
// ya apareció en esta partida.

        $sqlRecicladas = $sql . "
    ORDER BY
        CASE
            WHEN p.dificultad = :dificultad
            THEN 0
            ELSE 1
        END,
        RAND()

    LIMIT 1";

        return $this->database->queryOne(
            $sqlRecicladas,
            $parametros
        );

    }



}