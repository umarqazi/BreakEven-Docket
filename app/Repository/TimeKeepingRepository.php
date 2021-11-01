<?php

namespace App\Repository;

use App\Models\TimeKeepingModel;

/**
 * Class TimeKeepingRepository
 * @package App\Http\Repository
 */
class TimeKeepingRepository extends BaseRepo
{
    /**
     * TimeKeepingRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(TimeKeepingModel::class);
    }
}
