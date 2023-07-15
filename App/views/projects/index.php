<div class="row">
    <div class="col-12 text-center">
        <h1>Projects Manager</h1>
        <p>The web app to manage all the programming projects you dream</p>
    </div>
    <div class="col-12">
        <h2 class="text-center">Projects In Progress : </h2>
        <p>Total : <?= $projectsInProgress ? count($projectsInProgress) : 0  ?> </p>
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
        <?php if (!$projectsInProgress) : ?>
            <p>There is no projects in progress</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Created At</th>
                        <th scope="col">DETAILS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projectsInProgress as $project) :
                        $created_at = date('d/m/yy', strtotime($project->created_at));
                    ?>
                        <th scope="row"><?= $project->id_project ?></th>
                        <td><?= $project->name ?></td>
                        <td><?= $created_at ?></td>
                        <td><a href="detailsProject.php?id=<?= $project->id_project ?>" class="btn btn-primary">Détails</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>