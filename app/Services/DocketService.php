<?php


namespace App\Services;

use App\Repository\DocketRepository;
use App\Repository\AssignDocketRepository;

/**
 * Class DocketService
 * @package Services
 */
class DocketService
{
    /**
     * @var CompanyRepository
     */
    protected $db;
    protected $docket_repo;
    protected $assigndocket_repo;

    /**
     * DocketService constructor.
     */
    public function __construct()
    {
        helper('date');
        $this->db = \Config\Database::connect();
        $this->docket_repo = new DocketRepository();
        $this->assigndocket_repo = new AssignDocketRepository();
    }
    public function create($data){
        $current_date = date('Y-m-d H:i:s', time());
        $data = array(
            'docket_no' => $data['docket_no'],
            'added_by'  => user_id(),
            'created_at'  => $current_date,
        );
       $result = $this->docket_repo->insert($data);
       return $result;
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
    public function getDocketById($docket_id)
    {
        $qry = 'SELECT dockets.*, concat(users.first_name," ",users.last_name) as user_name
                FROM dockets
                LEFT JOIN users ON dockets.added_by = users.id
                WHERE users.company_id = ? AND dockets.id = ?';
        $dockets = $this->db->query($qry, [user()->company_id,$docket_id]);
        $result = $dockets->getResult('array');
        return !empty($result) ? $result : false;
    }
    public function getDocketAssignedToEmployeesByDocketId($docket_id)
    {
        $qry = 'SELECT dockets_to_employees.id AS dockets_to_employees_id,dockets_to_employees.employee_id ,dockets.docket_no,(SELECT concat(users.first_name," ",
                users.last_name) as user_name FROM users WHERE users.id = dockets_to_employees.employee_id ) 
                AS employee_name,concat(users.first_name," ",users.last_name) as assigned_by, dockets_to_employees.created_at as assigned_at
                FROM dockets_to_employees
                LEFT JOIN users ON dockets_to_employees.assignee_id = users.id
                LEFT JOIN dockets ON dockets_to_employees.docket_id = dockets.id
                WHERE users.company_id = ? AND dockets.id = ?
                order by dockets_to_employees.id Desc';
        $dockets = $this->db->query($qry, [user()->company_id,$docket_id]);
        $result = $dockets->getResult('array');
        return !empty($result) ? $result : false;
    }
    public function getDocketByEmployeeId()
    {
        $qry = 'SELECT dockets_to_employees.id AS dockets_to_employees_id,dockets_to_employees.employee_id ,dockets.id as docket_id,dockets.docket_no,(SELECT concat(users.first_name," ",
                users.last_name) as user_name FROM users WHERE users.id = dockets_to_employees.employee_id ) 
                AS employee_name,concat(users.first_name," ",users.last_name) as assigned_by, dockets_to_employees.created_at as assigned_at
                FROM dockets_to_employees
                LEFT JOIN users ON dockets_to_employees.assignee_id = users.id
                LEFT JOIN dockets ON dockets_to_employees.docket_id = dockets.id
                WHERE users.company_id = ? AND dockets_to_employees.employee_id = ?
                order by dockets_to_employees.created_at Desc';
        $dockets = $this->db->query($qry, [user()->company_id,user_id()]);
        $result = $dockets->getResult('array');
        return !empty($result) ? $result : false;
    }
    public function assignDocket($data)
    {
        $current_date = date('Y-m-d H:i:s', time());
        $data = array(
            'docket_id' => $data['docket_id'],
            'employee_id' => $data['employee_id'],
            'assignee_id'  => user_id(),
            'created_at'  => $current_date,
        );
       $result = $this->assigndocket_repo->insert($data);
       return $result;
    }
    public function all()
    {
       return $this->docket_repo->all();
    }
    public function show($id)
    {
        return $this->docket_repo->find($id);
    }
    public function delete($id)
    {
        return $this->docket_repo->delete($id);
    }

}
