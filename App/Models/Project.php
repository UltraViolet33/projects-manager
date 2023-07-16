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

    public function update(array $project)
    {
        $query = "UPDATE projects 
        SET name = :name, description = :description,
        github_link = :github_link, created_at=:created_at, priority = :priority
        WHERE id_project = :id_project";

        return $this->db->write($query, $project);
    }


    public function create(array $project, array $projectCategories): bool
    {
        $query = "INSERT INTO projects(name, description, created_at, github_link, priority) VALUES(:name, :description, CURDATE(), :github_link, :priority)";
        $this->db->write($query, $project);


        $idProject = $this->db->getLastInsertId();
        // $idProject = 150;

        $this->insertProjectCategories($idProject, $projectCategories);

        return true;
    }

    private function insertProjectCategories(int $idProject, array $categories)
    {
        $values = str_repeat('?,', 1) . '?';

        
        // // construct the entire query
        $sql = "INSERT INTO projects_categories (id_project, id_categorie) VALUES " .
        //     // repeat the (?,?) sequence for each row
        str_repeat("($values),", count($categories) - 1) . "($values)";
        
        
        $data = [];
        
        foreach($categories as $category)
        {
            $data[] = [$idProject,$category];
        }
        echo "<pre>";
        var_dump($data);
        echo "<pre>";

        // $this->db->write($sql, array_merge(...$categories));
        $stmt = $this->db->PDOInstance->prepare($sql);
        // // execute with all values from $data
        $stmt->execute(array_merge(...$data));
    }
}
