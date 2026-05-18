<?php

namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class SqlInjectionTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testSqlInjectionLoginBlocked()
    {
        // 1. Hapus expectException karena CI4 akan menangani input secara aman lewat Query Builder
        
        // 2. Kirim payload SQL Injection
        $result = $this->post('login', [
            'email'    => "' OR '1'='1",
            'password' => 'sembarang'
        ]);

        // 3. Verifikasi: User tidak boleh berhasil masuk (tidak ada redirect ke dashboard)
        // Jika login gagal, biasanya kembali ke halaman login atau menampilkan error
        $result->assertNotStatus(302); // Asumsi: 302 adalah redirect sukses ke dashboard
        
        // Atau cek apakah teks "Dashboard" TIDAK ada di body response
        $this->assertStringNotContainsString('Dashboard', $result->getBody());
    }
}