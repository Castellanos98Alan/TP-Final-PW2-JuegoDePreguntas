<?php

namespace app\controller;

use Redirect;

class BuscadorController
{
    private $model;
    private $render;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }

    public function show()
    {
        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toIndex();
            return;
        }

        $idPropio = (int)$_SESSION['usuario_id'];
        $orden = $_GET['orden'] ?? 'username';
        $jugadores = $this->model->obtenerJugadores($orden);

        $lista = [];
        foreach ($jugadores as $jugador) {
            $lista[] = [
                'id' => $jugador['id'],
                'username' => $jugador['username'],
                'nombre_completo' => $jugador['nombre_completo'],
                'foto_perfil' => $this->resolverFoto($jugador['foto_perfil']),
                'ubicacion' => $jugador['ciudad'] . ', ' . $jugador['pais'],
                'puntaje_acumulado' => $jugador['puntaje_acumulado'],
                'posicion' => $jugador['posicion'],
                'es_propio' => (int)$jugador['id'] === $idPropio
            ];
        }

        $this->render->renderiza("buscador", [
            'jugadores' => $lista,
            'total' => count($lista)
        ]);
    }

    private function resolverFoto($nombreFoto)
    {
        $ruta = 'public/' . (!empty($nombreFoto) ? $nombreFoto : 'default.png');

        if (!file_exists($ruta)) {
            $ruta = 'public/FondoPerfilLuffy.png';
        }

        return $ruta;
    }
}
