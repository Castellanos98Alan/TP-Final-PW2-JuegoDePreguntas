<?php

class Redirect
{
    public static function to($url)
    {
        $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        if (substr($url, 0, 1) !== '/') {
            $url = '/' . $url;
        }

        header("Location: " . $baseDir . $url);
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