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
    }
    public function index()
    {
        // if (logged_in()) {
            return view('master');
        // } else {
        //     return redirect()->to('login');
        // }
    }
    public function contact_us()
    {
        // if (logged_in()) {
            return view('common/contact_us');
        // } else {
        //     return redirect()->to('login');
        // }
    }
    public function terms_of_service()
    {
        // if (logged_in()) {
            return view('common/terms_of_service');
        // } else {
        //     return redirect()->to('login');
        // }
    }
    public function privacy_policy()
    {
        // if (logged_in()) {
            return view('common/privacy_policy');
        // } else {
        //     return redirect()->to('login');
        // }
    }
}
