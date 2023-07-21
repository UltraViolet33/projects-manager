<div class="row">
    <div class="col-12 text-center">
        <h1>Projects Manager</h1>
        <p>The web app to manage all the programming projects you dream</p>
    </div>
    <div class="col-12">
        <h2 class="text-center">Projects : </h2>
        <p>Total : </p>
    </div>
</div>
<form id="form-categories">
    <h3>Categories</h3>
    <div class="mb-3">
        <select id="form-categories-select" name="categoryFilter" class="form-select">
            <option value="all" selected>All</option>
            <?php foreach ($allCategories as $category) : ?>
                <option value="<?= $category->id_category ?>"><?= $category->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>
<form id="form-categories">
    <h3>Projects Status</h3>
    <div class="mb-3">
        <select id="form-status-select" name="projects-status" class="form-select">
            <option value="all">All</option>
            <option value="0">in_progress</option>
            <option value="1">done</option>
        </select>
    </div>
</form>
<div class="row">
    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Created At</th>
                    <th scope="col">DETAILS</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
</div>
<script src="../assets/js/projects.js"></script>