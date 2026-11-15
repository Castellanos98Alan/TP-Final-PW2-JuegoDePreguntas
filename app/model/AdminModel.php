<?php

namespace app\model;

class AdminModel
{
    // Una pregunta con menos respuestas que esto se muestra como dificultad "media".
    // En 0 se muestra siempre la dificultad guardada en pregunta.dificultad, que es la que
    // usa el juego (PartidaModel la recalcula recién a partir de las 15 respuestas).
    const MIN_RESPUESTAS_DIFICULTAD = 0;

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    // Devuelve el filtro correspondiente al período.
    private function filtroFecha($columna, $periodo)
    {
        switch ($periodo) {
            case 'dia':
                return "DATE($columna) = CURDATE()"; //trae los registros cuya fecha sea igual a la fecha de hoy

            case 'semana':
                return "YEARWEEK($columna, 1) = YEARWEEK(CURDATE(), 1)"; //trae los registros que pertenecen a la misma semana que la fecha actual

            case 'anio':
                return "YEAR($columna) = YEAR(CURDATE())";  //traer los registros cuyo año sea igual al año actual

            case 'mes':
            default:
                return "YEAR($columna) = YEAR(CURDATE())
                        AND MONTH($columna) = MONTH(CURDATE())"; //trae los registros que pertenezcan al mismo mes y año actuales
        }
    }

    // Cantidad de jugadores.
    public function getTotalJugadores()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM usuario
                WHERE id_rol = 1";

        $resultado = $this->database->queryOne($sql);

