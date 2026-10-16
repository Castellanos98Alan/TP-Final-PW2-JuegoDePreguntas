<?php

namespace app\controller;

 use Redirect;

 class LobbyController{

     public function show()
     {
         if (!isset($_SESSION['usuario_id'])) {
             Redirect::toIndex();
         }

     }






}