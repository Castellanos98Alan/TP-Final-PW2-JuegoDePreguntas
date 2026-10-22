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

        $this->render->renderiza("admin");
    }
}