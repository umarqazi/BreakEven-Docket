<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\UserService;
use App\Services\CompanyService;

class Company extends BaseController
{
    protected $user_service;
    protected $company_service;
    public function __construct()
    {
        $this->user_service = new UserService;
        $this->company_service = new CompanyService;
    }
    public function index()
    {
        //
    }
    public function store()
    {
        $company_id = $this->company_service->create($this->request->getPost());
        $result = $this->user_service->create($this->request->getPost(),$company_id);
        return $result;
    }
}
