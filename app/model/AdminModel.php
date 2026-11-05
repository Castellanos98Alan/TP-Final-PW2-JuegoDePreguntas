<?php

namespace app\model;

class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getTotalJugadores()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuario WHERE id_rol = 1";
        $resultado = $this->database->queryOne($sql);
        return $resultado['total'] ?? 0;
    }

    public function getTotalPartidas()
    {
        $sql = "SELECT COUNT(*) AS total FROM partida";
        $resultado = $this->database->queryOne($sql);
        return $resultado['total'] ?? 0;
    }

    public function getTotalPreguntasActivas()
    {
        $sql = "SELECT COUNT(*) AS total FROM pregunta WHERE esta_activa = 1";
        $resultado = $this->database->queryOne($sql);
        return $resultado['total'] ?? 0;
    }

    public function getTotalReportesPendientes()
    {
        $sql = "SELECT COUNT(*) AS total FROM reporte_pregunta WHERE estado = 'pendiente'";
        $resultado = $this->database->queryOne($sql);
        return $resultado['total'] ?? 0;
    }

    public function getEstadisticasPreguntas()
    {
        $sql = "SELECT 
                p.id,
                p.enunciado AS descripcion,
                c.nombre AS categoria,
                p.dificultad,
                0 AS veces_mostrada,
                0 AS veces_acertada,
                'Sin datos' AS dificultad_estadistica,
                0 AS porcentaje_aciertos
            FROM pregunta p
            LEFT JOIN categoria c ON p.categoria_id = c.id
            WHERE p.esta_activa = 1
            ORDER BY p.id DESC";

        return $this->database->queryAll($sql);
    }
}