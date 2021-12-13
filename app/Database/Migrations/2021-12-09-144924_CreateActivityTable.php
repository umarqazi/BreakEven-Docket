<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityTable extends Migration
{
    public function up()
    {
        /*
         * activities
         */
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'         => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'other_user_id'   => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'type'            => ['type' => 'tinyint', 'constraint' => 11,  'null' => true],
            'description'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'ip_address'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'      => ['type' => 'datetime', 'null' => true],
            'updated_at'      => ['type' => 'datetime', 'null' => true],
            'deleted_at'      => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('activities', true);
    }

    public function down()
    {
		$this->forge->dropTable('activities', true);
    }
}
