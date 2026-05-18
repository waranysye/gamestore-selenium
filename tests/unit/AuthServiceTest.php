<?php

namespace Tests\Unit;

use Tests\Support\DatabaseTestCase;
use App\Services\AuthService;

class AuthServiceTest extends DatabaseTestCase
{
    public function testPasswordStrength()
    {
        $service = new AuthService();
        
        $this->assertTrue($service->isPasswordStrong('GameStore2026')); // Kuat
        $this->assertFalse($service->isPasswordStrong('12345'));         // Lemah
    }

    public function testTokenGeneration()
    {
        $service = new AuthService();
        $token = $service->generateUserToken();
        
        $this->assertEquals(32, strlen($token)); // Cek panjang hex string
    }
}