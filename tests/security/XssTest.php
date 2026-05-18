<?php

namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;

class XssTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testXssPayloadDoesNotCrashSystem()
    {
        // 1. Ambil token CSRF yang valid
        $security = Services::security();
        $tokenName = $security->getTokenName();
        $tokenHash = $security->getHash();

        // 2. Kirim payload XSS bersama dengan token CSRF
        $result = $this->post('login', [
            $tokenName => $tokenHash, // 👈 WAJIB ada token
            'email'    => "<script>alert('xss')</script>@example.com",
            'password' => 'password123'
        ]);

        // 3. Pastikan sistem tidak crash (biasanya redirect kembali atau ke halaman error)
        // Kita tidak mengharapkan SecurityException (CSRF), jadi jika lolos sampai sini, tes berhasil.
        $this->assertNotEquals(403, $result->getStatusCode());
    }
}