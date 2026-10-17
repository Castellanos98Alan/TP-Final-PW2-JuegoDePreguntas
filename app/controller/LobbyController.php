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

         if($jugador === null){
             session_destroy();
             redirect::toIndex();
         }

         $data = [
             'username'          => $jugador['username'],
             'nombre_completo'   => $jugador['nombre_completo'],
             'foto_perfil'       => $jugador['foto_perfil'],
             'ubicacion'         => $jugador['ciudad'] . ', ' . $jugador['pais'],
             'puntaje_acumulado' => $jugador['puntaje_acumulado'],
             'posicion'          => $this->model->obtenerPosicionRanking($jugador['puntaje_acumulado']),
             'miembro_desde'     => $jugador['miembro_desde']
         ];

         $this->render->renderiza("lobby", $data);
     }






}