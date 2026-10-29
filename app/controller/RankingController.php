<?php

namespace app\controller;

use Redirect;

class RankingController
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

        $jugadores = $this->model->obtenerRankingJugadores();
        $idUsuarioActual = (int)$_SESSION['usuario_id'];


        $posicion = 1;
        foreach ($jugadores as &$jugador) {
            $jugador['posicion'] = $posicion;
            $jugador['es_podio'] = ($posicion <= 3);
            $jugador['es_primero'] = ($posicion === 1);
            $jugador['es_segundo'] = ($posicion === 2);
            $jugador['es_tercero'] = ($posicion === 3);
            $jugador['es_usuario_actual'] = ((int)$jugador['id'] === $idUsuarioActual);

            $foto = !empty($jugador['foto_perfil']) ? $jugador['foto_perfil'] : 'default.png';
            if (!file_exists('public/' . $foto)) {
                $foto = 'FondoPerfilLuffy.png';
            }
            $jugador['foto_perfil'] = $foto;

            $posicion++;
        }
        unset($jugador);

        $data = [
            'hay_jugadores' => !empty($jugadores),
            'jugadores'     => $jugadores
        ];

        $this->render->renderiza("ranking", $data);
    }
}