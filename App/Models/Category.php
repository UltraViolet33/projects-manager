<?php

namespace App\Models;

use App\Models\Model;
use App\Core\Database\Database;
use Exception;

class Category extends Model
{
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = "categories";
        $this->id = "id_category";
    }


    public function create(string $name)
    {
        try {

            $query = "INSERT INTO categories(name) VALUES(:name)";
            $this->db->write($query, ["name" => $name]);
        } catch (Exception $e) {
            echo $e;
            die;
        }
    }
}
