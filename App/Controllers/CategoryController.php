<?php

namespace App\Controllers;

use App\Core\Render;
use App\Models\Category;

class CategoryController
{

    private Category $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }


    public function index(): Render
    {
        $allCategories = $this->categoryModel->selectAll();
        return Render::make("categories/index", compact("allCategories"));
    }
}
