<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
/* Tombol umum supaya size dan style sama */
.btn-save, .btn-back {
    display: inline-block;
    padding: 10px 24px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Save */
.btn-save {
    background-color: #28a745;
    color: white;
    border: none;
}

.btn-save:hover {
    background-color: #218838;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transform: translateY(-2px);
}

/* Back */
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

<h2>Add Game</h2>

<form action="<?= site_url('admin/games') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <table class="table table-borderless" style="max-width:600px;">
        <tr>
            <td><label for="title">Title</label></td>
            <td>
                <input type="text" name="title" id="title" required class="form-control">
            </td>
        </tr>

        <tr>
            <td><label for="description">Description</label></td>
            <td>
                <textarea name="description" id="description" required class="form-control"></textarea>
            </td>
        </tr>

        <tr>
            <td><label for="price">Price</label></td>
            <td>
                <input type="number" name="price" id="price" required class="form-control" min="0" step="0.01">
            </td>
        </tr>

        <tr>
            <td><label for="game_file">Game File</label></td>
            <td>
                <input type="text" name="game_file" id="game_file" class="form-control">
            </td>
        </tr>

        <tr>
            <td><label for="cover_image">Cover Image</label></td>
            <td>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="form-control">
            </td>
        </tr>

        <!-- ✅ MULTIPLE GALLERY IMAGES -->
        <tr>
            <td><label for="images">Game Images (Gallery)</label></td>
            <td>
                <input
                    type="file"
                    name="images[]"
                    id="images"
                    accept="image/*"
                    multiple
                    class="form-control"
                >
                <small style="color:#aaa;">
                    You can select multiple images (hold CTRL or SHIFT to choose more than one)
                </small>
            </td>
        </tr>

        <!-- ✅ FIXED CATEGORY OPTIONS -->
        <tr>
            <td><label for="category_id">Category</label></td>
            <td>
                <select name="category_id" id="category_id" required class="form-control">
                    <option value="">-- Select Category --</option>
                    <option value="1">The Cozy Dreamer</option>
                    <option value="2">The Urban Legend</option>
                </select>
            </td>
        </tr>
    </table>

    <div class="mt-3">
        <button type="submit" class="btn-save">Save</button>
        <a href="<?= site_url('admin/games') ?>" class="btn-back" style="margin-left: 10px;">Back</a>
    </div>
</form>

<?= $this->endSection() ?>