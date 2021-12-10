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

}