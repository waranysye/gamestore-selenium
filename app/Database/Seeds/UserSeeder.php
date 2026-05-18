<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Tambahan pengaman QA
    if (ENVIRONMENT === 'production') {
        die("Fatal Error: Mencoba menjalankan Seeder di Production!");
    }

    $this->db->query('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel terkait (tabel yang saling berhubungan)
        $this->db->table('carts')->truncate();
        $this->db->table('users')->truncate();

        // Masukkan data user untuk testing Selenium
        $data = [
            [
                'name'       => 'Dash User',
                'email'      => 'dash@gmail.com',
                'password' => password_hash('dash123', PASSWORD_DEFAULT),
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Admin GameStore',
                'email'      => 'admin@gamestore.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('users')->insertBatch($data);

        // Hidupkan kembali pengecekan foreign key
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }
}