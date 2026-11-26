<?php

namespace app\controller;

use Redirect;

class SugerirPreguntaController
{
    private $model;
    private $render;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }

    private function verificarAutenticacion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            Redirect::toLogin();
        }

        $rol = $_SESSION['rol'] ?? $_SESSION['id_rol'] ?? 0;
        $esAdmin = ($rol == 3 || strtolower((string)$rol) === 'administrador');
        $esEditor = ($rol == 2 || strtolower((string)$rol) === 'editor');
        $esJugador = ((string)$rol === '1' || strtolower((string)$rol) === 'jugador') && !$esAdmin && !$esEditor;

        if (!$esJugador) {
            Redirect::toLobby();
        }
    }

    public function show()
    {
        $this->verificarAutenticacion();

        $data = [
            'username'       => $_SESSION['usuario'] ?? $_SESSION['username'] ?? 'Jugador',
            'categorias'     => $this->model->getCategoriasActivas(),
            'animes'         => $this->model->getAnimesActivos(),
            'mensaje_exito'  => $_SESSION['sugerir_exito'] ?? null,
            'mensaje_error'  => $_SESSION['sugerir_error'] ?? null
        ];

        unset($_SESSION['sugerir_exito'], $_SESSION['sugerir_error']);

        $this->render->renderiza("sugerirPregunta", $data);
    }

    public function guardar()
    {
        $this->verificarAutenticacion();

        $pregunta     = trim($_POST['pregunta'] ?? '');
        $descripcion  = trim($_POST['descripcion'] ?? '');
        $animeId      = (int)($_POST['anime_id'] ?? 0);
        $opciones     = $_POST['opciones'] ?? [];
        $correcta     = isset($_POST['correcta']) ? (int)$_POST['correcta'] : -1;
        $tipoPregunta = $_POST['tipo_pregunta'] ?? 'texto';
        $archivo      = $_FILES['recurso'] ?? null;

        // La dificultad inicial la define automáticamente el sistema
        $dificultadInicial = 'media';

        // 1. Validación de largo de la pregunta
        $largoPregunta = mb_strlen($pregunta);
        if ($largoPregunta < 10 || $largoPregunta > 100) {
            $_SESSION['sugerir_error'] = "La pregunta debe tener entre 10 y 100 caracteres (ingresaste $largoPregunta).";
            Redirect::toSugerirPregunta();
            return;
        }

        // 2. Validación de largo de la descripción
        $largoDescripcion = mb_strlen($descripcion);
        if ($largoDescripcion < 10 || $largoDescripcion > 100) {
            $_SESSION['sugerir_error'] = "La descripción debe tener entre 10 y 100 caracteres (ingresaste $largoDescripcion).";
            Redirect::toSugerirPregunta();
            return;
        }

        // 3. Validación de anime seleccionado
        if ($animeId <= 0) {
            $_SESSION['sugerir_error'] = "Debés seleccionar un anime.";
            Redirect::toSugerirPregunta();
            return;
        }

        // 4. Validación de opciones de respuesta
        $opcionesValidas = is_array($opciones) && count($opciones) === 4;
        if ($opcionesValidas) {
            foreach ($opciones as $opcion) {
                if (trim($opcion) === '') {
                    $opcionesValidas = false;
                    break;
                }
            }
        }

        if (!$opcionesValidas || $correcta < 0 || $correcta > 3) {
            $_SESSION['sugerir_error'] = "Debés completar las 4 opciones de respuesta e indicar cuál es la correcta.";
            Redirect::toSugerirPregunta();
            return;
        }

        $recursoRuta = null;

        // 5. Manejo de archivos multimedia opcionales (imagen o audio)
        if ($tipoPregunta === 'imagen' || $tipoPregunta === 'audio') {
            if ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {
                $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

                if ($tipoPregunta === 'imagen') {
                    $extPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
                    if (!in_array($extension, $extPermitidas)) {
                        $_SESSION['sugerir_error'] = "Formato de imagen no permitido (solo JPG, PNG o WEBP).";
                        Redirect::toSugerirPregunta();
                        return;
                    }

                    $directorioDestino = "public/img-preguntas/";
                    if (!is_dir($directorioDestino)) {
                        mkdir($directorioDestino, 0777, true);
                    }

                    $nombreArchivo = uniqid("preg_img_", true) . "." . $extension;
                    $destino = $directorioDestino . $nombreArchivo;

                    if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                        $recursoRuta = $destino;
                    } else {
                        $_SESSION['sugerir_error'] = "Error al subir la imagen. Por favor intente nuevamente.";
                        Redirect::toSugerirPregunta();
                        return;
                    }
                } elseif ($tipoPregunta === 'audio') {
                    $extPermitidas = ['mp3', 'wav', 'ogg'];
                    if (!in_array($extension, $extPermitidas)) {
                        $_SESSION['sugerir_error'] = "Formato de audio no permitido (solo MP3, WAV u OGG).";
                        Redirect::toSugerirPregunta();
                        return;
                    }

                    $directorioDestino = "public/audio/";
                    if (!is_dir($directorioDestino)) {
                        mkdir($directorioDestino, 0777, true);
                    }

                    $nombreArchivo = uniqid("preg_audio_", true) . "." . $extension;
                    $destino = $directorioDestino . $nombreArchivo;

                    if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                        $recursoRuta = $destino;
                    } else {
                        $_SESSION['sugerir_error'] = "Error al subir el audio. Por favor intente nuevamente.";
                        Redirect::toSugerirPregunta();
                        return;
                    }
                }
            } else {
                $tipoPregunta = 'texto';
            }
        } else {
            $tipoPregunta = 'texto';
        }

        $exito = $this->model->crearPreguntaSugerida(
            $pregunta,
            $descripcion,
            $animeId,
            $dificultadInicial,
            $opciones,
            $correcta,
            $tipoPregunta,
            $recursoRuta,
            (int)($_POST['categoria_id'] ?? 0)
        );

        if ($exito) {
            $_SESSION['sugerir_exito'] = "¡Pregunta recibida! Gracias por colaborar, ya fue enviada para que un editor la revise.";
        } else {
            $_SESSION['sugerir_error'] = "Ocurrió un error al guardar la sugerencia. Por favor reintentá.";
        }

        Redirect::toSugerirPregunta();
    }
}
