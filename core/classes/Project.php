<?php

require_once('./core/connection/Database.php');

class Project
{

    private $con = null;

    public function __construct()
    {
        $this->con = Database::getInstance();
    }


    /**
     * selectOneProject
     *
     * @param  mixed $idProject
     * @return object
     */
    public function selectOneProject($idProject)
    {
        $query = "SELECT * FROM projects WHERE id_project = :id_project";
        return $this->con->read($query, ["id_project" => $idProject], $single = true);
    }


    /**
     * selectProjectsInProgress
     *
     * @return array
     */
    public function selectProjectsInProgress()
    {
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects WHERE status = 0 ORDER BY remains_days ASC";
        return $this->con->read($query);
    }


    public function selectAllDoneProjects()
    {
        $query = "SELECT *, 0 AS remains_days FROM projects WHERE status = 1 ORDER BY created_at DESC";
        return $this->con->read($query);
    }


    /**
     * selectProjectsFromCategory
     *
     * @param  mixed $idCategory
     * @return array
     */
    public function selectIdsProjectsFromCategory($idCategory)
    {
        $query = "SELECT id_project FROM projects_categories WHERE id_categorie = :id_categorie";
        $result = $this->con->read($query, ['id_categorie' => $idCategory]);

        $idProjects = [];

        if (!$result) {
            return false;
        }

        foreach ($result as $item) {
            $idProjects[] = $item->id_project;
        }

        return $idProjects;
    }


    public function selectProjectsFromCategory($idCategory)
    {
        $idProjects = $this->selectIdsProjectsFromCategory($idCategory);
        if (!$idProjects) {
            return false;
        }
        $query = "SELECT * FROM projects WHERE id_project IN (" . implode(',', $idProjects) . ") ORDER BY created_at DESC";
        return $this->con->read($query);
    }


    public function selectProjectsNotDoneFromCategory($idCategory)
    {
        $idProjects = $this->selectIdsProjectsFromCategory($idCategory);
        if (!$idProjects) {
            return false;
        }
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects WHERE id_project IN (" . implode(',', $idProjects) . ") AND status = 0 ORDER BY remains_days ASC";
        return $this->con->read($query);
    }


    /**
     * addProject
     *
     * @return string
     */
    public function addProject()
    {
        $dataForm = ['name', 'description', 'deadline'];
        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        foreach ($dataForm as $data) {
            if (!isset($_POST[$data]) || empty($_POST[$data])) {
                return "Please fill all inputs";
            }
        }

        if ($deadline < $currentDate)  return $result = "The deadline must not be in the past";

        $deadline = date("Y-m-d", $deadline);
        $created_at = date("Y-m-d", $currentDate);

        if (isset($_POST['created_at']) && !empty($_POST['created_at'])) {
            $created_at = strtotime($_POST['created_at']);
            if ($created_at > $currentDate) return $result =  "The Created at date can not be in the futur";
            if ($created_at > strtotime($deadline)) return $result =  "The created At can not be after the deadline";
            $created_at = $_POST['created_at'];
        }

        if (isset($_POST['github_link'])) {
            $github_link = $_POST['github_link'];
        }

        $values = array(
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "github_link" => $github_link,
            "deadline" => $deadline,
            "created_at" => $created_at,
        );

        $query = "INSERT INTO projects(name, description, github_link, created_at, deadline) VALUES(:name, :description, :github_link, :created_at, :deadline)";

        $this->con->write($query, $values);
        $idProject = $this->con->getLastInsertId();

        foreach ($_POST['categories'] as $category) {
            $this->insertProjectCategories($idProject, $category);
        }

        header("Location: allProjects.php");
        return;
    }


    /**
     * addDoneProject
     *
     * @return string
     */
    public function addDoneProject()
    {
        $dataForm = ['name', 'description', 'created_at'];
        $currentDate = strtotime(date('Y-m-d'));
        $created_at = strtotime($_POST['created_at']);

        foreach ($dataForm as $data) {
            if (!isset($_POST[$data]) || empty($_POST[$data])) {
                return "Please fill all inputs";
            }
        }

        if ($created_at > $currentDate)  return $result = "The created at date must not be in the futur";
        $created_at = date("Y-m-d", $created_at);
        $github_link = null;

        $dateEnd = null;

        if (isset($_POST['date_end']) && !empty($_POST['date_end'])) {
            if (strtotime($_POST['date_end']) < strtotime($_POST['created_at'])) return "Date end can not be before the created date";
            if (strtotime($_POST['date_end']) > $currentDate) return "Date end can not be in the futur";
            $dateEnd = $_POST['date_end'];
        }

        if (isset($_POST['github_link'])) {
            $github_link = $_POST['github_link'];
        }

        $values = array(
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "github_link" => $github_link,
            "created_at" => $created_at,
            "deadline" => null,
            "status" => 1,
            "date_end" => $dateEnd,
        );

        $query = "INSERT INTO projects(name, description, github_link, created_at, deadline, date_end, status) VALUES(:name, :description, :github_link, :created_at, :deadline, :date_end, :status)";

        $this->con->write($query, $values);
        $idProject = $this->con->getLastInsertId();

        foreach ($_POST['categories'] as $category) {
            $this->insertProjectCategories($idProject, $category);
        }

        header("Location: allProjects.php");
        return;
    }

