<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\UserGameModel;

class Payment extends BaseController
{
    protected OrderModel $orderModel;
    protected OrderDetailModel $orderDetailModel;
    protected UserGameModel $userGameModel;

    public function __construct()
    {
        $this->orderModel       = new OrderModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->userGameModel    = new UserGameModel();
    }

    /**
     * PAYMENT STATUS PAGE
     */
    public function status($orderId)
    {
        $userId = session()->get('user_id');

        $order = $this->orderModel->find($orderId);

        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('/')
                ->with('error', 'Invalid order access.');
        }

        $this->autoCancelIfExpired($order);

        // refresh
        $order = $this->orderModel->find($orderId);

        $items = $this->orderDetailModel
            ->select('games.title, order_details.price')
            ->join('games', 'games.id = order_details.game_id')
            ->where('order_id', $orderId)
            ->findAll();

        return view('User/paymentstatus', [
            'status' => $order['status'],
            'order'  => $order,
            'items'  => $items
        ]);
    }

    /**
     * PAYMENT SUCCESS (RETURN URL)
     * (tetap dipakai kalau redirect manual)
     */
    public function success($orderId)
    {
        $userId = session()->get('user_id');

        $order = $this->orderModel->find($orderId);

        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('/')->with('error', 'Invalid order.');
        }

        if ($order['status'] === 'paid') {
            return redirect()->to('/library');
        }

        $this->orderModel->update($orderId, [
            'status' => 'paid'
        ]);

        $items = $this->orderDetailModel
            ->where('order_id', $orderId)
            ->findAll();

        foreach ($items as $item) {
            if ($this->userGameModel
                ->userOwnsGame($userId, $item['game_id'])) {
                continue;
            }

            $this->userGameModel->insert([
                'user_id'         => $userId,
                'game_id'         => $item['game_id'],
                'order_detail_id' => $item['id'],
                'acquired_at'     => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/library')
            ->with('success', 'Payment successful.');
    }

    /**
     * 🔥 MIDTRANS CALLBACK (INI YANG SEBELUMNYA KAMU TIDAK PUNYA)
     */
    public function callback()
{
    $payload = json_decode(file_get_contents('php://input'), true);

    if (!isset($payload['order_id'], $payload['transaction_status'])) {
        return;
    }

    $orderId   = $payload['order_id'];
    $trxStatus = $payload['transaction_status'];

    if (!in_array($trxStatus, ['capture', 'settlement'])) {
        return;
    }

    // ✅ FIX DI SINI
    $order = $this->orderModel->find($orderId);

    if (!$order || $order['status'] === 'paid') {
        return;
    }

    // update order
    $this->orderModel->update($orderId, [
        'status' => 'paid'
    ]);

    // insert ke library
    $items = $this->orderDetailModel
        ->where('order_id', $orderId)
        ->findAll();

    foreach ($items as $item) {

        if ($this->userGameModel
            ->userOwnsGame($order['user_id'], $item['game_id'])) {
            continue;
        }

        $this->userGameModel->insert([
            'user_id'         => $order['user_id'],
            'game_id'         => $item['game_id'],
            'order_detail_id' => $item['id'],
            'acquired_at'     => date('Y-m-d H:i:s')
        ]);
    }
}

    /**
     * AUTO CANCEL AFTER 5 MINUTES
     */
    private function autoCancelIfExpired(array $order): void
    {
        if ($order['status'] !== 'pending') {
            return;
        }

        if ((time() - strtotime($order['created_at'])) >= 300) {
            $this->orderModel->update($order['id'], [
                'status' => 'cancelled'
            ]);
        }
    }

    /**
     * MANUAL CANCEL BY USER
     */
    public function cancel($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order || $order['status'] !== 'pending') {
            return redirect()->back();
        }

        $this->orderModel->update($orderId, [
            'status' => 'cancelled'
        ]);

        return redirect()->to('/payment/status/' . $orderId);
    }
}