<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;

class Order extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;

    public function __construct()
    {
        $this->orderModel       = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
    }

    /**
     * LIST TRANSACTIONS
     */
    public function index()
{
    $userId = session()->get('user_id');

    $orders = $this->orderModel
        ->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->paginate(5);

    return view('User/transaction', [
        'orders'     => $orders,
        'pager'      => $this->orderModel->pager,
        'activePage' => 'orders' // ✅ FIX
    ]);
}

    /**
     * ORDER DETAIL
     */
    public function detail($orderId)
    {
        $userId = session()->get('user_id');

        $order = $this->orderModel
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            return redirect()->to('/transactions');
        }

        $items = $this->orderDetailModel
            ->select('games.title, order_details.price')
            ->join('games', 'games.id = order_details.game_id')
            ->where('order_id', $orderId)
            ->findAll();

        return view('User/transactions/detail', [
            'order' => $order,
            'items' => $items
        ]);
    }
}