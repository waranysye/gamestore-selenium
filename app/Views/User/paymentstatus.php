<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<?php
$status = $order['status'];
?>

<style>
.payment-wrapper {
    max-width: 820px;
    margin: 70px auto;
    text-align: center;
    color: #e5e7eb;
}

.status-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    font-weight: bold;
}

.status-success { background:#16a34a20; color:#22c55e; }
.status-pending { background:#facc1520; color:#facc15; }
.status-cancel  { background:#ef444420; color:#ef4444; }

.payment-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 6px;
}

.payment-subtitle {
    color: #9ca3af;
    margin-bottom: 30px;
}

.payment-card {
    background: #0f172a;
    border-radius: 16px;
    padding: 32px;
    text-align: left;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.row-flex {
    display: flex;
    justify-content: space-between;
    margin-bottom: 18px;
}

.row-flex small {
    color: #9ca3af;
    font-size: 12px;
    letter-spacing: .5px;
}

.row-flex strong {
    font-size: 15px;
}

.status-badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-success { background:#16a34a20; color:#22c55e; }
.badge-pending { background:#facc1520; color:#facc15; }
.badge-cancel  { background:#ef444420; color:#ef4444; }

.payment-card hr {
    border: none;
    border-top: 1px solid #1f2933;
    margin: 22px 0;
}

.item-row {
    display: flex;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #1f2933;
}

.item-row:last-child {
    border-bottom: none;
}

.payment-actions {
    margin-top: 35px;
    display: flex;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 26px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn-primary {
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
}

.btn-secondary {
    background: #1f2937;
    color: #e5e7eb;
}

.btn-secondary:hover {
    background:#374151;
}

.btn-danger {
    background:#dc2626;
    color:white;
}

.btn-danger:hover {
    background:#b91c1c;
}
</style>

<div class="payment-wrapper">

<?php if ($status === 'paid'): ?>
    <div class="status-icon status-success">✓</div>
    <div class="payment-title">Payment Successful</div>
    <div class="payment-subtitle">Your purchase has been completed successfully.</div>
<?php elseif ($status === 'pending'): ?>
    <div class="status-icon status-pending">⏳</div>
    <div class="payment-title">Waiting for Confirmation</div>
    <div class="payment-subtitle">Your payment is being reviewed by admin.</div>
<?php else: ?>
    <div class="status-icon status-cancel">✕</div>
    <div class="payment-title">Order Cancelled</div>
    <div class="payment-subtitle">This transaction has been cancelled.</div>
<?php endif; ?>

<div class="payment-card">

    <div class="row-flex">
        <div>
            <small>TRANSACTION ID</small><br>
            <strong>#ORD-<?= $order['id'] ?></strong>
        </div>
        <div style="text-align:right">
            <small>TOTAL AMOUNT</small><br>
            <strong>Rp <?= number_format($order['total_price'],0,',','.') ?></strong>
        </div>
    </div>

    <div class="row-flex">
        <div>
            <small>DATE</small><br>
            <strong><?= date('d F Y', strtotime($order['created_at'])) ?></strong>
        </div>
        <div style="text-align:right">
            <small>STATUS</small><br>
            <?php if ($status === 'paid'): ?>
                <span class="status-badge badge-success">Paid</span>
            <?php elseif ($status === 'pending'): ?>
                <span class="status-badge badge-pending">Pending</span>
            <?php else: ?>
                <span class="status-badge badge-cancel">Cancelled</span>
            <?php endif; ?>
        </div>
    </div>

    <hr>

    <h4>Purchased Items</h4>

    <?php foreach ($items as $item): ?>
        <div class="item-row">
            <span><?= esc($item['title']) ?></span>
            <span>Rp <?= number_format($item['price'],0,',','.') ?></span>
        </div>
    <?php endforeach; ?>

</div>

<div class="payment-actions">

<?php if ($status === 'paid'): ?>
    <a href="<?= site_url('/library') ?>" class="btn btn-primary">Go to Library</a>
    <a href="<?= site_url('/orders/'.$order['id']) ?>" class="btn btn-secondary">View Transaction</a>

<?php elseif ($status === 'pending'): ?>
    <a href="<?= site_url('/orders/'.$order['id']) ?>" class="btn btn-primary">View Transaction</a>

    <form action="<?= site_url('/payment/cancel/'.$order['id']) ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger">Cancel Order</button>
    </form>

<?php else: ?>
    <a href="<?= site_url('/') ?>" class="btn btn-primary">Return to Store</a>
<?php endif; ?>

</div>
</div>

<?= $this->endSection() ?>