<?php

namespace App\Repository;


use App\Models\CompanyModel;

/**
 * Class CompanyRepository
 * @package App\Http\Repository
 */
class CompanyRepository extends BaseRepo
{
    /**
     * CompanyRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(CompanyModel::class);
    }
}
