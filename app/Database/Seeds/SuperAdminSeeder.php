<?php

namespace App\Database\Seeds;

use App\Services\UserService;
use CodeIgniter\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function __construct()
    {
        $this->user_service = new UserService;
    }
    public function run()
    {
        $data = [
            'first_name'    => 'Super',
            'last_name'     => 'Admin',
            'username'      => 'Super Admin',
            'email'         => 'admin@docket.com',
            'password'      => 'mmmmmmmm',
            'user_type'     => 'admin',
            'mobile'        => '',
            'company_id'    => '',
            'is_verified'   => 1,
            'is_enabled'    => 1,
            'is_super_admin'=> 1
        ];
    $result = $this->user_service->create($data,null);
    }
}
