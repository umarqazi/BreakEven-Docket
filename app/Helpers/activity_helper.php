<?php

use App\Repository\ActivityRepository;

if(!function_exists('activityLogArray')){
    function activityLogArray(){
        return array(
         1 => 'user-logged-in',         ////
         2 => 'user-logged-out',        ////
         3 => 'employee-add',           ////
         4 => 'employee-update',        ////
         5 => 'employee-delete',
         6 => 'Docekt-create',
         7 => 'Docket-assigned',
         8 => 'worked-on-docket',
         9 => 'assigned-permissions',
         10 => 'attendance-time-in',
         11 => 'gone-on-break',
         12 => 'attendance-time-out',
         13 => 'update-company',
         14 => 'suspend-company',
         15 => 'employee-varified',
         16 => 'viewed-report',
         17 => 'saved-signature',
         18 => 'update-signature',
         19 => 'update-mail-signature'
        );
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