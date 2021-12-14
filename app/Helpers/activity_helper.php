<?php

use App\Repository\ActivityRepository;

if(!function_exists('activityLogArray')){
    function activityLogArray(){
        return array(
         1 => 'user-logged-in',         ////
         2 => 'user-logged-out',        ////
         3 => 'employee-add',           ////
         4 => 'employee-update',        ////
         5 => 'employee-delete',        ////
         6 => 'Docekt-create',          ////
         7 => 'Docket-assigned',        ////
         8 => 'worked-on-docket',       ////
         9 => 'time-out-from-docket',   ////
         10 => 'time-in-from-docket-manually',   ////
         11 => 'time-out-from-docket-manually',   ////
         12 => 'changed-permissions',   ////
         13 => 'attendance-time-in',    ////
         14 => 'attendance-time-out',   ////
         15 => 'gone-on-break',         ////
         16 => 'resume-break',          ////
         17 => 'update-company',        ////
         18 => 'suspend-company',       ////
         19 => 'suspend-company-by-admin',       ////
         20 => 'admin-enabled-company', ////
         21 => 'employee-varified',     ////
         22 => 'saved-updated-signature',       ////
         23 => 'update-mail-signature'  ////
        );
    }
}
if(!function_exists('getMatchingId')){
    function getMatchingId($index){
        $matchedIds =  array(
         'user-logged-in'          => '',
         'user-logged-out'         => '',
         'employee-add'            => 'employee_id',
         'employee-update'         => 'employee_id',
         'employee-delete'         => 'employee_id',
         'Docekt-create'           => 'docket_id',
         'Docket-assigned'         => 'docket_id',
         'worked-on-docket'        => 'docket_id',
         'assigned-permissions'    => 'permission_id',
         'attendance-time-in'      => '',
         'gone-on-break'           => '',
         'attendance-time-out'     => '',
         'update-company'          => 'company_id',
         'suspend-company'         => 'company_id',
         'employee-varified'       => '',
         'viewed-report'           => '',
         'saved-signature'         => '',
         'update-signature'        => '',
         'update-mail-signature'   => ''
        );
        return $matchedIds[$index];
    }
}
if(!function_exists('insertActivity')){
    function insertActivity($data = null)
    {
        date_default_timezone_set('Asia/Karachi');
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //Checking IP From Shared Internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //To Check IP is Pass From Proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $data['ip_address'] = $ip;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['user_id'] = empty($data['user_id']) ? user_id() : $data['user_id'];
        $activity_repo = new ActivityRepository;
        return $activity_repo->insert($data);
    }
}