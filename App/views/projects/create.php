<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add a Project</h1>
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
                <label for="categories">Project Categories : </label>
                <select name="categories[]" class="form-select" multiple>
                    <?php foreach ($allCategories as $category) : ?>
                        <option value="<?= $category->id_category ?>"><?= $category->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="priority">Project priority : </label>
                <select name="priority" class="form-select">
                    <option value="0">Low</option>
                    <option value="1">High</option>
                </select>
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="addProject">
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