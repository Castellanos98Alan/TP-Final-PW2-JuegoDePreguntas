<?php

namespace app\controller;

use Redirect;

class EditorController
{
    private $model;
    private $render;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }

    private function verificarPermisos()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toLogin();
        }

        $rol = (int)($_SESSION['rol'] ?? $_SESSION['id_rol'] ?? 0);
        if ($rol !== 2 && $rol !== 3) {
            Redirect::toLobby();
        }
    }

    public function show()
    {
        $this->verificarPermisos();

        $pendientes = $this->model->getPreguntasPendientes();

        $datos = [
            'username'             => $_SESSION['username'] ?? 'Editor',
            'pendientes'           => $pendientes,
            'preguntas_pendientes' => $pendientes,
            'activas'              => $this->model->getPreguntasActivas(),
            'reportes_pendientes'  => $this->model->getReportesPendientes(),
            'animes'               => $this->model->getAnimesActivos(),
            'categorias'           => $this->model->getCategoriasActivas()
        ];

        $this->render->renderiza("editor", $datos);
    }

    public function aprobar()
    {
        $this->verificarPermisos();

        $idPregunta = $_POST['id_pregunta'] ?? $_POST['id'] ?? null;

        if ($idPregunta) {
            $this->model->aprobarPregunta((int)$idPregunta);
        }

        Redirect::toEditor();
    }

    public function rechazar()
    {
        $this->verificarPermisos();

        $idPregunta = $_POST['id_pregunta'] ?? $_POST['id'] ?? null;

        if ($idPregunta) {
            $this->model->rechazarPregunta((int)$idPregunta);
        }

        Redirect::toEditor();
    }

    public function resolverReporte()
    {
        $this->verificarPermisos();

        $idReporte = $_POST['id_reporte'] ?? null;
        $accion = $_POST['accion'] ?? 'resuelto';

        if ($idReporte) {
            $this->model->resolverReporte((int)$idReporte, $accion);
        }

        Redirect::toEditor();
    }

    public function crearPregunta()
    {
        $this->guardar();
    }

    public function guardar()
    {
        $this->verificarPermisos();

        $descripcion = trim($_POST['descripcion'] ?? '');
        $animeId     = (int)($_POST['anime_id'] ?? 0);
        $categoriaId = (int)($_POST['categoria_id'] ?? 0);
        $dificultad  = $_POST['dificultad'] ?? '';
        $opciones    = $_POST['opciones'] ?? [];
        $correcta    = isset($_POST['correcta']) ? (int)$_POST['correcta'] : -1;

        $dificultadesValidas = ['facil', 'media', 'dificil'];

        if (
            $descripcion !== '' &&
            $animeId > 0 &&
            $categoriaId > 0 &&
            in_array($dificultad, $dificultadesValidas, true) &&
            is_array($opciones) &&
            count($opciones) === 4 &&
            $correcta >= 0 &&
            $correcta <= 3
        ) {
            $this->model->crearPreguntaConOpciones(
                $descripcion,
                $animeId,
                $categoriaId,
                $dificultad,
                $opciones,
                $correcta
            );
        }

        Redirect::toEditor();
    }

    public function editar()
    {
        $this->verificarPermisos();

        $idPregunta = (int)($_GET['id'] ?? 0);
        if ($idPregunta <= 0) {
            Redirect::toEditor();
            return;
        }

        $pregunta = $this->model->getPreguntaPorId($idPregunta);

        if (!$pregunta) {
            Redirect::toEditor();
            return;
        }

        $opcionesFormateadas = [];
        if (!empty($pregunta['opciones']) && is_array($pregunta['opciones'])) {
            foreach ($pregunta['opciones'] as $opcion) {
                $opcion['checked'] = !empty($opcion['es_correcta']) ? 'checked' : '';
                $opcionesFormateadas[] = $opcion;
            }
        }

        $animes = $this->model->getAnimesActivos();
        foreach ($animes as &$anime) {
            $anime['selected'] = ($anime['id'] == $pregunta['anime_id']);
        }
        unset($anime);

        $categorias = $this->model->getCategoriasActivas();
        foreach ($categorias as &$categoria) {
            $categoria['selected'] = ($categoria['id'] == $pregunta['categoria_id']);
        }
        unset($categoria);

        $dificultades = [
            ['valor' => 'facil', 'nombre' => 'Fácil'],
            ['valor' => 'media', 'nombre' => 'Media'],
            ['valor' => 'dificil', 'nombre' => 'Difícil']
        ];

        foreach ($dificultades as &$dificultad) {
            $dificultad['selected'] = ($dificultad['valor'] === $pregunta['dificultad']);
        }
        unset($dificultad);

        $this->render->renderiza("editarPregunta", [
            'id'             => $pregunta['id'],
            'descripcion'    => $pregunta['descripcion'],
            'opciones'       => $opcionesFormateadas,
            'tiene_opciones' => !empty($opcionesFormateadas),
            'animes'         => $animes,
            'categorias'     => $categorias,
            'dificultades'   => $dificultades,
            'username'       => $_SESSION['username'] ?? 'Editor'
        ]);
    }

    public function guardarEdicion()
    {
        $this->verificarPermisos();

        $idPregunta  = (int)($_POST['id'] ?? 0);
        $descripcion = trim($_POST['descripcion'] ?? '');
        $animeId     = (int)($_POST['anime_id'] ?? 0);
        $categoriaId = (int)($_POST['categoria_id'] ?? 0);
        $dificultad  = $_POST['dificultad'] ?? '';
        $opciones    = $_POST['opciones'] ?? [];
        $correcta    = $_POST['correcta'] ?? null;

        $dificultadesValidas = ['facil', 'media', 'dificil'];

        if (
            $idPregunta > 0 &&
            $descripcion !== '' &&
            $animeId > 0 &&
            $categoriaId > 0 &&
            in_array($dificultad, $dificultadesValidas, true) &&
            is_array($opciones) &&
            $correcta !== null
        ) {
            $this->model->actualizarPregunta(
                $idPregunta,
                $descripcion,
                $animeId,
                $categoriaId,
                $dificultad,
                $opciones,
                $correcta
            );
        }

        Redirect::toEditor();
    }
}