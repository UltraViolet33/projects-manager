<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Helpers\Session;

abstract class Controller
{
    protected function checkPostValues(array $values): bool
    {
        foreach ($values as $value) {
            if (!isset($_POST[$value]) || $_POST[$value] == "") {
                Session::setErrorMsg("Error : $value missing !");
                return false;
            }
        }

        return true;
    }


    protected function getIdInUrlOrRedirectTo(string $urlRedirect): bool|int
    {
        if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
            header("Location: $urlRedirect");
        }

        return $_GET["id"];
    }
}
