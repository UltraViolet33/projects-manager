<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    return;
}
?>
<?php require_once("./inc/header.php"); ?>
<?php
$categoryEdit = $category->selectOneCategory($_GET['id']);
if (!$categoryEdit) {
    header("Location: index.php");
    return;
}
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['editCategory'])) {
    $edit = $category->updateCategory($categoryEdit->id_categorie);
}
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Edit the Category : <?= $categoryEdit->name ?></h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($categoryEdit->name) ?>">
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="editCategory">
        </form>
        <div class="bg-danger">
            <?php if (isset($edit)) : ?>
                <?= $edit  ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>