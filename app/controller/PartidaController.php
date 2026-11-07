<?php

namespace app\controller;

use Redirect;

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
        $errorSeleccion = !empty($_SESSION['error_seleccion']) || ($_GET['error'] ?? null) == 1;
        $errorPreguntas = !empty($_SESSION['error_preguntas']) || ($_GET['error'] ?? null) == 2;
        unset($_SESSION['error_seleccion'], $_SESSION['error_preguntas']);
        $data = [
            'animes' => $animes,
            'errorSeleccion' => $errorSeleccion,
            'errorPreguntas' => $errorPreguntas
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/login'
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
            $_SESSION['error_seleccion'] = true;
            Redirect::to('/partida/seleccionar');
        }

        $usuarioId =
            $_SESSION['usuario_id'];

        /*
         * Pedimos las 15 preguntas al Model.
         */

        $primeraPregunta = $this->model->obtenerSiguientePregunta(
            $animesSeleccionados,
            $usuarioId,
            [],
            0
        );


        /*
         * Si por algún motivo no se pudieron
         * conseguir las 15 preguntas,
         * volvemos a selección.
         */

        if (!$primeraPregunta) {
            $_SESSION['error_preguntas'] = true;
            Redirect::to('/partida/seleccionar');
            exit();
        }


        /*
         * Guardamos el estado de la partida
         * dentro de la sesión. para que cuando el usuario recargue la pgina, el contador no se reinicie
         */
        $_SESSION['partida'] = [
            'preguntas' => [$primeraPregunta],
            'actual' => 0,
            'puntaje' => 0,
            'animes' => $animesSeleccionados,
            'perdio' => false,
            'inicio_pregunta' => time(),
            'ultimo_reporte' => null
        ];

        header(
            'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/jugar'
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/seleccionar'
            );
            exit();
        }

        /*
         * También comprobamos que siga
         * existiendo el usuario logueado.
         */
        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/login'
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


        if (!empty($partida['perdio'])) {
            Redirect::to('/partida/perder');
            exit();
        }

// Ganar requiere 15 respuestas correctas.
        if ($partida['puntaje'] >= 15) {
            Redirect::to('/partida/ganar');
            exit();
        }

