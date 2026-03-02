<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Orders List</h2>

<div class="card">
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Date</th>
            <th style="width:220px">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>

                <td><?= esc($order['user_name']) ?></td>

                <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>

                <td><?= esc($order['payment_method'] ?? '-') ?></td>

                <td>
                    <?php if ($order['status'] === 'pending'): ?>
                        <span style="padding:4px 10px;border-radius:6px;background:#f59e0b;color:white;">
                            Pending
                        </span>
                    <?php elseif ($order['status'] === 'paid'): ?>
                        <span style="padding:4px 10px;border-radius:6px;background:#4caf50;color:white;">
                            Paid
                        </span>
                    <?php elseif ($order['status'] === 'cancelled'): ?>
                        <span style="padding:4px 10px;border-radius:6px;background:#ef4444;color:white;">
                            Cancelled
                        </span>
                    <?php endif; ?>
                </td>

                <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>

                <td>
                    <?php if ($order['status'] === 'pending'): ?>

                        <form action="<?= site_url('admin/orders/approve/'.$order['id']) ?>"
                              method="post"
                              style="display:inline-block">
                            <?= csrf_field() ?>
                            <button class="btn btn-edit"
                                    onclick="return confirm('Approve this order?')">
                                Approve
                            </button>
                        </form>

                        <form action="<?= site_url('admin/orders/reject/'.$order['id']) ?>"
                              method="post"
                              style="display:inline-block">
                            <?= csrf_field() ?>
                            <button class="btn btn-delete"
                                    onclick="return confirm('Reject this order?')">
                                Reject
                            </button>
                        </form>

                    <?php else: ?>
                        <em class="text-dim">No Action</em>
                    <?php endif; ?>
                </td>

            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No orders found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<?= $this->endSection() ?>