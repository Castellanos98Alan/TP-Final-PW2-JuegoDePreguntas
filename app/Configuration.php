<?php

namespace app;

use app\controller\LoginController;
use app\controller\LobbyController;
use app\controller\PartidaController;
use app\model\LoginModel;
use app\model\LobbyModel;
use app\model\PartidaModel;
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

    public function getLoginController()
    {
        return new LoginController(
            $this->getLoginModel(),
            $this->getRender()
        );
    }

    public function getLobbyController()
    {
        return new LobbyController(
            $this->getLobbyModel(),
            $this->getRender()
        );
    }

    public function getPartidaController()
    {
        return new PartidaController(
            $this->getPartidaModel(),
            $this->getRender()
        );
    }

    // --- Modelos Privados ---

    private function getLoginModel()
    {
        return new LoginModel(
            $this->getDatabase()
        );
    }

    private function getLobbyModel()
    {
        return new LobbyModel(
            $this->getDatabase()
        );
    }

    private function getPartidaModel()
    {
        return new PartidaModel(
            $this->getDatabase()
        );
    }

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
        // Ruta por defecto: controlador 'login', método 'show'
        return new Router($this, "login", "show");
    }
}