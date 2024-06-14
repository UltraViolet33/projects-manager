<div class="row">
    <div class="col-12">
        <h1 class="text-center">Projects of portfolio <?= $portfolio->name ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php if (!$projects): ?>
            <p>There is no projects</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
=                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <th scope="row">
                                <?= $project->id_project ?>
                            </th>
                            <td>
                                <?= $project->name ?>
                            </td>
                            <td>
                                <a href="/portfolio/remove-project?id_project=<?= $project->id_project ?>&id_portfolio=<?= $portfolio->id_portfolio ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>