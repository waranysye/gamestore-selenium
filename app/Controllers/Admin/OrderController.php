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
    // APPROVE ORDER
    // =============================
    public function approve($id)
{
    $order = $this->orderModel->find($id);

    if (!$order || $order['status'] != 'pending') {
        return redirect()->to('/admin/orders');
    }

    $this->db->transStart();

    // update orders
    $this->orderModel->update($id, [
        'status' => 'paid'
    ]);

    // update payment
    $this->paymentModel
        ->where('order_id', $id)
        ->set([
            'status' => 'success',
            'paid_at' => date('Y-m-d H:i:s')
        ])
        ->update();

    // ambil detail order
    $items = $this->orderDetailModel
        ->where('order_id', $id)
        ->findAll();

    foreach ($items as $item) {

        $exists = $this->userGameModel
            ->where('user_id', $order['user_id'])
            ->where('game_id', $item['game_id'])
            ->first();

        if (!$exists) {

            $this->userGameModel->insert([
                'user_id'         => $order['user_id'],
                'game_id'         => $item['game_id'],
                'order_detail_id' => $item['id'], // FIX UTAMA
                'acquired_at'     => date('Y-m-d H:i:s')
            ]);
        }
    }

    $this->db->transComplete();

    return redirect()->to('/admin/orders')
        ->with('success', 'Order approved successfully.');
}

    // =============================
    // REJECT ORDER
    // =============================
    public function reject($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order || $order['status'] !== 'pending') {
            return redirect()->to('/admin/orders');
        }

        // Update order
        $this->orderModel->update($id, [
            'status' => 'cancelled'
        ]);

        // Update payment
        $this->paymentModel
            ->where('order_id', $id)
            ->set([
                'status' => 'failed'
            ])
            ->update();

        return redirect()->to('/admin/orders')
            ->with('success', 'Order rejected successfully.');
    }
}