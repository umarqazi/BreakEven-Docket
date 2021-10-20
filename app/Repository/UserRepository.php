<?php

namespace App\Repository;


use App\Models\User;

/**
 * Class UserRepository
 * @package App\Http\Repository
 */
class UserRepository extends BaseRepo
{
    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(User::class);
    }
}
