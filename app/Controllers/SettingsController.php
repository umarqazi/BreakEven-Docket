<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CompanyService;
use App\Services\UserService;

class SettingsController extends BaseController
{
    protected $authorize;
    protected $user_service;
    protected $company_service;
    function __construct()
    {
        $this->user_service = new UserService;
        $this->company_service = new CompanyService;
        $this->authorize     = service('authorization');
    }
    public function index()
    {
        return view('dashboard/settings/settings',['permissions' => $this->authorize]);
    }
    public function signature()
    {
        $signature = $this->user_service->show(user_id());
        return view('dashboard/settings/signature_setup',['signature'=> $signature['invoice_signature']]);
    }
    public function saveSignature()
    {
        $data = $this->request->getPost('img');
		list($type, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
        $img_name = $this->user_id.'_signature.png';
        $user_folder['relative_path'] = '/var/www/html/docket/public/uploads/signature_images/';
        if (!is_dir($user_folder['relative_path'])) {
			mkdir($user_folder['relative_path'], 0775, true);
		}
		file_put_contents($user_folder['relative_path'] . $img_name, $data);
        $data = [
            'invoice_signature' => $img_name
        ];
        $activity_data = ['type'=> 22,'user_id'=>$this->user_id, 'other_user_id'=> '','description' =>''];
        insertActivity($activity_data);
        $result = $this->user_service->update($this->user_id,$data);
        return ($result == true) ? true : false;
    }
    public function mailSignature()
    {
        $signature = $this->company_service->findWhere(user()->company_id);
        return view('dashboard/settings/mail_signature',['signature'=> $signature['signature']]);
    }
    public function updateSignature()
    {
        $data = [
            'signature' => $this->request->getPost('signature_body')
        ];
        $signature = $this->company_service->updateSignature(user()->company_id,$data);
        if($signature){
            return redirect()->back()->withCookies()->with('message', 'Signature Updated!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Some thing went wrong!');
        }
    }
}