// Si falta una pregunta por un problema de estado,
// intentamos recuperarla.
        if (!isset($partida['preguntas'][$indiceActual])) {

            $preguntasUsadas = [];

            foreach ($partida['preguntas'] as $pregunta) {
                $preguntasUsadas[] = $pregunta['id'];
            }

            $siguientePregunta = $this->model->obtenerSiguientePregunta(
                $partida['animes'],
                $_SESSION['usuario_id'],
                $preguntasUsadas,
                $indiceActual
            );

            if (!$siguientePregunta) {
                $_SESSION['error_preguntas'] = true;
                Redirect::to('/partida/seleccionar');
                exit();
            }

            $_SESSION['partida']['preguntas'][] = $siguientePregunta;
            $_SESSION['partida']['inicio_pregunta'] = time();

            $partida = $_SESSION['partida'];
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


            // en caso de que querramos ver el nivel del jugador ..
            'nivelJugador' => $this->model->obtenerNivelJugador(
                $usuarioId
            ),


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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/seleccionar'
            );
            exit();
        }

        /*
         * Tiene que existir un usuario logueado.
         */
        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/login'
            );
            exit();
        }

        // Esto es importante porque, si el usuario ya perdió por tiempo, no queremos que una respuesta enviada posteriormente genere otro registro.

        if (!empty($_SESSION['partida']['perdio'])) {
            Redirect::to('/partida/perder');
            exit();
        }

        if ($_SESSION['partida']['actual'] >= 15) {
            Redirect::to('/partida/ganar');
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/jugar'
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/jugar'
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
            Redirect::to('/partida/perder');
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/jugar'
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/jugar'
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/perder'
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/ganar'
            );

            exit();
        }


            // Guardamos los ID de las preguntas utilizadas.

        $preguntasUsadas = [];

        foreach ($_SESSION['partida']['preguntas'] as $pregunta) {
            $preguntasUsadas[] = $pregunta['id'];
        }

            // Obtenemos la próxima pregunta con el nivel actual.

        $siguientePregunta = $this->model->obtenerSiguientePregunta(
            $_SESSION['partida']['animes'],
            $usuarioId,
            $preguntasUsadas,
            $_SESSION['partida']['actual']
        );


        if (!$siguientePregunta) {
            $_SESSION['error_preguntas'] = true;

            header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/seleccionar');
            exit();
        }


        // Agregamos la pregunta a la partida actual.

        $_SESSION['partida']['preguntas'][] = $siguientePregunta;


        /*
         * Si todavía quedan preguntas,
         * mostramos la siguiente.
         */
        header(
            'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/jugar'
        );

        exit();
    }


    /**
     * Endpoint llamado cuando el contador llega a cero.
     */
    public function tiempoAgotado()
    {
        if (!isset($_SESSION['partida'], $_SESSION['usuario_id'])) {
            Redirect::to('/partida/seleccionar');
            exit();
        }


        if (!empty($_SESSION['partida']['perdio'])) {
            Redirect::to('/partida/perder');
            exit();
        }

        if ($_SESSION['partida']['actual'] >= 15) {
            Redirect::to('/partida/ganar');
            exit();
        }


        $indice = $_SESSION['partida']['actual'];
        $pregunta = $_SESSION['partida']['preguntas'][$indice] ?? null;
        $inicio = $_SESSION['partida']['inicio_pregunta'] ?? time();

        // No aceptar una llamada anticipada al endpoint.
        // Esta condición evita aceptar una llamada anticipada al método. También comprueba que exista una pregunta válida.
        if (!$pregunta || time() - $inicio < 8) {
            Redirect::to('/partida/jugar');
            exit();
        }

        $this->prepararDerrotaPorTiempo($pregunta);
        Redirect::to('/partida/perder');
        exit();
    }


    private function prepararDerrotaPorTiempo($pregunta)
    {
        // Evitamos registrar dos veces el mismo fallo.
        if (!empty($_SESSION['partida']['perdio'])) {
            return;
        }

        $usuarioId = $_SESSION['usuario_id'];
        $preguntaId = $pregunta['id'];

        // Guardamos el fallo por tiempo agotado.
        $this->model->registrarResultadoPregunta(
            $usuarioId,
            $preguntaId,
            false
        );

        // Marcamos la partida como perdida.
        $_SESSION['partida']['perdio'] = true;
        $_SESSION['partida']['motivoDerrota'] = 'tiempo';

        $_SESSION['partida']['respuestaIncorrecta'] = null;

        $_SESSION['partida']['respuestaCorrecta'] =
            $this->model->obtenerRespuestaCorrecta($preguntaId);

        $_SESSION['partida']['preguntaPerdida'] = $pregunta;

        $_SESSION['partida']['ultimaPreguntaRespondida'] = [
            'id' => $preguntaId,
            'enunciado' => $pregunta['enunciado']
        ];
    }


    /**
     * Guarda el reporte de la última pregunta contestada.
     */

    public function reportar()
    {
        if (!isset($_SESSION['usuario_id'], $_SESSION['partida'])) {
            Redirect::to('/login');
            exit();
        }

        // Solo se puede reportar cuando el jugador perdió.
        if (empty($_SESSION['partida']['perdio'])) {
            Redirect::to('/partida/jugar');
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

        Redirect::to('/partida/perder');
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/seleccionar'
            );
            exit();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/login'
            );
            exit();
        }


        if (!isset($_SESSION['partida']['preguntaPerdida'])) {
            unset($_SESSION['partida']);

            header(
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/seleccionar'
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/lobby'
            );
            exit();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header(
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/login'
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
                'Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/partida/jugar'
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