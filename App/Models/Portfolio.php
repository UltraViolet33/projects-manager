<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model;

class Portfolio extends Model
{
    public function create(array $portfolio): bool
    {
        $query = "INSERT INTO portfolios(name, category_id) VALUES(:name, :category_id)";
        return  $this->db->write($query, $portfolio);
    }

    
    public function selectNameWithCategory(): array
    {
        $query = "SELECT p.id_portfolio, p.name AS portfolio_name, c.name as category_name 
                    FROM $this->table as p 
                    INNER JOIN categories AS c 
                    ON c.id_category = p.category_id";

        return $this->db->read($query);
    }


    public function addProjects(array $projectsId, int $portfolioId): bool
    {
        $portfolioProjects = array_map(fn ($projectId): array => [$projectId, $portfolioId], $projectsId);
        return $this->insertMultipleValues(["project_id", "portfolio_id"], "portfolio_projects", $portfolioProjects);
    }


    public function selectProjectsPortfolio(int $portfolioId): array 
    {
        $query = "SELECT pro.name, pro.id_project FROM projects as pro
                    INNER JOIN portfolio_projects AS pp 
                    ON pro.id_project = pp.project_id
                    WHERE pp.portfolio_id = :portfolio_id";

        return $this->db->read($query, ['portfolio_id' => $portfolioId]);
    }


    public function deleteProjectsPortfolio(int $portfolioId): bool  
    {
        $query = "DELETE FROM portfolio_projects as pp WHERE pp.portfolio_id = :portfolio_id";
        return $this->db->write($query, ["portfolio_id" => $portfolioId]);
    }
}
