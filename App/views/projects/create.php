<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add a Project</h1>
        <h3>Add a project already done <a href="./addProjectDone.php">here</a></h3>
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
                <label for="created_at" class="form-label">Created At :</label>
                <input type="date" class="form-control" name="created_at" value="<?= isset($_POST['created_at']) ? htmlspecialChars($_POST['created_at']) : null ?>">
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline :</label>
                <input type="date" class="form-control" name="deadline" value="<?= isset($_POST['deadline']) ? htmlspecialChars($_POST['deadline']) : null ?>">
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" name="addProject">
        </form>
        <div class="bg-danger">
        </div>
    </div>
</div>