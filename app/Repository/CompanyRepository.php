<?php

namespace App\Repository;


use App\Models\Company;

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
        parent::__construct(Company::class);
    }
}
