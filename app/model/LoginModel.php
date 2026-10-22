<?php

namespace app\model;
class LoginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

//    public function autenticar($usuario, $password)
//    {
//        $passwordHash = md5($password);
//
//        $sql = "SELECT id, username
//            FROM usuario
//            WHERE username = '$usuario'
//            AND password = '$passwordHash'
//            AND esta_activo = 1";
//
//        return $this->database->queryOne($sql);
//    }

    public function autenticar($usuario, $password)
    {
        $passwordHash = md5($password);

        $sql = "SELECT id, username, id_rol
        FROM usuario
        WHERE username = :usuario
        AND password = :password
        AND esta_activo = 1";

        return $this->database->queryOne(
            $sql,
            [
                'usuario' => $usuario,
                'password' => $passwordHash
            ]
        );
    }

}
