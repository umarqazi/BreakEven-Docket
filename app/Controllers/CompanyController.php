<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\UserService;
use App\Services\CompanyService;
use App\Services\EmployeeService;

class CompanyController extends BaseController
{
    protected $user_service;
    protected $company_service;
    protected $employee_service;

    public function __construct()
    {
        $this->user_service     = new UserService;
        $this->company_service  = new CompanyService;
        $this->employee_service = new EmployeeService;
    }
    public function index()
    {
        //
    }
    public function store()
    {
        $this->db->transBegin();
        $employee_data['job_title'] = 'super_admin';
        $company_id = $this->company_service->create($this->request->getPost());
        $result = $this->user_service->create($this->request->getPost(),$company_id,$is_company=true);
        if(isset($result['user_id'])) {     
            $this->employee_service->create($employee_data,$result['user_id']);
            $this->db->transCommit();
            return redirect()->to(site_url('login'))->withCookies()->with('message', 'User Registerd Successfully!');;
        } else {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('errors', $result);
        }
    }
    public function show()
    {
        return $this->company_service->show();
    }
    public function edit()
    {
        return $this->company_service->edit();
    }
    public function update()
    {
        $this->validation->run($this->request->getPost(), 'companyUpdate');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            $company_id = $this->company_service->update($this->request->getPost());
            return redirect()->to(site_url('company'))->withCookies()->with('message', 'Record Updated Successfully!');
        }
    }
    public function suspendCompany()
    {
        return $this->company_service->suspendCompany();
    }
}
