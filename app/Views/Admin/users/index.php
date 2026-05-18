<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Users List</h2>
<a href="<?= site_url('admin/users/create') ?>" class="btn btn-success mb-3">+ Add User</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($users)): ?>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= esc($user['name']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td><?= ucfirst($user['role']) ?></td>
                <td>
                    <a href="<?= site_url('admin/users/edit/'.$user['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= site_url('admin/users/delete/'.$user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete <?= esc($user['name']) ?>?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No users found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>