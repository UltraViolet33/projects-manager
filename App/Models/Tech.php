<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model;
use App\Core\Database\Database;
use Exception;

class Tech extends Model
{
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = "techs";
        $this->id = "id_tech";
    }


    public function create(string $name): bool
    {
        $query = "INSERT INTO $this->table (name) VALUES(:name)";
        return $this->db->write($query, ["name" => $name]);
    }


    // public function update(array $category): bool
    // {
    //     $query = "UPDATE categories SET name = :name WHERE id_category = :id_category";
    //     return $this->db->write($query, $category);
    // }


    // public function delete(int $idCategory): bool
    // {
    //     $query = "DELETE FROM categories WHERE id_category = :id_category";
    //     return $this->db->write($query, ["id_category" =>  $idCategory]);
    // }


    // public function getProjectCategories(int $idProject): array
    // {
    //     $query = "SELECT *  FROM categories
    //             INNER JOIN projects_categories
    //             ON categories.id_category = projects_categories.id_categorie
    //             WHERE projects_categories.id_project = :id_project";

    //     return $this->db->read($query, ["id_project" => $idProject]);
    // }
}