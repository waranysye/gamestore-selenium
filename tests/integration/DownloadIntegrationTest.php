<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use App\Models\UserGameModel;

class DownloadIntegrationTest extends BaseIntegrationTest
{
   public function testGameMarkedAsInstalledAfterDownload()
{
    $userModel   = new \App\Models\UserModel();
    $catModel    = new \App\Models\CategoryModel();
    $gameModel   = new \App\Models\GameModel();
    $orderModel  = new \App\Models\OrderModel();
    $detailModel = new \App\Models\OrderDetailModel();
    $libModel    = new \App\Models\UserGameModel();

    // Arrange
    $userId = $userModel->insert([
        'name' => 'Test',
        'email' => 't@t.com',
        'password' => '1',
        'role' => 'user'
    ]);

    $catId = $catModel->insert(['name' => 'Action']);

    $gameId = $gameModel->insert([
        'title' => 'Game A',
        'category_id' => $catId,
        'price' => 1000
    ]);

    $orderId = $orderModel->insert([
        'user_id' => $userId,
        'total_price' => 1000
    ]);

    $odId = $detailModel->insert([
        'order_id' => $orderId,
        'game_id' => $gameId,
        'price' => 1000
    ]);

    $libModel->insert([
        'user_id' => $userId,
        'game_id' => $gameId,
        'order_detail_id' => $odId,
        'installed' => 0
    ]);

    // Act (simulate download logic)
    $libModel
        ->where(['user_id' => $userId, 'game_id' => $gameId])
        ->set(['installed' => 1])
        ->update();

    // Assert
    $result = $libModel
        ->where(['user_id' => $userId, 'game_id' => $gameId])
        ->first();

    $this->assertNotNull($result);
    $this->assertSame(1, (int)$result['installed']);
}
}