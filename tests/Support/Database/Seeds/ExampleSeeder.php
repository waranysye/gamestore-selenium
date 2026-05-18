<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExampleSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat kategori dummy terlebih dahulu agar ID 1 tersedia
        $categoryData = [
            'id'         => 1,
            'name'       => 'Action',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Gunakan insert ignore atau cek dulu agar tidak error saat seeder dijalankan ulang
        $this->db->table('categories')->insert($categoryData);

        // 2. Sekarang baru masukkan data game
        $gameData = [
            [
                'title'       => 'Elden Ring',
                'description' => 'Action RPG by FromSoftware',
                'price'       => 600000,
                'size'        => '60GB',
                'category_id' => 1, // Sekarang ID 1 sudah ada!
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'Cyberpunk 2077',
                'description' => 'Futuristic RPG',
                'price'       => 700000,
                'size'        => '70GB',
                'category_id' => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'Minecraft',
                'description' => 'Creative Sandbox',
                'price'       => 400000,
                'size'        => '1GB',
                'category_id' => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('games')->insertBatch($gameData);
    }
}