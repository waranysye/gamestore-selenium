<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartItems extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'cart_id' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'game_id' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'price' => [
            'type' => 'DECIMAL',
            'constraint' => '12,2',
        ],
        'created_at DATETIME default current_timestamp'
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('cart_id', 'carts', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('game_id', 'games', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('cart_items');
}

public function down()
{
    $this->forge->dropTable('cart_items');
}
}
