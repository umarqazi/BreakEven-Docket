<?php
namespace App\Services;


use App\Services\CompanyService;

class EmailService
{
    protected $email;
    public function __construct()
    {
        date_default_timezone_set('Asia/Karachi');
        $this->email = \Config\Services::email();
        $this->company_service = new CompanyService;
    }
    public function send_varification_mail($user,$activation_code)
    {
        $email = \Config\Services::email();
        $config = Array(
            'protocol' => getenv('protocol'),
            'SMTPHost' => getenv('SMTPHost'),
            'SMTPPort' => getenv('SMTPPort'),
            'SMTPUser' => getenv('SMTPUser'),
            'SMTPPass' => getenv('SMTPPass'),
            'mailType' => getenv('mailType'),
            'CRLF'     => "\r\n",
            'newline'  => "\r\n",
          );

        $email->initialize($config);
        $company = $this->company_service->show($user['company_id']);
        $user['activation_code'] = $activation_code;
        $user['company_name'] = $company['company_name'];
        $email_template = view('email/varification_template',['userdata'=>$user]);
        $email->setFrom('hamza.87.tuf@gmail.com', 'hamzah mahmood');
        $email->setTo($user['email']);
        $email->setSubject('Verify Your Email');
        $email->setMessage($email_template);
        
        if($email->send()){
            return true;
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }







}