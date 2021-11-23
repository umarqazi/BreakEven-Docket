<?php

namespace App\Repository;


use App\Models\DocketsToEmployeesModel;

/**
 * Class AssignDocketRepository
 * @package App\Http\Repository
 */
class AssignDocketRepository extends BaseRepo
{
    /**
     * AssignDocketRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(DocketsToEmployeesModel::class);
    }
}
