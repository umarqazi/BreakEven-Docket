<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendanceTable extends Migration
{
    public function up()
    {        
        /*
         * attendances
         */
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'check_in'        => ['type' => 'datetime', 'null' => true],
            'check_out'       => ['type' => 'datetime', 'null' => true],
            'user_id'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'on_break'        => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'break'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'resume'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'      => ['type' => 'datetime', 'null' => true],
            'updated_at'      => ['type' => 'datetime', 'null' => true],
            'deleted_at'      => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('attendances', true);
    }

    public function down()
    {
		$this->forge->dropTable('attendances', true);
    }
}
