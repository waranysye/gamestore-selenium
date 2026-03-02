<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
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
        'total_price' => [
            'type' => 'DECIMAL',
            'constraint' => '12,2',
        ],
        'status' => [
            'type' => 'ENUM',
            'constraint' => ['pending','paid','cancelled'],
            'default' => 'pending'
        ],
        'created_at DATETIME default current_timestamp',
        'updated_at DATETIME default current_timestamp on update current_timestamp'
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('orders');
}

public function down()
{
    $this->forge->dropTable('orders');
}
}
