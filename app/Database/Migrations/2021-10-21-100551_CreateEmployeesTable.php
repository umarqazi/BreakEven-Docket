<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        /*
         * employees
         */
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ss#'           => ['type' => 'varchar', 'constraint' => 25],
            'w4fed'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'w4state'       => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'hourly_rate'   => ['type' => 'decimal', 'constraint' => 30, 'null' => true],
            'salary'        => ['type' => 'decimal', 'constraint' => 30, 'null' => true],
            'user_id'       => ['type' => 'int',     'constraint' => 25, 'null' => true, 'unsigned' => TRUE],
            'job_title'     => ['type' => 'varchar', 'constraint' => 25, 'null' => true],
            'permissions'   => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'hire_date'     => ['type' => 'datetime', 'null' => true],
            'release_date'  => ['type' => 'datetime', 'null' => true],
            'birth_date'    => ['type' => 'datetime', 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
            'CONSTRAINT produk_ibfk_1 FOREIGN KEY(`user_id`) REFERENCES `users`(`id`)'
        ]);
        $this->forge->addKey('id', true);
        // $this->forge->addKey('user_id');
        // $this->forge->addForeignKey('user_id','users','id');
        $this->forge->createTable('employees', true);
    }

    public function down()
    {
		$this->forge->dropTable('employees', true);
    }
}
