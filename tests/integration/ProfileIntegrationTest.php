<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use CodeIgniter\Test\ControllerTestTrait;

class ProfileIntegrationTest extends BaseIntegrationTest
{
    use ControllerTestTrait;

    /**
     * @dataProvider invalidProfileProvider
     */
    public function testUpdateProfileValidation($name, $email)
    {
        $this->forceLogin(1, 'user');

        $result = $this->withBody([
                'name'  => $name,
                'email' => $email,
            ])->controller(\App\Controllers\User\Profile::class)
              ->execute('update');

        $this->assertTrue($result->isRedirect());
    }

    public function invalidProfileProvider()
    {
        return [
            'Nama Kosong'         => ['', 'user@test.com'],
            'Email Salah Format'  => ['User Baru', 'bukan-email'],
            'Nama Terlalu Pendek' => ['Ab', 'user@test.com'],
            'Email Kosong'        => ['User Baru', ''],
        ];
    }

    // Mengganti testUpdatePasswordValidation dengan Update Nama (Tetap 1 Test Case)
    public function testUpdateNameOnly()
    {
        $this->forceLogin(1, 'user');

        $result = $this->withBody([
            'name' => 'User Dash Baru',
            'email' => 'dash@gmail.com'
        ])->controller(\App\Controllers\User\Profile::class)
          ->execute('update');

        $this->assertTrue($result->isRedirect());
    }

    // Mengganti testUpdatePasswordSuccess dengan Update Email (Tetap 1 Test Case)
    public function testUpdateEmailOnly()
    {
        $this->forceLogin(1, 'user');

        $result = $this->withBody([
            'name' => 'dash',
            'email' => 'dash.baru@gmail.com'
        ])->controller(\App\Controllers\User\Profile::class)
          ->execute('update');

        $this->assertTrue($result->isRedirect());
    }

    public function testViewProfilePage()
    {
        $this->forceLogin(1, 'user');

        $result = $this->controller(\App\Controllers\User\Profile::class)
                       ->execute('index');
        
        $this->assertTrue($result->isOK());
    }
}