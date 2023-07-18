<?php

require_once "../vendor/autoload.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();

// projects
$router->get('/', ['App\Controllers\ProjectController', 'index']);
$router->get('/projects/in-progress', ['App\Controllers\ProjectController', 'index']);

$router->get('/projects/all', ['App\Controllers\ProjectController', 'all']);
$router->get('/projects', ['App\Controllers\ProjectController', 'all']);


$router->get('/projects/details', ['App\Controllers\ProjectController', 'details']);

$router->get('/projects/edit', ['App\Controllers\ProjectController', 'edit']);
$router->post('/projects/edit', ['App\Controllers\ProjectController', 'edit']);

$router->get('/projects/create', ['App\Controllers\ProjectController', 'create']);
$router->post('/projects/create', ['App\Controllers\ProjectController', 'create']);

$router->post('/projects/delete', ['App\Controllers\ProjectController', 'delete']);

$router->get('/api/projects/single-project', ['App\Controllers\ProjectController', 'getSingleProjectJSON']);




// categories
$router->get('/categories', ['App\Controllers\CategoryController', 'index']);
$router->get('/categories/index', ['App\Controllers\CategoryController', 'index']);

$router->get('/categories/create', ['App\Controllers\CategoryController', 'create']);
$router->post('/categories/create', ['App\Controllers\CategoryController', 'create']);

$router->get('/categories/edit', ['App\Controllers\CategoryController', 'edit']);
$router->post('/categories/edit', ['App\Controllers\CategoryController', 'edit']);

$router->post('/categories/delete', ['App\Controllers\CategoryController', 'delete']);


(new App($router, ["method" => $_SERVER["REQUEST_METHOD"], "uri" => $_SERVER["REQUEST_URI"]]))->run();