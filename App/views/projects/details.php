<link rel="stylesheet" href="../assets/css/buttonToggle.css">
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Details Project: <?= $project->name ?></h1>
        <p>Name : <?= $project->name ?></p>
        <p>Description : <?= $project->description ?></p>
        <p>Github link : <?= $project->github_link ?  " <a href='$project->github_link' target='_blanck'>Lien vers github</a> " : "non renseigné" ?></p>
        <p>Created at : <?= $project->created_at ?></p>
        <div id="btn-toggle-status"></div>
        <h4>Categories :</h4>
        <ul>
            <?php if ($project->categories) : ?>
                <?php foreach ($project->categories as $category) : ?>
                    <li><?= $category->name ?></li>
                <?php endforeach; ?>
            <?php else : ?>
                There is no category for this project
            <?php endif; ?>
        </ul>
        <h4>Technologies :</h4>
        <ul>
            <?php if ($project->techs) : ?>
                <?php foreach ($project->techs as $tech) : ?>
                    <li><?= $tech->name ?></li>
                <?php endforeach; ?>
            <?php else : ?>
                There is no techs for this project
            <?php endif; ?>
        </ul>
        <div class="m-2">
            <a href="/projects/edit?id=<?= $project->id_project ?>" class="btn btn-primary">Edit</a>
        </div>
        <div class="m-2">
            <form action="/projects/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this project ? ')">
                <input type="hidden" name="idProject" value="<?= $project->id_project ?>">
                <input class="btn btn-danger" type="submit" value="Delete" name="deleteProject"></input>
            </form>
        </div>
    </div>
</div>
<script src="../assets/js/editProject.js"></script>