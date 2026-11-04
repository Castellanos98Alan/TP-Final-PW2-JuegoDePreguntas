<?php

namespace app\controller;

class PartidaController
{
    private $model;
    private $render;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }


    /*
     * Muestra la pantalla donde el usuario
     * selecciona uno o varios animes.
     */
    public function seleccionar()
    {
        $animes = $this->model->obtenerAnimes();

        $error = $_GET['error'] ?? null;

        $data = [
            'animes' => $animes,
            'errorSeleccion' => $error == 1,
            'errorPreguntas' => $error == 2
        ];

        $this->render->renderiza(
            'seleccionarAnime',
            $data
        );
    }


    /*
     * Crea una nueva partida.
     *
     * Recibe los animes seleccionados
     * y genera las 15 preguntas:
     *
     * 5 fáciles
     * 5 medias
     * 5 difíciles
     */
    public function nueva()
    {
        /*
         * El usuario debe estar logueado.
         */
        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ?controller=login&method=index'
            );
            exit();
        }

        /*
         * Los checkboxes envían un array
         * llamado animes[].
         */
        $animesSeleccionados =
            $_POST['animes'] ?? [];

        /*
         * Debe seleccionar al menos un anime.
         */
        if (empty($animesSeleccionados)) {
            header(
                'Location: ?controller=partida&method=seleccionar&error=1'
            );
            exit();
        }

        $usuarioId =
            $_SESSION['usuario_id'];

        /*
         * Pedimos las 15 preguntas al Model.
         */
        $preguntas =
            $this->model->obtenerPreguntasDePartida(
                $animesSeleccionados,
                $usuarioId
            );

        /*
         * Si por algún motivo no se pudieron
         * conseguir las 15 preguntas,
         * volvemos a selección.
         */
        if (count($preguntas) < 15) {
            header(
                'Location: ?controller=partida&method=seleccionar&error=2'
            );
            exit();
        }

        /*
         * Guardamos el estado de la partida
         * dentro de la sesión. para que cuando el usuario recargue la pgina, el contador no se reinicie
         */
        $_SESSION['partida'] = [
            'preguntas' => $preguntas,
            'actual' => 0,
            'puntaje' => 0,
            'animes' => $animesSeleccionados,
            'perdio' => false,
            'inicio_pregunta' => time(),
            'ultimo_reporte' => null
        ];

        header(
            'Location: ?controller=partida&method=jugar'
        );

        exit();
    }


    /*
     * Muestra la pregunta actual.
     */
    public function jugar()
    {
        /*
         * Si no existe una partida,
         * vuelve a seleccionar anime.
         */
        if (!isset($_SESSION['partida'])) {
            header(
                'Location: ?controller=partida&method=seleccionar'
            );
            exit();
        }

        /*
         * También comprobamos que siga
         * existiendo el usuario logueado.
         */
        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ?controller=login&method=index'
            );
            exit();
        }

        $partida =
            $_SESSION['partida'];

        // El reloj se inicia una sola vez por pregunta.
