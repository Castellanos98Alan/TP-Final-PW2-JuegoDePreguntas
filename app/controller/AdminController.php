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

    private function verificarPermisos()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toLogin();
        }

        $rol = (int)($_SESSION['rol'] ?? $_SESSION['id_rol'] ?? 0);
        if ($rol !== 3) {
            Redirect::toLobby();
        }
    }

    public function show()
    {
        $this->verificarPermisos();

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