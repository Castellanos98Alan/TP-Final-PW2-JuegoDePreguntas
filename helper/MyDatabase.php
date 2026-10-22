<?php

class MyDatabase
{
    private $conexion;

    public function __construct($host, $user, $pass, $db, $port)
    {
        $this->conexion = new PDO(
            "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
            $user,
            $pass
        );
    }

//    public function queryOne(string $sql)
//    {
//        Log::info($sql);
//        $resultado = $this->conexion->query($sql, PDO::FETCH_ASSOC);
//        $fila = $resultado->fetch();
//        return $fila === false ? null : $fila;
//    }

    public function queryOne(string $sql, array $parametros = [])
    {
        Log::info($sql);

        $statement = $this->conexion->prepare($sql);
        $statement->execute($parametros);

        $fila = $statement->fetch(PDO::FETCH_ASSOC);

        return $fila === false ? null : $fila;
    }

    public function queryAll(string $sql, array $parametros = [])
    {
        Log::info($sql);

        $statement = $this->conexion->prepare($sql);
        $statement->execute($parametros);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute(string $sql, array $parametros = [])
    {
        Log::info($sql);
        $statement = $this->conexion->prepare($sql);
        return $statement->execute($parametros);
    }

    public function lastInsertId()
    {
        return $this->conexion->lastInsertId();
    }
}
