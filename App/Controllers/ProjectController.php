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

        $projectsTable = $this->makeHTMLProjectsTables($projectsInProgress);
        $totalProjects = count($projectsInProgress);
        return Render::make("projects/index", compact("projectsTable", "totalProjects", "allCategories"));
    }


    public function all(): Render
    {
        $allProjects = $this->projectModel->selectAll();
        $allCategories = $this->categoryModel->selectAll();
        $projectsTable = $this->makeHTMLProjectsTables($allProjects);
        $totalProjects = count($allProjects);
        return Render::make("projects/all", compact("projectsTable", "totalProjects", "allCategories"));
    }

    private function getSingleProject(int $idProject): object 
    {
        $project  = $this->projectModel->selectByColumn("id_project", $idProject);
        $project->categories = $this->categoryModel->getProjectCategories($idProject);
        return $project;
    }


    public function details(): Render
    {

        $idProject = $this->getIdInUrlOrRedirectTo("/");

        $project  = $this->getSingleProject($idProject);

        if (!$project) {
            header("Location: /projects/all");
        }

        return Render::make("projects/details", compact("project"));
    }

    public function makeHTMLProjectsTables(array $projects): string
    {
        $html = "";

        if (!$projects) {
            return "<p>There is no projects in progress</p>";
        }

        $html .= '<table class="table">
             <thead>
             <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Created At</th>
                <th scope="col">DETAILS</th>
             </tr>
             </thead>
             <tbody>';
        foreach ($projects as $project) {

            $created_at = date('d/m/yy', strtotime($project->created_at));

            $html .= '<th scope="row">' . $project->id_project . '</th>
                        <td>' . $project->name . '</td>
                        <td>' . $created_at . '</td>
                        <td><a href="/projects/details?id=' . $project->id_project . '" class="btn btn-primary">Détails</a></td>
                    </tr>';
        }
        $html .= '
                </tbody>
            </table>';

        return $html;
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
