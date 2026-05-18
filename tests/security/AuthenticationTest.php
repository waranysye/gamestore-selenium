<?php

namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;

class AuthenticationTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    /**
     * Helper untuk mendapatkan token CSRF secara otomatis
     */
    private function getCsrfFields(): array
    {
        $security = Services::security();
        return [
            $security->getTokenName() => $security->getHash()
        ];
    }

    public function testLoginFailsWithWrongPassword()
    {
        // Gabungkan token CSRF dengan data login
        $data = array_merge($this->getCsrfFields(), [
            'email'    => 'dash@gmail.com',
            'password' => 'wrongpass'
        ]);

        $this->post('/login', $data)->assertRedirect();
    }

    public function testLoginFailsWithEmptyInput()
    {
        // Tetap kirimkan CSRF meskipun field lainnya kosong
        $this->post('/login', $this->getCsrfFields())
             ->assertRedirect();
    }

    public function testLoginSuccessWithValidCredentials()
    {
        $data = array_merge($this->getCsrfFields(), [
            'email'    => 'admin@gamestore.com',
            'password' => 'admin123'
        ]);

        $result = $this->post('login', $data); // Tanpa garis miring di depan
        $result->assertRedirect();
    }
}