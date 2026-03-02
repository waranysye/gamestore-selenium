<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 style="margin-bottom:20px;">Categories</h2>

<a href="<?= site_url('admin/categories/create') ?>" class="btn btn-add">
    <i class="fas fa-plus"></i> Add Category
</a>

<div class="card" style="margin-top:20px;">
    <table>
        <thead>
            <tr>
                <th width="60">ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= esc($category['name']) ?></td>
                        <td><?= esc($category['slug']) ?></td>
                        <td>
                            <a href="<?= site_url('admin/categories/edit/'.$category['id']) ?>"
                               class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <a href="<?= site_url('admin/categories/delete/'.$category['id']) ?>"
                               class="btn btn-delete"
                               onclick="return confirm('Delete <?= esc($category['name']) ?>?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;color:#a0a0b8;">
                        No categories found.
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>