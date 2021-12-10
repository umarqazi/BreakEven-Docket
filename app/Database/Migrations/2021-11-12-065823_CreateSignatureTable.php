<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSignatureTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'signature'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'signature_image'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'user_id'           => ['type' => 'varchar', 'constraint' => 11,  'null' => true],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('signature', true);
    }

    public function down()
    {
		$this->forge->dropTable('signature', true);
    }
}
