<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<style>
.library-container {
    max-width: 1200px;
    margin: 40px auto;
    color: #fff;
}

.library-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.library-header h1 {
    font-size: 30px;
}

.library-header span {
    color: #9aa4bf;
    font-size: 14px;
}

.library-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 26px;
}

.game-card {
    background: #141b2d;
    border-radius: 16px;
    overflow: hidden;
    transition: transform .3s;
}

.game-card:hover {
    transform: translateY(-6px);
}

.game-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}

.game-content {
    padding: 16px;
}

.game-content h3 {
    margin: 0;
    font-size: 18px;
}

.game-meta {
    font-size: 12px;
    color: #9aa4bf;
    margin: 6px 0 14px;
}

.game-action {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.btn-play {
    background: #22c55e;
    padding: 10px 18px;
    border-radius: 10px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
}

.btn-download {
    background: #3b82f6;
    padding: 10px 18px;
    border-radius: 10px;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 14px;
}
</style>

<div class="library-container">

    <div class="library-header">
        <div>
            <h1>My Library</h1>
            <span><?= count($games) ?> Games Purchased</span>
        </div>
    </div>

    <div class="library-grid">
        <?php foreach ($games as $game): ?>
            <div class="game-card">

                <img src="<?= base_url('uploads/games/'.$game['cover_image']) ?>"
                     alt="<?= esc($game['title']) ?>">

                <div class="game-content">
                    <h3><?= esc($game['title']) ?></h3>

                    <div class="game-meta">
                        Size: <?= esc($game['size'] ?? '-') ?> GB
                    </div>

                    <div class="game-action">

                        <?php if ($game['installed']): ?>

                            <!-- PLAY -->
                            <a href="#" class="btn-play">Play</a>

                            <!-- UNINSTALL -->
                            <form class="action-form" action="<?= base_url('library/uninstall/'.$game['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-download" style="background:#ef4444;">
                                    Uninstall
                                </button>
                            </form>

                        <?php else: ?>

                            <!-- DOWNLOAD -->
                            <form class="action-form" action="<?= base_url('library/download/'.$game['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-download">
                                    Download
                                </button>
                            </form>

                        <?php endif; ?>

                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.action-form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('button');
            if (btn) {
                btn.innerText = 'Processing...';
                btn.disabled = true;
            }
        });
    });
});
</script>

<?= $this->endSection() ?>