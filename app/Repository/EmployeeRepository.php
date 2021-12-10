<?php

namespace App\Repository;

use App\Models\EmployeeModel;

/**
 * Class EmployeeRepository
 * @package App\Http\Repository
 */
class EmployeeRepository extends BaseRepo
{
    /**
     * EmployeeRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(EmployeeModel::class);
    }
}
