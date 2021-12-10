<?php


namespace App\Services;
use App\Repository\SignatureRepository;
use App\Repository\SubscriptionPlanRepository;

/**
 * Class SubscriptionPlanService
 * @package Services
 */
class SubscriptionPlanService
{
    /**
     * @var SignatureRepository
     */
    protected $subscriptionPlan_repo;
    protected $subscription_plan;
    protected $validation;
    protected $db;

    /**
     * SubscriptionPlanService constructor.
     */
    public function __construct()
    {
        helper('date');
        date_default_timezone_set('Asia/Karachi');
        $this->db               = \Config\Database::connect();
        $this->validation       =  \Config\Services::validation();
        $this->subscriptionPlan_repo        = new SubscriptionPlanRepository();
    }
    public function create($data)
    {
       return $this->subscriptionPlan_repo->insert($data);
    }
    public function update($signature_id,$data)
    {
       return $this->subscriptionPlan_repo->update($signature_id,$data);
    }
    public function findAll()
    {
       return $this->subscriptionPlan_repo->findAll();
    }
    public function show($id)
    {
        return $this->subscriptionPlan_repo->find($id);
    }
    public function delete($id)
    {
        return $this->subscriptionPlan_repo->delete($id);
    }
}
