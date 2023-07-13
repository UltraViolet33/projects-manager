<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Project;

class ProjectController
{

    private Project $projectModel;

    public function __construct()
    {
        $this->projectModel = new Project();
    }


    public function index(): Render
    {
        return Render::make("projects/index");
    }
}
