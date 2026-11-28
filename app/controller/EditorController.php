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

        $animes = $this->model->getTodosLosAnimes();

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

        $categoriasAdmin = $this->model->getCategoriasAdministrables();
        foreach ($categoriasAdmin as &$cat) {
            $cat['activa'] = (int)$cat['esta_activa'] === 1;
        }
        unset($cat);
        $_SESSION['csrf_categoria'] = $_SESSION['csrf_categoria'] ?? bin2hex(random_bytes(32));
        $mensajeCategoria = $_SESSION['mensaje_categoria'] ?? '';
        unset($_SESSION['mensaje_categoria']);

        $animesAdmin = $this->model->getAnimesAdministrables();

        foreach ($animesAdmin as &$anime) {
            $anime['activo'] = (int)$anime['esta_activo'] === 1;
        }

        unset($anime);

        $_SESSION['csrf_anime'] = $_SESSION['csrf_anime']
            ?? bin2hex(random_bytes(32));

        $mensajeAnime = $_SESSION['mensaje_anime'] ?? '';

        unset($_SESSION['mensaje_anime']);

        $datos = [
            'animesAdmin' => $animesAdmin,
            'csrfAnime' => $_SESSION['csrf_anime'],
            'mensajeAnime' => $mensajeAnime,
            'categoriasAdmin' => $categoriasAdmin,
            'csrfCategoria' => $_SESSION['csrf_categoria'],
            'mensajeCategoria' => $mensajeCategoria,
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

        $animes = $this->model->getTodosLosAnimes();
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


    private function validarAccionCategoria()
    {
        $this->verificarPermisos();
        $token = $_POST['csrf'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_string($token) ||
            empty($_SESSION['csrf_categoria']) || !hash_equals($_SESSION['csrf_categoria'], $token)) {
            http_response_code(403);
            exit('Acción no autorizada');
        }
    }

    public function guardarCategoria()
    {
        $this->validarAccionCategoria();
        $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
        $nombre = is_string($_POST['nombre'] ?? null) ? trim($_POST['nombre']) : '';
        $descripcion = is_string($_POST['descripcion'] ?? null) ? trim($_POST['descripcion']) : '';
        if ($id === false || $id < 0 || $nombre === '' || mb_strlen($nombre) > 100 || mb_strlen($descripcion) > 255) {
            $_SESSION['mensaje_categoria'] = 'Revisá el nombre y la descripción de la categoría.';
        } else {
            try {
                $ok = $this->model->guardarCategoria($id, $nombre, $descripcion);
                $_SESSION['mensaje_categoria'] = $ok ? 'Categoría guardada.' : 'No se pudo guardar la categoría.';
            } catch (\PDOException $e) {
                $_SESSION['mensaje_categoria'] = ($e->errorInfo[1] ?? 0) == 1062
                    ? 'Ya existe una categoría con ese nombre.' : 'No se pudo guardar la categoría.';
            }
        }
        Redirect::to('/editor#categorias');
    }

    public function cambiarEstadoCategoria()
    {
        $this->validarAccionCategoria();
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $estado = $_POST['activa'] ?? '';
        if ($id > 0 && in_array($estado, ['0', '1'], true)) {
            $ok = $this->model->cambiarEstadoCategoria($id, (int)$estado);
            $_SESSION['mensaje_categoria'] = $ok ? 'Estado actualizado.' : 'No se pudo actualizar el estado.';
        }
        Redirect::to('/editor#categorias');
    }

    private function validarAccionAnime()
    {
        $this->verificarPermisos();

        $token = $_POST['csrf'] ?? null;

        if (
            $_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !is_string($token) ||
            empty($_SESSION['csrf_anime']) ||
            !hash_equals($_SESSION['csrf_anime'], $token)
        ) {
            http_response_code(403);
            exit('Acción no autorizada');
        }
    }

    public function guardarAnime()
    {
        $this->validarAccionAnime();

        $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');

        if ($id === false || $id < 0 || $nombre === '' || mb_strlen($nombre) > 100) {
            $_SESSION['mensaje_anime'] = 'Ingresá un nombre válido.';
            Redirect::to('/editor#animes');
            return;
        }

        try {
            $imagen = $this->obtenerImagenActualAnime($id);

            if (isset($_FILES['imagen']) &&
                $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {

                $imagen = $this->subirImagenAnime($_FILES['imagen']);
            }

            if ($imagen === '') {
                throw new \RuntimeException('Debés seleccionar una imagen.');
            }

            $ok = $this->model->guardarAnime($id, $nombre, $imagen);

            $_SESSION['mensaje_anime'] = $ok
                ? 'Anime guardado correctamente.'
                : 'No se pudo guardar el anime.';

        } catch (\PDOException $e) {
            $_SESSION['mensaje_anime'] = 'No se pudo guardar el anime.';

        } catch (\RuntimeException $e) {
            $_SESSION['mensaje_anime'] = $e->getMessage();
        }

        Redirect::to('/editor#animes');
    }

    private function obtenerImagenActualAnime($id)
    {
        if ($id === 0) {
            return '';
        }

        foreach ($this->model->getAnimesAdministrables() as $anime) {
            if ((int)$anime['id'] === $id) {
                return $anime['imagen'];
            }
        }

        throw new \RuntimeException('El anime no existe.');
    }

    private function subirImagenAnime($archivo)
    {
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Error al cargar la imagen.');
        }

        if ($archivo['size'] > 5 * 1024 * 1024) {
            throw new \RuntimeException('La imagen supera los 5 MB.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $tipo = $finfo->file($archivo['tmp_name']);

        $permitidos = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg',
            'image/webp' => 'webp'
        ];

        if (!isset($permitidos[$tipo])) {
            throw new \RuntimeException('Formato de imagen no permitido.');
        }

        $nombreArchivo = uniqid('anime_') . '.' . $permitidos[$tipo];

        $destino = __DIR__ . '/../../public/img-animes/' . $nombreArchivo;

        if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
            throw new \RuntimeException('No se pudo guardar la imagen.');
        }

        return $nombreArchivo;
    }

    public function cambiarEstadoAnime()
    {
        $this->validarAccionAnime();

        $id = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';

        if ($id <= 0 || !in_array($estado, ['0', '1'], true)) {
            $_SESSION['mensaje_anime'] = 'Datos inválidos.';
            Redirect::to('/editor#animes');
            return;
        }

        $anime = $this->model->getAnimePorId($id);

        if (!$anime) {
            $_SESSION['mensaje_anime'] = 'El anime no existe.';
            Redirect::to('/editor#animes');
            return;
        }

        if ((int)$estado === 1) {

            $cantidad = $this->model
                ->contarPreguntasActivasPorAnime($id);

            if ($cantidad === 0) {
                $_SESSION['mensaje_anime'] =
                    'El anime no tiene preguntas disponibles.';

                Redirect::to('/editor#animes');
                return;
            }
        }

        $ok = $this->model->cambiarEstadoAnime(
            $id,
            (int)$estado
        );

        $_SESSION['mensaje_anime'] = $ok
            ? 'Estado del anime actualizado.'
            : 'No se pudo actualizar el estado.';

        Redirect::to('/editor#animes');
    }



}
