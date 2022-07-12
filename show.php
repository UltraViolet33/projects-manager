<?php
$title = "All Categories";
require_once("./inc/header.php");

$allCategories = $category->selectAllCategories();
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["deleteCategory"])) {
    if (isset($_POST['idCategory']) && is_numeric($_POST['idCategory'])) {
        $category->deleteCategory();
    }
}
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">All Categories</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php if (!$allCategories) : ?>
            <p>There is no category</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">EDIT</th>
                        <th scope="col">DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allCategories as $category) : ?>
                        <tr>
                            <th scope="row"><?= $category->id_categorie ?></th>
                            <td><?= $category->name ?></td>
                            <td><a href="editCategory.php?id=<?= $category->id_categorie ?>" class="btn btn-primary">Edit</a></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this category ?')">
                                    <input type="hidden" name="idCategory" value="<?= $category->id_categorie ?>">
                                    <input type="submit" class="btn btn-warning" value="Delete" name="deleteCategory">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>