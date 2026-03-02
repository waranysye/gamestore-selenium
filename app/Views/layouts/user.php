
<?php
$activePage = $activePage ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Game Store</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --sidebar-bg:#1a2238;
    --main-bg:#12182b;
    --card-bg:#1c2541;
    --accent:#3a86ff;
    --text-main:#fff;
    --text-dim:#a0a0b8;
}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}
body{background:var(--main-bg);color:var(--text-main);}

/* HEADER USER */
.header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:16px 32px;
    background:var(--sidebar-bg);
}
.logo{font-size:20px;font-weight:700;}
.nav{display:flex;gap:24px;}
.nav a{
    color:var(--text-dim);
    text-decoration:none;
    font-weight:500;
}
.nav a.active{color:var(--accent);}
.icons{
    display:flex;
    gap:18px;
}
.icons a{
    color:white;
    font-size:18px;
}
</style>
</head>
<script src="https://cdn.tailwindcss.com"></script>

<body>

<!-- HEADER USER -->
<div class="header">
    <div class="logo">Game Store</div>

    <div class="nav">
        <a href="<?= base_url('/') ?>"
           class="<?= ($activePage==='store')?'active':'' ?>">Store</a>

        <a href="<?= base_url('library') ?>"
           class="<?= ($activePage==='library')?'active':'' ?>">Library</a>
    </div>

    <div class="icons">
        <a href="<?= base_url('cart') ?>"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="<?= base_url('transactions') ?>"><i class="fa-solid fa-receipt"></i></a>
        <a href="<?= base_url('profile') ?>"><i class="fa-solid fa-user"></i></a>
    </div>
</div>

<?= $this->renderSection('content') ?>

</body>
</html>