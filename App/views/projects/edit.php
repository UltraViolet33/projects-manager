<div class="row">
    <div class="col-12">
        <h1 class="text-center">Edit Project <?= $project->name ?></h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name" value="<?= $project->name ?>">
            </div>
            <div class="mb-3">
                <label for="github_link" class="form-label">Github Link : </label>
                <input type="text" class="form-control" name="github_link" value="<?= $project->github_link ?>">
            </div>
            <div class="mb-3">
                <label for="description">Project Description : </label>
                <textarea class="form-control" name="description" rows="3"><?= $project->description ?></textarea>
            </div>
            <div class="mb-3">
                <label for="categories">Project Categories : </label>
                <select name="categories[]" class="form-select" multiple>
                    <?php foreach ($allCategories as $category) : ?>
                        <?php if ($category->isInProject) : ?>
                            <option value="<?= $category->id_category ?>" selected><?= $category->name ?></option>
                        <?php else : ?>
                            <option value="<?= $category->id_category ?>"><?= $category->name ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="priority">Project priority : </label>
                <select name="priority" class="form-select">
                    <?php foreach ($priorities as $key => $priority) : ?>
                        <?php if ($project->priority === $key) : ?>
                            <option value="<?= $key ?>" selected><?= $priority ?></option>
                        <?php else : ?>
                            <option value="<?= $key ?>"><?= $priority ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
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