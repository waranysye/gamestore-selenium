<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGames extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'title' => [
            'type' => 'VARCHAR',
            'constraint' => 150,
        ],
        'description' => [
            'type' => 'TEXT',
        ],
        'price' => [
            'type' => 'DECIMAL',
            'constraint' => '12,2',
        ],
        'cover_image' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
        ],
        'game_file' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
        ],
        'category_id' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'created_at DATETIME default current_timestamp',
        'updated_at DATETIME default current_timestamp on update current_timestamp'
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('games');
}

public function down()
{
    $this->forge->dropTable('games');
}
}
