<?php

namespace App\Repository;


use App\Models\Docket;

/**
 * Class DocketRepository
 * @package App\Http\Repository
 */
class DocketRepository extends BaseRepo
{
    /**
     * DocketRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Docket::class);
    }
}
