<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('orders')->truncate();

        $this->db->table('orders')->insertBatch([
            ['game_id' => 1, 'user_id' => 1, 'quantity' => 2, 'total' => 50000, 'created_at' => date('Y-m-d H:i:s')],
            ['game_id' => 2, 'user_id' => 1, 'quantity' => 1, 'total' => 50000, 'created_at' => date('Y-m-d H:i:s')]
        ]);
    }
}