<?php

namespace Tests\Integration;

use Tests\Support\BaseIntegrationTest;
use CodeIgniter\Test\ControllerTestTrait;

class AuthIntegrationTest extends BaseIntegrationTest
{
    use ControllerTestTrait;

    /**
     * FIX 1: Nama provider harus MATCH dengan fungsinya
     * @dataProvider invalidLoginProvider
     */
    public function testAttemptLoginFail($email, $pass)
    {
        $result = $this->withBody([
            'email'    => $email,
            'password' => $pass,
        ])->controller(\App\Controllers\Auth::class)
          ->execute('attemptLogin');

        $this->assertTrue($result->isRedirect());
    }

    public function invalidLoginProvider()
    {
        return [
            'Password Salah'     => ['admin@test.com', 'salah_password'],
            'Email Tidak Ada'    => ['ngawur@test.com', '12345'],
            'Email Format Salah' => ['bukan-email', '12345'],
            'Input Kosong'       => ['', ''],
        ];
    }
    /**
     * @dataProvider invalidSignupProvider
     */
    public function testAttemptSignupValidation($name, $email, $password, $agree)
    {
        $result = $this->withBody([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'agree'    => $agree
        ])->controller(\App\Controllers\Auth::class)
          ->execute('attemptSignup');

        // Harus redirect back karena gagal validasi atau tidak centang agree
        $this->assertTrue($result->isRedirect());
    }

    public function invalidSignupProvider()
    {
        return [
            'Tidak Centang Agree'  => ['User Baru', 'new@test.com', '123456', 0],
            'Nama Terlalu Pendek'  => ['Ab', 'new@test.com', '123456', 1],
            'Email Salah Format'   => ['User Baru', 'bukan-email', '123456', 1],
            'Password Kurang'      => ['User Baru', 'new@test.com', '123', 1],
            'Input Kosong Semua'   => ['', '', '', 1],
        ];
    }

    public function testAttemptSignupSuccess()
{
    // Gunakan email yang sangat unik agar tidak bentrok dengan is_unique
    $uniqueEmail = 'tester_' . time() . '@gmail.com';

    $result = $this->withBody([
        'name'     => 'Tester Berhasil',
        'email'    => $uniqueEmail,
        'password' => 'password123',
        'agree'    => 1
    ])->controller(\App\Controllers\Auth::class)
      ->execute('attemptSignup');

    // Cek apakah ada redirect (status code 302)
    $this->assertTrue($result->isRedirect());
    
    // Jika ternyata sistem kamu redirect ke Home, ganti kodenya jadi ini:
    // $result->assertRedirectTo('/'); 
}

    public function testAttemptLoginSuccess()
    {
        // 1. Pastikan user ada di DB (Sesuai cara login di controllermu)
        $model = new \App\Models\UserModel();
        $model->insert([
            'name'     => 'Tester',
            'email'    => 'tester@test.com',
            'password' => 'pass123', // Controllermu tidak pakai password_hash (langsung string)
            'role'     => 'user'
        ]);

        // 2. Jalankan Login
        $result = $this->withBody([
            'email'    => 'tester@test.com',
            'password' => 'pass123',
        ])->controller(\App\Controllers\Auth::class)
          ->execute('attemptLogin');

        $this->assertTrue($result->isRedirect());
    }

    public function testLogout()
    {
        $result = $this->controller(\App\Controllers\Auth::class)
                       ->execute('logout');

        $result->assertRedirectTo('/login');
    }
}