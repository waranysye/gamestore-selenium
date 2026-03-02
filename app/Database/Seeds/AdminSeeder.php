<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
{
    $existing = $this->db->table('users')
        ->where('email', 'admin@gamestore.com')
        ->get()
        ->getRow();

    if (!$existing) {
        $data = [
            'name'       => 'Administrator',
            'email'      => 'admin@gamestore.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($data);
    }
}
}
