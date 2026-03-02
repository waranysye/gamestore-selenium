<?php
$photo = $user['photo'] ?? null;
?>

<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<style>
.profile-wrapper {
    max-width: 900px;
    margin: 40px auto;
    background: #1b2340;
    border-radius: 20px;
    padding: 30px;
    color: #fff;
}
.profile-photo {
    display: flex;
    align-items: center;
    gap: 20px;
}
.profile-photo img {
    width: 120px;
    height: 120px;
    border-radius: 16px;
    object-fit: cover;
}
.btn {
    padding: 10px 16px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
}
.btn-primary { background: #3b82f6; color: #fff; }
.btn-danger  { background: #ef4444; color: #fff; }
.btn-muted   { background: #2d365f; color: #fff; }
.input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: #10162e;
    color: #fff;
}
.grid {
    display: grid;
    gap: 20px;
    margin-top: 20px;
}
.actions {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}
</style>

<form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
<?= csrf_field() ?>

<div class="profile-wrapper">

    <h2>My Profile</h2>

    <div class="profile-photo">
        <img src="<?= $photo
            ? base_url('uploads/profile/'.$photo)
            : base_url('assets/images/default-avatar.png') ?>"
            alt="Profile Photo">

        <div>
            <input type="file" name="photo" hidden id="photoInput" accept="image/*">

            <button type="button" class="btn btn-primary"
                onclick="document.getElementById('photoInput').click()">
                Update Photo
            </button>
        </div>
    </div>

    <div class="grid">

        <div>
            <label>Email</label>
            <input class="input" type="email" name="email"
                   value="<?= old('email', $user['email']) ?>" required>
        </div>

        <div>
            <label>New Password</label>
            <input type="password" class="input" name="password"
                   placeholder="Leave blank to keep current password">
        </div>

    </div>

    <div class="actions">
        <a href="<?= base_url('logout') ?>" class="btn btn-danger">
            Logout
        </a>

        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>
    </div>

</div>
</form>

<?= $this->endSection() ?>