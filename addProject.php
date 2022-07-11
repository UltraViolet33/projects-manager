<?php require_once("./inc/header.php"); ?>
<?php
$allCategories = $category->selectAllCategories();
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addProject'])) {
    $createProject = $project->addProject();
}
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add a Project</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="mb-3">
                <label for="description">Project Description : </label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <select name="categories[]" class="form-select" multiple>
                    <option selected>Choose categories</option>
                    <?php foreach ($allCategories as $category) : ?>
                        <option value="<?= $category->id_categorie ?>"><?= $category->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline :</label>
                <input type="date" class="form-control" name="deadline" value="<?= isset($_POST['deadline']) ? htmlspecialChars($_POST['deadline']) : null ?>">
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="addProject">
        </form>
        <div class="bg-danger">
            <?php if (isset($createProject)) : ?>
                <?= $createProject  ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>