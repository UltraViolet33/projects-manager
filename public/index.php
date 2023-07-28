<?php

require_once "../vendor/autoload.php";

use App\Core\App;
use App\Router\Router;

$router = new Router();

// projects
$router->get('/', ['App\Controllers\ProjectController', 'index']);
$router->get('/projects', ['App\Controllers\ProjectController', 'index']);
$router->get('/projects/details', ['App\Controllers\ProjectController', 'details']);

$router->get('/projects/portfolio', ['App\Controllers\ProjectController', 'getProjectsPortfolio']);

$router->get('/projects/in-progress', ['App\Controllers\ProjectController', 'getProjectsInProgress']);
$router->get('/projects/commit-portfolio', ['App\Controllers\ProjectController', 'commitPortfolio']);

$router->get('/projects/edit', ['App\Controllers\ProjectController', 'edit']);
$router->post('/projects/edit', ['App\Controllers\ProjectController', 'edit']);

$router->get('/projects/create', ['App\Controllers\ProjectController', 'create']);
$router->post('/projects/create', ['App\Controllers\ProjectController', 'create']);

$router->post('/projects/delete', ['App\Controllers\ProjectController', 'delete']);

// api projects
$router->get('/api/projects/all', ['App\Controllers\ProjectController', 'apiGetAllProjects']);
$router->get('/api/projects/category', ['App\Controllers\ProjectController', 'apiGetProjectsByCategory']);
$router->get('/api/projects/status', ['App\Controllers\ProjectController', 'apiGetProjectsByStatus']);

$router->get('/api/projects/single-project', ['App\Controllers\ProjectController', 'getSingleProjectJSON']);
$router->post('/api/projects/edit', ['App\Controllers\ProjectController', 'apiEdit']);


// categories
$router->get('/categories', ['App\Controllers\CategoryController', 'index']);
$router->get('/categories/index', ['App\Controllers\CategoryController', 'index']);

$router->get('/categories/create', ['App\Controllers\CategoryController', 'create']);
$router->post('/categories/create', ['App\Controllers\CategoryController', 'create']);

$router->get('/categories/edit', ['App\Controllers\CategoryController', 'edit']);
$router->post('/categories/edit', ['App\Controllers\CategoryController', 'edit']);

$router->post('/categories/delete', ['App\Controllers\CategoryController', 'delete']);


//technologies
$router->get('/techs', ['App\Controllers\TechController', 'index']);
$router->get('/techs/all', ['App\Controllers\TechController', 'index']);

$router->get('/techs/create', ['App\Controllers\TechController', 'create']);
$router->post('/techs/create', ['App\Controllers\TechController', 'create']);

$router->get('/techs/edit', ['App\Controllers\TechController', 'edit']);
$router->post('/techs/edit', ['App\Controllers\TechController', 'edit']);

$router->post('/techs/delete', ['App\Controllers\TechController', 'delete']);


(new App($router, ["method" => $_SERVER["REQUEST_METHOD"], "uri" => $_SERVER["REQUEST_URI"]]))->run();