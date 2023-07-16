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


    public function create(string $name): bool
    {
        $query = "INSERT INTO categories(name) VALUES(:name)";
        return $this->db->write($query, ["name" => $name]);
    }


    public function update(array $category): bool
    {
        $query = "UPDATE categories SET name = :name WHERE id_category = :id_category";
        return $this->db->write($query, $category);
    }


    public function delete(int $idCategory): bool
    {
        $query = "DELETE FROM categories WHERE id_category = :id_category";
        return $this->db->write($query, ["id_category" =>  $idCategory]);
    }


    public function checkIfNameExistsToEdit(string $name, int $id): bool
    {
        $query = "SELECT * FROM $this->table WHERE name = :name AND id_category != :id";
        $result = $this->db->readOneRow($query, ["name" => $name, "id" => $id]);

        return $result ? true : false;
    }

    public function getProjectCategories(int $idProject): array
    {
        $query = "SELECT *  FROM categories
                INNER JOIN projects_categories
                ON categories.id_category = projects_categories.id_categorie
                WHERE projects_categories.id_project = :id_project";

        return $this->db->read($query, ["id_project" => $idProject]);
    }
}
