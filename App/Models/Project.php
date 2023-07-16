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


    public function create(array $project): bool
    {
        $query = "INSERT INTO projects(name, description, created_at, github_link, priority) VALUES(:name, :description, CURDATE(), :github_link, :priority)";
        return $this->db->write($query, $project);
    }
}
