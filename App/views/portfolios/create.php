<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add a portfolio</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="mb-3">
                <label for="categories">Categories : </label>
                <select name="category" class="form-select" >
                    <?php foreach ($allCategories as $category) : ?>
                        <option value="<?= $category->id_category ?>"><?= $category->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input class="btn btn-primary" type="submit" value="Submit">
        </form>
        <?php if (strlen($errors) !== 0) : ?>
            <div class="bg-danger my-3 p-2">
                <p class="text-center">
                    <?= $errors ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>