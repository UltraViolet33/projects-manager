<?php

declare(strict_types=1);

namespace App\Core;

use App\Router\Router;
use Exception;

class App
{

    private Router $router;
    private array $requestURI;


    public function __construct(Router $router, array $requestURI)
    {
        $this->router = $router;
        $this->requestURI = $requestURI;
    }


    public function run(): void
    {
        try {
            echo $this->router->resolve($this->requestURI['method'], $this->requestURI['uri']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}