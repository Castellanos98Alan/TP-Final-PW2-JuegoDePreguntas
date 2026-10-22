<?php

namespace app\model;

class LobbyModel {

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function obtenerDatosDelJugador($idUsuario) {
        $sql = "SELECT nombre_completo, 
                username, 
                foto_perfil, 
                pais, ciudad,
                puntaje_acumulado, 
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

    public function obtenerPartidasDelJugador($idUsuario)
    {
        $sql = "SELECT id,
                   puntaje,
                   resultado,
                   DATE_FORMAT(created_at, '%d/%m/%Y') AS fecha
            FROM partida
            WHERE id_usuario = :idUsuario
            ORDER BY created_at DESC";

        return $this->database->queryAll(
            $sql,
            ['idUsuario' => $idUsuario]
        );
    }

}