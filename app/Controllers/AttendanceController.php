<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AttendanceService;

class AttendanceController extends BaseController
{
    protected $attendance_service;
    public function __construct()
    {
        date_default_timezone_set('Asia/Karachi');
        $this->attendance_service = new AttendanceService;
    }
    public function index()
    {
        return $this->attendance_service->index();
    }
    public function checkin()
    {
        return $this->attendance_service->checkin();
    }
    public function checkout()
    {
        return $this->attendance_service->checkout($this->request->getPost('id'));
    }
    public function break()
    {
        return $this->attendance_service->break($this->request->getPost('id'));
    }
    public function resume()
    {
        return $this->attendance_service->resume($this->request->getPost('id'));
    }
}
