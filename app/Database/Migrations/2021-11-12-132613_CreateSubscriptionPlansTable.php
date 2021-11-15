<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscriptionPlansTable extends Migration
{
    public function up()
    {
            /*
         * subscription_plans
         */
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'            => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'description'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'paypal_plan_id'  => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'price'           => ['type' => 'int',     'constraint' => 255, 'null' => true],
            'status'          => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'allowed_users'   => ['type' => 'int',     'constraint' => 11, 'null' => true],
            'header_color'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'body_color'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'      => ['type' => 'datetime', 'null' => true],
            'updated_at'      => ['type' => 'datetime', 'null' => true],
            'deleted_at'      => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('paypal_plan_id');
        $this->forge->createTable('subscription_plans', true);
    }

    public function down()
    {
		$this->forge->dropTable('subscription_plans', true);
    }
}
