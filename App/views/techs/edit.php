<div class="row">
    <div class="col-12">
        <h1 class="text-center">Edit tech :
            <?= $tech->name ?>
        </h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name : </label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($tech->name) ?>">
            </div>
            <input class="btn btn-primary" type="submit" value="Submit">
        </form>
        <?php if (strlen($errors) !== 0): ?>
            <div class="bg-danger my-3 p-2">
                <p class="text-center">
                    <?= $errors ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>