<?php

require_once('./core/connection/Database.php');

class Category
{

    private $con = null;

    public function __construct()
    {
        $this->con = Database::getInstance();
    }


    /**
     * selectOneCategory
     *
     * @param  mixed $idCategory
     * @return object
     */
    public function selectOneCategory($idCategory)
    {
        $query = "SELECT * FROM categories WHERE id_categorie = :id_categorie";
        return $this->con->read($query, ["id_categorie" => $idCategory], $single = true);
    }


    /**
     * selectProjectCategoriesIDS
     *
     * @param  mixed $idProject
     * @return array
     */
    public function selectProjectCategoriesIDS($idProject)
    {
        $query = "SELECT id_categorie FROM projects_categories WHERE id_project = :id_project";
        $categories = $this->con->read($query, ["id_project" => $idProject]);
        $idCategories = [];

        foreach ($categories as $category) {
            $idCategories[] = $category->id_categorie;
        }

        return $idCategories;
    }


    /**
     * selectProjectCategories
     *
     * @param  mixed $idProject
     * @return array
     */
    public function selectProjectCategories($idProject)
    {
        $query = "SELECT id_categorie FROM projects_categories WHERE id_project = :id_project";
        $idCategories = $this->con->read($query, ["id_project" => $idProject]);
        $allCategories = [];

        foreach ($idCategories as $id) {
            $allCategories[] = $this->selectOneCategory($id->id_categorie);
        }

        return $allCategories;
    }


    /**
     * addCategory
     *
     * @return string
     */
    public function addCategory()
    {
        if (!isset($_POST['name']) || empty($_POST['name']) || strlen($_POST['name'] < 1)) {
            return "Please fill the name input";
        }

        $categoryName = htmlspecialchars($_POST['name']);
        $query = "INSERT INTO categories(name) VALUES(:name)";

        if ($this->con->write($query, ['name' => $categoryName])) {
            header("Location: http://projects-manager.test/show.php");
            return;
        }

        return "An error occured, please try again";
    }


    /**
     * selectAllCategories
     *
     * @return array
     */
    public function selectAllCategories()
    {
        $query = "SELECT * FROM categories";
        return $this->con->read($query);
    }


    /**
     * updateCategory
     *
     * @param  mixed $idCategory
     * @return string
     */
    public function updateCategory($idCategory)
    {
        if (!isset($_POST['name']) || empty($_POST['name']) || strlen($_POST['name'] < 1)) {
            return "Please fill the name input";
        }

        $categoryName = htmlspecialchars($_POST['name']);
        $query = "UPDATE categories SET name = :name WHERE id_categorie = $idCategory";

        if ($this->con->write($query, ['name' => $categoryName])) {
            header("Location: http://projects-manager.test/show.php");
            return;
        }

        return "An error occured, please try again";
    }


    /**
     * deleteCategory
     *
     * @return void
     */
    public function deleteCategory()
    {
        $query = "DELETE FROM categories WHERE id_categorie = :idCategory";
        $this->con->write($query, ['idCategory' => $_POST['idCategory']]);
        header("Location: http://projects-manager.test/show.php");
        return;
    }
}
