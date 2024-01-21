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
}
