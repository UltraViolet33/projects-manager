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


class PortfolioController extends Controller
{
    private Category $categoryModel;
    private Tech $techModel;


    public function __construct()
    {
        $this->model = new Project();
        $this->categoryModel = new Category();
        $this->techModel = new Tech();
    }


    public function index(): Render
    {
        $titlePage = "All portfolios";
        $allPortfolios = [];
        return Render::make("portfolios/index", compact("titlePage", "allPortfolios"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if($this->checkPostValues(['name', 'category']))
            {
                var_dump($_POST);
                die;

                header('Location: /portfolio');
            }
            // if ($this->handleSubmitCreate()) {
            //     header("Location: /");
            //     exit();
            // }
        }

        $allCategories = $this->categoryModel->selectAll();

        $titlePage = "Create a portfolio";
        
        return Render::make("/portfolios/create", compact("allCategories", "titlePage"));
    }



}
