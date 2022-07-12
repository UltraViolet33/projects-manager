<?php
$title = "Add Project Done";
require_once("./inc/header.php");

$allCategories = $category->selectAllCategories();
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addProject'])) {
    $createProject = $project->addDoneProject();
}
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add a Project already done</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : null ?>">
            </div>
            <div class="mb-3">
                <label for="github_link" class="form-label">Github Link : </label>
                <input type="text" class="form-control" name="github_link" value="<?= isset($_POST['github_link']) ? $_POST['github_link'] : null ?>">
            </div>
            <div class="mb-3">
                <label for="description">Project Description : </label>
                <textarea class="form-control" name="description" rows="3"><?= isset($_POST['description']) ? $_POST['description'] : null ?></textarea>
            </div>
            <div class="mb-3">
                <select name="categories[]" class="form-select" multiple>
                    <?php foreach ($allCategories as $category) : ?>
                        <option value="<?= $category->id_categorie ?>"><?= $category->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Created At :</label>
                <input type="date" class="form-control" name="created_at" value="<?= isset($_POST['created_at']) ? htmlspecialChars($_POST['created_at']) : null ?>">
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