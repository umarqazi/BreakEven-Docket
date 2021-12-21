<?php

namespace App\Repository;

use App\Models\EmployeeModel;

/**
 * Class ReportsRepository
 * @package App\Http\Repository
 */
class ReportsRepository extends BaseRepo
{
    protected $db;
    /**
     * ReportsRepository constructor.
     */
    public function __construct()
    {
        // parent::__construct(EmployeeModel::class);
        $this->db = \Config\Database::connect();
    }
    public function getallTimeKeeping($filters)
    {
        // dd($filters);
        $this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $employee_id = isset($filters['employee_id']) ? " AND users.id = ".$filters['employee_id']." " : '';
        $docket_id   = isset($filters['docket_id']) ? " AND dockets.id = ".$filters['docket_id']." " : '';
        $time_in     = isset($filters['time_in']) ? " AND timekeepings.time_in LIKE '".$filters['time_in']."%' " : '';
        $time_out    = isset($filters['time_out']) ? " AND timekeepings.time_out LIKE '".$filters['time_out']."%' " : '';
        $qry = "SELECT timekeepings.*,dockets.docket_no,
                if(timekeepings.time_out != '' ,TIMEDIFF(timekeepings.time_out, timekeepings.time_in),'') 
                AS total_time, CONCAT(users.first_name, ' ',users.last_name) AS worked_by,
                    (SELECT CONCAT(users.first_name, ' ',users.last_name) 
                    FROM users 
                    WHERE dockets_to_employees.assignee_id = users.id ) AS assigned_by
                FROM timekeepings 
                LEFT JOIN dockets ON timekeepings.docket_id = dockets.id
                LEFT JOIN users ON timekeepings.employee_id = users.id
                LEFT JOIN dockets_to_employees ON  timekeepings.docket_id = dockets_to_employees.docket_id
                WHERE dockets_to_employees.assignee_id != timekeepings.employee_id AND users.company_id = ? 
                ".$employee_id.$docket_id.$time_in.$time_out."
                GROUP BY timekeepings.id ORDER BY timekeepings.id DESC";
        $logs = $this->db->query($qry,user()->company_id);
        $result = $logs->getResult('array');
        // dd($this->db->lastQuery);
        return !empty($result) ? $result : false;

    }
    public function sumOfWorkingTimeByDockets()
    {
        $qry = "SELECT if(timekeepings.time_out != '', SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(timekeepings.time_out, timekeepings.time_in)))),'')  AS total_time, timekeepings.docket_id,timekeepings.employee_id,CONCAT(users.first_name, ' ',users.last_name) AS worked_by,dockets.docket_no
                FROM timekeepings
                LEFT JOIN users ON timekeepings.employee_id = users.id
                LEFT JOIN dockets ON timekeepings.docket_id = dockets.id
                WHERE users.company_id = ?
                GROUP BY timekeepings.docket_id,timekeepings.employee_id
                ORDER BY timekeepings.id DESC";
        $logs = $this->db->query($qry,user()->company_id);
        $result = $logs->getResult('array');
        return !empty($result) ? $result : false;
    }
}
