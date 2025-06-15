<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProduk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'   => ['type' => 'TEXT'],
            'harga'       => ['type' => 'INT'],
            'gambar'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('produk');
    }

    public function down()
    {
        $this->forge->dropTable('produk');
    }
}
