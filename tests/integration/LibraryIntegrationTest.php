<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use App\Models\UserGameModel;

class LibraryIntegrationTest extends BaseIntegrationTest
{
    public function testUserOwnsGame()
{
    $userModel = new \App\Models\UserModel();
    $catModel  = new \App\Models\CategoryModel();
    $gameModel = new \App\Models\GameModel();
    $orderModel = new \App\Models\OrderModel();
    $orderDetailModel = new \App\Models\OrderDetailModel();
    $libModel = new \App\Models\UserGameModel();

    // Setup semua foreign key
    $userId = $userModel->insert(['name' => 'U', 'email' => 'u@t.com', 'password' => '1', 'role' => 'user']);
    $catId  = $catModel->insert(['name' => 'RPG']);
    $gameId = $gameModel->insert(['title' => 'Elden', 'category_id' => $catId, 'price' => 100]);
    $orderId = $orderModel->insert(['user_id' => $userId, 'total_price' => 100]);
    $odId = $orderDetailModel->insert(['order_id' => $orderId, 'game_id' => $gameId, 'price' => 100]);

    // Sekarang baru bisa insert ke user_games
    $libModel->insert([
        'user_id' => $userId,
        'game_id' => $gameId,
        'order_detail_id' => $odId,
        'installed' => 0
    ]);

    $check = $libModel->where('user_id', $userId)->first();
    $this->assertNotNull($check);
    $this->assertEquals($gameId, $check['game_id']);
}

    public function testInstallGame()
{
    $userModel = new \App\Models\UserModel();
    $catModel  = new \App\Models\CategoryModel();
    $gameModel = new \App\Models\GameModel();
    $orderModel = new \App\Models\OrderModel();
    $detailModel = new \App\Models\OrderDetailModel();
    $libModel = new \App\Models\UserGameModel();

    // 1. Setup Data Induk (Wajib lengkap agar foreign key valid)
    $userId = $userModel->insert(['name' => 'L', 'email' => 'l@t.com', 'password' => '1', 'role' => 'user']);
    $catId  = $catModel->insert(['name' => 'Strategy']);
    $gameId = $gameModel->insert(['title' => 'Civ VI', 'category_id' => $catId, 'price' => 200]);
    $orderId = $orderModel->insert(['user_id' => $userId, 'total_price' => 200, 'status' => 'completed']);
    
    // Ini adalah kunci yang hilang!
    $odId = $detailModel->insert(['order_id' => $orderId, 'game_id' => $gameId, 'price' => 200]);

    // 2. Insert ke User Games menggunakan $odId yang baru dibuat
    $libModel->insert([
        'user_id' => $userId,
        'game_id' => $gameId,
        'order_detail_id' => $odId, // Jangan biarkan kosong atau hardcoded
        'installed' => 0
    ]);

    // 3. Jalankan Logic Update (Pastikan nama method sesuai di modelmu)
    $libModel->where(['user_id' => $userId, 'game_id' => $gameId])->set(['installed' => 1])->update();

    $data = $libModel->where(['user_id' => $userId, 'game_id' => $gameId])->first();
    
    $this->assertNotNull($data);
    $this->assertEquals(1, $data['installed']);
}
}