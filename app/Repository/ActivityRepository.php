<?php

namespace App\Repository;


use App\Models\TimeKeepingModel;

/**
 * Class ActivityRepository
 * @package App\Http\Repository
 */
class ActivityRepository extends BaseRepo
{
    /**
     * ActivityRepository constructor.
     */
    protected $db;
    protected $current_date_time;

    public function __construct()
    {
        parent::__construct(TimeKeepingModel::class);
        $this->current_date_time = date('Y-m-d H:i:s');
        $this->db = \Config\Database::connect();
    }
}
