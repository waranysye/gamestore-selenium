<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGameImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'game_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Foreign Key
        $this->forge->addForeignKey(
            'game_id',
            'games',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('game_images');
    }

    public function down()
{
    $this->forge->dropTable('game_images', true);
}
}