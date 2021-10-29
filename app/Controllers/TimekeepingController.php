<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\DocketService;
use App\Services\EmployeeService;

class TimekeepingController extends BaseController
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
        $dockets = $this->docket_service->getDocketByEmployeeId();
        // dd($dockets);
        return view('dashboard/timekeeping/timekeeping',['validation'=>$validation,'dockets'=>$dockets]);
    }
    public function get_docket_details_for_timekeeping()
    {
        $docket_id = $this->request->getPost('docket_id');
        $dockets = $this->docket_service->show($docket_id);
        return !empty($dockets) ? json_encode($dockets) : false;
    }
}
