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


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // if ($this->submitFormCategory()) {

            //     if ($this->categoryModel->create($_POST["name"])) {
            //         header("Location: /categories");
            //     }
            // }
        }

        return Render::make("/projects/create");
    }
}