        return $resultado['total'] ?? 0;
    }

    // Cantidad de partidas.
    public function getTotalPartidas()
    {
        $sql = "SELECT COUNT(*) AS total FROM partida";

        $resultado = $this->database->queryOne($sql);

        return $resultado['total'] ?? 0;
    }

    // Preguntas activas.
    public function getTotalPreguntasActivas()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM pregunta";

        $resultado = $this->database->queryOne($sql);

        return $resultado['total'] ?? 0;
    }

    // Reportes pendientes.
    public function getTotalReportesPendientes()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM reporte_pregunta
                WHERE estado = 'pendiente'";

        $resultado = $this->database->queryOne($sql);

        return $resultado['total'] ?? 0;
    }

    // Categorías para el select de filtros.
    public function getCategorias()
    {
        $sql = "SELECT id, nombre
                FROM categoria
                ORDER BY nombre ASC";

        return $this->database->queryAll($sql);
    }

    // Animes que tienen al menos una pregunta activa, para el select de filtros.
    public function getAnimes()
    {
        $sql = "SELECT a.id, a.nombre
                FROM anime a
                WHERE EXISTS (
                    SELECT 1
                    FROM pregunta p
                    WHERE p.anime_id = a.id AND p.esta_activa = 1
                )
                ORDER BY a.nombre ASC";

        return $this->database->queryAll($sql);
    }

    // Estadísticas de preguntas, con filtros y orden opcionales.
    public function getEstadisticasPreguntas($periodo = null, $categoriaId = null, $dificultad = null, $orden = null, $animeId = null)
    {
        $filtroFecha = '';
        if ($periodo) {
            $filtro = $this->filtroFecha('hr.fecha_respuesta', $periodo);
            $filtroFecha = "AND $filtro";
        }

        $condiciones = [];

        if ($categoriaId !== null) {
            $condiciones[] = "t.categoria_id = " . (int)$categoriaId;
        }

        if ($animeId !== null) {
            $condiciones[] = "t.anime_id = " . (int)$animeId;
        }

        if (in_array($dificultad, ['facil', 'media', 'dificil'], true)) {
            $condiciones[] = "t.dificultad = '$dificultad'";
        }

        $where = $condiciones ? 'WHERE ' . implode(' AND ', $condiciones) : '';

        $ordenes = [
            'jugada_desc' => 't.veces_mostrada DESC',
            'jugada_asc' => 't.veces_mostrada ASC',
            'acertada_desc' => 't.veces_acertada DESC',
            'acertada_asc' => 't.veces_acertada ASC',
            'exito_desc' => 't.porcentaje_aciertos DESC',
            'exito_asc' => 't.porcentaje_aciertos ASC',
        ];

        $order = isset($ordenes[$orden]) ? $ordenes[$orden] . ', t.id DESC' : 't.id DESC';

        $minimoRespuestas = (int)self::MIN_RESPUESTAS_DIFICULTAD;

        $sql = "SELECT t.*
                FROM (
                    SELECT
                        p.id,
                        p.enunciado AS descripcion,
                        a.id AS anime_id,
                        a.nombre AS anime,
                        c.id AS categoria_id,
                        c.nombre AS categoria,
                        CASE
                            WHEN (SELECT COUNT(*) FROM historial_respuesta hr_tot WHERE hr_tot.pregunta_id = p.id) < $minimoRespuestas THEN 'media'
                            ELSE COALESCE(p.dificultad, 'media')
                        END AS dificultad,
                        COUNT(hr.id) AS veces_mostrada,
                        COALESCE(SUM(hr.fue_correcta), 0) AS veces_acertada,
                        CASE
                            WHEN COUNT(hr.id) = 0 THEN 0
                            ELSE ROUND((SUM(hr.fue_correcta) / COUNT(hr.id)) * 100, 2)
                        END AS porcentaje_aciertos
                    FROM pregunta p
                    LEFT JOIN categoria c ON p.categoria_id = c.id
                    LEFT JOIN anime a ON p.anime_id = a.id
                    LEFT JOIN historial_respuesta hr ON p.id = hr.pregunta_id $filtroFecha
                    WHERE p.esta_activa = 1
                    GROUP BY p.id, p.enunciado, a.id, a.nombre, c.id, c.nombre, p.dificultad
                ) t
                $where
                ORDER BY $order";

        return $this->database->queryAll($sql);
    }

    // Cantidad de usuarios nuevos.
    public function getUsuariosNuevos($periodo)
    {
        $filtro = $this->filtroFecha('u.created_at', $periodo);

        $sql = "SELECT COUNT(*) AS total
                FROM usuario u
                WHERE u.id_rol = 1 AND $filtro";

        $resultado = $this->database->queryOne($sql);

        return $resultado['total'] ?? 0;
    }

    // Cantidad de preguntas creadas.
    public function getPreguntasCreadas($periodo)
    {
        $filtro = $this->filtroFecha('p.created_at', $periodo);

        $sql = "SELECT COUNT(*) AS total
                FROM pregunta p
                WHERE $filtro";

        $resultado = $this->database->queryOne($sql);

        return $resultado['total'] ?? 0;
    }

    // Porcentaje de respuestas correctas.
    public function getPorcentajeCorrectas($periodo)
    {
        $filtro = $this->filtroFecha('hr.fecha_respuesta', $periodo);

        $sql = "SELECT
                COUNT(*) AS total,
                SUM(hr.fue_correcta) AS correctas
            FROM historial_respuesta hr
            WHERE $filtro";

        $resultado = $this->database->queryOne($sql);

        $total = $resultado['total'];
        $correctas = $resultado['correctas'];

        if ($total == 0) {
            return 0;
        }

        return round(($correctas / $total) * 100, 2);
    }

    // Usuarios agrupados por país.
    public function getUsuariosPorPais($periodo)
    {
        $filtro = $this->filtroFecha('u.created_at', $periodo);

        $sql = "SELECT u.pais AS etiqueta, COUNT(*) AS cantidad
                FROM usuario u
                WHERE u.id_rol = 1 AND $filtro
                GROUP BY u.pais
                ORDER BY cantidad DESC";

        return $this->database->queryAll($sql);
    }

    // Usuarios agrupados por sexo.
    public function getUsuariosPorSexo($periodo)
    {
        $filtro = $this->filtroFecha('u.created_at', $periodo);

        $sql = "SELECT u.sexo AS etiqueta, COUNT(*) AS cantidad
                FROM usuario u
                WHERE u.id_rol = 1 AND $filtro
                GROUP BY u.sexo";

        return $this->database->queryAll($sql);
    }

    // Usuarios agrupados por edad.
    public function getUsuariosPorEdad($periodo)
    {
        $filtro = $this->filtroFecha('u.created_at', $periodo);

        $sql = "SELECT
                    CASE
                        WHEN YEAR(CURDATE()) - u.anio_nacimiento < 18
                            THEN 'Menores de 18'
                        WHEN YEAR(CURDATE()) - u.anio_nacimiento BETWEEN 18 AND 25
                            THEN '18 a 25'
                        WHEN YEAR(CURDATE()) - u.anio_nacimiento BETWEEN 26 AND 35
                            THEN '26 a 35'
                        WHEN YEAR(CURDATE()) - u.anio_nacimiento BETWEEN 36 AND 50
                            THEN '36 a 50'
                        ELSE 'Mayores de 50'
                    END AS etiqueta,
                    COUNT(*) AS cantidad
                FROM usuario u
                WHERE u.id_rol = 1 AND $filtro
                GROUP BY etiqueta";

        return $this->database->queryAll($sql);
    }


    // Cantidad de partidas finalizadas según el período.
    public function getPartidasJugadas($periodo)
    {
        $filtro = $this->filtroFecha('p.created_at', $periodo);

        $sql = "SELECT COUNT(*) AS total
                FROM partida p
                WHERE $filtro
                AND p.resultado IN ('Ganada', 'Perdida')";

        $resultado = $this->database->queryOne($sql);

        return $resultado['total'] ?? 0;
    }

}