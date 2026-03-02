<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        $this->db->table('categories')->truncate();

        // Enable lagi
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $this->db->table('categories')->insertBatch([
            [
                'name' => 'The Cozy Dreamer',
                'slug' => 'the-cozy-dreamer'
            ],
            [
                'name' => 'The Urban Legend',
                'slug' => 'the-urban-legend'
            ]
        ]);
    }
}