<?php

use App\App;
use App\Lib\ErroView;

error_reporting(E_ALL & ~E_NOTICE);

require_once("vendor/autoload.php");
require_once("App/Lib/BibliotecaGlobal.php");
//CORRIGE DATA/HORA DE VERÃO
date_default_timezone_set("America/Fortaleza");
session_start();

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    $error = new ErroView(500);
    $error->render();
}
