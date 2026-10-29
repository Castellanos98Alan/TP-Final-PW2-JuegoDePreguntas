<?php

namespace app;

use app\controller\PerfilController;
use app\controller\RegistroController;
use app\controller\LoginController;
use app\controller\LobbyController;
use app\controller\PartidaController;
use app\controller\GrupoController;
use app\controller\AdminController;
use app\controller\EditorController;
use app\controller\RankingController;

use app\model\LoginModel;
use app\model\LobbyModel;
use app\model\PartidaModel;
use app\model\PerfilModel;
use app\model\RegistroModel;
use app\model\AdminModel;
use app\model\EditorModel;
use MustacheRender;
use MyDatabase;
use Router;
use app\model\RankingModel;

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

    public function getAdminController()
    {
        return new AdminController(
            $this->getAdminModel(),
            $this->getRender()
        );
    }

    public function getEditorController()
    {
        return new EditorController(
            $this->getEditorModel(),
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

    private function getAdminModel()
    {
        return new AdminModel(
            $this->getDatabase()
        );
    }

    private function getEditorModel()
    {
        return new EditorModel(
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

    public function getGrupoController()
    {
        return new GrupoController(
            $this->getRender()
        );
    }
    private function getRegistroModel(){
        return new RegistroModel(
            $this->getDatabase());
    }
    public function getRegistroController()
    {
        return new RegistroController(
            $this->getRegistroModel(),
            $this->getRender()
        );
    }

    private function getPerfilModel()
    {
        return new PerfilModel(
            $this->getDatabase()
        );
    }

    public function getPerfilController()
    {
        return new PerfilController(
            $this->getPerfilModel(),
            $this->getRender()
        );
    }
    public function getRankingController()
    {
        return new RankingController(
            $this->getRankingModel(),
            $this->getRender()
        );
    }

    private function getRankingModel()
    {
        return new RankingModel(
            $this->getDatabase()
        );
    }
}