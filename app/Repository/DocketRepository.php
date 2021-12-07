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
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        parent::__construct(DocketModel::class);
    }
    public function getAllDockets()
    {
        $qry = 'SELECT dockets.*, concat(users.first_name," ",users.last_name) as user_name
                FROM dockets
                LEFT JOIN users ON dockets.added_by = users.id
                WHERE users.company_id = ?';

        $dockets = $this->db->query($qry, [user()->company_id]);
        $result = $dockets->getResult('array');
        return !empty($result) ? $result : false;
    }
}
