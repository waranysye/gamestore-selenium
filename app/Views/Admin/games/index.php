<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 style="margin-bottom:20px;">Games List</h2>

<a href="<?= site_url('admin/games/create') ?>" class="btn btn-add" style="margin-bottom:20px;">
    <i class="fas fa-plus"></i> Add Game
</a>

<style>
.games-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}

.game-card {
    background: var(--card-bg);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
}

.game-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 36px rgba(0,0,0,0.45);
}

.game-card img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    background: #0d1117;
}

.game-card-body {
    padding: 14px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.game-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 6px;
}

.game-category {
    font-size: 0.85rem;
    color: var(--text-dim);
    margin-bottom: 8px;
}

.game-price {
    font-size: 1rem;
    font-weight: 600;
    color: var(--success);
    margin-bottom: 12px;
}
</style>

<div class="games-grid">
    <?php if (!empty($games)): ?>
        <?php foreach ($games as $game): ?>
            <div class="game-card">

                <img
                    src="<?= $game['cover_image']
                        ? base_url('uploads/games/' . $game['cover_image'])
                        : 'https://via.placeholder.com/400x250?text=No+Image'
                    ?>"
                    alt="<?= esc($game['title']) ?>"
                >

                <div class="game-card-body">
                    <div>
                        <div class="game-title"><?= esc($game['title']) ?></div>
                        <div class="game-category"><?= esc($game['category_name']) ?></div>
                        <div class="game-price">
                            Rp <?= number_format($game['price'], 0, ',', '.') ?>
                        </div>
                    </div>

                    <div style="display:flex; gap:6px;">
                        <a href="<?= site_url('admin/games/edit/' . $game['id']) ?>"
                           class="btn btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="<?= site_url('admin/games/delete/' . $game['id']) ?>"
                              method="post"
                              onsubmit="return confirm('Delete <?= esc($game['title']) ?>?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column:1/-1; color:var(--text-dim);">
            No games found.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>