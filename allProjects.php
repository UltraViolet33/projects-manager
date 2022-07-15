<?php
$title = "All Projects";
require_once("./inc/header.php");

$allCategories = $category->selectAllCategories();
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['categoryFilter'])) {
    $allProjects = $project->selectProjectsFromCategory($_POST['categoryFilter']);
} elseif ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['doneProjects'])) {
    $allProjects = $project->selectAllDoneProjects();
} else {
    $allProjects = $project->selectAllProjects();
}

?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">All Projects</h1>
        <p>Total : <?= $allProjects ? count($allProjects) : 0  ?> </p>
        <form method="POST" class="my-3">
            <input type="submit" class="btn btn-primary" name="doneProjects" value="Done Projects">
        </form>
        <form method="POST" class="my-3">
            <input type="submit" class="btn btn-primary" name="allProjects" value="All Projects">
        </form>
    </div>
</div>
<form method="POST" class="my-3">
    <div class="mb-3">
        <select onchange="this.form.submit()" name="categoryFilter" class="form-select">
            <option selected>Choose categories</option>
            <?php foreach ($allCategories as $category) : ?>
                <option value="<?= $category->id_categorie ?>"><?= $category->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>
<div class="row">
    <div class="col-12">
        <?php if (!$allProjects) : ?>
            <p>There is no projects</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Status</th>
                        <th scope="col">DETAILS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProjects as $project) : ?>
                        <?php
                        $deadline  = $project->deadline ? date('d/m/y', strtotime($project->deadline)) : "Done";
                        $created_at = date('d/m/y', strtotime($project->created_at));
                        $status = $project->status ? "Done" : "Not done yet";
                        ?>
                        <tr>
                            <th scope="row"><?= $project->id_project ?></th>
                            <td><?= $project->name ?></td>
                            <td><?= $created_at ?></td>
                            <td><?= $deadline ?></td>
                            <td><?= $status ?></td>
                            <td><a href="detailsProject.php?id=<?= $project->id_project ?>" class="btn btn-primary">Détails</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>