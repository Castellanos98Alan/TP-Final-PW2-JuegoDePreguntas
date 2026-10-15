<?php

namespace app\controller;

use Redirect;

class RegistroController
{
    private $render;
    private $model;

    public function __construct($model, $render)
    {
        $this->model = $model;
        $this->render = $render;
    }

    public function show()
    {
        $this->render->renderiza("registro");
    }

    public function registrar()
    {
        $datos = $_POST;
        $foto  = $_FILES['foto_perfil'] ?? null;
        $camposObligatorios = [
            'nombre_completo'  => 'Nombre completo',
            'anio_nacimiento'  => 'Año de nacimiento',
            'sexo'             => 'Sexo',
            'pais'             => 'País',
            'ciudad'           => 'Ciudad',
            'mail'             => 'Correo electrónico',
            'username'         => 'Nombre de usuario',
            'password'         => 'Contraseña',
            'repetir_password' => 'Repetir contraseña'
        ];
        foreach ($camposObligatorios as $campo => $nombreVisible) {
            if (empty(trim($datos[$campo] ?? ''))) {
                $this->mostrarError("El campo '$nombreVisible' es obligatorio.", $datos);
                return;
            }
        }
        $anio = (int)$datos['anio_nacimiento'];
        $anioActual = (int)date('Y');
        if ($anio < 1920 || $anio > $anioActual) {
            $this->mostrarError("El año de nacimiento debe estar entre 1920 y $anioActual.", $datos);
            return;
        }
        $sexosValidos = ['Masculino', 'Femenino', 'Prefiero no cargarlo'];
        if (!in_array($datos['sexo'], $sexosValidos)) {
            $this->mostrarError("El sexo seleccionado no es válido.", $datos);
            return;
        }
        if (!filter_var($datos['mail'], FILTER_VALIDATE_EMAIL)) {
            $this->mostrarError("El correo electrónico ingresado no tiene un formato válido.", $datos);
            return;
        }
        if ($datos['password'] !== $datos['repetir_password']) {
            $this->mostrarError("Las contraseñas no coinciden.", $datos);
            return;
        }
        if (!$foto || $foto['error'] !== UPLOAD_ERR_OK) {
            $this->mostrarError("Debe seleccionar una foto de perfil.", $datos);
            return;
        }
        $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionesPermitidas)) {
            $this->mostrarError("La foto de perfil debe ser un archivo JPG, JPEG o PNG.", $datos);
            return;
        }

        $resultado = $this->model->registrarUsuario($datos, $foto);

        if (!$resultado['exito']) {
            $this->mostrarError($resultado['error'], $datos);
            return;
        }

        Redirect::toIndex();}

    private function mostrarError($mensajeError, $datosPrevios)
    {
        $datosParaVista = $datosPrevios;
        $datosParaVista['error'] = $mensajeError;

        $this->render->renderiza("registro", $datosParaVista);
    }
}