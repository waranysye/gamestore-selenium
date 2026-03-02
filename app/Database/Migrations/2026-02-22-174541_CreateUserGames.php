<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserGames extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'user_id' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'game_id' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'order_detail_id' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'acquired_at DATETIME default current_timestamp'
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('game_id', 'games', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('order_detail_id', 'order_details', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('user_games');
}

public function down()
{
    $this->forge->dropTable('user_games');
}
}
