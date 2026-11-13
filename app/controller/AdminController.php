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

        $periodo = $_GET['periodo'] ?? 'mes';

        if (!in_array($periodo, ['dia', 'semana', 'mes', 'anio'], true)) {
            $periodo = 'mes';
        }

        $reporte = [
            'total_jugadores' => $this->model->getTotalJugadores(),

            // Partidas finalizadas según el período seleccionado.
            'total_partidas' => $this->model->getPartidasJugadas($periodo),

            'preguntas_activas' => $this->model->getTotalPreguntasActivas(),
            'reportes_pendientes' => $this->model->getTotalReportesPendientes(),

            'preguntas_creadas' => $this->model->getPreguntasCreadas($periodo),
            'usuarios_nuevos' => $this->model->getUsuariosNuevos($periodo),
            'porcentaje_correctas' => $this->model->getPorcentajeCorrectas($periodo),

            'preguntas' => $this->model->getEstadisticasPreguntas(),

            'paises_json' => json_encode($this->model->getUsuariosPorPais($periodo)),
            'sexos_json' => json_encode($this->model->getUsuariosPorSexo($periodo)),
            'edades_json' => json_encode($this->model->getUsuariosPorEdad($periodo)),

            'username' => $_SESSION['usuario'] ?? $_SESSION['username'] ?? 'Administrador',

            'es_dia' => $periodo === 'dia',
            'es_semana' => $periodo === 'semana',
            'es_mes' => $periodo === 'mes',
            'es_anio' => $periodo === 'anio'
        ];

        $this->render->renderiza('admin', $reporte);
    }
}
