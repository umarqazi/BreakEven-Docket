<?php


namespace App\Services;

use App\Repository\EmployeeRepository;
use App\Repository\DocketRepository;
use App\Repository\ReportsRepository;

/**
 * Class ReportsService
 * @package Services
 */
class ReportsService
{
    /**
     * @var CompanyRepository
     */

    protected $employee_repo;
    protected $activity_repo;
    protected $reports_repo;
    protected $docket_repo;
    protected $authorize;
    protected $db;

    /**
     * ReportsService constructor.
     */
    public function __construct()
    {
        $this->employee_repo = new EmployeeRepository;
        $this->docket_repo   = new DocketRepository;
        $this->reports_repo  = new ReportsRepository;
        $this->validation    = \Config\Services::validation();
        $this->authorize     = service('authorization');
        $this->db            = \Config\Database::connect();
    }
    public function reportsHomePage()
    {
        return view('dashboard/reports/reports');
    }
    public function timekeeping_report($filters)
    {
        $employees = $this->employee_repo->getAll();
        $dockets = $this->docket_repo->findAll();
        $logs = $this->reports_repo->getallTimeKeeping($filters);
        $sumOfWorkingTimeByDockets = $this->reports_repo->sumOfWorkingTimeByDockets();
        $show_remove_btn = false;
        if (!is_null($filters)) {
            $show_remove_btn = true;
        }
        return view('dashboard/reports/timekeeping_report',['validation'=>$this->validation,'logs'=>$logs,'sumOfWorkingTimeByDockets'=>$sumOfWorkingTimeByDockets,'dockets'=>$dockets,'employees'=>$employees,'show_remove_btn'=>$show_remove_btn,'filters'=>$filters]);
    }
}