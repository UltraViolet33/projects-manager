<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Project;

class CategoryController
{


    public function __construct()
    {
    }


    public function index(): Render
    {
        return Render::make("categories/index");
    }
}
