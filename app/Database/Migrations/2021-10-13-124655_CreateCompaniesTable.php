<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        /*
         * Companies
         */
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'                 => ['type' => 'varchar', 'constraint' => 255],
            'company_name'          => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'company_owner'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'fax'                   => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'phone'                 => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'company_website'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'company_logo'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'zip'                   => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'city'                  => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'credit_card_no'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'cvv'                   => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'address'               => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'card_address'          => ['type' => 'varchar', 'constraint' => 40, 'null' => true],
            'subscription_plan_id'  => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'plan_agreement_id'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'renew_cost'            => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'total_users'           => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'state'                 => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'company_abbreveation'  => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'client'                => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'signature'             => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'signature_image'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'is_enabled'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'is_paid'               => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 1],
            'renew_date'            => ['type' => 'datetime', 'null' => true],
            'expiry_date'           => ['type' => 'datetime', 'null' => true],
            'subscription_start_date'        => ['type' => 'datetime', 'null' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('companies', true);
    }

    public function down()
    {
		$this->forge->dropTable('companies', true);
    }
}
