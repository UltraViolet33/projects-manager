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


    public function update(array $tech): bool
    {
        $query = "UPDATE $this->table SET name = :name WHERE $this->id = :id";
        return $this->db->write($query, $tech);
    }


    public function getProjectTechs(int $idProject): array
    {
        $query = "SELECT * FROM $this->table INNER JOIN projects_techs
                ON techs.id_tech = projects_techs.id_tech
                WHERE projects_techs.id_project = :id_project";

        return $this->db->read($query, ["id_project" => $idProject]);
    }
}