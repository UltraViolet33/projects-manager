<div class="row">
    <div class="col-12">
        <h1 class="text-center">Details Project : <?= $project->name ?></h1>
        <p>Name : <?= $project->name ?></p>
        <p>Description : <?= $project->description ?></p>
        <p>Github link : <?= $project->github_link ?  " <a href='$project->github_link' target='_blanck'>Lien vers github</a> " : "non renseigné" ?></p>
        <p>Is in Github Portfolio : <?= $project->github_portfolio ? "yes" : "no" ?></p>
        <p>Status : <?= $project->status ? "Done" : "In progress" ?></p>
        <p>Priority : <?= $project->priority > 0 ? "High" : "Low" ?></p>
        <p>Created at : <?= $project->created_at ?></p>
        <h4>Categories :</h4>
        <ul>
            <?php foreach ($project->categories as $category) : ?>
                <li><?= $category->name ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="/projects/edit?id=<?= $project->id_project ?>" class="btn btn-primary">Edit</a>
        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this project ? ')">
            <input type="hidden" name="idProject" value="<?= $project->id_project ?>">
            <input class="btn btn-danger" type="submit" value="Delete" name="deleteProject"></input>
        </form>
    </div>
</div>