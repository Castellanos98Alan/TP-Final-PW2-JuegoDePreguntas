<?php

namespace app\controller;

 use Redirect;

 class LobbyController{

     private $model;
     private $render;

     public function __construct($model, $render){
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

         if($jugador === null){
             session_destroy();
             redirect::toIndex();
         }


         $rol = $_SESSION['rol'] ?? ($jugador['id_rol'] ?? null);

         $data = [
             'username'          => $jugador['username'],
             'nombre_completo'   => $jugador['nombre_completo'],
             'foto_perfil'       => $jugador['foto_perfil'],
             'ubicacion'         => $jugador['ciudad'] . ', ' . $jugador['pais'],
             'puntaje_acumulado' => $jugador['puntaje_acumulado'],
             'posicion'          => $this->model->obtenerPosicionRanking($jugador['puntaje_acumulado']),
             'miembro_desde'     => $jugador['miembro_desde'],
             'partidas'          => $partidas,


            'es_admin'          => ($rol == 3 || $rol === 'administrador'),
            'es_editor'         => ($rol == 2 || $rol === 'editor')
         ];

         $this->render->renderiza("lobby", $data);
     }






}