<?php

namespace App\Controllers;

use App\Core\Render;


class ProjectController
{


    public function __construct()
    {
    }


    public function index(): Render
    {
        return Render::make("projects/index");
    }
}
