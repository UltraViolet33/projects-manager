<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helpers\Session;
use App\Core\Render;
use App\Models\Tech;

class TechController extends Controller
{

    private Tech $techModel;

    public function __construct()
    {
        $this->techModel = new Tech();
    }


    public function index(): Render
    {
        $allTechs = $this->techModel->selectAll();
        $titlePage = "All Techs";
        return Render::make("techs/index", compact("allTechs", "titlePage"));
    }


    public function create(): Render
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if ($this->checkPostValues(["name"])) {
                if ($this->checkIfNameAvailable($_POST["name"])) {
                    $this->techModel->create($_POST["name"]);
                    header("Location: /techs");
                }

                Session::setErrorMsg("Error : Tech name already exists !");
            }
        }

        $titlePage = "Create Tech";
        return Render::make("/techs/create", compact("titlePage"));
    }


    private function checkIfNameAvailable(string $name): bool
    {
        return !$this->techModel->doesExist("name", $name);
    }


    private function isNameAvailableToEdit(string $name, int $id): bool
    {
        return !$this->techModel->checkIfArgAlreadyExistsInAnotherColumn("name", $name, $id);
    }


    public function edit(): Render
    {
        $idTech = $this->getIdInUrlOrRedirectTo("/techs");

        $tech = $this->techModel->selectByColumn("id_tech", $idTech);

        if (!$tech) {
            header("Location: /techs");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($this->checkPostValues(["name"]) && $this->isNameAvailableToEdit($_POST["name"], $tech->id_tech)) {
                $this->techModel->update(["name" => $_POST["name"], "id" => $tech->id_tech]);
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
                $tech = $this->techModel->selectByColumn("id_tech", $_POST["idTech"]);

                if ($this->techModel->delete($tech->id_tech)) {
                    header("Location: /techs");
                    exit();
                }
            }
        }

        header("Location: /techs");
    }
}