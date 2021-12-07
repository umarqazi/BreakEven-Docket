<?php


namespace App\Services;

use App\Repository\ActivityRepository;
use App\Repository\DocketRepository;
use App\Repository\EmployeeRepository;

/**
 * Class ActivityService
 * @package Services
 */
class ActivityService
{
    /**
     * @var CompanyRepository
     */

    protected $employee_repo;
    protected $activity_repo;
    protected $docket_repo;

    /**
     * ActivityService constructor.
     */
    public function __construct()
    {
        $this->activity_repo = new ActivityRepository;
        $this->docket_repo   = new DocketRepository;
        $this->employee_repo = new EmployeeRepository;
        $this->validation    = \Config\Services::validation();
    }
    public function getallTimeKeepingLogs($filters)
    {
        $employees = $this->employee_repo->getAll();
        $dockets = $this->docket_repo->getAllDockets();
        $logs = $this->activity_repo->getallTimeKeepingLogs($filters);
        $show_remove_btn = false;
        if (!is_null($filters)) {
            $show_remove_btn = true;
        }
        return view('dashboard/activity/activity_details',['validation'=>$this->validation,'logs'=>$logs,'dockets'=>$dockets,'employees'=>$employees,'show_remove_btn'=>$show_remove_btn]);
    }

}