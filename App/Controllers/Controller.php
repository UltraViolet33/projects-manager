<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Core\Helpers\Session;

abstract class Controller
{
    protected $model;

    protected function checkPostValues(array $values): bool
    {
        foreach ($values as $value) {
            if (!isset($_POST[$value]) || $_POST[$value] == "") {
                Session::setErrorMsg("Error : $value field missing !");
                return false;
            }
        }

        return true;
    }


    protected function getIdInUrlOrRedirectTo(string $urlRedirect): bool|int
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            header("Location: $urlRedirect");
            exit();
        }

        return (int) $_GET["id"];
    }


    protected function doesNameAlreadyExists(string $name): bool
    {
        return $this->model->doesExist("name", $name);
    }


    protected function isNameAvailableToEdit(string $name, int $id): bool
    {
        return !$this->model->checkIfArgAlreadyExistsInAnotherColumn("name", $name, $id);
    }
}