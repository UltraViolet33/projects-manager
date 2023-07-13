<?php

require_once "../vendor/autoload.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();

$router->get('/', ['App\Controllers\ProjectController', 'index']);

(new App($router, ["method" => $_SERVER["REQUEST_METHOD"], "uri" => $_SERVER["REQUEST_URI"]]))->run();