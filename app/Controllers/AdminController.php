<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CompanyService;
use App\Services\SignatureService;
use App\Services\SubscriptionPlanService;
use App\Services\UserService;

class AdminController extends BaseController
{
    protected $subscription_plan_service;
    protected $signature_service;
    protected $company_service;
    protected $user_service;
    protected $validation;
    protected $config;
	protected $auth;

    public function __construct()
    {
        helper('html');
        $this->config               = config('Auth');
        $this->user_service         = new UserService;
        $this->company_service      = new CompanyService;
        $this->signature_service    = new SignatureService;
		$this->auth                 = service('authentication');
        $this->validation           = \Config\Services::validation();
        $this->subscription_plan_service    = new SubscriptionPlanService();
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
    public function companies()
    {
        $companies = $this->company_service->getCompanyWithUser();
        return view('admin/company/companies',['companies'=>$companies]);
    }
    public function company_details($company_id = false)
    {
        $company = $this->company_service->getCompanyWithUser($company_id);
        $users = $this->user_service->findAllWithWhere(['company_id' => $company_id]);
        $users = !empty($users) ? count($users) : 0; 
        return view('admin/company/company_details',['company'=>$company,'users'=>$users]);
    }
    public function disable_company($company_id = false)
    {
        $company = $this->company_service->suspend_company($company_id);
        if ($company) {
            return redirect()->back()->with('message', 'Company disabled Successfully!');
        }
    }
    public function enable_company($company_id = false)
    {
        $company = $this->company_service->enable_company($company_id);
        if ($company) {
            return redirect()->back()->with('message', 'Company Enabled Successfully!');
        }
    }
    public function signature()
    {
        $signature = $this->signature_service->findAll();
        return view('admin/signature',['signature'=>$signature]);
    }
    public function update_signature()
    {
        $signature_id = $this->request->getPost('signature_id');
        $this->validation->run($this->request->getPost(), 'update_signature');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            if ($signature_id) {
                $result = $this->signature_service->update($signature_id,$this->request->getPost());
            } else {
                $result = $this->signature_service->create($this->request->getPost());
            }
            if ($result) {
                return redirect()->back()->with('message', 'Signature Updated Successfully!');
            } else {
                return redirect()->back()->with('error', 'There is some error!');
            }
        }
    }
    public function subscription_plans()
    {
        
        $subscriptions = $this->subscription_plan_service->findAll();
        return view('admin/subscription/subscription_plan',['subscriptions'=>$subscriptions]);
    }
    public function create_plan()
    {
        return view('admin/subscription/create_plan',['validation' => $this->validation]);
    }
    public function save_plan()
    {
        $plan_id = $this->request->getPost('plan_id');
        // dd($plan_id);
        $this->validation->run($this->request->getPost(), 'subscription_plan');
        if ($this->validation->getErrors()) {
            return redirect()->back()->withInput()->with('validation', $this->validation->getErrors());
        } else {
            $msg = '';
            if ($plan_id) {
                $result = $this->subscription_plan_service->update($plan_id,$this->request->getPost());
                $msg = "Plan Updated Successfully!";
            } else {
                $result = $this->subscription_plan_service->create($this->request->getPost());
                $msg = "Plan Created Successfully!";
            }
            if ($result) {
                return redirect()->to(site_url('admin/subscription-plans'))->with('message', $msg);
            } else {
                return redirect()->back()->with('error', 'There is some error!');
            }
        }
    }
    public function delete_plan($plan_id = null)
    {
        $result = $this->subscription_plan_service->delete($plan_id);
        if($result)
        {
            return redirect()->back()->with('message', 'Plan Deleted Successfully!');
        } else {
            return redirect()->back()->with('error', 'There is some error!');
        }
    }
    public function edit_plan($plan_id = null)
    {
        $subscription = $this->subscription_plan_service->show($plan_id);
        return view('admin/subscription/create_plan',['validation' => $this->validation,'subscription'=>$subscription]);
    }
}
