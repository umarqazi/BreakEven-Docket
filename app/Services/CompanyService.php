<?php


namespace App\Services;

use App\Repository\CompanyRepository;

/**
 * Class CompanyService
 * @package Services
 */
class CompanyService
{
    /**
     * @var CompanyRepository
     */
    protected $company_repo;

    /**
     * CompanyService constructor.
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Karachi');
        $this->company_repo = new CompanyRepository();
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
    public function all(){
       return $this->company_repo->all();
    }
    public function show($id){
        return $this->company_repo->find($id);
    }
    public function delete($id){
        return $this->company_repo->delete($id);
    }
    public function suspend_company()
    {
        //Cancel Subscription here
        //Send Email TO user "Docket Service Suspended"
        $data = [
            'is_enabled' => 0
        ];
        return $this->company_repo->update(User()->company_id,$data);
    }

}
