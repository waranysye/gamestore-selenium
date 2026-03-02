<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<style>
.transactions-container {
    max-width: 1100px;
    margin: 40px auto;
    color: #fff;
}

.transactions-header h1 {
    font-size: 28px;
    margin-bottom: 6px;
}

.transactions-header p {
    color: #9aa4bf;
    margin-bottom: 30px;
}

.transaction-card {
    display: flex;
    justify-content: space-between;
    background: #141b2d;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 18px;
}

.transaction-left {
    flex: 1;
}

.transaction-info h3 {
    margin: 0;
    font-size: 18px;
}

.transaction-info span {
    font-size: 13px;
    color: #8c96b3;
}

.game-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
}

.game-item img {
    width: 50px;
    height: 50px;
    border-radius: 6px;
    object-fit: cover;
}

.transaction-right {
    text-align: right;
}

.price {
    font-size: 18px;
    font-weight: bold;
}

.badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    margin-top: 6px;
    font-weight: 600;
}

.badge.paid {
    background: #1f8f5f;
    color: #b9ffe3;
}

.badge.pending {
    background: #9c6b1a;
    color: #ffe1a6;
}

.badge.cancelled {
    background: #8a1f1f;
    color: #ffb3b3;
}

.action-btn {
    margin-top: 10px;
    display: inline-block;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    text-decoration: none;
    color: #fff;
}

.btn-library { background: #3b82f6; }
.btn-cancel  { background: #ef4444; }
.btn-store   { background: #334155; }

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}
</style>

<div class="transactions-container">

    <div class="transactions-header">
        <h1>My Transactions</h1>
        <p>Manage and track your digital purchases</p>
    </div>

    <?php if (!empty($orders)) : ?>

        <?php foreach ($orders as $order): ?>
            <div class="transaction-card">

                <div class="transaction-left">
                    <div class="transaction-info">

                        <h3>
                            Order #<?= esc($order['order_code'] ?? $order['id'] ?? '-') ?>
                        </h3>

                        <div style="margin-top:8px;">
                            <?php if (!empty($order['games']) && is_array($order['games'])): ?>
                                <?php foreach ($order['games'] as $game): ?>
                                    <div class="game-item">
                                        <img src="<?= base_url(esc($game['cover_image'])) ?>">
                                        <span><?= esc($game['title']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span>No games found</span>
                            <?php endif; ?>
                        </div>

                        <span>
                            <?= isset($order['created_at']) 
                                ? date('M d, Y', strtotime($order['created_at'])) 
                                : '-' ?>
                        </span>

                    </div>
                </div>

                <div class="transaction-right">

                    <div class="price">
                        Rp <?= number_format($order['total_price'] ?? 0, 0, ',', '.') ?>
                    </div>

                    <?php if (($order['status'] ?? '') === 'paid'): ?>

                        <div class="badge paid">Paid</div><br>
                        <a href="<?= base_url('library') ?>" class="action-btn btn-library">
                            Go to Library
                        </a>

                    <?php elseif (($order['status'] ?? '') === 'pending'): ?>

                        <div class="badge pending"
                             data-created="<?= isset($order['created_at']) ? strtotime($order['created_at']) : 0 ?>">
                            Pending • <span class="countdown">05:00</span>
                        </div><br>

                        <a href="<?= base_url('payment/cancel/'.$order['id']) ?>"
                           class="action-btn btn-cancel"
                           onclick="return confirm('Cancel this order?')">
                            Cancel Order
                        </a>

                    <?php else: ?>

                        <div class="badge cancelled">Cancelled</div><br>
                        <a href="<?= base_url('dashboard') ?>" class="action-btn btn-store">
                            Back to Store
                        </a>

                    <?php endif; ?>

                </div>

            </div>
        <?php endforeach; ?>

        <div class="pagination">
            <?= $pager->links() ?>
        </div>

    <?php else: ?>
        <p>No transactions found.</p>
    <?php endif; ?>

</div>

<script>
document.querySelectorAll('.badge.pending').forEach(badge => {
    const created = parseInt(badge.dataset.created) * 1000;
    const expire  = created + (5 * 60 * 1000);

    function updateCountdown() {
        const now = Date.now();
        const diff = expire - now;

        if (diff <= 0) {
            location.reload();
            return;
        }

        const m = Math.floor(diff / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        badge.querySelector('.countdown').innerText =
            `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>

<?= $this->endSection() ?>