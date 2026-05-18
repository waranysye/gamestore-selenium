<?php

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

abstract class BaseIntegrationTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $namespace = 'App';
    protected $DBGroup   = 'tests';

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Pengaman Database Utama
        if ($this->db->database == 'gamestore') {
            die("BAHAYA: Testing mencoba mengakses database UTAMA!");
        }

        // 2. Jalankan Seeder secara berurutan
        // Pastikan GameSeeder dipanggil SEBELUM UserSeeder jika ada relasi
        $seeder = \Config\Database::seeder();
        $seeder->call('UserSeeder');
        
        // Cek apakah TestGameSeeder ada, jika ada aktifkan ini:
        // $seeder->call('TestGameSeeder'); 
    }

    /**
     * Helper untuk simulasi login User
     */
    protected function loginAsUser(array $user = [])
    {
        // Ambil data user pertama dari database hasil seeder
        $db = \Config\Database::connect('tests');
        $userData = $db->table('users')->where('role', 'user')->get()->getRow();

        return [
            'user_id'    => $userData->id ?? 1,
            'email'      => $userData->email ?? 'dash@gmail.com',
            'role'       => 'user',
            'isLoggedIn' => true
        ];
    }

    protected function forceLogin(int $userId = 1, string $role = 'user')
    {
        $sessionData = [
            'user_id'    => $userId,
            'role'       => $role,
            'isLoggedIn' => true
        ];
        $_SESSION = array_merge($_SESSION ?? [], $sessionData);
        session()->set($sessionData);
    }

    /**
     * Helper untuk simulasi login Admin
     */
    protected function loginAsAdmin()
    {
        $db = \Config\Database::connect('tests');
        $adminData = $db->table('users')->where('role', 'admin')->get()->getRow();

        return [
            'user_id'    => $adminData->id ?? 2,
            'email'      => $adminData->email ?? 'admin@gamestore.com',
            'role'       => 'admin',
            'isLoggedIn' => true
        ];
    }
}