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
        // Comprobamos si este usuario ya reportó la pregunta.
        $sql = "SELECT COUNT(*) AS total
            FROM reporte_pregunta
            WHERE usuario_id = :usuarioId
            AND pregunta_id = :preguntaId";

        $resultado = $this->database->queryOne($sql, [
            'usuarioId' => $usuarioId,
            'preguntaId' => $preguntaId
        ]);

        if ((int)$resultado['total'] > 0) {
            return false;
        }

        // Guardamos el reporte.
        $sql = "INSERT INTO reporte_pregunta
                (usuario_id, pregunta_id, motivo, descripcion)
            VALUES
                (:usuarioId, :preguntaId, :motivo, :descripcion)";

        $this->database->execute($sql, [
            'usuarioId' => $usuarioId,
            'preguntaId' => $preguntaId,
            'motivo' => $motivo,
            'descripcion' => $descripcion
        ]);

        // Contamos cuántos reportes pendientes tiene.
        $sql = "SELECT COUNT(DISTINCT usuario_id) AS total
            FROM reporte_pregunta
            WHERE pregunta_id = :preguntaId
            AND estado = 'Pendiente'";

        $resultado = $this->database->queryOne($sql, [
            'preguntaId' => $preguntaId
        ]);

        $cantidadReportes = (int)$resultado['total'];

        // Si alcanza o supera los 10 reportes de usuarios distintos, se desactiva.
        if ($cantidadReportes >= 10) {

            $sql = "UPDATE pregunta
            SET esta_activa = 0,
                estado_revision = 'Baja por reportes'
            WHERE id = :preguntaId
            AND esta_activa = 1
            AND estado_revision = 'Aprobada'";

            $this->database->execute($sql, [
                'preguntaId' => $preguntaId
            ]);
        }

        return true;
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
    ) {
        if (empty($animesSeleccionados)) {
            return null;
        }

        // 1. Obtenemos el nivel del jugador.
        $nivel = $this->obtenerNivelJugador($usuarioId);

        // 2. Determinamos la dificultad según su nivel.
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

        // 3. Preparamos los animes seleccionados.
        $parametrosAnime = [];
        $placeholdersAnime = [];

        foreach ($animesSeleccionados as $indice => $animeId) {
            $clave = 'anime' . $indice;

            $placeholdersAnime[] = ':' . $clave;
            $parametrosAnime[$clave] = (int) $animeId;
        }

        $condicionAnime = implode(', ', $placeholdersAnime);

        // 4. Excluimos las preguntas utilizadas
        // anteriormente en esta partida.
        $condicionExclusion = '';
        $parametrosExclusion = [];

        if (!empty($preguntasUsadas)) {
            $placeholdersExclusion = [];

            foreach ($preguntasUsadas as $indice => $preguntaId) {
                $clave = 'excluir' . $indice;

                $placeholdersExclusion[] = ':' . $clave;
                $parametrosExclusion[$clave] = (int) $preguntaId;
            }

            $condicionExclusion = "
            AND p.id NOT IN (" .
                implode(', ', $placeholdersExclusion) . ")
        ";
        }

        // 5. Sorteamos una categoría aleatoria
        // que tenga preguntas disponibles.
        $sqlCategoria = "
        SELECT c.id
        FROM pregunta p

        INNER JOIN categoria c
            ON p.categoria_id = c.id AND c.esta_activa = 1

        WHERE p.esta_activa = 1

        AND p.anime_id IN ($condicionAnime)

        $condicionExclusion

        GROUP BY c.id

        ORDER BY RAND()

        LIMIT 1
    ";

        $parametrosCategoria = array_merge(
            $parametrosAnime,
            $parametrosExclusion
        );

        $categoriaSeleccionada = $this->database->queryOne(
            $sqlCategoria,
            $parametrosCategoria
        );

        // Si no hay categorías disponibles, no hay pregunta.
        if (!$categoriaSeleccionada) {
            return null;
        }

        $categoriaId = (int) $categoriaSeleccionada['id'];

        // 6. Buscamos una pregunta de la categoría sorteada.
        // Primero intentamos encontrar una que el usuario no vio.
        $parametrosPregunta = array_merge(
            $parametrosAnime,
            $parametrosExclusion,
            [
                'usuarioId' => $usuarioId,
                'categoriaId' => $categoriaId,
                'dificultad' => $dificultad
            ]
        );

        $sqlBase = "
        SELECT
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

        INNER JOIN anime a
            ON p.anime_id = a.id

        INNER JOIN categoria c
            ON p.categoria_id = c.id AND c.esta_activa = 1

        LEFT JOIN usuario_pregunta up
            ON p.id = up.pregunta_id
            AND up.usuario_id = :usuarioId

        WHERE p.esta_activa = 1

        AND p.anime_id IN ($condicionAnime)

        AND c.id = :categoriaId

        $condicionExclusion
    ";

        // 7. Priorizamos preguntas nunca vistas.
        $sqlNuevas = $sqlBase . "
        AND up.pregunta_id IS NULL

        ORDER BY
            CASE
                WHEN p.dificultad = :dificultad THEN 0
                ELSE 1
            END,
            RAND()

        LIMIT 1
    ";

        $pregunta = $this->database->queryOne(
            $sqlNuevas,
            $parametrosPregunta
        );

        if ($pregunta) {
            return $pregunta;
        }

        // 8. Si ya vio todas las preguntas de esa categoría,
        // permitimos reutilizar una anterior.
        // Nunca se repite una pregunta de esta partida.
        $sqlRecicladas = $sqlBase . "
        ORDER BY
            CASE
                WHEN p.dificultad = :dificultad THEN 0
                ELSE 1
            END,
            RAND()

        LIMIT 1
    ";

        return $this->database->queryOne(
            $sqlRecicladas,
            $parametrosPregunta
        );
    }

    public function obtenerPartidaEnCurso($usuarioId)
    {
        $sql = "SELECT id 
                FROM partida 
                WHERE id_usuario = :usuarioId 
                AND resultado = 'En curso' 
                LIMIT 1";

        return $this->database->queryOne($sql, ['usuarioId' => $usuarioId]);
    }

    public function iniciarPartida($usuarioId)
    {
        $sql = "INSERT INTO partida (id_usuario, puntaje, resultado) 
                VALUES (:usuarioId, 0, 'En curso')";

        $this->database->execute($sql, ['usuarioId' => $usuarioId]);

        $sqlId = "SELECT id 
                  FROM partida 
                  WHERE id_usuario = :usuarioId 
                  ORDER BY id DESC 
                  LIMIT 1";

        $res = $this->database->queryOne($sqlId, ['usuarioId' => $usuarioId]);

        return $res ? (int)$res['id'] : null;
    }

    public function finalizarPartida($idPartida, $puntaje, $resultado)
    {
        $sql = "UPDATE partida 
                SET puntaje = :puntaje, 
                    resultado = :resultado 
                WHERE id = :idPartida";

        $this->database->execute($sql, [
            'idPartida' => $idPartida,
            'puntaje' => $puntaje,
            'resultado' => $resultado
        ]);
    }


}