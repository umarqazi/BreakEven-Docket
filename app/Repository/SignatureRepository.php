<?php

namespace App\Repository;

use App\Models\Signature;

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
        parent::__construct(Signature::class);
    }
}
