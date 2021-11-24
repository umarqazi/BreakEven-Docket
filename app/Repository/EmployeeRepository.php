<?php

namespace App\Repository;

use App\Models\EmployeeModel;

/**
 * Class EmployeeRepository
 * @package App\Http\Repository
 */
class EmployeeRepository extends BaseRepo
{
    protected $db;
    /**
     * EmployeeRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(EmployeeModel::class);
        $this->db = \Config\Database::connect();
    }
    public function getAllEmployees()
    {
        $qry = 'SELECT employees.*, users.*,concat(users.first_name," ",users.last_name) as user_name
                FROM employees
                LEFT JOIN users ON employees.user_id = users.id
                WHERE users.company_id = ? AND users.user_type = ? AND employees.user_id != ? ';

        $employees = $this->db->query($qry, [user()->company_id, 'employee', user_id()]);
        $result = $employees->getResult('array');
        return !empty($result) ? $result : false;
    }
    public function getEmployee($seg1)
    {
        $qry = 'SELECT employees.*, users.*
                FROM employees
                LEFT JOIN users ON employees.user_id = users.id
                WHERE users.company_id = ? AND users.user_type = ? AND users.id = ? ';

        $record = $this->db->query($qry, [user()->company_id,'employee',$seg1]);
        return $record->getRow();
    }
    public function editEmployee($user_id)
    {
        $qry = 'SELECT employees.*, users.*,employees.id as employee_id
                FROM employees
                LEFT JOIN users ON employees.user_id = users.id
                WHERE users.company_id = ? AND users.user_type = ? AND users.id = ? ';
        $record = $this->db->query($qry, [user()->company_id,'employee',$user_id]);
        return $record->getRow();
    }
}
