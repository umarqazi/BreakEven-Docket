<?php


namespace App\Services;

use App\Repository\CompanyRepository;
use App\Repository\EmployeeRepository;

/**
 * Class EmployeeService
 * @package Services
 */
class EmployeeService
{
    /**
     * @var EmployeeRepository
     */
    protected $employee_repo;
    protected $db;

    /**
     * EmployeeService constructor.
     */
    public function __construct()
    {
        helper('date');
        $this->db = \Config\Database::connect();
        $this->employee_repo = new EmployeeRepository;
    }
    public function create($data,$user_id){
        $current_date = date('Y-m-d H:i:s', time());
        $company = array(
            'ss#'          => !empty($data['ss#'])          ? $data['ss#'] : '',
            'w4fed'        => !empty($data['w4fed'])        ? $data['w4fed'] : '',
            'w4state'      => !empty($data['w4state'])      ? $data['w4state'] : '',
            'hourly_rate'  => !empty($data['hourly_rate'])  ? $data['hourly_rate'] : '',
            'salary'       => !empty($data['salary'])       ? $data['salary'] : '',
            'user_id'      => !empty($user_id)              ? $user_id : '',
            'job_title'    => !empty($data['job_title'])    ? $data['job_title'] : '',
            'permissions'  => !empty($data['permissions'])  ? $data['permissions'] : '',
            'hourly_rate'  => !empty($data['hourly_rate'])  ? $data['hourly_rate'] : '',
            'release_date' => !empty($data['release_date']) ? date('Y-m-d H:i:s', strtotime($data['release_date'])) : '',
            'hire_date'    => !empty($data['hire_date'])    ?  date('Y-m-d H:i:s', strtotime($data['hire_date'])) : '',
            'birth_date'   => !empty($data['birth_date'])   ? date('Y-m-d H:i:s', strtotime($data['birth_date'])) : '',
            'created_at'   => $current_date,
            'updated_at'   => $current_date,
        );
        if (isset($data['user_id']) && $data['user_id'] > 0) {
            $company['updated_at'] = $current_date;
            $company['user_id'] = $data['user_id'];
            $result = $this->employee_repo->update($data['employee_id'],$company);
            return $result;
        } else {
            $result = $this->employee_repo->insert($company);
            return $result;
        }
    }
    public function findAll()
    {
       return $this->employee_repo->findAll();
    }
    public function findAllWithWhere($param)
    {
        return $this->employee_repo->findAllWithWhere($param);
    }
    public function show($id)
    {
        return $this->employee_repo->find($id);
    }
    public function delete($id)
    {
        return $this->employee_repo->delete($id);
    }
    public function deleteWhere($where)
    {
        return $this->employee_repo->deleteWhere($where);
    }
    public function getAllEmployees()
    {
        $qry = 'SELECT employees.*, users.*,concat(users.first_name," ",users.last_name) as user_name
                FROM employees
                LEFT JOIN users ON employees.user_id = users.id
                WHERE users.company_id = ? AND users.user_type = ? AND employees.user_id != ? ';

        $employees = $this->db->query($qry, [user()->company_id,'employee',user_id()]);
        $result = $employees->getResult('array');
        return !empty($result) ? $result : false;
    }

}
