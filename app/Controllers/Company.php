<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\UserService;
use App\Services\CompanyService;
use App\Services\EmployeeService;

class Company extends BaseController
{
    protected $user_service;
    protected $company_service;
    protected $employee_service;
    public function __construct()
    {
        $this->user_service = new UserService;
        $this->company_service = new CompanyService;
        $this->employee_service = new EmployeeService;
    }
    public function index()
    {
        //
    }
    public function store()
    {
        $employee_data['job_title'] = 'super_admin';
        $company_id = $this->company_service->create($this->request->getPost());
        $result = $this->user_service->create($this->request->getPost(),$company_id,$is_company=true);        
        $this->employee_service->create($employee_data,$result['user_id']);
        return $result['response'];
    }
    public function show()
    {
        $validation = \Config\Services::validation();
        $company = $this->company_service->show(User()->company_id);
        $users = $this->user_service->findAllWithWhere(['company_id' => User()->company_id]);
        $users = !empty($users) ? count($users) : 0; 
        return view('dashboard/company/company_details',['validation'=>$validation,'company'=>$company,'users'=>$users]);
    }
}
