<?php

namespace Sts\Controllers;

class NotFound
{

    public function index($parameters = null)
    {
        die("Page Not Found, error 404");
    }

}