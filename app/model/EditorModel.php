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

    public function getPreguntasAdministrables(
        $pagina = 1,
        $busqueda = '',
        $animeId = 0,
        $categoriaId = 0,
        $estado = ''
    ) {
        $limite = 10;
        $offset = ($pagina - 1) * $limite;

        $sql = "SELECT
                p.id,
                p.enunciado AS descripcion,
                c.nombre AS categoria,
                p.esta_activa,
                p.estado_revision
            FROM pregunta p
            LEFT JOIN categoria c ON p.categoria_id = c.id
            WHERE p.estado_revision IN (
    'Aprobada',
    'Baja por reportes',
    'Rechazada'
)";

        $parametros = [];

        if ($busqueda !== '') {
            $sql .= " AND p.enunciado LIKE :busqueda";
            $parametros['busqueda'] = '%' . $busqueda . '%';
        }

        if ($animeId > 0) {
            $sql .= " AND p.anime_id = :anime_id";
            $parametros['anime_id'] = $animeId;
        }

        if ($categoriaId > 0) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $parametros['categoria_id'] = $categoriaId;
        }

        switch ($estado) {

            case 'activa':
                $sql .= " AND p.esta_activa = 1
                  AND p.estado_revision = 'Aprobada'";
                break;

            case 'inactiva':
                $sql .= " AND p.esta_activa = 0
                  AND p.estado_revision = 'Aprobada'";
                break;

            case 'rechazada':
                $sql .= " AND p.estado_revision = 'Rechazada'";
                break;

            case 'reportada':
                $sql .= " AND p.estado_revision = 'Baja por reportes'";
                break;

            default:
                break;
        }

        $sql .= " ORDER BY p.id DESC
              LIMIT $limite OFFSET $offset";

        return $this->database->queryAll($sql, $parametros);
    }

    // revisa la cantidad de preguntas disponibles para meterlas en paginas
    public function contarPreguntasAdministrables(
        $busqueda = '',
        $animeId = 0,
        $categoriaId = 0,
        $estado = ''
    ) {
        $sql = "SELECT COUNT(*) AS total
            FROM pregunta p
             WHERE p.estado_revision IN (
    'Aprobada',
    'Baja por reportes',
    'Rechazada'
)";

        $parametros = [];

        if ($busqueda !== '') {
            $sql .= " AND p.enunciado LIKE :busqueda";
            $parametros['busqueda'] = '%' . $busqueda . '%';
        }

        if ($animeId > 0) {
            $sql .= " AND p.anime_id = :anime_id";
            $parametros['anime_id'] = $animeId;
        }

        if ($categoriaId > 0) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $parametros['categoria_id'] = $categoriaId;
        }

        if ($estado === '1' || $estado === '0') {
            $sql .= " AND p.esta_activa = :estado";
            $parametros['estado'] = (int)$estado;
        }

        $resultado = $this->database->queryOne($sql, $parametros);

        return (int)$resultado['total'];
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
                p.tipo_pregunta,
                p.estado_revision,
                p.recurso,
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

    // Que una pregunta se de debaja automaticamente al llegar a los 10 reportes

    public function contarReportesPendientes($idPregunta)
    {
        $sql = "SELECT COUNT(*) AS total
            FROM reporte_pregunta
            WHERE pregunta_id = :id
            AND estado = 'Pendiente'";

        $resultado = $this->database->queryOne($sql, [
            'id' => $idPregunta
        ]);

        return (int)$resultado['total'];
    }

    public function desactivarPorReportes($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET esta_activa = 0
            WHERE id = :id
            AND esta_activa = 1";

        return $this->database->execute($sql, [
            'id' => $idPregunta
        ]);
    }







    public function desactivarPregunta($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET esta_activa = 0
            WHERE id = :id
            AND esta_activa = 1";

        return $this->database->execute($sql, [
            'id' => $idPregunta
        ]);
    }




    public function reactivarPregunta($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET esta_activa = 1
            WHERE id = :id
            AND estado_revision = 'Aprobada'
            AND esta_activa = 0";

        return $this->database->execute($sql, [
            'id' => $idPregunta
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

    public function getPreguntasBajaPorReportes()
    {
        $sql = "SELECT
                p.id,
                p.enunciado AS descripcion,
                c.nombre AS categoria,
                COUNT(DISTINCT r.usuario_id) AS cantidad_reportes
            FROM pregunta p
            LEFT JOIN categoria c
                ON p.categoria_id = c.id
            LEFT JOIN reporte_pregunta r
                ON r.pregunta_id = p.id
                AND r.estado = 'Pendiente'
            WHERE p.estado_revision = 'Baja por reportes'
              AND p.esta_activa = 0
            GROUP BY p.id, p.enunciado, c.nombre
            ORDER BY cantidad_reportes DESC";

        return $this->database->queryAll($sql);
    }

    public function getReportesPorPregunta($idPregunta)
    {
        $sql = "SELECT
                id,
                motivo,
                descripcion,
                created_at
            FROM reporte_pregunta
            WHERE pregunta_id = :idPregunta
            AND estado = 'Pendiente'
            ORDER BY created_at DESC";

        return $this->database->queryAll($sql, [
            'idPregunta' => $idPregunta
        ]);
    }


    public function aprobarPreguntaReportada($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET esta_activa = 1,
                estado_revision = 'Aprobada'
            WHERE id = :id
            AND estado_revision = 'Baja por reportes'";

        return $this->database->execute($sql, [
            'id' => $idPregunta
        ]);
    }

    public function mantenerBajaPreguntaReportada($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET esta_activa = 0,
                estado_revision = 'Rechazada'
            WHERE id = :id
            AND estado_revision = 'Baja por reportes'";

        return $this->database->execute($sql, [
            'id' => $idPregunta
        ]);
    }

    public function cerrarReportesPregunta($idPregunta, $estado)
    {
        if (!in_array($estado, ['Revisado', 'Descartado'], true)) {
            return false;
        }

        $sql = "UPDATE reporte_pregunta
            SET estado = :estado
            WHERE pregunta_id = :idPregunta
            AND estado = 'Pendiente'";

        return $this->database->execute($sql, [
            'estado' => $estado,
            'idPregunta' => $idPregunta
        ]);
    }

    public function recuperarPreguntaRechazada($idPregunta)
    {
        $sql = "UPDATE pregunta
            SET estado_revision = 'Aprobada',
                esta_activa = 1
            WHERE id = :id
            AND estado_revision = 'Rechazada'
            AND esta_activa = 0";

        return $this->database->execute($sql, [
            'id' => $idPregunta
        ]);
    }


    public function getCategoriasAdministrables()
    {
        return $this->database->queryAll("SELECT c.id, c.nombre, c.descripcion, c.esta_activa,
            (SELECT COUNT(*) FROM pregunta p WHERE p.categoria_id = c.id) AS cantidad
            FROM categoria c ORDER BY c.nombre");
    }

    public function guardarCategoria($id, $nombre, $descripcion)
    {
        $params = ['nombre' => $nombre, 'descripcion' => $descripcion];
        if ($id === 0) {
            return $this->database->execute("INSERT INTO categoria (nombre, descripcion, esta_activa)
                VALUES (:nombre, :descripcion, 1)", $params);
        }
        $params['id'] = $id;
        return $this->database->execute("UPDATE categoria SET nombre = :nombre,
            descripcion = :descripcion WHERE id = :id", $params);
    }

    public function cambiarEstadoCategoria($id, $activa)
    {
        return $this->database->execute("UPDATE categoria SET esta_activa = :activa WHERE id = :id",
            ['activa' => $activa, 'id' => $id]);
    }


    public function getAnimesAdministrables()
    {
        $sql = "SELECT a.id, a.nombre, a.imagen, a.esta_activo,
            (SELECT COUNT(*)
             FROM pregunta p
             INNER JOIN categoria c ON p.categoria_id = c.id
             WHERE p.anime_id = a.id
             AND p.esta_activa = 1
             AND c.esta_activa = 1) AS cantidad
            FROM anime a
            ORDER BY a.nombre";

        return $this->database->queryAll($sql);
    }

    public function guardarAnime($id, $nombre, $imagen)
    {
        $params = [
            'nombre' => $nombre,
            'imagen' => $imagen
        ];

        if ($id === 0) {
            $sql = "INSERT INTO anime
                (nombre, imagen, esta_activo)
                VALUES (:nombre, :imagen, 0)";

            return $this->database->execute($sql, $params);
        }

        $params['id'] = $id;

        $sql = "UPDATE anime
            SET nombre = :nombre,
                imagen = :imagen
            WHERE id = :id";

        return $this->database->execute($sql, $params);
    }

    public function cambiarEstadoAnime($id, $activo)
    {
        $sql = "UPDATE anime
            SET esta_activo = :activo
            WHERE id = :id";

        return $this->database->execute($sql, [
            'activo' => $activo,
            'id' => $id
        ]);
    }

    public function getTodosLosAnimes()
    {
        $sql = "SELECT id, nombre
            FROM anime
            ORDER BY nombre ASC";

        return $this->database->queryAll($sql);
    }

    public function getAnimePorId($id)
    {
        $sql = "SELECT id, nombre, imagen, esta_activo
            FROM anime
            WHERE id = :id";

        return $this->database->queryOne($sql, [
            'id' => $id
        ]);
    }

    public function contarPreguntasActivasPorAnime($id)
    {
        $sql = "SELECT COUNT(*) AS total
            FROM pregunta p
            INNER JOIN categoria c
                ON p.categoria_id = c.id
            WHERE p.anime_id = :id
            AND p.esta_activa = 1
            AND c.esta_activa = 1";

        $resultado = $this->database->queryOne($sql, [
            'id' => $id
        ]);

        return (int)$resultado['total'];
    }



}
