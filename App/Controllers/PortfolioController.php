<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Render;
use App\Models\Project;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Tech;

define('PATH_PROJECTS_JSON', dirname(__DIR__) . DIRECTORY_SEPARATOR . "\\Core" . DIRECTORY_SEPARATOR . "data\\projects.json");


class PortfolioController extends Controller
{
    private Category $categoryModel;
    private Tech $techModel;
    private Project $projectModel;


    public function __construct()
    {
        $this->model = new Portfolio();
        $this->categoryModel = new Category();
        $this->techModel = new Tech();
        $this->projectModel = new Project();
    }


    public function index(): Render
    {
        $titlePage = "All portfolios";
        $allPortfolios = $this->model->selectNameWithCategory();
        return Render::make("portfolios/index", compact("titlePage", "allPortfolios"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($this->checkPostValues(['name', 'category_id'])) {
                $this->model->create(['name' => $_POST["name"], 'category_id' => $_POST["category_id"]]);
                header('Location: /portfolios');
            }
        }

        $allCategories = $this->categoryModel->selectAll();
        $titlePage = "Create a portfolio";
        return Render::make("/portfolios/create", compact("allCategories", "titlePage"));
    }


    public function addProjects(): Render
    {
        $idPortfolio = $this->getIdInUrlOrRedirectTo("/portfolios");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($this->checkPostValues(['projects'])) {
                $this->model->deleteProjectsPortfolio($idPortfolio);
                $this->model->addProjects($_POST["projects"], $idPortfolio);
                header('Location: /portfolios');
            }
        }

        $portfolio = $this->model->selectByColumn("id_portfolio", $idPortfolio);
        $projects = $this->projectModel->selectProjectsByCategory($portfolio->category_id);
        $portfolioProjects = $this->model->selectProjectsPortfolio($idPortfolio);

        foreach ($projects as $project) {
            $project->isInPortfolio = false;
            foreach ($portfolioProjects as $pp) {
                if ($project->id_project === $pp->id_project) {
                    $project->isInPortfolio = true;
                }
            }
        }
        $titlePage = "add projects to portfolio";
        return Render::make("/portfolios/add_projects", compact("projects", "titlePage"));
    }


    public function projects(): Render
    {
        $idPortfolio = $this->getIdInUrlOrRedirectTo("/portfolios");
        $portfolio = $this->model->selectByColumn("id_portfolio", $idPortfolio);

        if (!$portfolio) {
            header("Location: /portfolios");
            exit();
        }

        $titlePage = "Portfolio " . $portfolio->name;
        $projects = [];

        $projects = $this->model->selectProjectsPortfolio($idPortfolio);
        return Render::make("/portfolios/projects", compact("portfolio", "projects", "titlePage"));
    }


    public function commitAllPortfolio(): void
    {
        $final_data = [];
        $allPortfolios = $this->model->selectNameWithCategory();

        foreach($allPortfolios as $p) {
            $projectsPortfolio = $this->model->selectProjectsPortfolio($p->id_portfolio);
            $projectsPortfolio = array_map(function ($project) {
                $techs = $this->techModel->getProjectTechs($project->id_project);
                $project->techs = array_map(fn($tech) => $tech->name, $techs);
                return $project;
    
            }, $projectsPortfolio);
            $final_data[$p->category_name] = $projectsPortfolio;
        }

        $final_data = json_encode($final_data);
        file_put_contents(PATH_PROJECTS_JSON, $final_data);

        // if (Config::$debug) {
        //     $command = "sh ../App/Core/commands/push_portfolio_debug.sh";
        // } else {
        //     $command = "sh ../App/Core/commands/push_portfolio.sh";
        // }

        // shell_exec($command);

        header("Location: /");
        exit();
    }
}
