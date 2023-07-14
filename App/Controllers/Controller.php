<?php

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
}
