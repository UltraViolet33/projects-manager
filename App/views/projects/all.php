<div class="row">
    <div class="col-12 text-center">
        <h1>Projects Manager</h1>
        <p>The web app to manage all the programming projects you dream</p>
    </div>
    <div class="col-12">
        <h2 class="text-center">All Projects</h2>
        <p>Total : <?= $totalProjects  ?> </p>
    </div>
</div>
<form method="POST">
    <div class="mb-3">
        <select onchange="this.form.submit()" name="categoryFilter" class="form-select">
            <option selected>Choose categories</option>
            <?php foreach ($allCategories as $category) : ?>
                <option value="<?= $category->id_categorie ?>"><?= $category->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>
<div class="row">
    <div class="col-12">
        <?= $projectsTable ?>
    </div>
</div>