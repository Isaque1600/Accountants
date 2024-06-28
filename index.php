<?php

require_once ('./vendor/autoload.php');

use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$url = new Core\ConfigController();

if (!isset($_COOKIE['PHPSESSID'])) {
    header("location:../Login/?cod=401");
}

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['newsession'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("location:../Login/?cod=401");
}

if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser'] != 0) {
    header("location:../Login/?cod=401");
}

$url->loadPage();