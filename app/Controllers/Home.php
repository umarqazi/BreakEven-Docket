<?php

namespace App\Controllers;

use App\Services\UserService;
use Myth\Auth\Config\Auth as AuthConfig;


class Home extends BaseController
{
    protected $user_service;

    public function __construct()
    {
        // Most services in this controller require
		// the session to be started - so fire it up!
        $this->user_service = new UserService;
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
    public function get_email()
    {
        $qry = $this->db->query('select COUNT(users.email) as count from users where users.email ="'.$this->request->getPost('email').'"');
        $count = $qry->getResult()[0]->count;
        if($this->request->getPost('email') == $this->request->getPost('old_email')) 
        {
            return '1';
        } else {
            if($count > 0){
                return '0';
            } else {
                return '1';
            }
        }
    }
}
