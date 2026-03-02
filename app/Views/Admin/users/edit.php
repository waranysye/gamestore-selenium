<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit User</h2>

<form action="<?= site_url('admin/users/update/'.$user['id']) ?>" method="post">
    <?= csrf_field() ?>

    <table class="table table-borderless" style="max-width: 600px;">
        <tr>
            <td><label for="name">Name</label></td>
            <td><input type="text" name="name" id="name" value="<?= esc($user['name']) ?>" required class="form-control"></td>
        </tr>
        <tr>
            <td><label for="email">Email</label></td>
            <td><input type="email" name="email" id="email" value="<?= esc($user['email']) ?>" required class="form-control"></td>
        </tr>
        <tr>
            <td><label for="password">Password</label></td>
            <td><input type="password" name="password" id="password" placeholder="Leave blank if unchanged" class="form-control"></td>
        </tr>
        <tr>
            <td><label for="role">Role</label></td>
            <td>
                <select name="role" id="role" required class="form-control">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </td>
        </tr>
    </table>

    <div class="mt-3">
        <button type="submit" class="btn btn-light" style="color:black;">Update</button>
        <a href="<?= site_url('admin/categories') ?>" style="margin-left: 10px;">Back</a>
    </div>
</form>

<?= $this->endSection() ?>