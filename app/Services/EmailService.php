<?php
namespace App\Services;

use App\Repository\UserRepository;
use App\Services\SignatureService;
use App\Services\CompanyService;

class EmailService
{
    protected $db;
    protected $email;
    protected $config;
    protected $user_repo;
    protected $signature_service;

    public function __construct()
    {
        date_default_timezone_set('Asia/Karachi');
        $this->email = \Config\Services::email();
        $this->company_service = new CompanyService;
        $this->user_repo = new UserRepository;
        $this->db = \Config\Database::connect();
        $this->signature_service = new SignatureService;

        $this->config = Array(
            'protocol' => getenv('protocol'),
            'SMTPHost' => getenv('SMTPHost'),
            'SMTPPort' => getenv('SMTPPort'),
            'SMTPUser' => getenv('SMTPUser'),
            'SMTPPass' => getenv('SMTPPass'),
            'mailType' => getenv('mailType'),
            'CRLF'     => "\r\n",
            'newline'  => "\r\n",
          );
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
        $user['signature'] = $company['signature'];
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
    public function super_admin_email($data)
    {
        $subject        = $data['subject'];
        $subject        = !empty($data['subject']) ? $data['subject'] : '';
        $message        = !empty($data['message']) ? $data['message'] : '';
        $email = \Config\Services::email();
        $email->initialize($this->config);
        $email->setFrom('hamza.87.tuf@gmail.com', 'hamzah mahmood');

        if (!empty($data['receiver'])) {
            $receivers           = $this->db->query('SELECT users.email FROM users WHERE id IN ('.implode(',',$data['receiver']).')')->getResult();
            $receiver_emails = [];
            foreach ($receivers as $key => $value) {
                array_push($receiver_emails, $value->email);
            }
            $email_receivers = implode(",", $receiver_emails);
            $email->setTo($email_receivers);
        }

        if (!empty($data['cc_recipient'])) {
            $cc           = $this->db->query('SELECT users.email FROM users WHERE id IN ('.implode(',',$data['cc_recipient']).')')->getResult();
            $cc_emails = [];
            foreach ($cc as $key => $value) {
                array_push($cc_emails, $value->email);
            }
            $email->setCC($cc_emails);
        }

        if (!empty($data['bcc_recipient'])) {
            $cc           = $this->db->query('SELECT users.email FROM users WHERE id IN ('.implode(',',$data['bcc_recipient']).')')->getResult();
            $bcc_emails = [];
            foreach ($cc as $key => $value) {
                array_push($bcc_emails, $value->email);
            }
            $email->setBCC($bcc_emails);
        }

        $email->setSubject($subject);
        $email->setMessage($message);
        if($email->send()){
            return true;
        } else {
            return $email->printDebugger(['headers']);
        }
    }




}