<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentTransactions extends Migration
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
        'payment_method' => [
            'type' => 'VARCHAR',
            'constraint' => 50,
        ],
        'transaction_id' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
        ],
        'gross_amount' => [
            'type' => 'DECIMAL',
            'constraint' => '12,2',
        ],
        'status' => [
            'type' => 'ENUM',
            'constraint' => ['pending','success','failed'],
            'default' => 'pending'
        ],
        'paid_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
        'created_at DATETIME default current_timestamp'
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('payment_transactions');
}

public function down()
{
    $this->forge->dropTable('payment_transactions');
}
}
