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
        $qry = "SELECT activities.*, CONCAT(USR.first_name, ' ',USR.last_name) AS user_name
                , CONCAT(EMP.first_name, ' ',EMP.last_name) AS employee_name,dockets.docket_no
                FROM activities
                LEFT JOIN users as USR ON USR.id = activities.user_id
                LEFT JOIN users as EMP ON EMP.id = activities.other_user_id
                LEFT JOIN dockets ON dockets.id = SUBSTRING_INDEX(activities.description,'docket_id\":',-1)
                where USR.company_id = ?
                ORDER BY activities.created_at DESC";

// $qry = "SELECT activities.*, CONCAT(users.first_name, ' ',users.last_name) AS user_name,
// CASE 
// WHEN activities.type = 3 THEN (SELECT CONCAT(users.first_name, ' ',users.last_name) FROM users WHERE users.id = SUBSTRING_INDEX(activities.description,'other_id\":',-1))
// WHEN activities.type = 4 THEN (SELECT CONCAT(users.first_name, ' ',users.last_name) FROM users WHERE users.id = SUBSTRING_INDEX(activities.description,'other_id\":',-1))
// WHEN activities.type = 7 THEN (SELECT CONCAT(users.first_name, ' ',users.last_name) FROM users,activities WHERE users.id = activities.other_user_id)
//     ELSE 'Nothing'
// END AS employees_name
// FROM activities, users
// WHERE activities.user_id = users.id AND users.company_id = ?
// ORDER BY activities.created_at DESC";


        $data = $this->db->query($qry, [user()->company_id]);
        $result = $data->getResult('array');
        // dd($result);
        return !empty($result) ? $result : false;
    }
}