// Recargar la página no reinicia los 8 segundos.
        if (!isset($_SESSION['partida']['inicio_pregunta'])) {
            $_SESSION['partida']['inicio_pregunta'] = time();
        }

        $indiceActual =
            $partida['actual'];

        /*
         * Si no existe una pregunta en
         * esa posición, debería haber
         * terminado la partida.
         */
        if (!isset(
            $partida['preguntas'][$indiceActual]
        )) {
            header(
                'Location: ?controller=partida&method=ganar'
            );
            exit();
        }

        $pregunta =
            $partida['preguntas'][$indiceActual];

        $usuarioId =
            $_SESSION['usuario_id'];

        /*
         * Desde el momento en que aparece
         * en pantalla, esta pregunta ya
         * se considera vista.
         */
        $this->model->registrarPreguntaVista(
            $usuarioId,
            $pregunta['id']
        );

        $data = [
            'pregunta' => $pregunta,

            /*
             * El array comienza en 0,
             * pero al usuario mostramos
             * preguntas del 1 al 15.
             */
            'numeroPregunta' =>
                $indiceActual + 1,

            'puntaje' =>
                $partida['puntaje'],


            //se calcula cuánto tiempo pasó desde el inicio y se resta de 8. max(0, ...) evita que el resultado sea negativo.
            'segundosRestantes' => max(0, 8 - (time() - $_SESSION['partida']['inicio_pregunta'])),
            'ultimaPreguntaRespondida' => $_SESSION['partida']['ultimaPreguntaRespondida'] ?? null,
            'reporteEnviado' => !empty($_SESSION['partida']['ultimo_reporte']) && (int)$_SESSION['partida']['ultimo_reporte'] === (int)(($_SESSION['partida']['ultimaPreguntaRespondida']['id'] ?? 0)),
            'mensajeReporte' => $_SESSION['partida']['mensajeReporte'] ?? null,

             'esImagen' =>
                $pregunta['tipo_pregunta']  === 'imagen',

            'esAudio' =>
                $pregunta['tipo_pregunta'] === 'audio'
        ];

        echo $this->render->renderiza(
            'partida',
            $data
        );
    }


    /*
     * Recibe la respuesta A, B, C o D
     * seleccionada por el jugador.
     */
    public function responder()
    {
        /*
         * Tiene que existir una partida.
         */
        if (!isset($_SESSION['partida'])) {
            header(
                'Location: ?controller=partida&method=seleccionar'
            );
            exit();
        }

        /*
         * Tiene que existir un usuario logueado.
         */
        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ?controller=login&method=index'
            );
            exit();
        }

        /*
         * Comprobamos que lleguen los
         * datos necesarios por POST.
         */
        if (
            !isset($_POST['idPregunta']) ||
            !isset($_POST['respuesta'])
        ) {
            header(
                'Location: ?controller=partida&method=jugar'
            );
            exit();
        }

        $idPregunta =
            $_POST['idPregunta'];

        $respuesta =
            strtoupper(
                $_POST['respuesta']
            );

        /*
         * Buscamos cuál debería ser
         * realmente la pregunta actual.
         */
        $indiceActual =
            $_SESSION['partida']['actual'];

        /*
         * Protección extra por si el índice
         * no existiera.
         */
        if (!isset(
            $_SESSION['partida']
            ['preguntas']
            [$indiceActual]
        )) {
            header(
                'Location: ?controller=partida&method=jugar'
            );
            exit();
        }

        $preguntaActual =
            $_SESSION['partida']
            ['preguntas']
            [$indiceActual];

        // Validación del servidor: una respuesta después de 8 segundos no vale.
        $inicioPregunta = $_SESSION['partida']['inicio_pregunta'] ?? time();


        //Si pasaron 8 segundos o más, se prepara la
        //derrota, se redirige y exit() detiene la ejecución para que no se procese la respuesta.
        if (time() - $inicioPregunta >= 8) {
            $this->prepararDerrotaPorTiempo($preguntaActual);
            header('Location: ?controller=partida&method=perder');
            exit();
        }

        /*
         * Evitamos que alguien cambie
         * manualmente el idPregunta
         * desde el navegador.
         */
        if (
            $preguntaActual['id']
            !=
            $idPregunta
        ) {
            header(
                'Location: ?controller=partida&method=jugar'
            );
            exit();
        }

        /*
         * Solo aceptamos estas respuestas.
         */
        $respuestasValidas =
            ['A', 'B', 'C', 'D'];

        if (
            !in_array(
                $respuesta,
                $respuestasValidas
            )
        ) {
            header(
                'Location: ?controller=partida&method=jugar'
            );
            exit();
        }

        $usuarioId =
            $_SESSION['usuario_id'];

        /*
         * El Model consulta cuál es
         * la respuesta correcta.
         */
        $esCorrecta =
            $this->model->validarRespuesta(
                $idPregunta,
                $respuesta
            );

        /*
         * Guardamos si respondió
         * correctamente o incorrectamente.
         */
        $this->model->registrarResultadoPregunta(
            $usuarioId,
            $idPregunta,
            $esCorrecta
        );

        /*
         * RESPUESTA INCORRECTA
         */
        if (!$esCorrecta) {

            $_SESSION['partida']['perdio'] = true;

            $_SESSION['partida']['respuestaIncorrecta'] =
                $respuesta;

            $_SESSION['partida']['respuestaCorrecta'] =
                $this->model->obtenerRespuestaCorrecta(
                    $idPregunta
                );

            $_SESSION['partida']['preguntaPerdida'] =
                $preguntaActual;
            $_SESSION['partida']['motivoDerrota'] = 'respuesta';
            $_SESSION['partida']['ultimaPreguntaRespondida'] = [
                'id' => $preguntaActual['id'],
                'enunciado' => $preguntaActual['enunciado']
            ];

            header(
                'Location: ?controller=partida&method=perder'
            );

            exit();
        }

        /*
         * RESPUESTA CORRECTA
         *
         * Sumamos un punto.
         */
        $_SESSION['partida']['puntaje']++;
        $_SESSION['partida']['ultimaPreguntaRespondida'] = [
            'id' => $preguntaActual['id'],
            'enunciado' => $preguntaActual['enunciado']
        ];

        /*
         * Avanzamos a la siguiente pregunta.
         */
        $_SESSION['partida']['actual']++;
        $_SESSION['partida']['inicio_pregunta'] = time();

        /*
         * Si respondió correctamente
         * las 15 preguntas, ganó.
         */
        if (
            $_SESSION['partida']['actual']
            >= 15
        ) {
            header(
                'Location: ?controller=partida&method=ganar'
            );

            exit();
        }

        /*
         * Si todavía quedan preguntas,
         * mostramos la siguiente.
         */
        header(
            'Location: ?controller=partida&method=jugar'
        );

        exit();
    }


    /**
     * Endpoint llamado cuando el contador llega a cero.
     */
    public function tiempoAgotado()
    {
        if (!isset($_SESSION['partida'], $_SESSION['usuario_id'])) {
            header('Location: ?controller=partida&method=seleccionar');
            exit();
        }

        $indice = $_SESSION['partida']['actual'];
        $pregunta = $_SESSION['partida']['preguntas'][$indice] ?? null;
        $inicio = $_SESSION['partida']['inicio_pregunta'] ?? time();

        // No aceptar una llamada anticipada al endpoint.
        // Esta condición evita aceptar una llamada anticipada al método. También comprueba que exista una pregunta válida.
        if (!$pregunta || time() - $inicio < 8) {
            header('Location: ?controller=partida&method=jugar');
            exit();
        }

        $this->prepararDerrotaPorTiempo($pregunta);
        header('Location: ?controller=partida&method=perder');
        exit();
    }

    private function prepararDerrotaPorTiempo($pregunta)
    {
        $_SESSION['partida']['perdio'] = true;
        $_SESSION['partida']['motivoDerrota'] = 'tiempo';
        $_SESSION['partida']['respuestaIncorrecta'] = null;
        $_SESSION['partida']['respuestaCorrecta'] = $this->model->obtenerRespuestaCorrecta($pregunta['id']);
        $_SESSION['partida']['preguntaPerdida'] = $pregunta;
        $_SESSION['partida']['ultimaPreguntaRespondida'] = [
            'id' => $pregunta['id'],
            'enunciado' => $pregunta['enunciado']
        ];
    }

    /**
     * Guarda el reporte de la última pregunta contestada.
     */

    public function reportar()
    {
        if (!isset($_SESSION['usuario_id'], $_SESSION['partida'])) {
            header('Location: ?controller=login&method=index');
            exit();
        }

        // Solo se puede reportar cuando el jugador perdió.
        if (empty($_SESSION['partida']['perdio'])) {
            header('Location: ?controller=partida&method=jugar');
            exit();
        }

        $idPregunta = filter_input(INPUT_POST, 'idPregunta', FILTER_VALIDATE_INT);
        $motivo = trim($_POST['motivo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        $motivosValidos = [
            'Respuesta incorrecta',
            'Ninguna opción es correcta',
            'Enunciado confuso',
            'Imagen o audio con problemas',
            'Otro'
        ];

        // Comprobamos que la pregunta pertenezca a esta partida.
        $preguntaValida = false;

        foreach ($_SESSION['partida']['preguntas'] as $pregunta) {
            if ((int)$pregunta['id'] === (int)$idPregunta) {
                $preguntaValida = true;
                break;
            }
        }

        if (
            !$idPregunta ||
            !$preguntaValida ||
            !in_array($motivo, $motivosValidos, true) ||
            $descripcion === '' ||
            mb_strlen($descripcion) > 2000
        ) {
            $_SESSION['partida']['mensajeReporte'] =
                'No se pudo enviar el reporte. Revisá los datos e intentá nuevamente.';
        } else {
            $this->model->guardarReporte(
                $_SESSION['usuario_id'],
                $idPregunta,
                $motivo,
                $descripcion
            );

            $_SESSION['partida']['mensajeReporte'] =
                'Gracias. El reporte se guardó correctamente.';
        }

        header('Location: ?controller=partida&method=perder');
        exit();
    }


    /*
     * Finaliza una partida perdida.
     */
    public function perder()
    {
        if (
            !isset($_SESSION['partida']) ||
            empty($_SESSION['partida']['perdio'])
        ) {
            header(
                'Location: ?controller=partida&method=seleccionar'
            );
            exit();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ?controller=login&method=index'
            );
            exit();
        }


        if (!isset($_SESSION['partida']['preguntaPerdida'])) {
            unset($_SESSION['partida']);

            header(
                'Location: ?controller=partida&method=seleccionar'
            );
            exit();
        }

        $usuarioId =
            $_SESSION['usuario_id'];

        $respuestasCorrectas =
            $_SESSION['partida']['puntaje'];

        $puntajeFinal = $respuestasCorrectas;

        // Evitamos registrar varias veces la misma derrota si se recarga
        // la pantalla o el usuario envía un reporte.
        if (empty($_SESSION['partida']['partidaGuardada'])) {
            $this->model->guardarPartida(
                $usuarioId,
                $puntajeFinal,
                'Perdida'
            );
            $_SESSION['partida']['partidaGuardada'] = true;
        }

        $preguntaPerdida =
            $_SESSION['partida']['preguntaPerdida'];

        $respuestaIncorrecta =
            $_SESSION['partida']['respuestaIncorrecta']
            ?? null;

        $respuestaCorrecta =
            $_SESSION['partida']['respuestaCorrecta']
            ?? null;

        $respuestas = [
            [
                'letra' => 'A',
                'texto' => $preguntaPerdida['respuesta_a'],
                'esCorrecta' => $respuestaCorrecta === 'A',
                'esIncorrecta' => $respuestaIncorrecta === 'A'
            ],
            [
                'letra' => 'B',
                'texto' => $preguntaPerdida['respuesta_b'],
                'esCorrecta' => $respuestaCorrecta === 'B',
                'esIncorrecta' => $respuestaIncorrecta === 'B'
            ],
            [
                'letra' => 'C',
                'texto' => $preguntaPerdida['respuesta_c'],
                'esCorrecta' => $respuestaCorrecta === 'C',
                'esIncorrecta' => $respuestaIncorrecta === 'C'
            ],
            [
                'letra' => 'D',
                'texto' => $preguntaPerdida['respuesta_d'],
                'esCorrecta' => $respuestaCorrecta === 'D',
                'esIncorrecta' => $respuestaIncorrecta === 'D'
            ]
        ];

        $data = [
            'respuestasCorrectas' => $respuestasCorrectas,
            'puntajeFinal' => $puntajeFinal,
            'enunciadoPregunta' => $preguntaPerdida['enunciado'],
            'respuestas' => $respuestas,
            'preguntaPerdidaId' => $preguntaPerdida['id'],
            'motivoDerrotaTiempo' =>
                ($_SESSION['partida']['motivoDerrota'] ?? '') === 'tiempo',
            'mensajeReporte' => $_SESSION['partida']['mensajeReporte'] ?? null,

            // Preguntas de esta partida que se pueden reportar.
            'preguntasReporte' => array_map(
                function ($pregunta) {
                    return [
                        'id' => $pregunta['id'],
                        'enunciado' => $pregunta['enunciado']
                    ];
                },
                $_SESSION['partida']['preguntas']
            )
        ];

        $this->render->renderiza(
            'derrota',
            $data
        );
    }



    /*
     * Finaliza una partida ganada.
     */
    public function ganar()
    {
        /*
         * Tiene que existir la partida.
         */
        if (!isset($_SESSION['partida'])) {
            header(
                'Location: ?controller=lobby&method=index'
            );
            exit();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ?controller=login&method=index'
            );
            exit();
        }

        /*
         * No puede entrar manualmente
         * a ganar si todavía no respondió
         * las 15 preguntas.
         */
        if (
            $_SESSION['partida']['actual']
            < 15
        ) {
            header(
                'Location: ?controller=partida&method=jugar'
            );
            exit();
        }

        $usuarioId =
            $_SESSION['usuario_id'];

        $puntaje =
            $_SESSION['partida']['puntaje'];

        /*
         * Guardamos la partida como Ganada.
         */
        $this->model->guardarPartida(
            $usuarioId,
            $puntaje,
            'Ganada'
        );

        $data = [
            'puntaje' => $puntaje
        ];

        /*
         * Terminó la partida.
         */
        unset($_SESSION['partida']);

        echo $this->render->renderiza(
            'victoria',
            $data
        );
    }
}