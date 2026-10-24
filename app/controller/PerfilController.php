<?php

namespace app\controller;

use Redirect;

class PerfilController
{

    private const RUTA_PHPQRCODE = 'vendor/phpqrcode/qrlib.php';

    private $model;
    private $render;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }

    public function show()
    {
        $idPedido = $_GET['id'] ?? null;

        if ($idPedido === null || $idPedido === '') {
            if (!isset($_SESSION['usuario_id'])) {
                Redirect::toIndex();
                return;
            }
            $idUsuario = (int)$_SESSION['usuario_id'];
        } else {
            $idUsuario = (int)$idPedido;
        }

        $jugador = $idUsuario > 0 ? $this->model->obtenerPerfil($idUsuario) : null;

        if ($jugador === null) {
            $this->render->renderiza("perfil", ['no_encontrado' => true]);
            return;
        }

        $resumen   = $this->model->obtenerResumenPartidas($idUsuario);
        $partidas  = $this->model->obtenerPartidas($idUsuario);
        $esJugador = ((int)$jugador['id_rol'] === 1);

        $tieneUbicacion = is_numeric($jugador['latitud']) && is_numeric($jugador['longitud']);

        $urlPerfil = $this->construirUrlPerfil($idUsuario);
        $qrImagen  = $this->generarQr($urlPerfil);

        $data = [
            'no_encontrado'     => false,
            'id'                => $jugador['id'],
            'username'          => $jugador['username'],
            'nombre_completo'   => $jugador['nombre_completo'],
            'foto_perfil'       => $this->resolverFoto($jugador['foto_perfil']),
            'pais'              => $jugador['pais'],
            'ciudad'            => $jugador['ciudad'],
            'ubicacion'         => $jugador['ciudad'] . ', ' . $jugador['pais'],
            'puntaje_acumulado' => $jugador['puntaje_acumulado'],
            'miembro_desde'     => $jugador['miembro_desde'],
            'es_propio'         => isset($_SESSION['usuario_id']) && (int)$_SESSION['usuario_id'] === $idUsuario,
            'es_jugador'        => $esJugador,
            'posicion'          => $esJugador ? $this->model->obtenerPosicionRanking($jugador['puntaje_acumulado']) : null,
            'tiene_ubicacion'   => $tieneUbicacion,
            'latitud'           => $tieneUbicacion ? $jugador['latitud'] : '',
            'longitud'          => $tieneUbicacion ? $jugador['longitud'] : '',
            'cantidad_partidas' => $resumen['total'],
            'mejor_puntaje'     => $resumen['mejor_puntaje'],
            'promedio'          => $resumen['promedio'],
            'partidas'          => $partidas,
            'url_perfil'        => $urlPerfil,
            'tiene_qr'          => $qrImagen !== null,
            'qr_imagen'         => $qrImagen
        ];

        $this->render->renderiza("perfil", $data);
    }

    private function resolverFoto($nombreFoto)
    {
        $ruta = 'public/' . (!empty($nombreFoto) ? $nombreFoto : 'default.png');

        if (!file_exists($ruta)) {
            $ruta = 'public/FondoPerfilLuffy.png';
        }

        return $ruta;
    }

    private function construirUrlPerfil($idUsuario)
    {
        $https   = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $esquema = $https ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $carpeta = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

        return $esquema . '://' . $host . $carpeta . '/?controller=perfil&method=show&id=' . $idUsuario;
    }

    private function generarQr($url)
    {
        if (!file_exists(self::RUTA_PHPQRCODE)) {
            return null;
        }

        require_once self::RUTA_PHPQRCODE;

        $tmp = tempnam(sys_get_temp_dir(), 'qr');
        \QRcode::png($url, $tmp, \QR_ECLEVEL_M, 6, 2);
        $png = file_get_contents($tmp);
        unlink($tmp);

        if ($png === false || $png === '') {
            return null;
        }

        return 'data:image/png;base64,' . base64_encode($png);
    }
}