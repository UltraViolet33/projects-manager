<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model;

class Project extends Model
{

    public function selectProjectsInProgress(): array
    {
        $query = "SELECT * FROM projects WHERE status = 0 ORDER BY priority DESC, created_at";
        return $this->db->read($query);
    }


    public function selectProjectsPortfolio(): array
    {
        $query = "SELECT * FROM $this->table WHERE github_portfolio = 1 ORDER BY created_at DESC";
        return $this->db->read($query);
    }


    public function selectDataProjectsPortfolio(): array
    {
        $query = "SELECT name, description, github_link FROM $this->table WHERE github_portfolio = 1 ORDER BY created_at DESC";
        return $this->db->read($query);
    }


    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->table ORDER BY created_at DESC";
        return $this->db->read($query);
    }


    public function selectProjectsByCategory(int $idCategory): array
    {
        $query = "SELECT * FROM projects INNER JOIN projects_categories 
        ON projects.id_project = projects_categories.id_project 
        WHERE projects_categories.id_categorie = :id_category";

        return $this->db->read($query, ["id_category" => $idCategory]);
    }


    public function selectProjectsByStatus(int $status): array
    {
        $query = "SELECT * FROM projects WHERE status = :status";
        return $this->db->read($query, ["status" => $status]);
    }


    public function updateProjectWithCategories(array $project, array $projectCategories, array $projectTechs): bool
    {
        $query = "UPDATE projects 
        SET name = :name, description = :description,
        github_link = :github_link, created_at=:created_at, priority = :priority
        WHERE id_project = :id_project";

        $idProject = $project["id_project"];

        $projectTechs = array_map(fn($value): array => [$idProject, $value], $projectTechs);

        $this->db->write($query, $project);
        $this->deleteProjectCategories($idProject);
        $this->deleteProjectTechs($idProject);
        $this->insertMultipleValues(["id_project", "id_tech"], "projects_techs", $projectTechs);
        return $this->insertProjectCategories($idProject, $projectCategories);
    }


    public function update(array $project): bool
    {
        $query = "UPDATE projects SET name = :name, description = :description,
        github_link = :github_link, github_portfolio = :github_portfolio, status= :status, created_at=:created_at, priority = :priority
        WHERE id_project = :id_project";

        return $this->db->write($query, $project);
    }


    private function deleteProjectCategories(int $idProject): bool
    {
        $query = "DELETE FROM projects_categories WHERE id_project = :id_project";
        return $this->db->write($query, ["id_project" => $idProject]);
    }


    private function deleteProjectTechs(int $idProject): bool
    {
        $query = "DELETE FROM projects_techs WHERE id_project = :id_project";
        return $this->db->write($query, ["id_project" => $idProject]);
    }


    public function create(array $project, array $projectCategories, array $projectTechs): bool
    {
        $query = "INSERT INTO projects(name, description, created_at, github_link, priority) VALUES(:name, :description, CURDATE(), :github_link, :priority)";
        $this->db->write($query, $project);

        $idProject = $this->db->getLastInsertId();

        $projectTechs = array_map(fn($value): array => [$idProject, $value], $projectTechs);

        $this->insertMultipleValues(["id_project", "id_tech"], "projects_techs", $projectTechs);

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