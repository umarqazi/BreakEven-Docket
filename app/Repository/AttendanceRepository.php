<?php

namespace App\Repository;


use App\Models\AttendanceModel;

/**
 * Class AttendanceRepository
 * @package App\Repository
 */
class AttendanceRepository extends BaseRepo
{
    /**
     * AttendanceRepository constructor.
     */
    protected $db;
    protected $current_date_time;


    public function __construct()
    {
        $this->current_date_time    = date('Y-m-d H:i:s');
        $this->db                   = \Config\Database::connect();
        parent::__construct(AttendanceModel::class);
    }
    public function getPresence($user_id)
    {
        $qry = "SELECT attendances.* ,if(attendances.check_out != '' ,TIMEDIFF(attendances.check_out, attendances.check_in),'') 
                AS total_time
                FROM attendances
                WHERE attendances.user_id = ?
                ORDER BY attendances.id DESC LIMIT 1";
        $data   = $this->db->query($qry,[$user_id]);
        $result = $data->getResult('array');
        return !empty($result) ? $result[0] : false;
    }
    
}
