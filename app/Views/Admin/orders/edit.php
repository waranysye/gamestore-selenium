<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h2>Edit Order</h2>

<div class="card">
<form action="<?= site_url('admin/orders/update/'.$order['id']) ?>" method="post">
<?= csrf_field() ?>

<div class="form-group">
<label>User</label>
<select name="user_id" required>
<?php foreach($users as $u): ?>
<option value="<?= $u['id'] ?>"
<?= $order['user_id'] == $u['id'] ? 'selected' : '' ?>>
<?= esc($u['name']) ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="form-group">
<label>Total Price</label>
<input type="number" name="total_price" value="<?= $order['total_price'] ?>" required>
</div>

<div class="form-group">
<label>Status</label>
<select name="status">
<option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>Pending</option>
<option value="paid" <?= $order['status']=='paid'?'selected':'' ?>>Paid</option>
<option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
</select>
</div>

<button type="submit" class="btn btn-edit">Update</button>
<a href="<?= site_url('admin/orders') ?>" class="btn">Back</a>

</form>
</div>

<?= $this->endSection() ?>