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
            $_SESSION['login_error'] = true;
            Redirect::to('/login');
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario'] = $usuario['username'];
        $_SESSION['rol'] = $usuario['id_rol'];
        $_SESSION['foto_perfil'] = $usuario['foto_perfil'];

        switch ($usuario['id_rol']) {

            case 1:
                Redirect::to('/lobby');
                break;

            case 2:
                Redirect::to('/editor');
                break;

            case 3:
                Redirect::to('/admin');
                break;

            default:
                Redirect::toIndex();
                break;
        }
    }

    public function show()
    {
        if (isset($_SESSION['usuario_id'])) {
            Redirect::toLobby();
        }

        $registroPendiente = !empty($_SESSION['registro_pendiente']);
        $cuentaActivada    = !empty($_SESSION['cuenta_activada']);
        $loginError        = !empty($_SESSION['login_error']);

        unset($_SESSION['registro_pendiente'], $_SESSION['cuenta_activada'], $_SESSION['login_error']);

        $data = [
            'login_error'        => $loginError,
            'registro_pendiente' => $registroPendiente,
            'cuenta_activada'    => $cuentaActivada
        ];

        $this->render->renderiza("login", $data);
    }


    public function logout()
    {
        session_destroy();
        Redirect::toIndex();
    }
}
