<?php

namespace app\model;

class PerfilModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerPerfil($idUsuario)
    {
        $sql = "SELECT id,
                nombre_completo,
                username,
                foto_perfil,
                pais,
                ciudad,
                latitud,
                longitud,
                puntaje_acumulado,
                id_rol,
                DATE_FORMAT(created_at, '%d/%m/%Y') AS miembro_desde
                FROM usuario
                WHERE id = :id
                AND esta_activo = 1";

        return $this->database->queryOne($sql, ['id' => $idUsuario]);
    }

    public function obtenerPosicionRanking($puntaje)
    {
        $sql = "SELECT COUNT(*) + 1 AS posicion
                FROM usuario
                WHERE esta_activo = 1
                AND id_rol = 1
                AND puntaje_acumulado > :puntaje";

        $resultado = $this->database->queryOne($sql, ['puntaje' => $puntaje]);

        return $resultado['posicion'];
    }

    public function obtenerResumenPartidas($idUsuario)
    {
        $sql = "SELECT COUNT(*) AS total,
                COALESCE(MAX(puntaje), 0) AS mejor_puntaje,
                COALESCE(ROUND(AVG(puntaje), 1), 0) AS promedio
                FROM partida
                WHERE id_usuario = :idUsuario";

        return $this->database->queryOne($sql, ['idUsuario' => $idUsuario]);
    }

    public function obtenerPartidas($idUsuario)
    {
        $sql = "SELECT id,
                puntaje,
                resultado,
                DATE_FORMAT(created_at, '%d/%m/%Y') AS fecha
                FROM partida
                WHERE id_usuario = :idUsuario
                ORDER BY created_at DESC";

        return $this->database->queryAll($sql, ['idUsuario' => $idUsuario]);
    }
}