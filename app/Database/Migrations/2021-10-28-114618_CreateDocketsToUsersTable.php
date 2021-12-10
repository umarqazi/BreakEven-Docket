<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocketsToUsersTable extends Migration
{
    public function up()
    {
        /*
         * dockets_to_employees
         */
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'docket_id'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'employee_id'    => ['type' => 'int',     'constraint' => 11, 'null' => true, 'unsigned' => TRUE],
            'assignee_id' => ['type' => 'int',     'constraint' => 11, 'null' => true, 'unsigned' => TRUE],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('docket_id');
        $this->forge->addKey('employee_id');
        $this->forge->addKey('assignee_id');
        $this->forge->createTable('dockets_to_employees', true);
    }

    public function down()
    {
		$this->forge->dropTable('dockets_to_employees', true);
    }
}
