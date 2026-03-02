<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;

class Transaction extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;

    public function __construct()
    {
        $this->orderModel       = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $orders = $this->orderModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate(4);

        foreach ($orders as &$order) {

            $games = $this->orderDetailModel
                ->select('games.id, games.title, games.cover_image')
                ->join('games', 'games.id = order_details.game_id')
                ->where('order_details.order_id', $order['id'])
                ->findAll();

            $order['games'] = $games ?? [];
        }

        unset($order);

        return view('User/transactions', [
            'orders' => $orders,
            'pager'  => $this->orderModel->pager
        ]);
    }
}