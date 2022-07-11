<?php

require_once('./core/connection/Database.php');

class Project
{

    private $con = null;

    public function __construct()
    {
        $this->con = Database::getInstance();
    }


    public function selectOneProject($idProject)
    {
        $query = "SELECT * FROM projects WHERE id_project = :id_project";
        return $this->con->read($query, ["id_project" => $idProject], $single = true);
    }

    public function selectProjectsInProgress()
    {
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects WHERE status = 0 ORDER BY remains_days ASC";
        return $this->con->read($query);
    }

    public function selectProjectsFromCategory($idCategory)
    {
        // if(!is_numeric($_POST['categoryFilter']))
        // {
        //     return "Please, select a valid category";
        // }

        $query = "SELECT id_project FROM projects_categories WHERE id_categorie = :id_categorie";

        $result = $this->con->read($query, ['id_categorie' => $idCategory]);

        $idProjects = [];

        foreach ($result as $item) {

            $idProjects[] = $item->id_project;
        }

        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects WHERE id_project IN (" . implode(',', $idProjects) . ") AND status = 0 ORDER BY remains_days ASC";
        return $this->con->read($query);
    }



    public function addProject()
    {
        $dataForm = ['name', 'description', 'deadline'];

        foreach ($dataForm as $data) {
            if (!isset($_POST[$data]) || empty($_POST[$data])) {
                return "Please fill all inputs";
            }
        }

        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        if ($deadline < $currentDate)  return $result = "The deadline must not be in the past";

        $deadline = date("Y-m-d", $deadline);
        $created_at = date("Y-m-d", $currentDate);

        $values = array(
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "deadline" => $deadline,
            "created_at" => $created_at,
        );

        $query = "INSERT INTO projects(name, description, created_at, deadline) VALUES(:name, :description, :created_at, :deadline)";

        $this->con->write($query, $values);
        $idProject = $this->con->getLastInsertId();

        foreach ($_POST['categories'] as $category) {
            $this->insertProjectCategories($idProject, $category);
        }

        header("Location: index.php");
        return;
    }


    private function insertProjectCategories($idProject, $idCategory)
    {
        $query = "INSERT INTO projects_categories(id_project, id_categorie) VALUES(:id_project, :id_categorie)";
        $values = ["id_project" => $idProject, "id_categorie" => $idCategory];
        $this->con->write($query, $values);
    }


    public function selectAllProjects()
    {
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects ORDER BY remains_days ASC";
        return $this->con->read($query);
    }


    public function updateProject($idProject)
    {
        $dataForm = ['name', 'description', 'created_at', 'deadline'];

        foreach ($dataForm as $data) {
            if (!isset($_POST[$data]) || empty($_POST[$data])) {
                return "Please fill all inputs";
            }
        }

        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        if ($deadline < $currentDate)  return $result = "The deadline must not be in the past";

        $deadline = date("Y-m-d", $deadline);
        $created_at = date("Y-m-d", $currentDate);

        $status = 0;
        if (isset($_POST['status']) && $_POST['status'] == "true") {
            $status = 1;
        }

        $values = array(
            "id_project" => $idProject,
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "deadline" => $deadline,
            "status" => $status,
            "created_at" => $created_at,
        );

        $query = "UPDATE projects SET name = :name, description = :description, created_at=:created_at, deadline=:deadline, status=:status WHERE id_project=:id_project";

        $this->con->write($query, $values);
        $this->deleteProjectCategories($idProject);

        foreach ($_POST['categories'] as $category) {
            $this->insertProjectCategories($idProject, $category);
        }

        header("Location: index.php");
        return;
    }


    public function deleteProjectCategories($idProject)
    {
        $query = "DELETE FROM projects_categories WHERE id_project = :id_project";
        $this->con->write($query, ["id_project" => $idProject]);
    }


    public function deleteProject()
    {
        $query = "DELETE FROM projects WHERE id_project = :id_project";
        $this->con->write($query, ['id_project' => $_POST['idProject']]);
        header("Location: http://projects-manager.test/allProjects.php");
        return;
    }
}
