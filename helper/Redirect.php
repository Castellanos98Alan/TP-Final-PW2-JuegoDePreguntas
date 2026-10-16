<?php

class Redirect
{
    public static function to($url)
    {
        header("Location: /TP-Final-PW2-JuegoDePreguntas" . $url);
        exit();
    }

    public static function toIndex()
    {
        self::to('/');
    }

    public static function toLobby()
    {
        self::to('/?controller=lobby&method=show');
    }
}