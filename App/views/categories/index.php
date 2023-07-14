<div class="row">
    <div class="col-12">
        <h1 class="text-center">All Categories</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php if (!$allCategories) : ?>
            <p>There is no category</p>
        <?php else : ?>
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
                    <?php foreach ($allCategories as $category) : ?>
                        <tr>
                            <th scope="row"><?= $category->id_category ?></th>
                            <td><?= $category->name ?></td>
                            <td><a href="/categories/edit?id=<?= $category->id_category ?>" class="btn btn-primary">Edit</a></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this category ?')">
                                    <input type="hidden" name="idCategory" value="<?= $category->id_category ?>">
                                    <input type="submit" class="btn btn-warning" value="Delete" name="deleteCategory">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>