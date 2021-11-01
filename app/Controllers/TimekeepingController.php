<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\DocketService;
use App\Services\EmployeeService;
use App\Services\TimeKeepingService;

class TimekeepingController extends BaseController
{
    protected $timekeeping_service;
    protected $docket_service;
    protected $validation;
    protected $employee_service;
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->docket_service = new DocketService;
        $this->employee_service = new EmployeeService;
        $this->timekeeping_service = new TimeKeepingService;
        $this->validation =  \Config\Services::validation();
    }
    public function index()
    {
        $validation = \Config\Services::validation();
        $dockets = $this->docket_service->getDocketByEmployeeId();
        return view('dashboard/timekeeping/timekeeping',['validation'=>$validation,'dockets'=>$dockets]);
    }
    public function get_docket_details_for_timekeeping()
    {
        $docket_id = $this->request->getPost('docket_id');
        $dockets = $this->docket_service->show($docket_id);
        $timekeeping = $this->timekeeping_service->getTimekeepingByDocketId($docket_id);
        $checkTimeInOrOut = $this->timekeeping_service->checkTimeInOrOut($docket_id);
        echo json_encode(array('dockets' => !empty($dockets) ? $dockets : false, 'timekeeping' => !empty($timekeeping) ? $timekeeping : false, 'checkTimeInOrOut' => !empty($checkTimeInOrOut) ? $checkTimeInOrOut : false));
        // return $record;
    }
    public function get_time_keeping_data()
    {
        $docket_id = $this->request->getPost('docket_id');
        return !empty($dockets) ? json_encode($dockets) : false;
    }
    public function time_in()
    {
        $record = $this->timekeeping_service->createTimeIn($this->request->getPost());
        if ($record) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
}
