<?php

namespace app\model;

class EditorModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
}