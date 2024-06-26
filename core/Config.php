<?php

namespace Core;

abstract class Config
{

    public function __construct()
    {

        ini_set("session.cookie_lifetime", 0);
        ini_set("gc_maxlifetime", 1440);
        error_reporting(E_ALL);
        date_default_timezone_set("America/Recife");

        define("DEFAULT_URL", $_ENV['BASEURL'] . "/");

        define("CSS_URL", DEFAULT_URL . "assets/css/");
        define("JS_URL", DEFAULT_URL . "assets/js/");
        define("IMG_URL", DEFAULT_URL . "assets/images/");
        define("ARCHIVES_URL", DEFAULT_URL . "arc");

        define("ARCHIVES_PATH", dirname(__DIR__) . "/arc");

    }

}
