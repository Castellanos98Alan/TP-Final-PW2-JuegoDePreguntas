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
                    id, 
                    descripcion, 
                    categoria, 
                    veces_mostrada, 
                    veces_acertada,
                    CASE 
                        WHEN veces_mostrada = 0 THEN 'Sin datos'
                        WHEN (veces_acertada / veces_mostrada) >= 0.70 THEN 'Fácil'
                        WHEN (veces_acertada / veces_mostrada) >= 0.35 THEN 'Media'
                        ELSE 'Difícil'
                    END AS dificultad,
                    CASE 
                        WHEN veces_mostrada = 0 THEN 0
                        ELSE ROUND((veces_acertada / veces_mostrada) * 100, 1)
                    END AS porcentaje_aciertos
                FROM pregunta
                WHERE esta_activa = 1
                ORDER BY veces_mostrada DESC";

        return $this->database->queryAll($sql);
    }
}