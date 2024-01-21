<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database\Config;
use App\Core\Helpers\Session;
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


    public function __construct()
    {
        $this->model = new Portfolio();
        $this->categoryModel = new Category();
        $this->techModel = new Tech();
    }


    public function index(): Render
    {
        $titlePage = "All portfolios";
        $allPortfolios = $this->model->selectNameWithCategory();
        var_dump($allPortfolios);
        // die;
     
        return Render::make("portfolios/index", compact("titlePage", "allPortfolios"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if($this->checkPostValues(['name', 'category_id']))
            {
                var_dump($_POST);
                $this->model->create(['name' => $_POST["name"], 'category_id' => $_POST["category_id"]]);

                header('Location: /portfolios');
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
