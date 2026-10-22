<?php

namespace app\controller;

use Redirect;
use Request;

class LoginController
{
    private $model;
    private $render;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }

    public function login()
    {
        $usuario = $this->model->autenticar(Request::post('usuario'), Request::post('password'));

        if ($usuario === null) {
            Redirect::to('/?login_error=1');
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario'] = $usuario['username'];

        Redirect::toLobby();
    }

    public function show()
    {
        if (isset($_SESSION['usuario_id'])) {
            Redirect::toLobby();
        }

        $data = [
            'login_error'        => Request::get('login_error') === '1',
            'registro_pendiente' => Request::get('registro_pendiente') === '1',
            'cuenta_activada'    => Request::get('cuenta_activada') === '1'
        ];

        $this->render->renderiza("login", $data);
    }


    public function logout()
    {
        session_destroy();
        Redirect::toIndex();
    }
}
