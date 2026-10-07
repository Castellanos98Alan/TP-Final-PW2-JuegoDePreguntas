<?php
namespace app\controller;
class GrupoController{
    private $render;
    public function __construct($render)
    {
        $this->render = $render;
    }
    public function show()
    {
        $data = [
            "mensaje" => "Grupo TP Programación Web 2",
            "integrantes" => [
                ["nombre" => "Arrojas Brian Arian"],
                ["nombre" => "Castellano Alan"],
                ["nombre" => "Frias Uriel"],
                ["nombre" => "Gaete Axel"],
                ["nombre" => "Ibañez Juan"]
            ]
        ];
        $this->render->renderiza("Grupo", $data);
    }
}