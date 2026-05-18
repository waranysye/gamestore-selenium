<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cart_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'game_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint'  => '12,2',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Index untuk foreign key (WAJIB untuk MySQL stabil)
        $this->forge->addKey('cart_id');
        $this->forge->addKey('game_id');

        // Foreign keys
        $this->forge->addForeignKey(
            'cart_id',
            'carts',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'game_id',
            'games',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Force InnoDB (WAJIB untuk FK)
        $this->forge->createTable('cart_items', true, [
            'ENGINE' => 'InnoDB'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('cart_items', true);
    }
}