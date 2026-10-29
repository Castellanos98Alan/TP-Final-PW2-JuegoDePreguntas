<?php
namespace app\model;

class RankingModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerRankingJugadores()
    {
        $sql = "SELECT u.id,
                       u.username,
                       u.nombre_completo,
                       u.foto_perfil,
                       u.pais,
                       u.ciudad,
                       COALESCE(SUM(p.puntaje), 0) AS puntaje_acumulado
                FROM usuario u
                LEFT JOIN partida p ON u.id = p.id_usuario AND p.resultado = 'Ganada'
                WHERE u.id_rol = 1
                  AND u.esta_activo = 1
                GROUP BY u.id, u.username, u.nombre_completo, u.foto_perfil, u.pais, u.ciudad
                ORDER BY puntaje_acumulado DESC, u.username ASC";

        return $this->database->queryAll($sql);
    }
}