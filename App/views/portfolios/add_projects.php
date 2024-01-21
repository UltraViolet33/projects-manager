<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add projects </h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="projects">Projects : </label>
                <select name="projects[]" class="form-select" multiple>
                    <?php foreach ($projects as $project) : ?>
                        <option value="<?= $project->id_project ?>"><?= $project->name ?></option>
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