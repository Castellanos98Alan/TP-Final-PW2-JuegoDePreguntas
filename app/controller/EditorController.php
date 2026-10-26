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
        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toIndex();
            exit();
        }

        if ($_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
            Redirect::toLobby();
            exit();
        }
    }

    public function show()
    {
        $this->verificarPermisos();

        $datos = [
            'username'             => $_SESSION['username'] ?? 'Editor',
            'pendientes'           => $this->model->getPreguntasPendientes(),
            'preguntas_pendientes' => $this->model->getPreguntasPendientes(),
            'activas'              => $this->model->getPreguntasActivas(),
            'reportes_pendientes'  => $this->model->getReportesPendientes()
        ];

        $this->render->renderiza("editor", $datos);
    }
    /*
        public function aprobar()
        {
            $this->verificarPermisos();

            $idPregunta = $_POST['id_pregunta'] ?? $_POST['id'] ?? null;
            if ($idPregunta) {
                $this->model->aprobarPregunta($idPregunta);
            }

            header("Location: ?controller=editor&method=show");
            exit();
        }

        public function rechazar()
        {
            $this->verificarPermisos();

            $idPregunta = $_POST['id_pregunta'] ?? $_POST['id'] ?? null;
            if ($idPregunta) {
                $this->model->inactivarPregunta($idPregunta);
            }

            header("Location: ?controller=editor&method=show");
            exit();
        }
*/
    public function resolverReporte()
    {
        $this->verificarPermisos();

        $idReporte = $_POST['id_reporte'] ?? null;
        $accion = $_POST['accion'] ?? 'resuelto';

        if ($idReporte) {
            $this->model->resolverReporte($idReporte, $accion);
        }

        header("Location: ?controller=editor&method=show");
        exit();
    }
    public function crearPregunta()
    {
        $this->guardar();
    }

    public function guardar()
    {
        $this->verificarPermisos();

        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoria = trim($_POST['categoria'] ?? 'Anime General');
        $opciones = $_POST['opciones'] ?? [];
        $correcta = (int)($_POST['correcta'] ?? 0);
        $creadorId = $_SESSION['usuario_id'] ?? null;

        if (!empty($descripcion) && is_array($opciones) && count($opciones) === 4) {
            $this->model->crearPreguntaConOpciones($descripcion, $categoria, $creadorId, $opciones, $correcta);
        }

        header("Location: ?controller=editor&method=show");
        exit();
    }

    public function editar()
    {
        $this->verificarPermisos();

        $idPregunta = $_GET['id'] ?? null;
        $pregunta = $this->model->getPreguntaPorId($idPregunta);

        if (!$pregunta) {
            header("Location: ?controller=editor&method=show");
            exit();
        }


        $opcionesFormateadas = [];
        if (!empty($pregunta['opciones'])) {
            foreach ($pregunta['opciones'] as $opc) {
                $opc['checked'] = !empty($opc['es_correcta']) ? 'checked' : '';
                $opcionesFormateadas[] = $opc;
            }
        }

        $this->render->renderiza("editarPregunta", [
            'id'          => $pregunta['id'],
            'descripcion' => $pregunta['descripcion'],
            'categoria'   => $pregunta['categoria'],
            'opciones'    => $opcionesFormateadas,
            'tiene_opciones' => !empty($opcionesFormateadas),
            'username'    => $_SESSION['username'] ?? 'Editor'
        ]);
    }

    public function guardarEdicion()
    {
        $this->verificarPermisos();

        $idPregunta = $_POST['id'] ?? null;
        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $opciones = $_POST['opciones'] ?? [];
        $idOpcionCorrecta = $_POST['correcta'] ?? null;

        if ($idPregunta && !empty($descripcion) && !empty($categoria)) {
            $this->model->actualizarPregunta($idPregunta, $descripcion, $categoria, $opciones, $idOpcionCorrecta);
        }

        header("Location: ?controller=editor&method=show");
        exit();
    }
}