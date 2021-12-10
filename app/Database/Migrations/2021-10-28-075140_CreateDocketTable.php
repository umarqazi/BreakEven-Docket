<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocketTable extends Migration
{
    public function up()
    {
        /*
         * dockets
         */
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'docket_no'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'added_by'      => ['type' => 'int',     'constraint' => 25, 'null' => true, 'unsigned' => TRUE],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('added_by');
        $this->forge->createTable('dockets', true);
    }

    public function down()
    {
		$this->forge->dropTable('dockets', true);
    }
}
