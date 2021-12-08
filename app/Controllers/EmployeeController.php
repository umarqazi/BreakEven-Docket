<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\UserModel;
use App\Services\EmployeeService;
use App\Services\UserService;

class EmployeeController extends BaseController
{
    protected $user_service;
    protected $employee_service;
    
    public function __construct()
    {
        $this->user_service = new UserService;
        $this->employee_service = new EmployeeService;
    }
    
    public function index()
    {
        //
    }

    public function employeeCenter()
    {
        return $this->employee_service->getAllEmployees();
    }

    public function employeeForm()
    {
        return view('dashboard/employees/add_employee_form',['validation'=>$this->validation]);
    }

    public function store()
    {
        $this->validation->run($this->request->getPost(), 'employeStore');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            $msg = '';
            if($this->request->getPost('user_id') != ''){
                $msg = 'Employee Updated Successfully!';
            } else {
                $send_mail = true;
                $msg = 'Employee Added Successfully!';
            }
            $company_id = user()->company_id;
            $user_id = $this->user_service->create($this->request->getPost(),$company_id);
            $result = $this->employee_service->create($this->request->getPost(),$user_id);
            if($result == true) {
                return redirect()->to(site_url('employee-center'))->withCookies()->with('message', $msg);
            }
        }
    }
    public function show($seg1 = false)
    {
        return $this->employee_service->getEmployee($seg1);
    }
    public function edit($user_id = null)
    {
        return $this->employee_service->editEmployee($user_id);
    }
    public function delete($user_id = null)
    {
        return $this->employee_service->deleteEmployee($user_id);
    }
    public function employeeVerify($user_id=false, $code=false)
    {
        $user = $this->user_service->validateUser($user_id,$code);
        return view('Auth/create_password',['user' => ($user) ? $user : false, 'validation' => $this->validation]);
    }
    public function setPassword()
    {
        $this->validation->run($this->request->getPost(), 'setPassword');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            $data['password'] = $this->request->getPost('password');
            $data['activation_code'] = '';
            $id = $this->request->getPost('user_id');
            $result = $this->user_service->setPassword($id,$data);
            if($result){
                return redirect()->to(site_url('employee-center'))->withCookies()->with('message', 'Password is updated You can login Now');
            } else {
                return redirect()->back()->withInput()->with('error', 'Some thing went wrong!');
            }
        }
    }
}
