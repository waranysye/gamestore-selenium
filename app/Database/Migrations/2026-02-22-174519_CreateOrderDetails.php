<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderDetails extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'order_id' => [
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
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('game_id', 'games', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('order_details');
}

public function down()
{
    $this->forge->dropTable('order_details', true);
}
}
