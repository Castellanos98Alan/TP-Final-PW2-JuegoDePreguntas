<?php

namespace app\controller;

use Redirect;

class LobbyController
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
            $this->render->renderiza("home");
            return;
        }

        $jugador = $this->model->obtenerDatosDelJugador($_SESSION['usuario_id']);
        $partidas = $this->model->obtenerPartidasDelJugador($_SESSION['usuario_id']);

        if ($jugador === null) {
            session_destroy();
            redirect::toIndex();
            return;
        }

        // Obtener el rol del usuario
        $rol = $_SESSION['rol'] ?? ($jugador['id_rol'] ?? null);

        // Identificar los roles
        $esAdmin = ($rol == 3 || strtolower((string)$rol) === 'administrador');
        $esEditor = ($rol == 2 || strtolower((string)$rol) === 'editor');

        // Solamente jugadores pueden jugar
        $puedeJugar = !$esAdmin && !$esEditor;

        $data = [
            'username' => $jugador['username'],
            'nombre_completo' => $jugador['nombre_completo'],
            'foto_perfil' => $jugador['foto_perfil'],
            'ubicacion' => $jugador['ciudad'] . ', ' . $jugador['pais'],
            'puntaje_acumulado' => $jugador['puntaje_acumulado'],
            'posicion' => $this->model->obtenerPosicionRanking($_SESSION['usuario_id']),
            'miembro_desde' => $jugador['miembro_desde'],
            'partidas' => $partidas,

            'es_admin' => $esAdmin,
            'es_editor' => $esEditor,
            'puede_jugar' => $puedeJugar
        ];

        $this->render->renderiza("lobby", $data);
    }
}
