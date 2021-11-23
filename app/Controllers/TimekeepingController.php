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

    public function __construct()
    {
        $this->docket_service = new DocketService;
        $this->employee_service = new EmployeeService;
        $this->timekeeping_service = new TimeKeepingService;
    }
    public function index()
    {
        $dockets = $this->docket_service->getDocketByEmployeeId();
        return view('dashboard/timekeeping/timekeeping',['validation'=>$this->validation,'dockets'=>$dockets]);
    }
    public function getDocketDetails()
    {
        $docket_id = $this->request->getPost('docket_id');
        $dockets = $this->docket_service->show($docket_id);
        $timekeeping = $this->timekeeping_service->getTimekeepingByDocketId($docket_id);
        $checkTimeInOrOut = $this->timekeeping_service->checkTimeInOrOut($docket_id);
        echo json_encode(array('dockets' => !empty($dockets) ? $dockets : false, 'timekeeping' => !empty($timekeeping) ? $timekeeping : false, 'checkTimeInOrOut' => !empty($checkTimeInOrOut) ? $checkTimeInOrOut : false));
    }
    public function getTimeKeepingData()
    {
        $docket_id = $this->request->getPost('docket_id');
        return !empty($dockets) ? json_encode($dockets) : false;
    }
    public function timeIn()
    {
        $record = $this->timekeeping_service->createTimeIn($this->request->getPost());
        if ($record) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
    public function manualTimeIn()
    {
        $msg = '';
        if (!empty($this->request->getPost('timekeeping_id'))) {
            $msg = 'Time Out Successfully';
        } else {
            $msg = 'Time In Successfully';
        }
        $record = $this->timekeeping_service->createManualTimeIn($this->request->getPost());
        if ($record) {
            return redirect()->to(site_url('time-keeping'))->withCookies()->with('message', $msg);
        } else {
            return false;
        }
    }
}
