<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use App\Models\OrderModel;
use App\Models\PaymentTransactionModel;

class TransactionIntegrationTest extends BaseIntegrationTest
{
    public function testOrderAndPaymentFlow()
{
    $userModel = new \App\Models\UserModel();
    $orderModel = new OrderModel();
    $paymentModel = new PaymentTransactionModel();

    // Buat User dulu
    $userId = $userModel->insert([
        'name' => 'Buyer', 'email' => 'buy@test.com', 'password' => '123', 'role' => 'user'
    ]);

    $orderId = $orderModel->insert([
        'user_id' => $userId, // Pakai ID dinamis
        'total_price' => 50000,
        'status' => 'pending'
    ]);

    $paymentId = $paymentModel->insert([
        'order_id' => $orderId,
        'payment_method' => 'midtrans',
        'transaction_id' => 'TRX-FLOW-001',
        'gross_amount' => 50000,
        'status' => 'paid'
    ]);

    $this->assertIsNumeric($orderId);
    $this->assertIsNumeric($paymentId);
}
}