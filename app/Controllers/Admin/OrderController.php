<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\UserGameModel;
use App\Models\PaymentTransactionModel;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;
    protected $userGameModel;
    protected $paymentModel;
    protected $db;

    public function __construct()
    {
        $this->orderModel       = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->userGameModel    = new UserGameModel();
        $this->paymentModel     = new PaymentTransactionModel();
        $this->db               = \Config\Database::connect();
    }

    // =============================
    // LIST ORDERS
    // =============================
    public function index()
    {
        $orders = $this->orderModel
            ->select('orders.*, users.name as user_name, payment_transactions.payment_method, payment_transactions.status as payment_status')
            ->join('users', 'users.id = orders.user_id')
            ->join('payment_transactions', 'payment_transactions.order_id = orders.id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        return view('admin/orders/index', [
            'orders' => $orders,
            'active' => 'orders'
        ]);
    }

    // =============================
    // APPROVE ORDER (FINALIZE)
    // =============================
    public function approve($id)
{
    $order = $this->orderModel->find($id);

    if (!$order || $order['status'] !== 'pending') {
        return redirect()->back();
    }

    $this->db->transStart();

    // Update order
    $this->orderModel->update($id, [
        'status' => 'paid'
    ]);

    // Update payment
    $this->paymentModel
        ->where('order_id', $id)
        ->set([
            'status'  => 'success',
            'paid_at' => date('Y-m-d H:i:s')
        ])
        ->update();

    // Ambil semua game dari order_details
    $items = $this->orderDetailModel
        ->where('order_id', $id)
        ->findAll();

    foreach ($items as $item) {
        $this->userGameModel->insert([
            'user_id'     => $order['user_id'],
            'game_id'     => $item['game_id'],
            'acquired_at' => date('Y-m-d H:i:s')
        ]);
    }

    $this->db->transComplete();

    return redirect()->back()->with('success', 'Order approved & game added to library.');
}
    // =============================
    // REJECT ORDER
    // =============================
    public function reject($id)
{
    $order = $this->orderModel->find($id);

    if (!$order || $order['status'] !== 'pending') {
        return redirect()->back();
    }

    // Update order
    $this->orderModel->update($id, [
        'status' => 'cancelled'
    ]);

    // Update payment
    $this->paymentModel
        ->where('order_id', $id)
        ->set(['status' => 'failed'])
        ->update();

    return redirect()->back()->with('success', 'Order rejected.');
}
}