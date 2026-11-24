<?php

namespace app\controller;

use Redirect;

class RankingController
{
    private $model;
    private $render;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }

    public function show()
    {
        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toIndex();
            return;
        }

        $tipo = isset($_GET['tipo']) && $_GET['tipo'] === 'historico' ? 'historico' : 'mensual';
        $mesSeleccionado = isset($_GET['mes']) ? (int)$_GET['mes'] : (int)date('m');
        $anioSeleccionado = isset($_GET['anio']) ? (int)$_GET['anio'] : (int)date('Y');
        $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $porPagina = 10;

        $resultado = $this->procesarRankingPaginado($tipo, $mesSeleccionado, $anioSeleccionado, $pagina, $porPagina);
        $meses = $this->obtenerListaMeses($mesSeleccionado);
        $anios = $this->obtenerListaAnios($anioSeleccionado);

        $paginas = [];
        for ($i = 1; $i <= $resultado['total_paginas']; $i++) {
            $paginas[] = [
                'numero' => $i,
                'es_actual' => ($i === $resultado['pagina_actual'])
            ];
        }

        $data = [
            'tipo'             => $tipo,
            'es_historico'     => ($tipo === 'historico'),
            'es_mensual'       => ($tipo === 'mensual'),
            'hay_jugadores'    => !empty($resultado['jugadores']),
            'jugadores'        => $resultado['jugadores'],
            'meses'            => $meses,
            'anios'            => $anios,
            'mes_actual'       => $mesSeleccionado,
            'anio_actual'      => $anioSeleccionado,
            'pagina_actual'    => $resultado['pagina_actual'],
            'total_paginas'    => $resultado['total_paginas'],
            'total_jugadores'  => $resultado['total_jugadores'],
            'tiene_paginas'    => ($resultado['total_paginas'] > 1),
            'tiene_anterior'   => ($resultado['pagina_actual'] > 1),
            'pagina_anterior'  => $resultado['pagina_actual'] - 1,
            'tiene_siguiente'  => ($resultado['pagina_actual'] < $resultado['total_paginas']),
            'pagina_siguiente' => $resultado['pagina_actual'] + 1,
            'paginas'          => $paginas
        ];

        $this->render->renderiza("ranking", $data);
    }

    public function obtenerRankingAjax()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            exit;
        }

        $tipo = isset($_GET['tipo']) && $_GET['tipo'] === 'historico' ? 'historico' : 'mensual';
        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : (int)date('m');
        $anio = isset($_GET['anio']) ? (int)$_GET['anio'] : (int)date('Y');
        $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $porPagina = 10;

        $resultado = $this->procesarRankingPaginado($tipo, $mes, $anio, $pagina, $porPagina);

        echo json_encode([
            'success'         => true,
            'tipo'            => $tipo,
            'mes'             => $mes,
            'anio'            => $anio,
            'pagina_actual'   => $resultado['pagina_actual'],
            'total_paginas'   => $resultado['total_paginas'],
            'total_jugadores' => $resultado['total_jugadores'],
            'jugadores'       => $resultado['jugadores']
        ]);
        exit;
    }

    private function procesarRankingPaginado($tipo, $mes, $anio, $pagina = 1, $porPagina = 10)
    {
        if ($tipo === 'historico') {
            $todosJugadores = $this->model->obtenerRankingHistorico();
        } else {
            $todosJugadores = $this->model->obtenerRankingJugadores($mes, $anio);
        }
        $idUsuarioActual = isset($_SESSION['usuario_id']) ? (int)$_SESSION['usuario_id'] : 0;

        $posicion = 1;
        foreach ($todosJugadores as &$jugador) {
            $jugador['posicion'] = $posicion;
            $jugador['es_podio'] = ($posicion <= 3);
            $jugador['es_primero'] = ($posicion === 1);
            $jugador['es_segundo'] = ($posicion === 2);
            $jugador['es_tercero'] = ($posicion === 3);
            $jugador['es_usuario_actual'] = ((int)$jugador['id'] === $idUsuarioActual);

            $foto = !empty($jugador['foto_perfil']) ? $jugador['foto_perfil'] : 'default.png';
            if (!file_exists('public/' . $foto)) {
                $foto = 'FondoPerfilLuffy.png';
            }
            $jugador['foto_perfil'] = $foto;

            $posicion++;
        }
        unset($jugador);

        $totalJugadores = count($todosJugadores);
        $totalPaginas = max(1, (int)ceil($totalJugadores / $porPagina));
        $pagina = min(max(1, $pagina), $totalPaginas);
        $offset = ($pagina - 1) * $porPagina;

        $jugadoresPagina = array_slice($todosJugadores, $offset, $porPagina);

        return [
            'total_jugadores' => $totalJugadores,
            'total_paginas'   => $totalPaginas,
            'pagina_actual'   => $pagina,
            'jugadores'       => $jugadoresPagina
        ];
    }

    private function obtenerListaMeses($mesSeleccionado)
    {
        $nombres = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $meses = [];
        foreach ($nombres as $num => $nombre) {
            $meses[] = [
                'numero'       => $num,
                'nombre'       => $nombre,
                'seleccionado' => ($num === $mesSeleccionado)
            ];
        }
        return $meses;
    }

    private function obtenerListaAnios($anioSeleccionado)
    {
        $anioActual = (int)date('Y');
        $anios = [];
        for ($a = $anioActual; $a >= $anioActual - 2; $a--) {
            $anios[] = [
                'anio'         => $a,
                'seleccionado' => ($a === $anioSeleccionado)
            ];
        }
        return $anios;
    }
}