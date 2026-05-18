<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\PaymentTransactionModel;

class Transaction extends BaseController
{
    protected $orderModel;
    protected $orderDetailModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->orderModel       = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->paymentModel     = new PaymentTransactionModel();
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

            // =========================
            // AUTO EXPIRE 5 MENIT
            // =========================
            if ($order['status'] === 'pending') {

                $created = strtotime($order['created_at']);
                $expire  = $created + 300;

                if (time() > $expire) {

                    $this->orderModel->update($order['id'], [
                        'status' => 'cancelled'
                    ]);

                    $this->paymentModel
                        ->where('order_id', $order['id'])
                        ->set(['status' => 'failed'])
                        ->update();

                    $order['status'] = 'cancelled';
                }
            }

            // =========================
            // AMBIL GAME
            // =========================
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