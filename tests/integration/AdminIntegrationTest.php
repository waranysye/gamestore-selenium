<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use CodeIgniter\Test\ControllerTestTrait;
use App\Models\UserModel;

class AdminIntegrationTest extends BaseIntegrationTest
{
    use ControllerTestTrait;

    public function testAdminUserExists()
    {
        $model = new UserModel();
        $model->insert([
            'name'     => 'Admin Test',
            'email'    => 'admin@test.com',
            'password' => '12345',
            'role'     => 'admin'
        ]);

        $admin = $model->where('role', 'admin')->first();
        $this->assertIsArray($admin);
    }

    /**
     * @dataProvider invalidGameProvider
     */
    public function testUpdateGameValidation($title, $price, $desc)
    {
        $this->forceLogin(1, 'admin');
        
        // FIX: Buat kategori dulu agar ID valid
        $catId = (new \App\Models\CategoryModel())->insert(['name' => 'Testing Update']);

        $gameId = (new \App\Models\GameModel())->insert([
            'title' => 'Old Title', 
            'price' => 1000, 
            'category_id' => $catId, 
            'description' => 'Old Desc'
        ]);

        $result = $this->withBody([
                'title'       => $title,
                'price'       => $price,
                'description' => $desc,
                'category_id' => $catId
            ])->controller(\App\Controllers\Admin\GameController::class)
              ->execute('update', $gameId);

        $this->assertTrue($result->isRedirect());
    }

    public function testCategoryIndexOk()
    {
        $this->forceLogin(1, 'admin');
        $result = $this->controller(\App\Controllers\Admin\CategoryController::class)
                       ->execute('index');
        $this->assertTrue($result->isOK());
    }

    /**
     * @dataProvider invalidGameProvider
     */
    public function testAddGameValidation($title, $price, $desc)
    {
        $this->forceLogin(1, 'admin');
        $catId = (new \App\Models\CategoryModel())->insert(['name' => 'Kategori Baru']);

        $result = $this->withBody([
                'title'       => $title,
                'price'       => $price,
                'description' => $desc,
                'category_id' => $catId,
            ])->controller(\App\Controllers\Admin\GameController::class) 
              ->execute('create');

        $this->assertTrue($result->isRedirect());
    }

    public function invalidGameProvider()
    {
        return [
            'Judul Kosong'        => ['', 50000, 'Deskripsi game baru'],
            'Harga Bukan Angka'   => ['Game Baru', 'Gratis', 'Deskripsi game baru'],
            'Deskripsi Kosong'    => ['Game Baru', 50000, ''],
            'Nama Terlalu Pendek' => ['Ab', 50000, 'Deskripsi game baru'],
        ];
    }

    public function testDeleteGameRedirect()
    {
        $this->forceLogin(1, 'admin');
        $catId = (new \App\Models\CategoryModel())->insert(['name' => 'Action']);

        $gameId = (new \App\Models\GameModel())->insert([
            'title'       => 'Game Hapus',
            'description' => 'Akan dihapus',
            'price'       => 1000,
            'category_id' => $catId
        ]);

        $result = $this->controller(\App\Controllers\Admin\GameController::class)
                       ->execute('delete', $gameId);

        $this->assertTrue($result->isRedirect());
    }
}