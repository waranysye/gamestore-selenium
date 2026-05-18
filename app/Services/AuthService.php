<?php

namespace App\Services;

class AuthService
{
    public function isPasswordStrong(string $password): bool
    {
        // Minimal 8 karakter, ada angka, dan ada huruf besar
        return strlen($password) >= 8 && preg_match('/[0-9]/', $password) && preg_match('/[A-Z]/', $password);
    }

    public function generateUserToken(): string
    {
        return bin2hex(random_bytes(16));
    }
}