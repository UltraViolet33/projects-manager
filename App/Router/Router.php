<?php
declare(strict_types=1);

namespace App\Router;

class Router
{
    private array $routes = [];


    public function register(string $path, callable|array $action, string $requestedMethod): void
    {
        $this->routes[$requestedMethod][$path] = $action;
    }


    public function get(string $path, callable|array $action): void
    {
        $this->register($path, $action, 'GET');
    }


    public function post(string $path, callable|array $action): void
    {
        $this->register($path, $action, 'POST');
    }


    public function resolve(string $method, string $uri): mixed
    {
        $path = explode('?', $uri)[0];
      
        $action = $this->routes[$method][$path] ?? null;

      

        if (is_callable($action)) {
            return $action();
        }

        if (is_array($action)) {
            [$class, $classMethod] = $action;

            if (class_exists($class) && method_exists($class, $classMethod)) {
                $controller = new $class();
                return call_user_func_array([$controller, $classMethod], []);
            }
        }
    }


    public function getRoutes(): array
    {
        return $this->routes;
    }
}