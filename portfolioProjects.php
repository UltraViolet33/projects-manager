<?php
$title = "Portfolio Projects";
require_once("./inc/header.php");
$allProjects = $project->getAllPortfolioProjects();
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">All Portfolio Projects</h1>
        <p>Total : <?= $allProjects ? count($allProjects) : 0  ?> </p>
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
                        <th scope="col">DETAILS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProjects as $project) : ?>
                        <tr>
                            <th scope="row"><?= $project->id_project ?></th>
                            <td><?= $project->name ?></td>
                            <td><a href="detailsProject.php?id=<?= $project->id_project ?>" class="btn btn-primary">Détails</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="./commitPortfolio.php" class="btn btn-primary">Commit to github portfolio</a>
        <?php endif; ?>
    </div>
</div>
<?php require_once("./inc/footer.php"); ?>