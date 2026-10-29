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
                anio_nacimiento,
                sexo,
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

    public function existeUsernameEnOtroUsuario($username, $idUsuario)
    {
        $sql = "SELECT id FROM usuario WHERE username = :username AND id != :id";
        $resultado = $this->database->queryOne($sql, [
            'username' => $username,
            'id'       => $idUsuario
        ]);
        return $resultado !== null;
    }

    public function actualizarPerfil($idUsuario, $datos, $nombreFoto = null)
    {
        if ($nombreFoto !== null) {
            $sql = "UPDATE usuario SET
                        nombre_completo = :nombre_completo,
                        username        = :username,
                        anio_nacimiento = :anio_nacimiento,
                        sexo            = :sexo,
                        pais            = :pais,
                        ciudad          = :ciudad,
                        latitud         = :latitud,
                        longitud        = :longitud,
                        foto_perfil     = :foto_perfil
                    WHERE id = :id";

            $params = [
                'id'              => $idUsuario,
                'nombre_completo' => $datos['nombre_completo'],
                'username'        => $datos['username'],
                'anio_nacimiento' => (int)$datos['anio_nacimiento'],
                'sexo'            => $datos['sexo'],
                'pais'            => $datos['pais'],
                'ciudad'          => $datos['ciudad'],
                'latitud'         => !empty($datos['latitud']) ? $datos['latitud'] : null,
                'longitud'        => !empty($datos['longitud']) ? $datos['longitud'] : null,
                'foto_perfil'     => $nombreFoto
            ];
        } else {
            $sql = "UPDATE usuario SET
                        nombre_completo = :nombre_completo,
                        username        = :username,
                        anio_nacimiento = :anio_nacimiento,
                        sexo            = :sexo,
                        pais            = :pais,
                        ciudad          = :ciudad,
                        latitud         = :latitud,
                        longitud        = :longitud
                    WHERE id = :id";

            $params = [
                'id'              => $idUsuario,
                'nombre_completo' => $datos['nombre_completo'],
                'username'        => $datos['username'],
                'anio_nacimiento' => (int)$datos['anio_nacimiento'],
                'sexo'            => $datos['sexo'],
                'pais'            => $datos['pais'],
                'ciudad'          => $datos['ciudad'],
                'latitud'         => !empty($datos['latitud']) ? $datos['latitud'] : null,
                'longitud'        => !empty($datos['longitud']) ? $datos['longitud'] : null
            ];
        }

        return $this->database->execute($sql, $params);
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

    public function verificarPassword($idUsuario, $password)
    {
        $sql = "SELECT id FROM usuario WHERE id = :id AND password = :password";
        $resultado = $this->database->queryOne($sql, [
            'id'       => $idUsuario,
            'password' => md5($password)
        ]);

        return $resultado !== null;
    }

    public function actualizarPassword($idUsuario, $nuevaPassword)
    {
        $sql = "UPDATE usuario SET password = :password WHERE id = :id";
        return $this->database->execute($sql, [
            'id'       => $idUsuario,
            'password' => md5($nuevaPassword)
        ]);
    }

}