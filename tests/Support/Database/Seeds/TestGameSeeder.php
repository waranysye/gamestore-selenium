<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestGameSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('games')->insertBatch([
            [
                'id'          => 1,
                'title'       => 'Game Test 1',
                'description' => 'Description for Game Test 1',
                'price'       => 19.99,
                'image'       => 'game1.jpg'
            ],
            [
                'id'          => 2,
                'title'       => 'Game Test 2',
                'description' => 'Description for Game Test 2',
                'price'       => 29.99,
                'image'       => 'game2.jpg'
            ]
        ]);
    }
}