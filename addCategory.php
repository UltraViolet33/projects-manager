<?php require_once("./inc/header.php"); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addCategory'])) {
    $createCategory = $category->addCategory();
}
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add a Category</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name">
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="addCategory">
        </form>
        <div class="bg-danger">
            <?php if (isset($createCategory)) : ?>
                <?= $createCategory  ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>