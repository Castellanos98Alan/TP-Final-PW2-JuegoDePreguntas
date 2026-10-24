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
         * dentro de la sesión.
         */
        $_SESSION['partida'] = [
            'preguntas' => $preguntas,
            'actual' => 0,
            'puntaje' => 0,
            'animes' => $animesSeleccionados,
            'perdio' => false
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

        /*
         * Avanzamos a la siguiente pregunta.
         */
        $_SESSION['partida']['actual']++;

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

        /*
         * Si por algún motivo no quedó guardada
         * la pregunta donde perdió, evitamos
         * generar warnings.
         */
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

        $puntajeFinal = 0;

        $this->model->guardarPartida(
            $usuarioId,
            $puntajeFinal,
            'Perdida'
        );

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
            'enunciadoPregunta' =>
                $preguntaPerdida['enunciado'],
            'respuestas' => $respuestas
        ];

        unset($_SESSION['partida']);

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