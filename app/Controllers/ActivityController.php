<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ActivityService;

class ActivityController extends BaseController
{
    protected $activity_service;
    public function __construct()
    {
        $this->activity_service = new ActivityService;
    }
    public function index()
    {
        
    }
}
