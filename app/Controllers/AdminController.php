<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    protected $config;
	protected $auth;

    public function __construct()
    {
        helper('html');
        $this->config = config('Auth');
		$this->auth = service('authentication');

    }
    public function index()
    {
        return view('admin/dashboard');
    }
    public function login()
    {
        if ($this->auth->check())
		{
			$this->auth->logout();
		}
        return view('admin/login',['config' => $this->config]);
    }
}
