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
            }
        }

        $titlePage = "Create Tech";
        return Render::make("/techs/create", compact("titlePage"));
    }


    private function handleSubmitCreate(): bool
    {
        if (!isset($_POST["name"]) || $_POST["name"] == "") {
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
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($this->checkPostValues(["name"]) && $this->isNameAvailableToEdit($_POST["name"], $tech->id_tech)) {
                $this->model->update(["name" => $_POST["name"], "id" => $tech->id_tech]);
                header("Location: /techs");
            }

            Session::setErrorMsg("Error : Tech name already exists !");
        }

        $titlePage = "Edit " . $tech->name;
        return Render::make("/techs/edit", compact("tech", "titlePage"));
    }


    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->checkPostValues(["idTech"])) {
                $tech = $this->model->selectByColumn("id_tech", $_POST["idTech"]);

                if ($this->model->delete($tech->id_tech)) {
                    header("Location: /techs");
                    exit();
                }
            }
        }

        header("Location: /techs");
    }


    // private function checkIfNameAvailable(string $name): bool
    // {
    //     return !$this->model->doesExist("name", $name);
    // }
}