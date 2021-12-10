<?php

namespace App\Repository;


use App\Models\ActivityModel;

/**
 * Class ActivityRepository
 * @package App\Http\Repository
 */
class ActivityRepository extends BaseRepo
{
    /**
     * ActivityRepository constructor.
     */
    protected $db;
    protected $current_date_time;

    public function __construct()
    {
        parent::__construct(ActivityModel::class);
        $this->current_date_time = date('Y-m-d H:i:s');
        $this->db = \Config\Database::connect();
    }
    public function getAllActivities()
    {
        $qry = "SELECT activities.*, CONCAT(users.first_name, ' ',users.last_name) AS user_name,
                CASE 
                WHEN activities.type = 3 THEN (SELECT CONCAT(users.first_name, ' ',users.last_name) FROM users WHERE users.id = SUBSTRING_INDEX(activities.description,'other_id\":',-1))
                WHEN activities.type = 4 THEN (SELECT CONCAT(users.first_name, ' ',users.last_name) FROM users WHERE users.id = SUBSTRING_INDEX(activities.description,'other_id\":',-1))
                    ELSE 'Nothing'
                END AS employees_name
                FROM activities, users
                WHERE activities.user_id = users.id AND users.company_id = ?
                ORDER BY activities.created_at DESC";

// SELECT activities.*, CONCAT(users.first_name, ' ',users.last_name) AS user_name, 
// CASE 
//   WHEN activities.type = 3 THEN (SELECT CONCAT(users.first_name, ' ',users.last_name) FROM users WHERE users.id = SUBSTRING_INDEX(activities.description,'other_id":',-1))
//   WHEN activities.type = 4 then 'other_user_name'
// 	ELSE 'Nothing'
// END AS other_user_name
// FROM activities, users
// WHERE activities.user_id = users.id AND users.company_id = 2
// ORDER BY activities.created_at DESC


        $data = $this->db->query($qry, [user()->company_id]);
        $result = $data->getResult('array');
        // dd($result);
        return !empty($result) ? $result : false;
    }
}
