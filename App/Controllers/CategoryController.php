<?php

declare(strict_types=1);

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

            if ($this->submitFormCategory()) {

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

            if ($this->submitFormEditCategory($category->id_category)) {
                echo "test";

                if ($this->categoryModel->update(["name" => $_POST["name"], "id_category" => $category->id_category])) {
                    header("Location: /categories");
                }
            }
        }


        return Render::make("/categories/edit", compact("category"));
    }


    private function submitFormCategory(): bool
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

    private function submitFormEditCategory(int $idCategory): bool
    {
        if ($this->categoryModel->checkIfNameExistsToEdit($_POST["name"], $idCategory)) {
            Session::setErrorMsg("Error : Category name already exists !");
            return false;
        }

        if (!$this->checkPostValues(["name"])) {
            return false;
        }


        return true;
    }
}
