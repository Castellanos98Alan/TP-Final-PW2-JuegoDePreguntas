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
            "nombre_grupo" => "Grupo Los Crack de Messi",
            "participantes" => [
                ["nombre" => "Arrojas Brian Arian"],
                ["nombre" => "Castellano Alan"],
                ["nombre" => "Frias Uriel"],
                ["nombre" => "Gaete Axel"],
                ["nombre" => "Ibañez Juan"]
            ]
        ];
        $this->render->renderiza("grupo", $data);
    }
}