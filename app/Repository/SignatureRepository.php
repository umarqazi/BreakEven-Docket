<?php

namespace App\Repository;

use App\Models\SignatureModel;

/**
 * Class SignatureRepository
 * @package App\Http\Repository
 */
class SignatureRepository extends BaseRepo
{
    /**
     * SignatureRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(SignatureModel::class);
    }
}
