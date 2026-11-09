<?php

namespace app\model;

class LobbyModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerDatosDelJugador($idUsuario)
    {
        $sql = "SELECT u.nombre_completo,
            u.username,
            u.foto_perfil,
            u.pais,
            u.ciudad,
            u.id_rol,
            COALESCE((SELECT SUM(p.puntaje)
                      FROM partida p
                      WHERE p.id_usuario = u.id), 0) AS puntaje_acumulado,
            DATE_FORMAT(u.created_at, '%d/%m/%Y') AS miembro_desde
            FROM usuario u
            WHERE u.id = :id
            AND u.esta_activo = 1";

        return $this->database->queryOne($sql, ['id' => $idUsuario]);
    }

    public function obtenerPosicionRanking($idUsuario)
    {
        $sql = "SELECT COUNT(*) + 1 AS posicion
            FROM (
                SELECT u.username, COALESCE(SUM(p.puntaje), 0) AS total
                FROM usuario u
                LEFT JOIN partida p ON u.id = p.id_usuario
                WHERE u.id_rol = 1 AND u.esta_activo = 1
                GROUP BY u.id, u.username
            ) r
            CROSS JOIN (
                SELECT u.username, COALESCE(SUM(p.puntaje), 0) AS total
                FROM usuario u
                LEFT JOIN partida p ON u.id = p.id_usuario
                WHERE u.id = :id
                GROUP BY u.id, u.username
            ) yo
            WHERE r.total > yo.total
               OR (r.total = yo.total AND r.username < yo.username)";

        $resultado = $this->database->queryOne($sql, ['id' => $idUsuario]);

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
            ORDER BY created_at DESC LIMIT 5";

        return $this->database->queryAll(
            $sql,
            ['idUsuario' => $idUsuario]
        );
    }

}