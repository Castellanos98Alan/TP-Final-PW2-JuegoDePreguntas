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

        $modal = $_GET['modal'] ?? '';
        $abrirModalEditar   = ($modal === 'editar');
        $abrirModalPassword = ($modal === 'password');

        $tokenUrl     = $_GET['token_pass'] ?? '';
        $tokenSession = $_SESSION['token_pass_verificado'] ?? '';
        $passVerificada = (!empty($tokenUrl) && !empty($tokenSession) && hash_equals($tokenSession, $tokenUrl));

        $data = [
            'no_encontrado'        => false,
            'id'                   => $jugador['id'],
            'username'             => $jugador['username'],
            'nombre_completo'      => $jugador['nombre_completo'],
            'foto_perfil'          => $this->resolverFoto($jugador['foto_perfil']),
            'anio_nacimiento'      => $jugador['anio_nacimiento'],
            'sexo'                 => $jugador['sexo'],
            'es_masculino'         => $jugador['sexo'] === 'Masculino',
            'es_femenino'          => $jugador['sexo'] === 'Femenino',
            'es_otro_sexo'         => $jugador['sexo'] === 'Prefiero no cargarlo',
            'pais'                 => $jugador['pais'],
            'ciudad'               => $jugador['ciudad'],
            'ubicacion'            => $jugador['ciudad'] . ', ' . $jugador['pais'],
            'puntaje_acumulado'    => $jugador['puntaje_acumulado'],
            'miembro_desde'        => $jugador['miembro_desde'],
            'es_propio'            => isset($_SESSION['usuario_id']) && (int)$_SESSION['usuario_id'] === $idUsuario,
            'es_jugador'           => $esJugador,
            'posicion'             => $esJugador ? $this->model->obtenerPosicionRanking($jugador['puntaje_acumulado']) : null,
            'tiene_ubicacion'      => $tieneUbicacion,
            'latitud'              => $tieneUbicacion ? $jugador['latitud'] : '',
            'longitud'             => $tieneUbicacion ? $jugador['longitud'] : '',
            'cantidad_partidas'    => $resumen['total'],
            'mejor_puntaje'        => $resumen['mejor_puntaje'],
            'promedio'             => $resumen['promedio'],
            'partidas'             => $partidas,
            'url_perfil'           => $urlPerfil,
            'tiene_qr'             => $qrImagen !== null,
            'qr_imagen'            => $qrImagen,
            'abrir_modal_editar'   => $abrirModalEditar,
            'abrir_modal_password' => $abrirModalPassword,
            'pass_verificada'      => $passVerificada,
            'token_pass'           => $tokenUrl,
            'error_perfil'         => $_GET['error_perfil'] ?? null,
            'error_password'       => $_GET['error_password'] ?? null,
            'mensaje_exito'        => $_GET['mensaje_exito'] ?? '¡Operación realizada con éxito!',
            'exito_edicion'        => isset($_GET['exito'])
        ];

        $this->render->renderiza("perfil", $data);
    }

    public function actualizar()
    {
        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toIndex();
            return;
        }

        $idUsuario = (int)$_SESSION['usuario_id'];
        $datos = $_POST;
        $foto  = $_FILES['foto_perfil'] ?? null;

        $camposObligatorios = ['nombre_completo', 'username', 'anio_nacimiento', 'sexo', 'pais', 'ciudad'];
        foreach ($camposObligatorios as $campo) {
            if (empty(trim($datos[$campo] ?? ''))) {
                Redirect::to('/?controller=perfil&method=show&modal=editar&error_perfil=Todos+los+campos+son+obligatorios');
                return;
            }
        }

        $anio = (int)$datos['anio_nacimiento'];
        $anioActual = (int)date('Y');
        if ($anio < 1920 || $anio > $anioActual) {
            Redirect::to('/?controller=perfil&method=show&modal=editar&error_perfil=Año+de+nacimiento+inválido');
            return;
        }

        $sexosValidos = ['Masculino', 'Femenino', 'Prefiero no cargarlo'];
        if (!in_array($datos['sexo'], $sexosValidos)) {
            Redirect::to('/?controller=perfil&method=show&modal=editar&error_perfil=El+sexo+seleccionado+no+es+válido');
            return;
        }

        $username = trim($datos['username']);
        if (strlen($username) < 3 || strlen($username) > 30) {
            Redirect::to('/?controller=perfil&method=show&modal=editar&error_perfil=El+nombre+de+usuario+debe+tener+entre+3+y+30+caracteres');
            return;
        }

        if ($this->model->existeUsernameEnOtroUsuario($username, $idUsuario)) {
            Redirect::to('/?controller=perfil&method=show&modal=editar&error_perfil=El+nombre+de+usuario+ya+está+en+uso');
            return;
        }

        $nombreFoto = null;
        if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
            $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $extensionesPermitidas)) {
                Redirect::to('/?controller=perfil&method=show&modal=editar&error_perfil=Formato+de+foto+no+válido+(JPG+o+PNG)');
                return;
            }

            $nombreFoto = uniqid("perfil_", true) . "." . $extension;
            $destino = "public/" . $nombreFoto;

            if (!move_uploaded_file($foto['tmp_name'], $destino)) {
                Redirect::to('/?controller=perfil&method=show&modal=editar&error_perfil=Error+al+guardar+la+foto');
                return;
            }
        }

        $this->model->actualizarPerfil($idUsuario, $datos, $nombreFoto);

        $_SESSION['usuario'] = $username;
        if ($nombreFoto !== null) {
            $_SESSION['foto_perfil'] = $nombreFoto;
        }

        Redirect::to('/?controller=perfil&method=show&exito=1&mensaje_exito=' . urlencode('¡Perfil actualizado con éxito!'));
    }

    public function verificarPasswordActual()
    {
        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toIndex();
            return;
        }

        $idUsuario   = (int)$_SESSION['usuario_id'];
        $passActual  = trim($_POST['password_actual'] ?? '');

        if (empty($passActual)) {
            Redirect::to('/?controller=perfil&method=show&modal=password&error_password=' . urlencode('Debés ingresar tu contraseña actual'));
            return;
        }

        if (!$this->model->verificarPassword($idUsuario, $passActual)) {
            Redirect::to('/?controller=perfil&method=show&modal=password&error_password=' . urlencode('La contraseña actual es incorrecta'));
            return;
        }

        $token = bin2hex(random_bytes(16));
        $_SESSION['token_pass_verificado'] = $token;

        Redirect::to('/?controller=perfil&method=show&modal=password&token_pass=' . $token);
    }

    public function cambiarPassword()
    {
        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toIndex();
            return;
        }

        $idUsuario = (int)$_SESSION['usuario_id'];

        $tokenPost    = $_POST['token_pass'] ?? '';
        $tokenSession = $_SESSION['token_pass_verificado'] ?? '';

        if (empty($tokenPost) || empty($tokenSession) || !hash_equals($tokenSession, $tokenPost)) {
            Redirect::to('/?controller=perfil&method=show&modal=password&error_password=' . urlencode('Debés validar tu contraseña actual primero'));
            return;
        }

        $nuevaPass   = trim($_POST['nueva_password'] ?? '');
        $repetirPass = trim($_POST['repetir_password'] ?? '');

        if (empty($nuevaPass) || empty($repetirPass)) {
            Redirect::to('/?controller=perfil&method=show&modal=password&token_pass=' . $tokenPost . '&error_password=' . urlencode('Tenés que completar ambos campos'));
            return;
        }

        if ($nuevaPass !== $repetirPass) {
            Redirect::to('/?controller=perfil&method=show&modal=password&token_pass=' . $tokenPost . '&error_password=' . urlencode('Las nuevas contraseñas no coinciden'));
            return;
        }

        if (strlen($nuevaPass) < 4) {
            Redirect::to('/?controller=perfil&method=show&modal=password&token_pass=' . $tokenPost . '&error_password=' . urlencode('La nueva contraseña debe tener al menos 4 caracteres'));
            return;
        }

        $this->model->actualizarPassword($idUsuario, $nuevaPass);

        unset($_SESSION['token_pass_verificado']);

        Redirect::to('/?controller=perfil&method=show&exito=1&mensaje_exito=' . urlencode('¡Contraseña actualizada con éxito!'));
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
