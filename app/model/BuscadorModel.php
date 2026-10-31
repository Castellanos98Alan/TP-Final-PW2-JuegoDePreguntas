<?php

namespace app\model;

class BuscadorModel
{
    private $database;

    private const ORDENES = [
        'username' => 'u.username ASC',
        'nombre' => 'u.nombre_completo ASC',
        'puntaje' => 'u.puntaje_acumulado DESC, u.username ASC',
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
                       u.puntaje_acumulado,
                       (SELECT COUNT(*) + 1
                        FROM usuario r
                        WHERE r.esta_activo = 1
                        AND r.id_rol = 1
                        AND r.puntaje_acumulado > u.puntaje_acumulado) AS posicion
                FROM usuario u
                WHERE u.esta_activo = 1
                AND u.id_rol = 1
                ORDER BY $orderBy";

        return $this->database->queryAll($sql, []);
    }
}
