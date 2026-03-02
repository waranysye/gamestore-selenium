<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 style="margin-bottom:20px;">Edit Category</h2>

<div class="card" style="max-width:600px;">
    <form action="<?= site_url('admin/categories/update/'.$category['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Category Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?= esc($category['name']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input
                type="text"
                id="slug"
                name="slug"
                value="<?= esc($category['slug']) ?>"
                required
            >
        </div>

        <div style="display:flex; gap:10px; margin-top:20px;">
            <button type="submit" class="btn btn-edit">
                <i class="fas fa-save"></i> Update
            </button>

            <a href="<?= site_url('admin/categories') ?>" class="btn btn-delete">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>