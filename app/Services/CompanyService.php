<?php


namespace App\Services;

use App\Repository\CompanyRepository;
use App\Repository\UserRepository;

/**
 * Class CompanyService
 * @package Services
 */
class CompanyService
{
    /**
     * @var CompanyRepository
     */
    protected $db;
    protected $user_repo;
    protected $validation;
    protected $company_repo;

    /**
     * CompanyService constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        date_default_timezone_set('Asia/Karachi');
        $this->user_repo    = new UserRepository;
        $this->company_repo = new CompanyRepository();
        $this->validation   = \Config\Services::validation();
    }
    public function create($data){
        
        $plan = $data['plan'];
        $price['price'] = 1;
        $company = array(
            'email' => $data['email'],
            'company_name' => $data['company_name'],
            'company_owner' => $data['owner_name'],
            'phone' => $data['company_phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['postal_code'],
            'expiry_date' => date('Y-m-d'),
            'subscription_start_date' => date('Y-m-d'),
            'subscription_plan_id' => $plan,
            'renew_date' => date('Y-m-d'),
            'is_enabled' => 1,
            'is_paid' => 0,
            'renew_cost' => $price['price']
        );
       $result = $this->company_repo->insert($company);
       return $result;
    }
    public function update($data)
    {
        $plan = 1;
        $price['price'] = 1;
        $company = array(
            'email' => $data['email'],
            'company_name' => $data['company_name'],
            'company_owner' => $data['owner_name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'subscription_plan_id' => $plan,
        );
        $result = $this->company_repo->update($data['company_id'],$company);
        return $result;
    }
    public function updateSignature($id,$data)
    {
        return $this->company_repo->update($id,$data);
    }
    public function findAll(){
       return $this->company_repo->findAll();
    }
    public function findWhere($id)
    {
        return $this->company_repo->find($id);
    }
    public function show(){
        $company_id =  User()->company_id;
        $company = $this->company_repo->find($company_id);
        $users = $this->user_repo->findAllWithWhere(['company_id' => $company_id]);
        $users = !empty($users) ? count($users) : 0; 
        return view('dashboard/company/company_details',['validation'=>$this->validation,'company'=>$company,'users'=>$users]);
    }
    public function edit(){
        $company_id =  User()->company_id;
        $company = $this->company_repo->find($company_id);
        $users = $this->user_repo->findAllWithWhere(['company_id' => $company_id]);
        $users = !empty($users) ? count($users) : 0; 
        return view('dashboard/company/edit_company',['validation'=>$this->validation,'company'=>$company]);
    }
    public function is_enable($company_id = null)
    {
        return $this->company_repo->find($company_id);
    }
    public function delete($id){
        return $this->company_repo->delete($id);
    }
    public function suspendCompany($company_id = null)
    {
        $data = [
            'is_enabled' => 0
        ];
        if (!empty($company_id)) {
            $result = $this->company_repo->update($company_id,$data);
        } else {
            $result = $this->company_repo->update(User()->company_id,$data);
        }
        if ($result) {
            return redirect()->to(site_url('logout'))->withCookies()->with('message', 'Company Suspended Successfully!');
        }
    }
    public function enableCompany($company_id)
    {
        $data = [
            'is_enabled' => 1
        ];
        return $this->company_repo->update($company_id,$data);
    }
    public function getCompanyWithUser($company_id = null)
    {
        return $this->company_repo->getCompanyWithUser($company_id = null);
    }
}
