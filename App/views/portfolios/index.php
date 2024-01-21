<div class="row">
    <div class="col-12">
        <h1 class="text-center">All portfolios</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php if (!$allPortfolios): ?>
            <p>There is no portfolio</p>
            <a href="/portfolios/create">create one</a>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">EDIT</th>
                        <th scope="col">DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allPortfolios as $tech): ?>
                        <tr>
                            <th scope="row">
                                <?= $tech->id_tech ?>
                            </th>
                            <td>
                                <?= $tech->name ?>
                            </td>
                            <td>
                                <a href="/techs/edit?id=<?= $tech->id_tech ?>" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form action="/techs/delete" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this tech ?')">
                                    <input type="hidden" name="id_tech" value="<?= $tech->id_tech ?>">
                                    <input type="submit" class="btn btn-warning" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>