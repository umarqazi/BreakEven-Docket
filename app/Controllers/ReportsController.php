<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ReportsService;

class ReportsController extends BaseController
{
    protected $reports_service;
    public function __construct()
    {
        $this->reports_service = new ReportsService;   
    }
    public function index()
    {
        return $this->reports_service->reportsHomePage();
    }
    public function timekeeping_report()
    {
        $filters = null;
        if ($this->request->getPost()) {
            $filters = $this->request->getPost();
        }
        return $this->reports_service->timekeeping_report($filters);
    }
}
