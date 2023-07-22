<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helpers\Session;
use App\Core\Render;
use App\Models\Project;
use App\Models\Category;

define('PATH_PROJECTS_JSON', dirname(__DIR__) . DIRECTORY_SEPARATOR . "\\Core" . DIRECTORY_SEPARATOR . "data\\projects.json");


class ProjectController extends Controller
{
    private Project $projectModel;
    private Category $categoryModel;

    const PRIORITIES = [
        "0" => "LOW",
        "1" => "HIGH",
    ];


    public function __construct()
    {
        $this->projectModel = new Project();
        $this->categoryModel = new Category();
    }


    public function index(): Render
    {
        $allCategories = $this->categoryModel->selectAll();
        return Render::make("projects/index", compact("allCategories"));
    }


    public function apiGetAllProjects(): string
    {
        $allProjects = $this->projectModel->selectAll();
        return json_encode($allProjects);
    }


    public function all(): Render
    {
        $allProjects = $this->projectModel->selectAll();
        $allCategories = $this->categoryModel->selectAll();
        $projectsTable = $this->makeHTMLProjectsTables($allProjects);
        $totalProjects = count($allProjects);
        return Render::make("projects/all", compact("projectsTable", "totalProjects", "allCategories"));
    }


    public function getProjectsPortfolio(): Render
    {
        $projectsPortfolio = $this->projectModel->selectProjectsPortfolio();
        $projectsTable = $this->makeHTMLProjectsTables($projectsPortfolio);
        $totalProjects = count($projectsPortfolio);
        return Render::make("projects/portfolio", compact("projectsTable", "totalProjects"));
    }

    public function getProjectsInProgress(): Render
    {
        $projectsInProgress = $this->projectModel->selectProjectsInProgress();
        $projectsTable = $this->makeHTMLProjectsTables($projectsInProgress);
        $totalProjects = count($projectsInProgress);
        return Render::make("projects/in-progress", compact("projectsTable", "totalProjects"));
    }


    private function getSingleProject(int $idProject): object
    {
        $project  = $this->projectModel->selectByColumn("id_project", $idProject);
        $project->categories = $this->categoryModel->getProjectCategories($idProject);
        return $project;
    }


    public function getSingleProjectJSON(): string
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            return json_encode(["error", "id project missing"]);
        }

        $idProject = (int) $_GET["id"];
        $project  = $this->getSingleProject($idProject);

        $project->status = $project->status > 0 ? true : false;
        $project->priority = $project->priority > 0 ? true : false;
        $project->github_portfolio = $project->github_portfolio > 0 ? true : false;


        if (!$project) {
            return json_encode(["error", "project not found"]);
        }

        return json_encode($project);
    }


    public function apiGetProjectsByStatus(): string
    {
        if (!isset($_GET["status"]) || !is_numeric($_GET["status"])) {
            return json_encode(["error", "status missing"]);
        }

        $status = (int) $_GET["status"];
        $projects  = $this->projectModel->selectProjectsByStatus($status);

        return json_encode($projects);
    }


    public function apiGetProjectsByCategory(): string
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            return json_encode(["error", "id category missing"]);
        }

        $idCategory = (int) $_GET["id"];
        $projects  = $this->projectModel->selectProjectsByCategory($idCategory);

        return json_encode($projects);
    }


    public function apiEdit(): string
    {
        $data = file_get_contents("php://input");

        $project = json_decode($data);

        $project->status = $project->status ? 1 : 0;
        $project->priority = $project->priority ? 1 : 0;
        $project->github_portfolio = $project->github_portfolio ? 1 : 0;

        unset($project->categories);
        $newProject = (array) $project;

        if ($this->projectModel->update($newProject)) {
            $project  = $this->getSingleProject($project->id_project);

            $project->status = $project->status > 0 ? true : false;
            return json_encode($project);
        }

        return json_encode($project);
    }


    public function edit(): Render
    {
        $idProject = $this->getIdInUrlOrRedirectTo("/");
        $project  = $this->getSingleProject($idProject);

        if (!$project) {
            header("Location: /projects/all");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->submitFormEditProject($idProject)) {
                $project = [
                    "name" => $_POST["name"],
                    "github_link" => $_POST["github_link"] == "" ? null : $_POST["github_link"],
                    "description" => $_POST["description"] == "" ? null : $_POST["description"],
                    "priority" => $_POST["priority"],
                    "created_at" => $_POST["created_at"] == "" ? $project->created_at : $_POST["created_at"],
                    "id_project" => $idProject
                ];

                $projectCategories = $_POST["categories"];

                if (is_string($projectCategories)) {
                    $projectCategories = [];
                    $projectCategories[] = $_POST["categories"];
                }

                if ($this->projectModel->updateProjectWithCategories($project, $projectCategories)) {
                    header("Location: /");
                }
            }
        }

        $allCategories = $this->categoryModel->selectAll();

        foreach ($allCategories as $category) {
            $category->isInProject = false;

            foreach ($project->categories as $projectCategory) {
                if ($projectCategory->name === $category->name) {
                    $category->isInProject = true;
                }
            }
        }

        $priorities = self::PRIORITIES;
        return Render::make("projects/edit", compact("project", "allCategories", "priorities"));
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
                <th scope="col">Priority</th>
                <th scope="col">Created At</th>
                <th scope="col">DETAILS</th>
             </tr>
             </thead>
             <tbody>';
        foreach ($projects as $project) {

            $created_at = date('d/m/yy', strtotime($project->created_at));
            $priority = $project->priority ? "high" : "";

            $html .= '<th scope="row">' . $project->id_project . '</th>
                        <td>' . $project->name . '</td>
                        <td>' . $priority  . '</td>

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

                $projectCategories = $_POST["categories"];

                if (is_string($projectCategories)) {
                    $projectCategories = [];
                    $projectCategories[] = $_POST["categories"];
                }

                if ($this->projectModel->create($project, $projectCategories)) {
                    header("Location: /");
                }
            }
        }

        $allCategories = $this->categoryModel->selectAll();

        return Render::make("/projects/create", compact("allCategories"));
    }


    public function commitPortfolio() 
    {
        $projectsPortfolio = $this->projectModel->selectProjectsPortfolio();
        // var_dump($projectsPortfolio);
        $projectsPortfolioJson = json_encode($projectsPortfolio);
        // echo $projectsPortfolioJson;
        var_dump(PATH_PROJECTS_JSON);
        // die;
        file_put_contents(PATH_PROJECTS_JSON, $projectsPortfolioJson);
        // $commands = file_get_contents("./core/classes/pushPortfolio.sh");
        $test = shell_exec("sh ../App/Core/commands/push_portfolio.sh");
        // $test = shell_exec("pwd");

        var_dump($test);
        header("Location: /");
    }


    public function submitFormEditProject(int $idProject): bool
    {
        $valuesToCheck = ["name", "categories", "priority"];

        if (!$this->checkPostValues($valuesToCheck)) {
            return false;
        }

        if ($this->projectModel->checkIfNameExistsToEdit($_POST["name"], $idProject)) {
            Session::setErrorMsg("Error : Category name already exists !");
            return false;
        }

        return true;
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


    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->checkPostValues(["idProject"])) {
                $project = $this->projectModel->selectByColumn("id_project", $_POST["idProject"]);

                if ($this->projectModel->delete($project->id_project)) {
                    header("Location: /projects");
                }
            }
        }

        header("Location: /projects");
    }
}
