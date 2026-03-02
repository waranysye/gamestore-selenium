<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* Tombol umum supaya ukuran dan style sama */
.btn-update, .btn-back {
    display: inline-block;
    padding: 10px 24px; /* ukuran sama seperti Add User/Game */
    font-size: 16px;
    font-weight: 500;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Update → hijau cerah sama Save sebelumnya */
.btn-update {
    background-color: #28a745;
    color: white;
    border: none;
}

.btn-update:hover {
    background-color: #218838;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transform: translateY(-2px);
}

/* Back → biru cerah sama Back sebelumnya */
.btn-back {
    background-color: #007bff;
    color: white;
    border: none;
}

.btn-back:hover {
    background-color: #0069d9;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transform: translateY(-2px);
}
</style>

<h2>Edit Game</h2>

<form action="<?= site_url('admin/games/update/'.$game['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <table class="table table-borderless" style="max-width:600px;">
        <tr>
            <td><label for="title">Title</label></td>
            <td><input type="text" name="title" id="title" value="<?= esc($game['title']) ?>" required class="form-control"></td>
        </tr>
        <tr>
            <td><label for="description">Description</label></td>
            <td><textarea name="description" id="description" required class="form-control"><?= esc($game['description']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="price">Price</label></td>
            <td><input type="number" name="price" id="price" value="<?= esc($game['price']) ?>" required class="form-control" min="0" step="0.01"></td>
        </tr>
        <tr>
            <td><label for="game_file">Game File</label></td>
            <td><input type="text" name="game_file" id="game_file" value="<?= esc($game['game_file']) ?>" class="form-control"></td>
        </tr>
        <tr>
            <td><label for="cover_image">Cover Image</label></td>
            <td>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="form-control">
                <?php if($game['cover_image']): ?>
                    <small>Current: <?= esc($game['cover_image']) ?></small>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><label for="category_id">Category</label></td>
            <td>
                <select name="category_id" id="category_id" required class="form-control">
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $game['category_id'] ? 'selected' : '' ?>>
                            <?= esc($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>

    <div class="mt-3">
        <button type="submit" class="btn-update">Update</button>
        <a href="<?= site_url('admin/games') ?>" class="btn-back" style="margin-left: 10px;">Back</a>
    </div>
</form>

<?= $this->endSection() ?>