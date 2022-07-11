<?php require_once("./inc/header.php");
$projectsInProgress = $project->selectProjectsInProgress(); ?>
<div class="row">
    <div class="col-12 text-center">
        <h1>Projects Manager</h1>
        <p>The web app to manage all the programming projects you dream</p>
    </div>
    <div class="col-12">
        <h2 class="text-center">Projects In Progress : </h2>
    </div>
</div>
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
                        <th scope="col">Remains Days</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">DETAILS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projectsInProgress as $project) :
                        $deadline = date('d/m/y', strtotime($project->deadline));
                        $created_at = date('d/m/y', strtotime($project->created_at)); ?>
                        <?php if ($project->remains_days <= 0) : ?>
                            <tr class="bg-danger">
                            <?php elseif ($project->remains_days <= 5) : ?>
                            <tr class="bg-warning">
                            <?php else : ?>
                            <tr>
                            <?php endif; ?>
                            <th scope="row"><?= $project->id_project ?></th>
                            <td><?= $project->name ?></td>
                            <td><?= $project->remains_days ?></td>
                            <td><?= $created_at ?></td>
                            <td><?= $deadline ?></td>
                            <td><a href="detailsProject.php?id=<?= $project->id_project ?>" class="btn btn-primary">Détails</a></td>
                            </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>