<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;

class CheckoutIntegrationTest extends BaseIntegrationTest
{
    public function testOrderCreated()
{
    $userModel = new \App\Models\UserModel();
    $orderModel = new OrderModel();

    $userId = $userModel->insert([
        'name' => 'Buyer', 'email' => 'buy@test.com', 'password' => '123', 'role' => 'user'
    ]);

    $id = $orderModel->insert([
        'user_id' => $userId, // Gunakan ID hasil insert
        'total_price' => 100000,
        'status' => 'pending'
    ]);

    $this->assertIsNumeric($id);
}

    public function testOrderDetailCreated()
{
    $userModel = new \App\Models\UserModel();
    $catModel  = new \App\Models\CategoryModel();
    $gameModel = new \App\Models\GameModel();
    $orderModel = new \App\Models\OrderModel();
    $detailModel = new \App\Models\OrderDetailModel();

    // Setup Hierarki Data
    $userId = $userModel->insert(['name' => 'U', 'email' => 'u@t.com', 'password' => '1', 'role' => 'user']);
    $catId  = $catModel->insert(['name' => 'Action']);
    $gameId = $gameModel->insert(['title' => 'G', 'category_id' => $catId, 'price' => 50000]);
    $orderId = $orderModel->insert(['user_id' => $userId, 'total_price' => 50000, 'status' => 'pending']);

    $id = $detailModel->insert([
        'order_id' => $orderId, // Gunakan ID dinamis
        'game_id'  => $gameId,  // Gunakan ID dinamis
        'price'    => 50000
    ]);

    $this->assertIsNumeric($id);
}
}