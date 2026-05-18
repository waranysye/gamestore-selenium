<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use App\Models\PaymentTransactionModel;

class PaymentIntegrationTest extends BaseIntegrationTest
{
    public function testPaymentCreated()
{
    $userModel = new \App\Models\UserModel();
    $orderModel = new \App\Models\OrderModel();
    $paymentModel = new \App\Models\PaymentTransactionModel();

    $userId = $userModel->insert(['name' => 'B', 'email' => 'b@t.com', 'password' => '1', 'role' => 'user']);
    $orderId = $orderModel->insert(['user_id' => $userId, 'total_price' => 100000]);

    $id = $paymentModel->insert([
        'order_id' => $orderId,
        'payment_method' => 'midtrans',
        'transaction_id' => 'TRX-INT-001',
        'gross_amount' => 100000,
        'status' => 'paid'
    ]);

    $this->assertIsNumeric($id);
}

    public function testPaymentStatusPaid()
{
    $userModel    = new \App\Models\UserModel();
    $orderModel   = new \App\Models\OrderModel();
    $paymentModel = new \App\Models\PaymentTransactionModel();

    // 1. Bersihkan environment (opsional tapi membantu)
    $paymentModel->truncate(); 

    // 2. Setup data induk
    $userId  = $userModel->insert([
        'name'     => 'PayUser', 
        'email'    => 'p@t.com', 
        'password' => '1', 
        'role'     => 'user'
    ]);
    
    $orderId = $orderModel->insert([
        'user_id'     => $userId, 
        'total_price' => 50000, 
        'status'      => 'pending'
    ]);

    $trxId = 'TRX-INT-999';

    // 3. Insert transaksi
    $paymentModel->insert([
        'order_id'       => $orderId,
        'payment_method' => 'midtrans',
        'transaction_id' => $trxId,
        'gross_amount'   => 50000,
        'status'         => 'success'
    ]);

    // 4. Ambil data (Gunakan asArray untuk memastikan format)
    $data = $paymentModel->asArray()->where('transaction_id', $trxId)->first();

    // Debugging jika masih gagal:
    if ($data === null) {
        $allData = $paymentModel->findAll();
        $count = count($allData);
        $this->fail("Data tidak ditemukan. Jumlah data di tabel: $count");
    }

    // 5. Assertion
    $this->assertNotEmpty($data, "Hasil query kosong");
    $this->assertEquals('success', trim($data['status'])); // Gunakan trim() untuk jaga-jaga ada spasi
}
}