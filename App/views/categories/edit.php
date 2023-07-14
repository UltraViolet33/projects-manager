<div class="row">
    <div class="col-12">
        <h1 class="text-center">Edit the Category : <?= $category->name ?></h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($category->name) ?>">
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="editCategory">
        </form>
    </div>
</div>