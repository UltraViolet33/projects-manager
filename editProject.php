<?php require_once("./inc/header.php"); ?>
<?php
$singleProject = $project->selectOneProject($_GET['id']);
$allCategories = $category->selectAllCategories();
$projectCategoriesIDS = $category->selectProjectCategoriesIDS($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['editProject'])) {
    $editProject = $project->updateProject($_GET['id']);
}
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Edit a Project</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($singleProject->name) ?>">
            </div>
            <div class="mb-3">
                <label for="description">Project Description : </label>
                <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($singleProject->description) ?></textarea>
            </div>
            <div class="mb-3">
                <select name="categories[]" class="form-select" multiple>
                    <?php foreach ($allCategories as $category) : ?>
                        <?php if (in_array($category->id_categorie, $projectCategoriesIDS)) : ?>
                            <option value="<?= $category->id_categorie ?>" selected><?= $category->name ?></option>
                        <?php else : ?>
                            <option value="<?= $category->id_categorie ?>"><?= $category->name ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="created" class="form-label">Date begining :</label>
                <input type="date" class="form-control" name="created_at" value="<?= $singleProject->created_at ?>">
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline :</label>
                <input type="date" class="form-control" name="deadline" value="<?= htmlspecialChars($singleProject->deadline)  ?>">
            </div>
            <div class="form-check mb-3">
                <?php if ($singleProject->status) : ?>
                    <input name="status" class="form-check-input" type="checkbox" value="true" id="flexCheckDefault" checked>
                <?php else : ?>
                    <input name="status" class="form-check-input" type="checkbox" value="true" id="flexCheckDefault">
                <?php endif; ?>
                <label for="status" class="form-check-label" for="flexCheckDefault">
                    Done
                </label>
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="editProject">
        </form>
        <div class="bg-danger">
            <?php if (isset($editProject)) : ?>
                <?= $editProject  ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>