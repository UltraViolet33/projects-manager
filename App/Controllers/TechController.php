<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helpers\Session;
use App\Core\Render;
use App\Models\Tech;

class TechController extends Controller
{
    public function __construct()
    {
        $this->model = new Tech();
    }


    public function index(): Render
    {
        $allTechs = $this->model->selectAll();
        $titlePage = "All Techs";
        return Render::make("techs/index", compact("allTechs", "titlePage"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($this->handleSubmitCreate()) {
                header("Location: /techs");
                exit();
            }
        }

        $titlePage = "Create Tech";
        return Render::make("/techs/create", compact("titlePage"));
    }


    private function handleSubmitCreate(): bool
    {
        if (!isset($_POST["name"]) || empty($_POST["name"])) {
            Session::setErrorMsg("Error : Missing name field !");
            return false;
        }

        $name = $_POST["name"];

        if ($this->doesNameAlreadyExists($name)) {
            Session::setErrorMsg("Error : Tech name already exists !");
            return false;
        }

        return $this->model->create($name);
    }


    public function edit(): Render
    {
        $idTech = $this->getIdInUrlOrRedirectTo("/techs");
        $tech = $this->model->selectByColumn("id_tech", $idTech);

        if (!$tech) {
            header("Location: /techs");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($this->handleSubmitEdit($tech)) {
                header("Location: /techs");
                exit();
            }
        }

        $titlePage = "Edit " . $tech->name;
        return Render::make("/techs/edit", compact("tech", "titlePage"));
    }


    private function handleSubmitEdit(object $tech): bool
    {
        if (!isset($_POST["name"]) || empty($_POST["name"])) {
            Session::setErrorMsg("Error : Missing name field !");
            return false;
        }

        $name = $_POST["name"];

        if ($this->isNameAvailableToEdit($name, $tech->id_tech)) {
            $this->model->update(["name" => $_POST["name"], "id" => $tech->id_tech]);
            return true;
        }

        Session::setErrorMsg("Error : Tech name already exists !");
        return false;
    }


    public function delete(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["id_tech"]) && !empty($_POST["id_tech"])) {
                $tech = $this->model->selectByColumn("id_tech", $_POST["id_tech"]);

                if (!$tech) {
                    // not found tech
                }

                $this->model->delete($tech->id_tech);
            }
        }

        header("Location: /techs");
        exit();
    }
}