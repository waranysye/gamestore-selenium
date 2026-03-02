<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GamesSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // ==============================
        // AMBIL CATEGORY BERDASARKAN SLUG
        // ==============================
        $simulation = $this->db->table('categories')
            ->where('slug', 'the-cozy-dreamer')
            ->get()
            ->getRow();

        $action = $this->db->table('categories')
            ->where('slug', 'the-urban-legend')
            ->get()
            ->getRow();

        // ==============================
        // VALIDASI CATEGORY
        // ==============================
        if (!$simulation || !$action) {
            echo "Category belum ada. Jalankan CategorySeeder dulu.\n";
            return;
        }

        // ==============================
        // NONAKTIFKAN FOREIGN KEY CHECK
        // ==============================
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // Kosongkan tabel games
        $this->db->table('games')->truncate();

        // Aktifkan kembali FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // ==============================
        // DATA GAMES
        // ==============================
        $data = [

            // ==============================
            // SIMULATION
            // ==============================
            [
                'title'       => 'The Sims 4 Bundle',
                'description' => 'A comprehensive collection featuring the base game and exclusive expansion packs for ultimate interior design creativity.',
                'price'       => 650000,
                'cover_image' => 'sims4_bundle.jpg',
                'game_file'   => 'sims4_bundle.zip',
                'category_id' => $simulation->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Animal Crossing: NH',
                'description' => 'Escape to a deserted island and create your own paradise as you explore, create, and customize in this relaxing simulation.',
                'price'       => 790000,
                'cover_image' => 'acnh_spring.jpg',
                'game_file'   => 'animal_crossing_nh.zip',
                'category_id' => $simulation->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Stardew Valley',
                'description' => 'A charming farming simulation RPG where you inherit your grandfather’s old farm and build a thriving life in Pelican Town.',
                'price'       => 175000,
                'cover_image' => 'stardew_valley.jpg',
                'game_file'   => 'stardew_valley.zip',
                'category_id' => $simulation->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Coral Island',
                'description' => 'A vibrant and laid-back reimagining of farm sim games with enchanting island life.',
                'price'       => 250000,
                'cover_image' => 'coralisland_beach.jpg',
                'game_file'   => 'coral_island.zip',
                'category_id' => $simulation->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Disney Dreamlight Valley',
                'description' => 'A life-sim adventure game rich with quests and activities alongside familiar Disney friends.',
                'price'       => 450000,
                'cover_image' => 'disney_dreamlight.jpg',
                'game_file'   => 'dreamlight_valley.zip',
                'category_id' => $simulation->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            // ==============================
            // ACTION
            // ==============================
            [
                'title'       => 'Valorant Premium Pack',
                'description' => 'Enhance your tactical experience with exclusive aesthetic weapon skins and radiant points.',
                'price'       => 500000,
                'cover_image' => 'valo_points.jpg',
                'game_file'   => 'valorant_pack.zip',
                'category_id' => $action->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Cyberpunk 2077',
                'description' => 'An open-world action RPG set in Night City, a dangerous megalopolis obsessed with power.',
                'price'       => 700000,
                'cover_image' => 'cyberpunk_night.jpg',
                'game_file'   => 'cyberpunk_2077.zip',
                'category_id' => $action->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Elden Ring',
                'description' => 'Rise, Tarnished, and become an Elden Lord in the Lands Between.',
                'price'       => 600000,
                'cover_image' => 'elden_ring.jpg',
                'game_file'   => 'elden_ring.zip',
                'category_id' => $action->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'GTA V: Premium Edition',
                'description' => 'Includes the complete GTA V story experience and access to GTA Online.',
                'price'       => 400000,
                'cover_image' => 'gtav_premium.jpg',
                'game_file'   => 'gta_v_premium.zip',
                'category_id' => $action->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Stray',
                'description' => 'A stray cat must untangle an ancient mystery to escape a cybercity.',
                'price'       => 280000,
                'cover_image' => 'stray_cat.jpg',
                'game_file'   => 'stray.zip',
                'category_id' => $action->id,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        // ==============================
        // INSERT DATA
        // ==============================
        $this->db->table('games')->insertBatch($data);

        echo "GamesSeeder berhasil dijalankan.\n";
    }
}