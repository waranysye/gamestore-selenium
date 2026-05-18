<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        // No need to truncate when $refresh = true is active
        $this->db->table('users')->insertBatch([
            [
                'id'       => 1, // Explicit IDs help match your adminSession() helper
                'name'     => 'Admin',
                'email'    => 'admin@test.com',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role'     => 'admin'
            ],
            [
                'id'       => 2,
                'name'     => 'User',
                'email'    => 'user@test.com',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role'     => 'user'
            ]
        ]);
    }
}