<?php


namespace App\Services;

/**
 * Class ActivityService
 * @package Services
 */
class ActivityService
{
    /**
     * @var CompanyRepository
     */
    protected $db;
    protected $current_date_time;

    /**
     * ActivityService constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->current_date_time = date('Y-m-d H:i:s');
    }
    public function getallTimeKeepingLogs()
    {
        $qry = "SELECT timekeepings.*,dockets.docket_no,
                if(timekeepings.time_out != '' ,TIMEDIFF(timekeepings.time_out, timekeepings.time_in),'') 
                AS total_time, CONCAT(users.first_name, ' ',users.last_name) AS worked_by,
                    (SELECT CONCAT(users.first_name, ' ',users.last_name) 
                    from users WHERE dockets_to_employees.assignee_id = users.id ) AS assigned_by
                FROM timekeepings 
                LEFT JOIN dockets ON timekeepings.docket_id = dockets.id
                LEFT JOIN users ON timekeepings.employee_id = users.id
                LEFT JOIN dockets_to_employees ON  timekeepings.docket_id = dockets_to_employees.docket_id
                WHERE dockets_to_employees.assignee_id != timekeepings.employee_id AND users.company_id = ?
                GROUP BY timekeepings.id
                ORDER BY timekeepings.id DESC";
                // dd($qry);
        $logs = $this->db->query($qry,user()->company_id);
        $result = $logs->getResult('array');
        return !empty($result) ? $result : false;

    }

}