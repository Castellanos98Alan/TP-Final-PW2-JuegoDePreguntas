<?php


namespace app\controller;

class RegistroController
{
    private $render;

    public function __construct($render)
    {
        $this->render = $render;
    }

    public function show()
    {
        $this->render->renderiza("registro");
    }
}