<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\DocketService;
use App\Services\EmployeeService;

class DocketController extends BaseController
{
    protected $docket_service;
    protected $employee_service;
    
    public function __construct()
    {
        $this->docket_service = new DocketService;
        $this->employee_service = new EmployeeService;
    }
    public function index()
    {
        $dockets = $this->docket_service->getAllDockets();
        return view('dashboard/docket/dockets_nos',['validation'=>$this->validation,'dockets'=>$dockets]);
    }
    public function dockets()
    {
        $dockets = $this->docket_service->getAllDockets();
        return view('dashboard/docket/dockets',['validation'=>$this->validation,'dockets'=>$dockets]);
    }
    public function getDocketNo()
    {
        return $this->docket_service->isUniqueDocketNo($this->request->getPost('docket_no'));
    }
    public function storeDocket()
    {
        $this->validation->run($this->request->getPost(), 'docketStore');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            return $this->docket_service->create($this->request->getPost());
        }
    }
    public function assignDetails($docket_id=null)
    {
        $dockets = $this->docket_service->getDocketById($docket_id);
        $assignedEmployees = $this->docket_service->getDocketAssignedToEmployeesByDocketId($docket_id);
        
        $alreadyAssignedEmployees = [];
        if($assignedEmployees != false) 
        {
            foreach ($assignedEmployees as $key => $value) {
                $alreadyAssignedEmployees[$key] = $value['employee_id'];
            }
        }
        $employees = $this->docket_service->getAllEmployees($docket_id);
        return view('dashboard/docket/docket_details',['validation'=>$this->validation,'dockets'=>$dockets,'employees'=>$employees,'assignedEmployees'=>$assignedEmployees,'alreadyAssignedEmployees'=>$alreadyAssignedEmployees]);
    }
    public function assignDocket()
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
    public function getdocketDetailByid()
    {
        $docket_id = $this->request->getPost('docket_id');
        $assignedEmployees = $this->docket_service->getDocketAssignedToEmployeesByDocketId($docket_id);
        return !empty($assignedEmployees) ? json_encode($assignedEmployees) : json_encode(false);
    }
}
