<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTimeKeepingTable extends Migration
{
    public function up()
    {
    /*
         * timekeepings
         */
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'docket_id'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'employee_id'    => ['type' => 'int',  'constraint' => 11, 'null' => true, 'unsigned' => TRUE],
            'time_in'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'time_out'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('docket_id');
        $this->forge->addKey('employee_id');
        $this->forge->createTable('timekeepings', true);
    }

    public function down()
    {
		$this->forge->dropTable('timekeepings', true);
    }
}
