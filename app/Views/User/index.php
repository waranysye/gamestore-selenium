<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Game Store</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $activeCategory = $activeCategory ?? 'all'; ?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --sidebar-bg: #1a2238;
    --main-bg: #12182b;
    --card-bg: #1c2541;
    --accent: #3a86ff;
    --danger: #ef4444;
    --success: #4caf50;
    --text-main: #ffffff;
    --text-dim: #a0a0b8;
}
* { margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }
body { background:var(--main-bg); color:var(--text-main); }

/* ===== HEADER ===== */
.header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:20px 40px;
    background:var(--sidebar-bg);
    min-height:72px;
}

.logo { font-size:20px; font-weight:700; }

.nav { display:flex; gap:28px; }

.nav a {
    color:var(--text-dim);
    text-decoration:none;
    font-weight:500;
    font-size:15px;
}

.nav a.active { color:var(--accent); }

.icons {
    display:flex;
    align-items:center;
    gap:22px;
}

.icons a {
    color:#ffffff;
    font-size:20px;
    text-decoration:none;
}

.icons a:hover { opacity:0.85; }

/* HERO */
.hero {
    margin:30px;
    border-radius:20px;
    overflow:hidden;
    background:linear-gradient(to right, rgba(0,0,0,.6), rgba(0,0,0,.2)),
    url("<?= base_url('assets/images/hero.jpg'); ?>") center/cover;
    padding:60px;
}

/* FILTER */
.filters { display:flex; gap:12px; padding:0 30px 20px; }

.filters a {
    padding:10px 18px;
    border-radius:999px;
    background:var(--card-bg);
    color:white;
    text-decoration:none;
    font-weight:500;
}

.filters a.active { background:var(--accent); }

/* GRID */
.section { padding:0 30px 40px; }

.grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

/* CARD LINK */
.card-link {
    text-decoration:none;
    color:inherit;
}

.card {
    background:var(--card-bg);
    border-radius:16px;
    overflow:hidden;
    transition:0.2s ease;
    cursor:pointer;
    position:relative;
}

.card:hover {
    transform:translateY(-4px);
    box-shadow:0 10px 20px rgba(0,0,0,0.3);
}

.card img {
    width:100%;
    height:150px;
    object-fit:cover;
}

.card .badge {
    position:absolute;
    top:14px;
    left:14px;
    background:var(--accent);
    color:white;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:0.08em;
}

.card .info { padding:14px; }

.card .title {
    font-weight:600;
    margin-bottom:4px;
}

.card .genre {
    font-size:13px;
    color:var(--text-dim);
    margin-bottom:8px;
}

.card .price {
    color:var(--accent);
    font-weight:600;
}

.empty {
    color:var(--text-dim);
    font-style:italic;
}
</style>
</head>

<body>

<!-- GLOBAL HEADBAR -->
<?= view('partials/headbar') ?>

<!-- HERO -->
<div class="hero">
    <h1>Latest Featured Game</h1>
    <p>Explore the newest adventure available in the store.</p>
</div>

<!-- FILTER CATEGORY -->
<div class="filters">
    <a href="<?= base_url('/') ?>"
       class="<?= ($activeCategory=='all')?'active':'' ?>">
       All Games
    </a>

    <a href="<?= base_url('/?category=the-cozy-dreamer') ?>"
       class="<?= ($activeCategory=='the-cozy-dreamer')?'active':'' ?>">
       Cozy Dreamer
    </a>

    <a href="<?= base_url('/?category=the-urban-legend') ?>"
       class="<?= ($activeCategory=='the-urban-legend')?'active':'' ?>">
       Urban Legend
    </a>
</div>

<!-- GAME LIST -->
<div class="section">
    <h2>Games</h2>

    <?php if (empty($games)): ?>
        <div class="empty">Game tidak tersedia</div>
    <?php else: ?>
    <div class="grid">
        <?php foreach ($games as $game): ?>
            <?php $isNew = !empty($game['created_at']) && strtotime($game['created_at']) > strtotime('-30 days'); ?>
            <a href="<?= base_url('game/'.$game['id']); ?>" class="card-link">
                <div class="card">
                    <?php if ($isNew): ?>
                        <div class="badge">New</div>
                    <?php endif; ?>
                    <img src="<?= base_url('uploads/games/' . $game['cover_image']) ?>">
                    <div class="info">
                        <div class="title"><?= esc($game['title']); ?></div>
                        <div class="genre"><?= esc($game['category_name']); ?></div>
                        <div class="price">
                            Rp <?= number_format($game['price'],0,',','.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>