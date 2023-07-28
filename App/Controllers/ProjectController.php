<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database\Config;
use App\Core\Helpers\Session;
use App\Core\Render;
use App\Models\Project;
use App\Models\Category;
use App\Models\Tech;

define('PATH_PROJECTS_JSON', dirname(__DIR__) . DIRECTORY_SEPARATOR . "\\Core" . DIRECTORY_SEPARATOR . "data\\projects.json");


class ProjectController extends Controller
{
    // private Project $model;
    private Category $categoryModel;
    private Tech $techModel;

    const PRIORITIES = [
        "0" => "LOW",
        "1" => "HIGH",
    ];


    public function __construct()
    {
        $this->model = new Project();
        $this->categoryModel = new Category();
        $this->techModel = new Tech();
    }


    public function index(): Render
    {
        $allCategories = $this->categoryModel->selectAll();
        $titlePage = "All Projects";
        return Render::make("projects/index", compact("allCategories", "titlePage"));
    }
    

    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if($this->handleSubmitCreate()){
                header("Location: /");
                exit();
            }
        }

        $allCategories = $this->categoryModel->selectAll();
        $allTechs = $this->techModel->selectAll();
        $titlePage = "Create a project";
        return Render::make("/projects/create", compact("allCategories", "allTechs", "titlePage"));
    }


    private function handleSubmitCreate(): bool
    {
        if ($this->submitFormCreateProject()) {
            $project = [
                "name" => $_POST["name"],
                "github_link" => $_POST["github_link"] == "" ? null : $_POST["github_link"],
                "description" => $_POST["description"] == "" ? null : $_POST["description"],
                "priority" => $_POST["priority"],
            ];

            $projectTechs = is_array($_POST["techs"]) ? $_POST["techs"] : [$_POST["techs"]];
            $projectCategories = is_array($_POST["categories"]) ? $_POST["categories"] : [$_POST["categories"]];

            return $this->model->create($project, $projectCategories, $projectTechs);
        }

        return false;
    }


    public function submitFormCreateProject(): bool
    {
        $valuesToCheck = ["name", "categories", "priority", "techs"];

        if (!$this->checkPostValues($valuesToCheck)) {
            return false;
        }

        if ($this->model->doesExist("name", $_POST["name"])) {
            Session::setErrorMsg("Error : Project name already exists !");
            return false;
        }

        return true;
    }


    public function apiGetAllProjects(): string
    {
        $allProjects = $this->model->selectAll();
        return json_encode($allProjects);
    }


    public function apiGetProjectsByCategory(): string
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            return json_encode(["error", "id category missing"]);
        }

        $idCategory = (int) $_GET["id"];
        $projects = $this->model->selectProjectsByCategory($idCategory);

        return json_encode($projects);
    }


    public function apiGetProjectsByStatus(): string
    {
        if (!isset($_GET["status"]) || !is_numeric($_GET["status"])) {
            return json_encode(["error", "status missing"]);
        }

        $status = (int) $_GET["status"];
        $projects = $this->model->selectProjectsByStatus($status);

        return json_encode($projects);
    }


    // public function all(): Render
    // {
    //     $allProjects = $this->projectModel->selectAll();
    //     $allCategories = $this->categoryModel->selectAll();
    //     $projectsTable = $this->makeHTMLProjectsTables($allProjects);
    //     $totalProjects = count($allProjects);
    //     return Render::make("projects/all", compact("projectsTable", "totalProjects", "allCategories"));
    // }


    public function getProjectsPortfolio(): Render
    {
        $projectsPortfolio = $this->model->selectProjectsPortfolio();
        $projectsTable = $this->makeHTMLProjectsTables($projectsPortfolio);
        $totalProjects = count($projectsPortfolio);
        $titlePage = "Portfolio Projects";
        return Render::make("projects/portfolio", compact("projectsTable", "totalProjects", "titlePage"));
    }


    public function getProjectsInProgress(): Render
    {
        $projectsInProgress = $this->model->selectProjectsInProgress();
        $projectsTable = $this->makeHTMLProjectsTables($projectsInProgress);
        $totalProjects = count($projectsInProgress);
        $titlePage = "Projects in progress";
        return Render::make("projects/in-progress", compact("projectsTable", "totalProjects", "titlePage"));
    }


    public function details(): Render
    {
        $idProject = $this->getIdInUrlOrRedirectTo("/");

        $project = $this->getSingleProject($idProject);

        if (!$project) {
            header("Location: /projects/all");
            exit();
        }

        $titlePage = "Details " . $project->name;

        return Render::make("projects/details", compact("project", "titlePage"));
    }


    private function getSingleProject(int $idProject): object
    {
        $project = $this->model->selectByColumn("id_project", $idProject);
        $project->categories = $this->categoryModel->getProjectCategories($idProject);
        $project->techs = $this->techModel->getProjectTechs($idProject);
        return $project;
    }


    public function getSingleProjectJSON(): string
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            return json_encode(["error", "id project missing"]);
        }

        $idProject = (int) $_GET["id"];
        $project = $this->getSingleProject($idProject);

        $project->status = $project->status > 0 ? true : false;
        $project->priority = $project->priority > 0 ? true : false;
        $project->github_portfolio = $project->github_portfolio > 0 ? true : false;


        if (!$project) {
            return json_encode(["error", "project not found"]);
        }

        return json_encode($project);
    }


    public function apiEdit(): string
    {
        $data = file_get_contents("php://input");

        $project = json_decode($data);

        $project->status = $project->status ? 1 : 0;
        $project->priority = $project->priority ? 1 : 0;
        $project->github_portfolio = $project->github_portfolio ? 1 : 0;

        unset($project->categories);
        unset($project->techs);

        $newProject = (array) $project;

        if ($this->model->update($newProject)) {
            $project = $this->getSingleProject($project->id_project);
            $project->status = $project->status > 0 ? true : false;
        }

        return json_encode($project);
    }


    public function edit(): Render
    {
        $idProject = $this->getIdInUrlOrRedirectTo("/");
        $project = $this->getSingleProject($idProject);

        if (!$project) {
            header("Location: /projects/all");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->handleEditProject($project);
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

        $allTechs = $this->techModel->selectAll();

        foreach ($allTechs as $tech) {
            $tech->isInProject = false;

            foreach ($project->techs as $projectTech) {
                if ($projectTech->name === $tech->name) {
                    $tech->isInProject = true;
                }
            }
        }

        $priorities = self::PRIORITIES;
        $titlePage = "Edit " . $project->name;
        return Render::make("projects/edit", compact("project", "allCategories", "allTechs", "priorities", "titlePage"));
    }


    private function handleEditProject(object $project)
    {
        if ($this->submitFormEditProject($project->id_project)) {
            $project = [
                "name" => $_POST["name"],
                "github_link" => $_POST["github_link"] == "" ? null : $_POST["github_link"],
                "description" => $_POST["description"] == "" ? null : $_POST["description"],
                "priority" => $_POST["priority"],
                "created_at" => $_POST["created_at"] == "" ? $project->created_at : $_POST["created_at"],
                "id_project" => $project->id_project
            ];

            $projectTechs = is_array($_POST["techs"]) ? $_POST["techs"] : [$_POST["techs"]];
            $projectCategories = is_array($_POST["categories"]) ? $_POST["categories"] : [$_POST["categories"]];

            if ($this->model->updateProjectWithCategories($project, $projectCategories, $projectTechs)) {
                header("Location: /");
            }

        }
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
            $classPriority = $project->priority ? "bg-danger" : "";

            $html .= '<th scope="row">' . $project->id_project . '</th>
                        <td>' . $project->name . '</td>
                        <td class=' . $classPriority . '> ' . $priority . '</td>

                        <td>' . $created_at . '</td>
                        <td><a href="/projects/details?id=' . $project->id_project . '" class="btn btn-primary">Détails</a></td>
                    </tr>';
        }
        $html .= '
                </tbody>
            </table>';

        return $html;
    }



    public function commitPortfolio()
    {
        $projectsPortfolio = $this->model->selectDataProjectsPortfolio();
        $projectsPortfolioJson = json_encode($projectsPortfolio);

        file_put_contents(PATH_PROJECTS_JSON, $projectsPortfolioJson);

        if (Config::$debug) {
            $command = "sh ../App/Core/commands/push_portfolio_debug.sh";
        } else {
            $command = "sh ../App/Core/commands/push_portfolio.sh";
        }

        shell_exec($command);

        header("Location: /");
    }


    public function submitFormEditProject(int $idProject): bool
    {
        $valuesToCheck = ["name", "categories", "priority"];

        if (!$this->checkPostValues($valuesToCheck)) {
            return false;
        }

        if ($this->model->checkIfNameExistsToEdit($_POST["name"], $idProject)) {
            Session::setErrorMsg("Error : Category name already exists !");
            return false;
        }

        return true;
    }


    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->checkPostValues(["idProject"])) {
                $project = $this->model->selectByColumn("id_project", $_POST["idProject"]);

                if ($this->model->delete($project->id_project)) {
                    header("Location: /projects");
                }
            }
        }

        header("Location: /projects");
    }
}