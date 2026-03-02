<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data lama
        $this->db->table('users')->truncate();

        // Insert data baru
        $this->db->table('users')->insertBatch([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}