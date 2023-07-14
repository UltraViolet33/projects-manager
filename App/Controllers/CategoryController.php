<?php

namespace App\Controllers;

use App\Core\Helpers\Session;
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

            if ($this->submitFormCreateCategory()) {

                if ($this->categoryModel->create($_POST["name"])) {
                    header("Location: /categories");
                }
            }
        }

        return Render::make("/categories/create");
    }

    public function edit(): Render
    {
        $idCategory = $this->getIdInUrlOrRedirectTo("/categories");

        $category = $this->categoryModel->selectByColumn("id_category", $idCategory);

        if (!$category) {
            header("Location: /categories");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->submitFormCreateCategory()) {

                // if ($this->categoryModel->create($_POST["name"])) {
                // header("Location: /categories");
                // }
            }
        }



        return Render::make("/categories/edit", compact("category"));
    }


    private function submitFormCreateCategory(): bool
    {
        if ($this->categoryModel->doesExist("name", $_POST["name"])) {
            Session::setErrorMsg("Error : Category name already exists !");
            return false;
        }

        if (!$this->checkPostValues(["name"])) {
            return false;
        }

        return true;
    }
}
