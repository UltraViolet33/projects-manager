<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Category;

class CategoryController extends Controller
{

    private Category $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }


    public function index(): Render
    {
        $allCategories = $this->categoryModel->selectAll();
        return Render::make("categories/index", compact("allCategories"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->checkPostValues(["name"])) {
                $this->categoryModel->create($_POST["name"]);
                header("Location: /categories");
            }
            
        }

        return Render::make("/categories/create");
    }
}
