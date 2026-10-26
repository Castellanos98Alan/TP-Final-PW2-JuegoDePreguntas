<?php

namespace app\controller;

use Redirect;

class AdminController
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

        if ($_SESSION['rol'] != 3) {
            Redirect::toLobby();
            return;
        }

        $datos = [
            'total_jugadores'     => $this->model->getTotalJugadores(),
            'total_partidas'      => $this->model->getTotalPartidas(),
            'preguntas_activas'   => $this->model->getTotalPreguntasActivas(),
            'reportes_pendientes' => $this->model->getTotalReportesPendientes(),
            'preguntas'           => $this->model->getEstadisticasPreguntas(),
            'username'            => $_SESSION['username'] ?? 'Administrador'
        ];

        $this->render->renderiza("admin", $datos);
    }
}