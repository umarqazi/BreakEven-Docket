<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AccessControlService;

class AccessControllController extends BaseController
{
    protected $accessControl_service;

    public function __construct()
    {
        $this->accessControl_service = new AccessControlService;
    }
    public function index()
    {
        return $this->accessControl_service->accessControl();
    }
    public function addPermissions()
    {
        return $this->accessControl_service->addPermissions();
    }
    public function savePermission()
    {
        return $this->accessControl_service->savePermission($this->request->getPost());
    }
    public function deletePermission($permission_id=null)
    {
        return $this->accessControl_service->deletePermission($permission_id);
    }
    public function assignPermissions()
    {
        return $this->accessControl_service->assignPermissions($this->request->getPost());
    }
    public function getUserPermissions()
    {
        return $this->accessControl_service->getUserPermissions($this->request->getPost());
    }
}
