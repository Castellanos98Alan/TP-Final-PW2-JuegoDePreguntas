<?php

namespace app\model;

class BuscadorModel
{
    private $database;

    private const ORDENES = [
        'username' => 'u.username ASC',
        'nombre'   => 'u.nombre_completo ASC',
        'puntaje'  => 'puntaje_acumulado DESC, u.username ASC',
    ];
    private const ORDEN_POR_DEFECTO = 'username';
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function obtenerJugadores($orden = self::ORDEN_POR_DEFECTO)
    {
        $orderBy = self::ORDENES[$orden] ?? self::ORDENES[self::ORDEN_POR_DEFECTO];
        $sql = "SELECT u.id,
                       u.username,
                       u.nombre_completo,
                       u.foto_perfil,
                       u.pais,
                       u.ciudad,
                       COALESCE(SUM(p.puntaje), 0) AS puntaje_acumulado,
                       ROW_NUMBER() OVER (
                           ORDER BY COALESCE(SUM(p.puntaje), 0) DESC, u.username ASC
                       ) AS posicion
                FROM usuario u
                LEFT JOIN partida p ON u.id = p.id_usuario
                                   AND MONTH(p.created_at) = MONTH(CURRENT_DATE())
                                   AND YEAR(p.created_at) = YEAR(CURRENT_DATE())
                WHERE u.esta_activo = 1
                  AND u.id_rol = 1
                GROUP BY u.id, u.username, u.nombre_completo, u.foto_perfil, u.pais, u.ciudad
                ORDER BY $orderBy";
        return $this->database->queryAll($sql, []);
    }
}
