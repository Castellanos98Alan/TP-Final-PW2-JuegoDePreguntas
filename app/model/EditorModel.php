<?php

namespace app\model;

class EditorModel{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getPreguntasPendientes(){
        $sql = "SELECT id, descripcion, categoria, 'Sugerida' AS creador
                FROM pregunta
                WHERE esta_activa = 0
                ORDER BY id DESC";

        return $this->database->queryAll($sql);
    }

    public function getPreguntasActivas(){
        $sql = "SELECT id, descripcion, categoria
                FROM pregunta
                WHERE esta_activa = 1
                ORDER BY id DESC";

        return $this->database->queryAll($sql);
    }

    public function getPreguntaPorId($idPregunta){
        $sql = "SELECT id, descripcion, categoria, esta_activa
                FROM pregunta
                WHERE id = :id";
        $pregunta = $this->database->queryOne($sql, ['id' => $idPregunta]);

        if ($pregunta) {
            $sqlOpciones = "SELECT id, descripcion, es_correcta
                            FROM opcion
                            WHERE pregunta_id = :id";
            $pregunta['opciones'] = $this->database->queryAll($sqlOpciones, ['id' => $idPregunta]);
        }

        return $pregunta ?: null;
    }

    public function actualizarPregunta($idPregunta, $descripcion, $categoria, array $opciones, $idOpcionCorrecta){
        $sqlPregunta = "UPDATE pregunta
                        SET descripcion = :descripcion, categoria = :categoria
                        WHERE id = :id";
        $this->database->execute($sqlPregunta, [
            'descripcion' => $descripcion,
            'categoria'   => $categoria,
            'id'          => $idPregunta
        ]);

        $sqlOpcion = "UPDATE opcion
                      SET descripcion = :descripcion, es_correcta = :es_correcta
                      WHERE id = :id AND pregunta_id = :pregunta_id";

        foreach ($opciones as $opcionId => $textoOpcion) {
            $this->database->execute($sqlOpcion, [
                'descripcion' => $textoOpcion,
                'es_correcta' => ((int)$opcionId === (int)$idOpcionCorrecta) ? 1 : 0,
                'id'          => $opcionId,
                'pregunta_id' => $idPregunta
            ]);
        }

        return true;
    }

    public function getReportesPendientes(){
        $sql = "SELECT r.id AS reporte_id, r.motivo, r.comentario, r.pregunta_id,
                       p.descripcion AS pregunta_descripcion, p.categoria
                FROM reporte_pregunta r
                INNER JOIN pregunta p ON r.pregunta_id = p.id
                WHERE r.estado = 'pendiente'
                ORDER BY r.id DESC";

        return $this->database->queryAll($sql);
    }

    public function resolverReporte($idReporte, $accion = 'resuelto'){
        $sql = "UPDATE reporte_pregunta SET estado = :estado WHERE id = :id";
        return $this->database->execute($sql, [
            'estado' => $accion,
            'id'     => $idReporte
        ]);
    }

    public function aprobarPregunta($idPregunta){
        $sql = "UPDATE pregunta SET esta_activa = 1 WHERE id = :id";
        return $this->database->execute($sql, ['id' => $idPregunta]);
    }

    public function inactivarPregunta($idPregunta){
        $sql = "UPDATE pregunta SET esta_activa = 0 WHERE id = :id";
        return $this->database->execute($sql, ['id' => $idPregunta]);
    }


    public function crearPreguntaConOpciones($descripcion, $categoria, $creadorId, array $opciones, $correctaIndice){
        $sqlPregunta = "INSERT INTO pregunta (descripcion, categoria, esta_activa, veces_mostrada, veces_acertada)
                        VALUES (:descripcion, :categoria, 1, 0, 0)";
        $this->database->execute($sqlPregunta, [
            'descripcion' => $descripcion,
            'categoria'   => $categoria
        ]);

        $idPregunta = $this->database->lastInsertId();

        $sqlOpcion = "INSERT INTO opcion (pregunta_id, descripcion, es_correcta)
                      VALUES (:pregunta_id, :descripcion, :es_correcta)";

        foreach ($opciones as $indice => $textoOpcion) {
            $this->database->execute($sqlOpcion, [
                'pregunta_id' => $idPregunta,
                'descripcion' => trim($textoOpcion),
                'es_correcta' => ($indice === $correctaIndice) ? 1 : 0
            ]);
        }

        return $idPregunta;
    }
}