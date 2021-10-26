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
    protected $validation;
    public function __construct()
    {
        $this->user_service = new UserService;
        $this->employee_service = new EmployeeService;
        $this->validation =  \Config\Services::validation();

    }
    public function index()
    {
        //
    }
    public function employee_center()
    {
        $db = \Config\Database::connect();
        // $param = [
        //     'user_type' => 'employee',
        //     'company_id' => user()->company_id
        // ];
        // $employees = $this->user_service->findAllWithWhere($param);

        $qry = 'SELECT employees.*, users.*
                FROM employees
                LEFT JOIN users ON employees.user_id = users.id
                WHERE users.company_id = ? AND users.user_type = ? ';

        $employees = $db->query($qry, [user()->company_id,'employee']);
        return view('dashboard/employees/employees', ['employees' => $employees->getResult('array')]);
    }
    public function employee_form()
    {
        $validation = \Config\Services::validation();
        return view('dashboard/employees/add_employee_form',['validation'=>$validation]);
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
        $db = \Config\Database::connect();
        $qry = 'SELECT employees.*, users.*
                FROM employees
                LEFT JOIN users ON employees.user_id = users.id
                WHERE users.company_id = ? AND users.user_type = ? AND users.id = ? ';

        $record = $db->query($qry, [user()->company_id,'employee',$seg1]);
        return view('dashboard/employees/employee_profile',['record' => $record->getRow()]);
    }
    public function edit($user_id = null)
    {
        $db = \Config\Database::connect();
        $qry = 'SELECT employees.*, users.*,employees.id as employee_id
                FROM employees
                LEFT JOIN users ON employees.user_id = users.id
                WHERE users.company_id = ? AND users.user_type = ? AND users.id = ? ';

        $record = $db->query($qry, [user()->company_id,'employee',$user_id]);
        return view('dashboard/employees/employee_edit',['record' => $record->getRow()]);
    }
    public function delete($user_id = null)
    {
        // $del_emp = ['user_id' => $user_id];
        // $this->employee_service->deleteWhere($del_emp);

        $del_user = ['id' => $user_id];
        $this->user_service->deleteWhere($del_user);
        return redirect()->to(site_url('employee-center'))->withCookies()->with('message', 'Employee Deleted Successfully');
    }
    public function employee_verify($user_id=false, $code=false)
    {
        $user = $this->user_service->validateUser($user_id,$code);
        if ($user) {
            return view('Auth/create_password',['user'=>$user]);
        } else {
            return view('Auth/create_password',['user'=>false]);
        }
    }
}