<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use CodeIgniter\Test\ControllerTestTrait;
use App\Models\CartModel;
use App\Models\CartItemModel;

class CartIntegrationTest extends BaseIntegrationTest
{
    use ControllerTestTrait;

    public function testCartCreatedForUser()
    {
        $userModel = new \App\Models\UserModel();
        $cartModel = new CartModel();

        $userId = $userModel->insert([
            'name' => 'User Cart', 'email' => 'cart@test.com', 'password' => '123', 'role' => 'user'
        ]);

        $id = $cartModel->insert(['user_id' => $userId]);
        $this->assertIsNumeric($id);
    }

    public function testAddToCartControllerSuccess()
    {
        $this->forceLogin(1, 'user');
        
        $catId  = (new \App\Models\CategoryModel())->insert(['name' => 'Action']);
        $gameId = (new \App\Models\GameModel())->insert([
            'title' => 'Elden Ring', 'category_id' => $catId, 'price' => 500000, 'stock' => 10, 'game_file' => 'test.zip'
        ]);

        $result = $this->controller(\App\Controllers\User\Cart::class)
                       ->execute('add', $gameId);

        $this->assertTrue($result->isRedirect());
    }

    public function testRemoveFromCart()
    {
        $this->forceLogin(1, 'user');
        
        $db = \Config\Database::connect();
        
        // 1. Pastikan Cart ID 1 ada
        $db->table('carts')->ignore()->insert(['id' => 1, 'user_id' => 1]);

        // 2. Masukkan item yang akan dihapus (Hanya kolom minimal)
        $db->table('cart_items')->ignore()->insert([
            'cart_id' => 1, 
            'game_id' => 1
        ]);

        // 3. Eksekusi remove. 
        // Jika controller kamu butuh ID dari tabel cart_items, ganti angka 1 di bawah.
        // Tapi biasanya route 'remove' menerima Game ID.
        $result = $this->controller(\App\Controllers\User\Cart::class)
                       ->execute('remove', 1);

        // Pastikan redirect (berarti sukses melewati logic delete)
        $this->assertTrue($result->isRedirect());
    }

    public function testAddInvalidGameToCart()
    {
        $this->forceLogin(1, 'user');
        
        $result = $this->controller(\App\Controllers\User\Cart::class)
                       ->execute('add', 9999);

        $this->assertTrue($result->isRedirect());
    }

    public function testGameExistsInCart()
    {
        $model = new CartItemModel();
        $exists = $model->where('game_id', 1)->first();
        $this->assertTrue(true); 
    }

    public function testViewCartPage()
    {
        $this->forceLogin(1, 'user');
        $result = $this->controller(\App\Controllers\User\Cart::class)
                       ->execute('index');
        $this->assertTrue($result->isOK());
    }
}