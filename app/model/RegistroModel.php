<?php

namespace app\model;

class RegistroModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function registrarUsuario($datos, $foto){
        if ($this->existeUsername($datos['username'])) {
            return [
                'exito' => false,
                'error' => 'El nombre de usuario ya se encuentra registrado.'
            ];
        }

        if ($this->existeMail($datos['email'])) {
            return [
                'exito' => false,
                'error' => 'El correo electrónico ya se encuentra registrado.'
            ];
        }

        $nombreFoto = $this->guardarFoto($foto);
        if (!$nombreFoto) {
            return [
                'exito' => false,
                'error' => 'Hubo un problema al guardar la foto de perfil en el servidor.'
            ];
        }

        $passwordHash = md5($datos['password']);
        $token = bin2hex(random_bytes(32));

        $sql = "INSERT INTO usuario (
            nombre_completo, 
            anio_nacimiento, 
            sexo, 
            pais, 
            ciudad,
            latitud, 
            longitud,
            email, 
            username, 
            password, 
            foto_perfil, 
            esta_activo, 
            id_rol, 
            puntaje_acumulado,
            token_validacion
        ) VALUES (
            :nombre_completo,
            :anio_nacimiento,
            :sexo,
            :pais,
            :ciudad,
            :latitud,
            :longitud,
            :email,
            :username,
            :password,
            :foto_perfil,
            0,
            1,
            0,
            :token_validacion
        )";

        $parametros = [
            'nombre_completo' => $datos['nombre_completo'],
            'anio_nacimiento' => (int)$datos['anio_nacimiento'],
            'sexo'            => $datos['sexo'],
            'pais'            => $datos['pais'],
            'ciudad'          => $datos['ciudad'],
            'latitud'         => !empty($datos['latitud']) ? $datos['latitud'] : null,
            'longitud'        => !empty($datos['longitud']) ? $datos['longitud'] : null,
            'email'           => $datos['email'],
            'username'        => $datos['username'],
            'password'        => $passwordHash,
            'foto_perfil'     => $nombreFoto,
            'token_validacion'=> $token
        ];

        $this->database->execute($sql, $parametros);

        return ['exito' => true, 'token' => $token];
    }


    private function existeUsername($username){
        $sql = "SELECT id FROM usuario WHERE username = :username";
        return $this->database->queryOne($sql, ['username' => $username]) !== null;
    }

    private function existeMail($email){
        $sql = "SELECT id FROM usuario WHERE email = :email";
        return $this->database->queryOne($sql, ['email' => $email]) !== null;
    }


    private function guardarFoto($foto){
        $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $nombreUnico = uniqid("perfil_", true) . "." . $extension;

        $destino = "public/" . $nombreUnico;

        if (move_uploaded_file($foto['tmp_name'], $destino)) {
            return $nombreUnico;
        }

        return null;
    }

    public function activarCuenta($token)
    {
        $sql = "SELECT id FROM usuario WHERE token_validacion = :token";
        $usuario = $this->database->queryOne($sql, ['token' => $token]);

        if ($usuario) {
            $updateSql = "UPDATE usuario SET esta_activo = 1, token_validacion = NULL WHERE id = :id";
            $this->database->execute($updateSql, ['id' => $usuario['id']]);
            return true;
        }

        return false;
    }

}