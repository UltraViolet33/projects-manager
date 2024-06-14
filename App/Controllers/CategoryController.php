<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helpers\Session;
use App\Core\Render;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->model = new Category();
    }


    public function index(): Render
    {
        $allCategories = $this->model->selectAll();
        $titlePage = "All Categories";
        return Render::make("categories/index", compact("allCategories", "titlePage"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($this->handleSubmitCreate()) {
                header("Location: /categories");
                exit();
            }
        }

        $titlePage = "Create category";
        return Render::make("/categories/create", compact("titlePage"));
    }


    private function handleSubmitCreate(): bool
    {
        if (!isset($_POST["name"]) || empty($_POST["name"])) {
            Session::setErrorMsg("Error : Missing name field !");
            return false;
        }

        $name = $_POST["name"];

        if ($this->doesNameAlreadyExists($name)) {
            Session::setErrorMsg("Error : Category name already exists !");
            return false;
        }

        return $this->model->create($name);
    }


    public function edit(): Render
    {
        $idCategory = $this->getIdInUrlOrRedirectTo("/categories");
        $category = $this->model->selectByColumn("id_category", $idCategory);

        if (!$category) {
            header("Location: /categories");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->handleSubmitEdit($category)) {
                header("Location: /categories");
                exit();
            }
        }

        $titlePage = "Edit " . $category->name;
        return Render::make("/categories/edit", compact("category", "titlePage"));
    }


    private function handleSubmitEdit(object $category): bool
    {
        if (!isset($_POST["name"]) || empty($_POST["name"])) {
            Session::setErrorMsg("Error : Missing name field !");
            return false;
        }

        $name = $_POST["name"];

        if ($this->isNameAvailableToEdit($name, $category->id_category)) {
            $this->model->update(["name" => $_POST["name"], "id_category" => $category->id_category]);
            return true;
        }

        Session::setErrorMsg("Error : Category name already exists !");
        return false;
    }


    public function delete(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if (isset($_POST["id_category"]) && !empty($_POST["id_category"])) {

                $category = $this->model->selectByColumn("id_category", $_POST["id_category"]);

                if (!$category) {
                    // not found category
                }

                $this->model->delete($category->id_category);
            }
        }

        header("Location: /categories");
        exit();
    }
}
