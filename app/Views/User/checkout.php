
<?php
/**
 * @var string $mode
 * @var array<int, array{
 *   game_id:int|string,
 *   title:string,
 *   price:int|float
 * }> $items
 * @var int|float $total
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout | Game Store</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --sidebar-bg: #1a2238;
    --main-bg: #12182b;
    --card-bg: #1c2541;
    --accent: #3a86ff;
    --text-main: #ffffff;
    --text-dim: #a0a0b8;
}

* {
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

body {
    margin: 0;
    background: var(--main-bg);
    color: var(--text-main);
}

/* ===== HEADER ===== */
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 32px;
    background: var(--sidebar-bg);
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
    color: var(--text-dim);
    text-decoration: none;
}

.search input {
    width: 260px;
    padding: 10px 14px;
    border-radius: 10px;
    border: none;
    background: var(--card-bg);
    color: white;
}

.icons {
    display: flex;
    gap: 18px;
}

.icons a {
    color: white;
    font-size: 18px;
}

/* ===== BREADCRUMB ===== */
.breadcrumb {
    padding: 24px 32px;
    color: var(--text-dim);
}

/* ===== LAYOUT ===== */
.container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    padding: 0 32px 60px;
}

/* ===== CARD ===== */
.card {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 24px;
}

/* ===== PAYMENT METHOD ===== */
.payment-methods {
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 16px;
    margin-bottom: 20px;
}

.method {
    border: 2px solid transparent;
    border-radius: 12px;
    padding: 16px;
    cursor: pointer;
    text-align: center;
    background: #151c33;
}

.method.active {
    border-color: var(--accent);
    background: #18224a;
}

.method i {
    font-size: 24px;
    margin-bottom: 8px;
}

/* ===== INPUT ===== */
.input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: #151c33;
    color: white;
    margin-top: 10px;
}

/* ===== ORDER ITEMS ===== */
.item {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px solid #2a3358;
}

/* ===== BUTTON ===== */
.btn {
    width: 100%;
    margin-top: 20px;
    padding: 14px;
    border-radius: 12px;
    border: none;
    background: var(--accent);
    color: white;
    font-weight: 600;
    cursor: pointer;
}
</style>
</head>

<body>

<!-- HEADER -->
<!-- GLOBAL HEADBAR -->
<?= view('partials/headbar') ?>

<!-- BREADCRUMB -->
<div class="breadcrumb">
    Store › <a href="<?= base_url('cart') ?>" style="color:#a0a0b8">Shopping Cart</a> › <b>Checkout</b>
</div>

<form action="<?= base_url('checkout/confirm') ?>" method="post">
<?= csrf_field() ?>

<input type="hidden" name="mode" value="<?= esc($mode) ?>">

<?php if ($mode === 'buy_now' && !empty($items[0]['game_id'])): ?>
    <input type="hidden" name="game_id" value="<?= esc($items[0]['game_id']) ?>">
<?php endif; ?>

<input type="hidden" name="payment_method" id="payment_method" value="bank_transfer">

<div class="container">

    <!-- LEFT -->
    <div class="card">
        <h3>Select Payment Method</h3>

        <div class="payment-methods">
            <div class="method active" onclick="selectPayment(this,'bank_transfer')">
                <i class="fa-solid fa-building-columns"></i>
                <div>Bank Transfer</div>
            </div>

            <div class="method" onclick="selectPayment(this,'e_wallet')">
                <i class="fa-solid fa-wallet"></i>
                <div>E-Wallet</div>
            </div>
        </div>

        <div id="bankBox">
            <label>Bank Account</label>
            <input class="input" type="text" value="BCA / BNI / Mandiri" readonly>
        </div>

        <div id="walletBox" style="display:none">
            <label>Phone Number</label>
            <input class="input" type="text" name="phone" placeholder="08xxxxxxxxxx">
        </div>

        <h4 style="margin-top:30px">Order Items</h4>

        <?php foreach ($items as $item): ?>
        <div class="item">
            <span><?= esc($item['title'] ?? '-') ?></span>
            <span>Rp <?= number_format((float)($item['price'] ?? 0), 0, ',', '.') ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- RIGHT -->
    <div class="card">
        <h3>Order Summary</h3>

        <div class="item">
            <span>Total</span>
            <strong>Rp <?= number_format((float)$total, 0, ',', '.') ?></strong>
        </div>

        <button type="submit" class="btn">
            <i class="fa-solid fa-lock"></i> Confirm Payment
        </button>
    </div>

</div>
</form>

<script>
function selectPayment(el, method) {
    document.querySelectorAll('.method').forEach(m => {
        m.classList.remove('active');
    });

    el.classList.add('active');

    document.getElementById('payment_method').value = method;

    document.getElementById('bankBox').style.display =
        method === 'bank_transfer' ? 'block' : 'none';

    document.getElementById('walletBox').style.display =
        method === 'e_wallet' ? 'block' : 'none';
}

document.getElementById('payment_method').value = 'bank_transfer';
</script>

</body>
</html>