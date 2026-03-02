<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Add User</h2>

<form action="<?= site_url('admin/users/store') ?>" method="post">
    <?= csrf_field() ?>

    <table class="table table-borderless" style="max-width: 600px;">
        <tr>
            <td><label for="name">Name</label></td>
            <td><input type="text" name="name" id="name" required class="form-control"></td>
        </tr>
        <tr>
            <td><label for="email">Email</label></td>
            <td><input type="email" name="email" id="email" required class="form-control"></td>
        </tr>
        <tr>
            <td><label for="password">Password</label></td>
            <td><input type="password" name="password" id="password" required class="form-control"></td>
        </tr>
        <tr>
            <td><label for="role">Role</label></td>
            <td>
                <select name="role" id="role" required class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </td>
        </tr>
    </table>

    <div class="mt-3">
        <button type="submit" class="btn btn-light" style="color:black;">Save</button>
        <a href="<?= site_url('admin/categories') ?>" style="margin-left: 10px;">Back</a>
    </div>
</form>

<?= $this->endSection() ?>