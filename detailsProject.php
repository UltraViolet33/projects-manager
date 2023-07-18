<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    return;
}
$title = "Details Project";
require_once("./inc/header.php");

$singleProject = $project->selectOneProject($_GET['id']);

$categories = $category->selectProjectCategories($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === "POST" && is_numeric($_POST['idProject'])) {
    $project->deleteProject($_POST['idProject']);
}
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Details Project : <?= $singleProject->name ?></h1>
        <p>ID : <?= $singleProject->id_project ?></p>
        <p>Name : <?= $singleProject->name ?></p>
        <p>Description : <?= $singleProject->description ?></p>
        <p>Github link : <?= $singleProject->github_link ?  " <a href='$singleProject->github_link' target='_blanck'>Lien vers github</a> " : "non renseigné" ?></p>
        <p>Is in Github Portfolio : <?= $singleProject->github_portfolio ? "yes" : "no" ?></p>
        <p>Status : <?= $singleProject->status ? "Done" : "Not done" ?></p>
        <p>Created at : <?= $singleProject->created_at ?></p>
        <p>Deadline : <?= $singleProject->deadline ? $singleProject->deadline : "DONE" ?></p>
        <p>Date end : <?= $singleProject->date_end ? $singleProject->date_end : "unknown" ?></p>
        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Toggle button</button>
        <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" aria-pressed="true">Active toggle button</button>
        <h2>Categories : </h2>
        <?php foreach ($categories as $category) : ?>
            <p><?= $category->name ?></p>
        <?php endforeach; ?>
        <a href="editProject.php?id=<?= $singleProject->id_project ?>" class="btn btn-warning">Edit</a>
        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this project ? ')">
            <input type="hidden" name="idProject" value="<?= $singleProject->id_project ?>">
            <input class="btn btn-danger" type="submit" value="Delete" name="deleteProject"></input>
        </form>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>