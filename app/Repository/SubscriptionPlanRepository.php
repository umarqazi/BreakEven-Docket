<?php

namespace App\Repository;

use App\Models\SubscriptionPlans;

/**
 * Class SubscriptionPlanRepository
 * @package App\Http\Repository
 */
class SubscriptionPlanRepository extends BaseRepo
{
    /**
     * SubscriptionPlanRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(SubscriptionPlans::class);
    }
}
