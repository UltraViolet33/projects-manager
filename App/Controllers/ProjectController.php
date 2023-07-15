<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Project;
use App\Models\Category;

class ProjectController
{

    private Project $projectModel;
    private Category $categoryModel;


    public function __construct()
    {
        $this->projectModel = new Project();
        $this->categoryModel = new Category();

    }


    public function index(): Render
    {
        $projectsInProgress = $this->projectModel->selectProjectsInProgress();
        $allCategories = $this->categoryModel->selectAll();
        return Render::make("projects/index", compact("projectsInProgress", "allCategories"));
    }
}
