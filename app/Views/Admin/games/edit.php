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

<?php $validation = \Config\Services::validation(); ?>

<?php if (!empty(session()->getFlashdata('errors'))): ?>
    <div class="alert alert-danger" style="margin-bottom:20px;padding:15px;border-radius:12px;background:#ffe3e3;color:#9f1c1c;">
        <strong>Validation failed:</strong>
        <ul style="margin-top:10px;list-style:disc;padding-left:20px;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('admin/games/update/'.$game['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <table class="table table-borderless" style="max-width:600px;">
        <tr>
            <td><label for="title">Title</label></td>
            <td><input type="text" name="title" id="title" value="<?= esc(old('title', $game['title'])) ?>" required class="form-control"></td>
        </tr>
        <tr>
            <td><label for="description">Description</label></td>
            <td><textarea name="description" id="description" required class="form-control"><?= esc(old('description', $game['description'])) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="price">Price</label></td>
            <td><input type="number" name="price" id="price" value="<?= esc(old('price', $game['price'])) ?>" required class="form-control" min="0" step="0.01"></td>
        </tr>
        <tr>
            <td><label for="game_file">Game File</label></td>
            <td><input type="text" name="game_file" id="game_file" value="<?= esc(old('game_file', $game['game_file'])) ?>" class="form-control"></td>
        </tr>
        <tr>
            <td><label for="size">File Size (MB)</label></td>
            <td><input type="number" name="size" id="size" value="<?= esc(old('size', $game['size'])) ?>" class="form-control" min="0" step="1" placeholder="Contoh: 350"></td>
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
            <td><label for="images">Additional Gallery Images</label></td>
            <td>
                <input type="file" name="images[]" id="images" accept="image/*" multiple class="form-control">
                <small style="color:#aaa;">Upload lebih banyak screenshot untuk ditampilkan di halaman detail game.</small>
            </td>
        </tr>
        <?php if (!empty($images)): ?>
        <tr>
            <td>Existing Gallery</td>
            <td>
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    <?php foreach ($images as $img): ?>
                        <div style="position:relative;width:120px;">
                            <img src="<?= base_url('uploads/games/gallery/' . $img['image']) ?>" alt="gallery" style="width:120px;height:80px;object-fit:cover;border-radius:10px;border:1px solid #4b5563;">
                            <form action="<?= site_url('admin/games/remove-image/'.$img['id']) ?>" method="post" style="position:absolute;top:6px;right:6px;">
                                <?= csrf_field() ?>
                                <button type="submit" title="Remove image" style="background:rgba(0,0,0,0.6);border:none;color:#fff;border-radius:999px;width:28px;height:28px;cursor:pointer;">×</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td><label for="category_id">Category</label></td>
            <td>
                <select name="category_id" id="category_id" required class="form-control">
                    <option value="">-- Select Category --</option>
                    <?php foreach($categories as $c): ?>
                        <option value="<?= esc($c['id']) ?>" <?= $c['id'] == old('category_id', $game['category_id']) ? 'selected' : '' ?> >
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