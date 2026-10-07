<?php

namespace app;

use app\controller\GrupoController;
use MustacheRender;
use MyDatabase;
use Router;

require_once("helper/Autoloader.php");

class Configuration
{
    public function __construct()
    {
    }

    // --- Controladores Públicos ---

/*    public function getGrupoController()
    {
        return new GrupoController(
            $this->getRender()
        );
    }
*/
    // --- Servicios de Infraestructura ---

    private function getDatabase()
    {
        $config = parse_ini_file("config/config.ini");

        return new MyDatabase(
            $config["db_host"],
            $config["db_user"],
            $config["db_pass"],
            $config["db_name"],
            $config["db_port"]
        );
    }

    private function getRender()
    {
        return new MustacheRender();
    }

    public function getRouter()
    {
        // Ruta por defecto: controlador 'grupo', método 'show'
        return new Router($this, "grupo", "show");
    }
}