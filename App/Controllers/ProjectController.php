<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helpers\Session;
use App\Core\Render;
use App\Models\Project;
use App\Models\Category;

class ProjectController extends Controller
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


    public function all(): Render
    {
        $allProjects = $this->projectModel->selectAll();
        $allCategories = $this->categoryModel->selectAll();
        return Render::make("projects/all", compact("allProjects", "allCategories"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->submitFormCreateProject()) {
                $project = [
                    "name" => $_POST["name"],
                    "github_link" => $_POST["github_link"] == "" ? null : $_POST["github_link"],
                    "description" => $_POST["description"] == "" ? null : $_POST["description"],
                    "priority" => $_POST["priority"],
                ];

                if ($this->projectModel->create($project)) {
                    header("Location: /");
                }
            }
        }

        $allCategories = $this->categoryModel->selectAll();

        return Render::make("/projects/create", compact("allCategories"));
    }


    public function submitFormCreateProject(): bool
    {
        $valuesToCheck = ["name", "categories", "priority"];

        if (!$this->checkPostValues($valuesToCheck)) {
            return false;
        }

        if ($this->projectModel->doesExist("name", $_POST["name"])) {
            Session::setErrorMsg("Error : Category name already exists !");
            return false;
        }

        return true;
    }
}
