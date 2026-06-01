<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart | GameVault</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #0f172a;
    color: #fff;
}

/* ===== HEADER ===== */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 32px;
    background: #020617;
    border-bottom: 1px solid #1e293b;
}

.logo {
    font-size: 20px;
    font-weight: 700;
}

.nav {
    display: flex;
    gap: 24px;
}

.nav a {
    color: #94a3b8;
    text-decoration: none;
}

.nav a.active {
    color: #38bdf8;
}

.icons {
    display: flex;
    gap: 20px;
}

.icons a {
    color: #e5e7eb;
    font-size: 18px;
}

/* ===== PAGE ===== */
.container {
    padding: 40px;
    display: grid;
    grid-template-columns: 2.5fr 1fr;
    gap: 30px;
}

h1 {
    margin-bottom: 24px;
}

/* ===== CART TABLE ===== */
.cart-box {
    background: #020617;
    border-radius: 16px;
    padding: 24px;
}

.cart-row {
    display: grid;
    grid-template-columns: 80px 1.8fr 1fr 1fr 40px;
    gap: 16px;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px solid #1e293b;
}

.cart-row:last-child {
    border-bottom: none;
}

.cart-row img {
    width: 70px;
    border-radius: 10px;
}

.game-title {
    font-weight: 600;
}

.genre {
    font-size: 13px;
    color: #94a3b8;
}

.price {
    font-weight: 600;
    color: #38bdf8;
}

.remove {
    color: #ef4444;
    cursor: pointer;
}

/* ===== SUMMARY ===== */
.summary {
    background: #020617;
    border-radius: 16px;
    padding: 24px;
    height: fit-content;
}

.summary h3 {
    margin-bottom: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    color: #cbd5f5;
}

.total {
    font-size: 22px;
    font-weight: 700;
    color: #38bdf8;
}

.checkout-btn {
    margin-top: 20px;
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: none;
    background: #38bdf8;
    color: #020617;
    font-weight: 600;
    cursor: pointer;
}
.checkout-btn:disabled {
    background: #475569;
    cursor: not-allowed;
    opacity: 0.6;
}
</style>
</head>

<body>

<!-- HEADER -->
<!-- GLOBAL HEADBAR -->
<?= view('partials/headbar') ?>

<!-- CONTENT -->
<div class="container">

    <!-- CART -->
    <div>
        <h1>Your Shopping Cart</h1>

        <div class="cart-box">
            <?php if(empty($cartItems)): ?>
                <p>Cart is empty.</p>
            <?php else: ?>
                <?php $total = 0; ?>
                <?php foreach($cartItems as $item): ?>
                    <?php $total += $item['price']; ?>
                    <div class="cart-row">
                        <img src="<?= base_url('uploads/games/'.$item['cover_image']) ?>">
                        <div>
                            <div class="game-title"><?= esc($item['title']) ?></div>
                            <div class="genre"><?= esc($item['genre']) ?></div>
                        </div>
                        <div>PC Digital</div>
                        <div class="price">
                            Rp <?= number_format($item['price'],0,',','.') ?>
                        </div>
                        <a class="remove"
                           href="<?= base_url('cart/remove/'.$item['id']) ?>">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- SUMMARY -->
    <div class="summary">
        <h3>Order Summary</h3>

        <div class="summary-row">
            <span>Total</span>
            <span class="total">
                Rp <?= number_format($total ?? 0,0,',','.') ?>
            </span>
        </div>

        <?php $isEmpty = empty($cartItems); ?>

<form action="<?= base_url('checkout') ?>" method="get">
    <button type="submit" class="checkout-btn" <?= $isEmpty ? 'disabled' : '' ?>>
        Proceed to Checkout
    </button>
</form>
    </div>

</div>

</body>
</html>