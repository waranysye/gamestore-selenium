<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Results | Game Store</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

/* GRID */
.section { padding:40px 30px; }

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

<div class="section">
    <h2>Search Results for: "<?= esc($keyword) ?>"</h2>
    <br>

    <?php if (empty($games)): ?>
        <div class="empty">No games found matching your search.</div>
    <?php else: ?>
    <div class="grid">
        <?php foreach ($games as $game): ?>
            <a href="<?= base_url('game/'.$game['id']); ?>" class="card-link">
                <div class="card">
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