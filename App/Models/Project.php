<?php

namespace App\Models;

use App\Models\Model;

class Project extends Model
{

    public function selectProjectsInProgress()
    {
        $query = "SELECT * FROM projects WHERE status = 0";
        return $this->db->read($query);
    }


    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->table ORDER BY created_at DESC";
        return $this->db->read($query);
    }

    public function update(array $project, array $projectCategories)
    {
        $query = "UPDATE projects 
        SET name = :name, description = :description,
        github_link = :github_link, created_at=:created_at, priority = :priority
        WHERE id_project = :id_project";

        $this->db->write($query, $project);
        
        $this->deleteProjectCategories($project["id_project"]);

        return $this->insertProjectCategories($project["id_project"], $projectCategories);
    }

    private function deleteProjectCategories(int $idProject): bool
    {
        $query = "DELETE FROM projects_categories WHERE id_project = :id_project";
        return $this->db->write($query, ["id_project" => $idProject]);
    }


    public function create(array $project, array $projectCategories): bool
    {
        $query = "INSERT INTO projects(name, description, created_at, github_link, priority) VALUES(:name, :description, CURDATE(), :github_link, :priority)";
        $this->db->write($query, $project);


        $idProject = $this->db->getLastInsertId();

        return $this->insertProjectCategories($idProject, $projectCategories);
    }

    private function insertProjectCategories(int $idProject, array $categories): bool
    {
        $values = "?,?";

        $sql = "INSERT INTO projects_categories (id_project, id_categorie) VALUES " .

            str_repeat("($values),", count($categories) - 1) . "($values)";


        $data = [];

        foreach ($categories as $category) {
            $data[] = [$idProject, $category];
        }

        return $this->db->write($sql, array_merge(...$data));
    }
}
