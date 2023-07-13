<?php

namespace App\Models;

use App\Models\Model;
use App\Core\Database\Database;


class Category extends Model
{
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = "categories";
        $this->id = "id_category";
    }
}
