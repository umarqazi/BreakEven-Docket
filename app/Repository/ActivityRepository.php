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
    public function getAllActivities($filters)
    {
        $employee_id = isset($filters['employee_id']) ? " AND USR.id = ".$filters['employee_id']." " : '';
        $created_at_from = (isset($filters['date_from']) && $filters['date_from'] != '' ) ? " AND DATE(activities.created_at) >= DATE('".$filters['date_from']."') " : '';
        $created_at_to   = (isset($filters['date_to'])   && $filters['date_to'] != '' ) ? "   AND DATE(activities.created_at) <= DATE('".$filters['date_to']."') " : '';
        $qry = "SELECT activities.*, CONCAT(USR.first_name, ' ',USR.last_name) AS user_name
                , CONCAT(EMP.first_name, ' ',EMP.last_name) AS employee_name,dockets.docket_no
                FROM activities
                LEFT JOIN users as USR ON USR.id = activities.user_id
                LEFT JOIN users as EMP ON EMP.id = activities.other_user_id
                LEFT JOIN dockets ON dockets.id = SUBSTRING_INDEX(activities.description,'docket_id\":',-1)
                where USR.company_id = ? "
                .$employee_id.$created_at_from.$created_at_to. 
                "ORDER BY activities.created_at DESC";
        $data = $this->db->query($qry, [user()->company_id]);
        $result = $data->getResult('array');
        // dd($this->db->getLastQuery());
        return !empty($result) ? $result : false;
    }
}
