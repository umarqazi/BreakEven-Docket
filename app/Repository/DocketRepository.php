<?php

namespace App\Repository;


use App\Models\DocketModel;

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
        parent::__construct(DocketModel::class);
    }
}