    public function commitPortfolio()
    {

        $projectsPortfolio = $this->getAllPortfolioProjects();
        // var_dump($projectsPortfolio);
        $projectsPortfolioJson = json_encode($projectsPortfolio);
        // echo $projectsPortfolioJson;
        file_put_contents("./core/data/projects.json", $projectsPortfolioJson);
        // $commands = file_get_contents("./core/classes/pushPortfolio.sh");
        $test = shell_exec("sh ./core/classes/pushPortfolio.sh");
        var_dump($test);
    }


    /**
     * insertProjectCategories
     *
     * @param  mixed $idProject
     * @param  mixed $idCategory
     * @return void
     */
    private function insertProjectCategories($idProject, $idCategory)
    {
        $query = "INSERT INTO projects_categories(id_project, id_categorie) VALUES(:id_project, :id_categorie)";
        $values = ["id_project" => $idProject, "id_categorie" => $idCategory];
        $this->con->write($query, $values);
    }


    /**
     * selectAllProjects
     *
     * @return array
     */
    public function selectAllProjects()
    {
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects ORDER BY created_at DESC";
        return $this->con->read($query);
    }


    /**
     * getAllPortfolioProjects
     *
     * @return array
     */
    public function getAllPortfolioProjects()
    {
        $query = "SELECT name, description, github_link, id_project  FROM projects WHERE github_portfolio = 1 ORDER BY created_at DESC";
        return $this->con->read($query);
    }


    /**
     * updateProject
     *
     * @param  mixed $idProject
     * @return string
     */
    public function updateProject($idProject)
    {

        $dataForm = ['name', 'description', 'created_at'];

        foreach ($dataForm as $data) {
            if (!isset($_POST[$data]) || empty($_POST[$data])) {
                return "Please fill all inputs";
            }
        }

        $currentDate = strtotime(date('Y-m-d'));
        if ($_POST["deadline"]) {
            $deadline = strtotime($_POST['deadline']);

            if ($deadline < $currentDate)  return $result = "The deadline must not be in the past";
            $deadline = date("Y-m-d", $deadline);
        }


        $created_at = $_POST['created_at'];
        $status = 0;
        $github_portfolio = 0;

        $values = array(
            "id_project" => $idProject,
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "deadline" => $deadline,
            "created_at" => $created_at,
            "status" => $status,
            "github_portfolio" => $github_portfolio,
            "github_link" => $_POST["github_link"],
            'date_end' => null
        );

        if (isset($_POST['status']) && $_POST['status'] == "true") {
            $values['status'] = 1;
            $values['date_end'] = date("Y-m-d", $currentDate);
            $values["deadline"] = null;
        }


        if (isset($_POST['github_portfolio']) && $_POST['github_portfolio'] == "true") {
            $values['github_portfolio'] = 1;
        }


        $query = "UPDATE projects SET name = :name, description = :description, created_at=:created_at, deadline=:deadline, github_portfolio=:github_portfolio, github_link=:github_link, status=:status, date_end=:date_end WHERE id_project=:id_project";


        var_dump($values);
        $this->con->write($query, $values);
        $this->deleteProjectCategories($idProject);

        foreach ($_POST['categories'] as $category) {
            $this->insertProjectCategories($idProject, $category);
        }

        header("Location: allProjects.php");
        return;
    }


    /**
     * deleteProjectCategories
     *
     * @param  mixed $idProject
     * @return void
     */
    public function deleteProjectCategories($idProject)
    {
        $query = "DELETE FROM projects_categories WHERE id_project = :id_project";
        $this->con->write($query, ["id_project" => $idProject]);
    }


    /**
     * deleteProject
     *
     * @return void
     */
    public function deleteProject()
    {
        $query = "DELETE FROM projects WHERE id_project = :id_project";
        $this->con->write($query, ['id_project' => $_POST['idProject']]);
        header("Location: http://projects-manager.test/allProjects.php");
        return;
    }
}
