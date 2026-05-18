<?php

namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class CsrfTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testLoginBlockedWithoutCsrf()
    {
        // 1. Simulasikan request POST tanpa token CSRF
        $result = $this->post('login', [
            'email'    => 'dash@gmail.com',
            'password' => 'dash123',
        ]);

        // 2. CI4 biasanya me-redirect balik (302) jika CSRF salah
        $result->assertRedirect();
        
        // 3. Opsional: Cek apakah session punya pesan error 'error'
        // $result->assertSessionHas('error'); 
    }
}