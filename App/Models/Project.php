<?php

namespace App\Models;

use App\Models\Model;

class Project extends Model
{

    public function selectProjectsInProgress(){
        
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects WHERE status = 0 ORDER BY remains_days ASC";
        return $this->db->read($query);
    }
}
