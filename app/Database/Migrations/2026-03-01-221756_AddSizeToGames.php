<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSizeToGames extends Migration
{
    public function up()
    {
        $this->forge->addColumn('games', [
            'size' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'game_file' // opsional, biar rapi urutannya
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('games', 'size');
    }
}