<?php

require_once "../vendor/autoload.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();

// projects
$router->get('/', ['App\Controllers\ProjectController', 'index']);


// categories
$router->get('/categories', ['App\Controllers\CategoryController', 'index']);
$router->get('/categories/index', ['App\Controllers\CategoryController', 'index']);


(new App($router, ["method" => $_SERVER["REQUEST_METHOD"], "uri" => $_SERVER["REQUEST_URI"]]))->run();