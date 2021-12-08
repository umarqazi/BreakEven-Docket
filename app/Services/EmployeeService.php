<?php


namespace App\Services;

use App\Repository\CompanyRepository;
use App\Repository\EmployeeRepository;
use App\Repository\UserRepository;

/**
 * Class EmployeeService
 * @package Services
 */
class EmployeeService
{
    /**
     * @var EmployeeRepository
     */
    protected $db;
    protected $user_repo;
    protected $validation;
    protected $employee_repo;
    /**
     * EmployeeService constructor.
     */
    public function __construct()
    {
        helper('date');
        date_default_timezone_set('Asia/Karachi');
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
        $this->employee_repo = new EmployeeRepository;
        $this->user_repo    = new UserRepository;
    }
    public function create($data,$user_id){
        $current_date = date('Y-m-d H:i:s');
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
        $result = $this->employee_repo->getAllEmployees();
        return view('dashboard/employees/employees', ['employees' => !empty($result) ? $result : false]);
    }
    
    public function getEmployee($seg1)
    {
        $record = $this->employee_repo->getEmployee($seg1);
        return view('dashboard/employees/employee_profile',['record' => $record]);
    }
    
    public function editEmployee($user_id)
    {
        $record = $this->employee_repo->editEmployee($user_id);
        return view('dashboard/employees/employee_edit',['record' => $record, 'validation'=>$this->validation]);
    }
    public function deleteEmployee($user_id = null)
    {
        $where_user = ['id' => $user_id];
        $where_emp = ['user_id' => $user_id];
        $this->user_repo->deleteWhere($where_user);
        $this->employee_repo->deleteWhere($where_emp);
        return redirect()->to(site_url('employee-center'))->with('message', 'Employee Deleted Successfully');

    }

}
