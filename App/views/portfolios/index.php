<div class="row">
    <div class="col-12">
        <h1 class="text-center">All portfolios</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php if (!$allPortfolios) : ?>
            <p>There is no portfolio</p>
            <a href="/portfolios/create">create one</a>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">See projects</th>
                        <th scope="col">Add projects</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allPortfolios as $portfolio) : ?>
                        <tr>
                            <th scope="row">
                                <?= $portfolio->id_portfolio ?>
                            </th>
                            <td>
                                <?= $portfolio->portfolio_name ?>
                            </td>
                            <td>
                                <?= $portfolio->category_name ?>
                            </td>
                            <td>
                                <a href="/portfolios/projects?id=<?= $portfolio->id_portfolio ?>" class="btn btn-primary">See</a>
                            </td>
                            <td>
                                <a href="/portfolios/add-projects?id=<?= $portfolio->id_portfolio ?>" class="btn btn-primary">Add</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>