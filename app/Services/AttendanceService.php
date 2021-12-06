<?php


namespace App\Services;

use App\Repository\ActivityRepository;
use App\Repository\AttendanceRepository;
use App\Repository\DocketRepository;
use App\Repository\EmployeeRepository;
use DateTime;

/**
 * Class AttendanceService
 * @package Services
 */
class AttendanceService
{
    /**
     * @var CompanyRepository
     */

    protected $attendance_repo;
    protected $employee_repo;
    protected $activity_repo;
    protected $docket_repo;
    protected $user_id;

    /**
     * AttendanceService constructor.
     */
    public function __construct()
    {
        $this->user_id          = user_id();
        $this->activity_repo    = new ActivityRepository;
        $this->docket_repo      = new DocketRepository;
        $this->employee_repo    = new EmployeeRepository;
        $this->attendance_repo  = new AttendanceRepository;
        $this->validation       = \Config\Services::validation();
    }
    public function index()
    {
        $data = $this->attendance_repo->getPresence(['user_id' => $this->user_id]);
        // dd($data);
        $today = date('Y-m-d');
        $data['today_report'] = false;
        $data['records'] = false;
        if (($data != false) && !empty($data['check_in']) && !empty($data['check_out']) && (date('Y-m-d') == date('Y-m-d', strtotime($data['check_in'])) )){
            $data['today_report'] = true;
            $breaks = json_decode($data['break']);
            $resumes = json_decode($data['resume']);
            $break_time_hours = 0.0;
            $seconds_to_minuts = 0;
            foreach ($breaks as $key => $value) {
                $a = new DateTime($breaks[$key]);
                $b = new DateTime($resumes[$key]);
                $interval = $a->diff($b);
                // $val = $interval->format("%h:%i:%s");
                $minutes = $interval->days * 24 * 60;
                $minutes += $interval->h * 60;
                $minutes += $interval->i;
                $seconds_to_minuts += $interval->s;
                $break_time_hours += $minutes;
            }
            $break_time_hours += floor($seconds_to_minuts / 60);
            $data['hours_to_time'] = $this->hoursToTime($break_time_hours);
            $aa = new DateTime($data['total_time']);
            $bb = new DateTime($data['hours_to_time']['time_string']);
            $interval = $aa->diff($bb);
            $total_working_time = $interval->format("%H").':'.$interval->format("%i").':'.$interval->format("%s");
            $data['total_working_time'] = $total_working_time;
            
        } else if($data == false){
            $data['records'] = true;
        } else {
            $data['records'] = true;
        }
        return view('dashboard/attendance/attendance',['data' => $data,'today' => $today]);
    }
    public function hoursToTime($break)
    {
        $break_time = '';
        if ($break > 60){
            $hours = floor($break / 60);
            $minutes = $break % 60;
            if ($hours){
                $break_time .= ($hours>1 ? ($hours.' Hours ') : ($hours.' Hour '));
            }
            if ($hours && $minutes){
                $break_time .= 'and ';
            }
            if ($minutes){
                $break_time .= ($minutes>1 ? ($minutes.' Minutes') : ($minutes.' Minute'));
            }
            $report['break_time'] = $break_time;
            $report['time_string'] = $hours.':'.$minutes.':00';
        } else if ($break == 60){
            $hours = 1;
            $report['break_time'] = $hours.' Hour';
            $report['time_string'] = $hours.':00:00';
        } else{
            $report['break_time'] = $break.' Minutes';
            $report['time_string'] = '00:'.$break.':00';
        }
        return $report;
    }
    public function checkin()
    {
        $data = array('user_id' => $this->user_id, 'check_in' => date("Y-m-d H:i:s"));
        return $this->attendance_repo->insert($data);
    }
    public function checkout($id)
    {
        $data = array('check_out' => date("Y-m-d H:i:s"));
        return $this->attendance_repo->update($id,$data);
    }
    public function break($id)
    {
        $breaks = $this->attendance_repo->find($id);
        $current_time = date("Y-m-d H:i:s");
        if (empty($breaks['break'])) {
            $break_data = json_encode(array($current_time));
        } else {
            $break_array = json_decode($breaks['break']);
            array_push($break_array, $current_time);
            $break_data = json_encode($break_array);
        }
        $data = array('break' => $break_data, 'on_break' => 1);
        return $this->attendance_repo->update($id,$data);
    }
    public function resume($id)
    {
        $resume = $this->attendance_repo->find($id);
        $current_time = date("Y-m-d H:i:s");
        if (empty($resume['resume'])) {
            $break_data = json_encode(array($current_time));
        } else {
            $resume_array = json_decode($resume['resume']);
            array_push($resume_array, $current_time);
            $break_data = json_encode($resume_array);
        }
        $data = array('resume' => $break_data, 'on_break' => 0);
        return $this->attendance_repo->update($id,$data);
    }

}