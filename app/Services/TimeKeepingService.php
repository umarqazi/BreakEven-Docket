<?php


namespace App\Services;

use App\Repository\TimeKeepingRepository;

/**
 * Class TimeKeepingService
 * @package Services
 */
class TimeKeepingService
{
    /**
     * @var CompanyRepository
     */
    protected $db;
    protected $timekeeping_repo;
    protected $current_date_time;

    /**
     * TimeKeepingService constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->timekeeping_repo = new TimeKeepingRepository();
        $this->current_date_time = date('Y-m-d H:i:s', time());
    }
    public function createTimeIn($data){
        if (!empty($data['timekeeping_id'])) {
            $timekeeping_id = $data['timekeeping_id'];
            $data = array(
                'docket_id'     => $data['docket_id'],
                'employee_id'   => user_id(),
                'time_out'      => ($data['time_out'] == 'true') ? $this->current_date_time : '',
            );
            $activity_data = ['type'=> 9,'other_user_id'=>'','description' => json_encode(['docket_id'=> intval($data['docket_id'])])];
            insertActivity($activity_data);
            return $this->timekeeping_repo->update($timekeeping_id,$data);
        } else {
            $data = array(
                'docket_id'     => $data['docket_id'],
                'employee_id'   => user_id(),
                'time_in'       => ($data['time_in'] == 'true') ? $this->current_date_time : '',
                'time_out'      => ($data['time_out'] == 'true') ? $this->current_date_time : '',
            );
            $activity_data = ['type'=> 8,'other_user_id'=>'','description' => json_encode(['docket_id'=> intval($data['docket_id'])])];
            insertActivity($activity_data);
            return $this->timekeeping_repo->insert($data);
        }
    }
    public function createManualTimeIn($data){
        // dd($data);
        if (!empty($data['timekeeping_id'])) {
            $timekeeping_id = $data['timekeeping_id'];
            $update_data = array(
                'docket_id'     => $data['form_docket_id'],
                'employee_id'   => user_id(),
                'time_out'      => !empty($data['date']) ? date("Y-m-d H:i:s", strtotime($data['date'])) : '',
            );
            $activity_data = ['type'=> 11,'other_user_id'=>'','description' => json_encode(['docket_id'=> intval($data['form_docket_id'])])];
            insertActivity($activity_data);
            return $this->timekeeping_repo->update($timekeeping_id,$update_data);
        } else {
            $create_data = array(
                'docket_id'     => $data['form_docket_id'],
                'employee_id'   => user_id(),
                'time_out'      => '',
                'time_in'       => !empty($data['date']) ? date("Y-m-d H:i:s", strtotime($data['date'])) : '',
            );
            $activity_data = ['type'=> 10,'other_user_id'=>'','description' => json_encode(['docket_id'=> intval($data['form_docket_id'])])];
            insertActivity($activity_data);
            return $this->timekeeping_repo->insert($create_data);
        }
    }
    public function getTimekeepingByDocketId($docket_id)
    {
        $qry = "SELECT timekeepings.*, dockets.docket_no,if(timekeepings.time_out != '' ,TIMEDIFF(timekeepings.time_out, timekeepings.time_in),'') AS total_time, if(timekeepings.time_out != '', '',UNIX_TIMESTAMP(timekeepings.time_in)) AS timeIn_in_seconds
                FROM timekeepings 
                LEFT JOIN dockets ON timekeepings.docket_id = dockets.id
                WHERE timekeepings.docket_id = ? AND timekeepings.employee_id = ? ORDER BY timekeepings.id ASC";
        $dockets = $this->db->query($qry, [$docket_id,user_id()]);
        $result = $dockets->getResult('array');
        return !empty($result) ? $result : false;

    }
    public function checkTimeInOrOut($docket_id)
    {
        $qry = "SELECT timekeepings.*, dockets.docket_no
                FROM timekeepings 
                LEFT JOIN dockets ON timekeepings.docket_id = dockets.id
                WHERE timekeepings.docket_id = ? AND timekeepings.employee_id = ?
                ORDER BY timekeepings.id DESC LIMIT 1";
        $record = $this->db->query($qry, [$docket_id,user_id()]);
        $result = $record->getResult('array');
        return !empty($result) ? $result : false;
    }
    public function all(){
       return $this->timekeeping_repo->all();
    }
    public function show($id){
        return $this->timekeeping_repo->find($id);
    }
    public function delete($id){
        return $this->timekeeping_repo->delete($id);
    }

}
