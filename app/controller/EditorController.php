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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['limpiar_filtros'])) {
                unset($_SESSION['filtros_editor']);
            } else {
                $_SESSION['filtros_editor'] = [
                    'busqueda' => trim($_POST['busqueda'] ?? ''),
                    'anime_id' => max(0, (int)($_POST['anime_id'] ?? 0)),
                    'categoria_id' => max(0, (int)($_POST['categoria_id'] ?? 0)),
                    'estado' => $_POST['estado'] ?? ''
                ];
            }

            Redirect::to('/editor');
            return;
        }

        $pendientes = $this->model->getPreguntasPendientes();

        $pagina = max(1, (int)($_GET['pagina'] ?? 1));

        $filtros = $_SESSION['filtros_editor'] ?? [];

        $busqueda = $filtros['busqueda'] ?? '';
        $animeId = $filtros['anime_id'] ?? 0;
        $categoriaId = $filtros['categoria_id'] ?? 0;
        $estado = $filtros['estado'] ?? '';

        $estadosValidos = ['', 'activa', 'inactiva', 'rechazada', 'reportada'];

        if (!in_array($estado, $estadosValidos, true)) {
            $estado = '';
        }

        $totalPreguntas = $this->model->contarPreguntasAdministrables(
            $busqueda,
            $animeId,
            $categoriaId,
            $estado
        );

        $totalPaginas = max(1, (int)ceil($totalPreguntas / 10));

        $pagina = min($pagina, $totalPaginas);

        $preguntas = $this->model->getPreguntasAdministrables(
            $pagina,
            $busqueda,
            $animeId,
            $categoriaId,
            $estado
        );

        foreach ($preguntas as &$pregunta) {

            $pregunta['activa'] =
                ((int)$pregunta['esta_activa'] === 1);

            $pregunta['bloqueadaPorReportes'] =
                (($pregunta['estado_revision'] ?? '') === 'Baja por reportes');

            $pregunta['rechazada'] =
                (($pregunta['estado_revision'] ?? '') === 'Rechazada');

            $pregunta['inactiva'] =
                !$pregunta['activa'] &&
                !$pregunta['bloqueadaPorReportes'] &&
                !$pregunta['rechazada'];

            $pregunta['estadoTexto'] = 'Activa';

            if ($pregunta['bloqueadaPorReportes']) {
                $pregunta['estadoTexto'] = 'Reportada';
            } elseif ($pregunta['rechazada']) {
                $pregunta['estadoTexto'] = 'Rechazada';
            } elseif ($pregunta['inactiva']) {
                $pregunta['estadoTexto'] = 'Inactiva';
            }

            $pregunta['estadoActiva'] = $pregunta['activa'];
            $pregunta['estadoReportada'] = $pregunta['bloqueadaPorReportes'];
            $pregunta['estadoRechazada'] = $pregunta['rechazada'];
            $pregunta['estadoInactiva'] = $pregunta['inactiva'];
        }




        $paginaAnterior = $pagina - 1;
        $paginaSiguiente = $pagina + 1;

        $hayAnterior = $pagina > 1;
        $haySiguiente = $pagina < $totalPaginas;

        unset($pregunta);

        // conservar los datos

        $animes = $this->model->getAnimesActivos();

        foreach ($animes as &$anime) {
            $anime['selected'] = ((int)$anime['id'] === $animeId);
        }
        unset($anime);

        $categorias = $this->model->getCategoriasActivas();

        foreach ($categorias as &$categoria) {
            $categoria['selected'] = ((int)$categoria['id'] === $categoriaId);
        }
        unset($categoria);

        $filtrosUrl = http_build_query([
            'busqueda' => $busqueda,
            'anime_id' => $animeId,
            'categoria_id' => $categoriaId,
            'estado' => $estado
        ]);

        $paginaAnteriorUrl = 'editor?pagina=' . $paginaAnterior . '&' . $filtrosUrl;
        $paginaSiguienteUrl = 'editor?pagina=' . $paginaSiguiente . '&' . $filtrosUrl;

        $datos = [
            'username' => $_SESSION['username'] ?? 'Editor',
            'pendientes' => $pendientes,
            'preguntas_pendientes' => $pendientes,
            'activas' => $preguntas,
            'reportes_pendientes' => $this->model->getReportesPendientes(),
            'animes' => $animes,
            'categorias' => $categorias,
            'busqueda' => $busqueda,
            'animeSeleccionado' => $animeId,
            'categoriaSeleccionada' => $categoriaId,
            'estadoActivo' => ($estado === 'activa'),
            'estadoInactivo' => ($estado === 'inactiva'),
            'estadoRechazado' => ($estado === 'rechazada'),
            'estadoReportado' => ($estado === 'reportada'),
            'activas' => $preguntas,
            'paginaActual' => $pagina,
            'totalPaginas' => $totalPaginas,
            'hayAnterior' => $hayAnterior,
            'haySiguiente' => $haySiguiente,
            'paginaAnterior' => $paginaAnterior,
            'paginaSiguiente' => $paginaSiguiente,
            'paginaAnteriorUrl' => $paginaAnteriorUrl,
            'paginaSiguienteUrl' => $paginaSiguienteUrl,
            'preguntas_baja_reportes' => $this->model->getPreguntasBajaPorReportes(),

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
        $animeId = (int)($_POST['anime_id'] ?? 0);
        $categoriaId = (int)($_POST['categoria_id'] ?? 0);
        $dificultad = 'media';
        $opciones = $_POST['opciones'] ?? [];
        $correcta = isset($_POST['correcta']) ? (int)$_POST['correcta'] : -1;

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

        $tipoPregunta = strtolower(trim($pregunta['tipo_pregunta'] ?? ''));
        $recurso = $pregunta['recurso'] ?? '';

        $esImagen = false;
        $esAudio = false;

        if ($recurso !== '') {
            $esImagen = in_array($tipoPregunta, ['imagen', 'silueta', 'objeto', 'recompensa'], true);
            $esAudio = ($tipoPregunta === 'audio');
        }

        $recursoUrl = '';

        if ($recurso !== '') {
            $recursoUrl = '/Preguntados/' . ltrim($recurso, '/');
        }

        if (!$pregunta) {
            Redirect::toEditor();
            return;
        }

        $esBajaPorReportes =
            $pregunta['estado_revision'] === 'Baja por reportes';

        $reportes = [];

        if ($esBajaPorReportes) {
            $reportes = $this->model->getReportesPorPregunta($idPregunta);
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
            'id' => $pregunta['id'],
            'descripcion' => $pregunta['descripcion'],
            'opciones' => $opcionesFormateadas,
            'tiene_opciones' => !empty($opcionesFormateadas),
            'animes' => $animes,
            'categorias' => $categorias,
            'dificultades' => $dificultades,
            'username' => $_SESSION['username'] ?? 'Editor',
            'esImagen' => $esImagen,
            'esAudio' => $esAudio,
            'recursoUrl' => $recursoUrl,
            'esBajaPorReportes' => $esBajaPorReportes,
            'reportes' => $reportes,
            'cantidadReportes' => count($reportes),
        ]);
    }

    public function guardarEdicion()
    {
        $this->verificarPermisos();

        $idPregunta = (int)($_POST['id'] ?? 0);
        $descripcion = trim($_POST['descripcion'] ?? '');
        $animeId = (int)($_POST['anime_id'] ?? 0);
        $categoriaId = (int)($_POST['categoria_id'] ?? 0);
        $dificultad = $_POST['dificultad'] ?? '';
        $opciones = $_POST['opciones'] ?? [];
        $correcta = $_POST['correcta'] ?? null;

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

    public function desactivar()
    {
        $this->verificarPermisos();

        $idPregunta = (int)($_POST['id_pregunta'] ?? 0);

        if ($idPregunta > 0) {
            $this->model->desactivarPregunta($idPregunta);
        }

        Redirect::toEditor();
    }

    public function reactivar()
    {
        $this->verificarPermisos();

        $idPregunta = (int)($_POST['id_pregunta'] ?? 0);

        if ($idPregunta > 0) {
            $this->model->reactivarPregunta($idPregunta);
        }

        Redirect::toEditor();
    }

    public function revisarPreguntaReportada()
    {
        $this->verificarPermisos();

        $idPregunta = (int)($_POST['id_pregunta'] ?? 0);
        $accion = $_POST['accion'] ?? '';

        if ($idPregunta <= 0) {
            Redirect::toEditor();
            return;
        }

        if ($accion === 'aprobar') {
            $this->model->aprobarPreguntaReportada($idPregunta);
            $this->model->cerrarReportesPregunta($idPregunta, 'Descartado');
        }

        if ($accion === 'mantener_baja') {
            $this->model->mantenerBajaPreguntaReportada($idPregunta);
            $this->model->cerrarReportesPregunta($idPregunta, 'Revisado');
        }

        Redirect::toEditor();
    }


    public function recuperarRechazada()
    {
        $this->verificarPermisos();

        $idPregunta = (int)($_POST['id_pregunta'] ?? 0);

        if ($idPregunta > 0) {
            $this->model->recuperarPreguntaRechazada($idPregunta);
        }

        Redirect::toEditor();
    }

}