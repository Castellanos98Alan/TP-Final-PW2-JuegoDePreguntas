<?php

namespace app\controller;

use Redirect;

class AdminController
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

        if ($rol !== 3) {
            Redirect::toLobby();
        }
    }

    private function armarOpciones(array $lista, $seleccionado)
    {
        $opciones = [];

        foreach ($lista as $valor => $texto) {
            $opciones[] = [
                'valor' => $valor,
                'texto' => $texto,
                'seleccionada' => (string)$valor === (string)$seleccionado
            ];
        }

        return $opciones;
    }

    public function show()
    {
        $this->verificarPermisos();

        $periodo = $_GET['periodo'] ?? 'mes';

        if (!in_array($periodo, ['dia', 'semana', 'mes', 'anio'], true)) {
            $periodo = 'mes';
        }

        // Filtros de la tabla de preguntas.
        $categoriaId = $_GET['categoria'] ?? '';
        $categoriaId = (is_string($categoriaId) && ctype_digit($categoriaId) && (int)$categoriaId > 0)
            ? (int)$categoriaId
            : null;

        $animeId = $_GET['anime'] ?? '';
        $animeId = (is_string($animeId) && ctype_digit($animeId) && (int)$animeId > 0)
            ? (int)$animeId
            : null;

        $listaDificultades = [
            '' => 'Todas',
            'facil' => 'Fácil',
            'media' => 'Media',
            'dificil' => 'Difícil'
        ];

        $dificultad = $_GET['dificultad'] ?? '';
        if (!is_string($dificultad) || $dificultad === '' || !isset($listaDificultades[$dificultad])) {
            $dificultad = null;
        }

        $listaOrdenes = [
            '' => 'Orden original',
            'jugada_desc' => 'Jugada (mayor a menor)',
            'jugada_asc' => 'Jugada (menor a mayor)',
            'acertada_desc' => 'Acertada (mayor a menor)',
            'acertada_asc' => 'Acertada (menor a mayor)',
            'exito_desc' => '% Éxito (mayor a menor)',
            'exito_asc' => '% Éxito (menor a mayor)'
        ];

        $orden = $_GET['orden'] ?? '';
        if (!is_string($orden) || $orden === '' || !isset($listaOrdenes[$orden])) {
            $orden = null;
        }

        $listaCategorias = ['' => 'Todas'];
        foreach ($this->model->getCategorias() as $categoria) {
            $listaCategorias[$categoria['id']] = $categoria['nombre'];
        }

        $listaAnimes = ['' => 'Todos'];
        foreach ($this->model->getAnimes() as $anime) {
            $listaAnimes[$anime['id']] = $anime['nombre'];
        }

        // Paginación de la tabla de preguntas (10 por página, igual que en Editor).
        $porPagina = 10;
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));

        $totalPreguntas = $this->model->contarEstadisticasPreguntas($periodo, $categoriaId, $dificultad, $animeId);
        $totalPaginas = max(1, (int)ceil($totalPreguntas / $porPagina));
        $pagina = min($pagina, $totalPaginas);

        $preguntas = $this->model->getEstadisticasPreguntas(
            $periodo,
            $categoriaId,
            $dificultad,
            $orden,
            $animeId,
            $pagina,
            $porPagina
        );

        $paginaAnterior = $pagina - 1;
        $paginaSiguiente = $pagina + 1;

        $paramsBase = array_filter([
            'periodo' => $periodo,
            'anime' => $animeId,
            'categoria' => $categoriaId,
            'dificultad' => $dificultad,
            'orden' => $orden,
        ], static function ($v) {
            return $v !== null && $v !== '';
        });

        $paginaAnteriorUrl = 'admin?' . http_build_query($paramsBase + ['pagina' => $paginaAnterior]) . '#balance-preguntas';
        $paginaSiguienteUrl = 'admin?' . http_build_query($paramsBase + ['pagina' => $paginaSiguiente]) . '#balance-preguntas';

        $reporte = [
            'total_jugadores' => $this->model->getTotalJugadores(),

            // Partidas finalizadas según el período seleccionado.
            'total_partidas' => $this->model->getPartidasJugadas($periodo),

            'preguntas_activas' => $this->model->getTotalPreguntasActivas(),
            'reportes_pendientes' => $this->model->getTotalReportesPendientes(),

            'preguntas_creadas' => $this->model->getPreguntasCreadas($periodo),
            'usuarios_nuevos' => $this->model->getUsuariosNuevos($periodo),
            'porcentaje_correctas' => $this->model->getPorcentajeCorrectas($periodo),

            'preguntas' => $preguntas,
            'cantidad_preguntas' => $totalPreguntas,

            'paginaActual' => $pagina,
            'totalPaginas' => $totalPaginas,
            'hayAnterior' => $pagina > 1,
            'haySiguiente' => $pagina < $totalPaginas,
            'paginaAnteriorUrl' => $paginaAnteriorUrl,
            'paginaSiguienteUrl' => $paginaSiguienteUrl,

            'animes' => $this->armarOpciones($listaAnimes, $animeId),
            'categorias' => $this->armarOpciones($listaCategorias, $categoriaId),
            'dificultades' => $this->armarOpciones($listaDificultades, $dificultad),
            'ordenes' => $this->armarOpciones($listaOrdenes, $orden),
            'periodo' => $periodo,

            'paises_json' => json_encode($this->model->getUsuariosPorPais($periodo)),
            'sexos_json' => json_encode($this->model->getUsuariosPorSexo($periodo)),
            'edades_json' => json_encode($this->model->getUsuariosPorEdad($periodo)),

            'username' => $_SESSION['usuario'] ?? $_SESSION['username'] ?? 'Administrador',

            'es_dia' => $periodo === 'dia',
            'es_semana' => $periodo === 'semana',
            'es_mes' => $periodo === 'mes',
            'es_anio' => $periodo === 'anio'
        ];

        $this->render->renderiza('admin', $reporte);
    }

    public function descargarPdf()
    {
        $this->verificarPermisos();

        $periodo = $_GET['periodo'] ?? 'mes';
        if (!in_array($periodo, ['dia', 'semana', 'mes', 'anio'], true)) {
            $periodo = 'mes';
        }

        $categoriaId = $_GET['categoria'] ?? null;
        $categoriaId = ($categoriaId !== null && $categoriaId !== '' && ctype_digit((string)$categoriaId) && (int)$categoriaId > 0)
            ? (int)$categoriaId
            : null;

        $animeId = $_GET['anime'] ?? null;
        $animeId = ($animeId !== null && $animeId !== '' && ctype_digit((string)$animeId) && (int)$animeId > 0)
            ? (int)$animeId
            : null;

        $dificultad = $_GET['dificultad'] ?? null;
        if (!in_array($dificultad, ['facil', 'media', 'dificil'], true)) {
            $dificultad = null;
        }

        $orden = $_GET['orden'] ?? 'jugada_desc';
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));

        $preguntas = $this->model->getEstadisticasPreguntas(
            $periodo,
            $categoriaId,
            $dificultad,
            $orden,
            $animeId,
            $pagina,
            10
        );

        $paises = $this->model->getUsuariosPorPais($periodo);
        $sexos = $this->model->getUsuariosPorSexo($periodo);
        $edades = $this->model->getUsuariosPorEdad($periodo);

        $graficoPaisesUrl = '';
        if (!empty($paises)) {
            $chartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => array_column($paises, 'etiqueta'),
                    'datasets' => [[
                        'label' => 'Usuarios',
                        'data' => array_map('intval', array_column($paises, 'cantidad')),
                        'backgroundColor' => '#4F8EDC'
                    ]]
                ],
                'options' => [
                    'legend' => ['display' => false],
                    'scales' => ['yAxes' => [['ticks' => ['beginAtZero' => true, 'precision' => 0]]]]
                ]
            ];
            $graficoPaisesUrl = 'https://quickchart.io/chart?w=320&h=180&bkg=white&c=' . urlencode(json_encode($chartConfig));
        }

        $graficoSexosUrl = '';
        if (!empty($sexos)) {
            $chartConfig = [
                'type' => 'doughnut',
                'data' => [
                    'labels' => array_column($sexos, 'etiqueta'),
                    'datasets' => [[
                        'data' => array_map('intval', array_column($sexos, 'cantidad')),
                        'backgroundColor' => ['#4F8EDC', '#D66CA8', '#D4AF55']
                    ]]
                ],
                'options' => ['legend' => ['position' => 'top']]
            ];
            $graficoSexosUrl = 'https://quickchart.io/chart?w=280&h=180&bkg=white&c=' . urlencode(json_encode($chartConfig));
        }

        $graficoEdadesUrl = '';
        if (!empty($edades)) {
            $chartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => array_column($edades, 'etiqueta'),
                    'datasets' => [[
                        'label' => 'Usuarios',
                        'data' => array_map('intval', array_column($edades, 'cantidad')),
                        'backgroundColor' => '#D4AF55'
                    ]]
                ],
                'options' => [
                    'legend' => ['display' => false],
                    'scales' => ['yAxes' => [['ticks' => ['beginAtZero' => true, 'precision' => 0]]]]
                ]
            ];
            $graficoEdadesUrl = 'https://quickchart.io/chart?w=320&h=180&bkg=white&c=' . urlencode(json_encode($chartConfig));
        }

        $reporte = [
            'periodo' => ucfirst($periodo),
            'total_partidas' => $this->model->getPartidasJugadas($periodo),
            'usuarios_nuevos' => $this->model->getUsuariosNuevos($periodo),
            'preguntas_creadas' => $this->model->getPreguntasCreadas($periodo),
            'preguntas_activas' => $this->model->getTotalPreguntasActivas(),
            'reportes_pendientes' => $this->model->getTotalReportesPendientes(),
            'porcentaje_correctas' => $this->model->getPorcentajeCorrectas($periodo),
            'paises' => $paises,
            'sexos' => $sexos,
            'edades' => $edades,
            'grafico_paises_url' => $graficoPaisesUrl,
            'grafico_sexos_url' => $graficoSexosUrl,
            'grafico_edades_url' => $graficoEdadesUrl,
            'preguntas' => $preguntas
        ];

        $html = $this->render->renderHtml('reportePdf', $reporte);
        \PdfHelper::descargarDesdeHtml($html, "reporte-{$periodo}.pdf");
    }
}