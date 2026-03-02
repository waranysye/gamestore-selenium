<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PaymentTransactionModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;

class Paymentstatus extends BaseController
{
    public function byOrder($orderId)
    {
        $paymentModel     = new PaymentTransactionModel();
        $orderModel       = new OrderModel();
        $orderDetailModel = new OrderDetailModel();

        $order = $orderModel->find($orderId);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Order tidak ditemukan');
        }

        $payment = $paymentModel
            ->where('order_id', $orderId)
            ->first();

        if (!$payment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Payment tidak ditemukan');
        }

        $expiresAt = null;

        // =========================
        // AUTO EXPIRE 5 MENIT
        // =========================
        if (
            $payment['status'] === 'pending' &&
            !empty($payment['created_at'])
        ) {
            $createdAt = strtotime($payment['created_at']);
            $expiresAt = $createdAt + 300;

            if (time() > $expiresAt) {

                // Update payment
                $paymentModel->update($payment['id'], [
                    'status' => 'failed'
                ]);

                // Update order
                $orderModel->update($orderId, [
                    'status' => 'cancelled'
                ]);

                // Refresh data
                $payment['status'] = 'failed';
                $order['status']   = 'cancelled';
            }
        }

        // =========================
        // MAPPING UNTUK TAMPILAN
        // =========================
        // Order: pending, paid, cancelled
        // View : pending, success, failed

        $displayStatus = 'pending';

        if ($order['status'] === 'paid') {
            $displayStatus = 'success';
        } elseif ($order['status'] === 'cancelled') {
            $displayStatus = 'failed';
        }

        // =========================
        // AMBIL ITEM ORDER
        // =========================
        $items = $orderDetailModel
            ->select('games.title, order_details.price')
            ->join('games', 'games.id = order_details.game_id')
            ->where('order_details.order_id', $orderId)
            ->findAll();

        return view('User/paymentstatus', [
            'payment'       => $payment,
            'order'         => $order,
            'items'         => $items,
            'displayStatus' => $displayStatus,
            'expiresAt'     => $expiresAt
        ]);
    }
}