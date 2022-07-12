<?php require_once("./inc/header.php"); ?>
<?php
$allProjects = $project->selectAllProjects();
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">All Projects</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php if (!$allProjects) : ?>
            <p>There is no projects</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Remains Days</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Status</th>
                        <th scope="col">DETAILS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProjects as $project) : ?>
                        <?php
                        $deadline  = $project->deadline ? date('d/m/y', strtotime($project->deadline)) : "Done";
                        $remains_days = $project->remains_days ?: 0;
                        $created_at = date('d/m/y', strtotime($project->created_at));
                        $status = $project->status ? "Done" : "Not done yet";
                        ?>
                        <tr>
                            <th scope="row"><?= $project->id_project ?></th>
                            <td><?= $project->name ?></td>
                            <td><?= $remains_days ?></td>
                            <td><?= $created_at ?></td>
                            <td><?= $deadline ?></td>
                            <td><?= $status ?></td>
                            <td><a href="detailsProject.php?id=<?= $project->id_project ?>" class="btn btn-primary">Détails</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>