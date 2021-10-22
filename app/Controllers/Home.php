<?php

namespace App\Controllers;
use Myth\Auth\Config\Auth as AuthConfig;
use CodeIgniter\Session\Session;


class Home extends BaseController
{
    protected $auth;

	/**
	 * @var AuthConfig
	 */
	protected $config;

	/**
	 * @var Session
	 */
	protected $session;

    public function __construct()
    {
        // Most services in this controller require
		// the session to be started - so fire it up!
		$this->session = service('session');

		$this->config = config('Auth');
		$this->auth = service('authentication');
        helper('auth');
        helper('html');
    }
    public function index()
    {
        return view('dashboard/home_page');
    }
    public function contact_us()
    {
        return view('common/contact_us');
    }
    public function terms_of_service()
    {
        return view('common/terms_of_service');
    }
    public function privacy_policy()
    {
        return view('common/privacy_policy');
    }
}
