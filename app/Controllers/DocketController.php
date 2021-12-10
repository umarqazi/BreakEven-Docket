<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\DocketService;
use App\Services\EmployeeService;

class DocketController extends BaseController
{
    protected $docket_service;
    protected $validation;
    protected $employee_service;
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->docket_service = new DocketService;
        $this->employee_service = new EmployeeService;
        $this->validation =  \Config\Services::validation();
    }
    public function index()
    {
        $validation = \Config\Services::validation();
        $dockets = $this->docket_service->getAllDockets();
        return view('dashboard/docket/dockets_nos',['validation'=>$validation,'dockets'=>$dockets]);
    }
    public function dockets()
    {
        $validation = \Config\Services::validation();
        $dockets = $this->docket_service->getAllDockets();
        return view('dashboard/docket/dockets',['validation'=>$validation,'dockets'=>$dockets]);
    }
    public function get_docket_no()
    {
        $db = \Config\Database::connect();
        $rrr = $db->query('select COUNT(dockets.docket_no) as count from dockets where dockets.docket_no ="'.$this->request->getPost('docket_no').'"');
        $count = $rrr->getResult()[0]->count;
        if($count > 0){
            return '0';
        } else {
            return '1';
        }
    }
    public function store_docket()
    {
        $this->validation->run($this->request->getPost(), 'docketStore');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            $result = $this->docket_service->create($this->request->getPost());
            if($result == true) {
                return redirect()->to(site_url('docket-no'))->withCookies()->with('message', 'Docket Added Successfully');
            } else {
                return redirect()->to(site_url('docket-no'))->withCookies()->with('error', 'There is some error!');
            }
        }
    }
    public function assign_details($docket_id=null)
    {
        $validation = \Config\Services::validation();
        $dockets = $this->docket_service->getDocketById($docket_id);
        $assignedEmployees = $this->docket_service->getDocketAssignedToEmployeesByDocketId($docket_id);
        
        $alreadyAssignedEmployees = [];
        if($assignedEmployees != false) 
        {
            foreach ($assignedEmployees as $key => $value) {
                $alreadyAssignedEmployees[$key] = $value['employee_id'];
            }
        }
        $employees = $this->employee_service->getAllEmployees($docket_id);
        return view('dashboard/docket/docket_details',['validation'=>$validation,'dockets'=>$dockets,'employees'=>$employees,'assignedEmployees'=>$assignedEmployees,'alreadyAssignedEmployees'=>$alreadyAssignedEmployees]);
    }
    public function assign_docket()
    {
        $this->validation->run($this->request->getPost(), 'docketStore');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            $result = $this->docket_service->assignDocket($this->request->getPost());
            if($result == true) {
                return redirect()->back()->withCookies()->with('message', 'Docket Assigned to Employee Successfully');
            } else {
                return redirect()->back()->withCookies()->with('error', 'There is some error!');
            }
        }
    }
}
