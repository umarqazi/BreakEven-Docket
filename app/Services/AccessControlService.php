<?php


namespace App\Services;

use App\Repository\EmployeeRepository;
use PhpParser\Node\Expr\Print_;

/**
 * Class AccessControlService
 * @package Services
 */
class AccessControlService
{
    /**
     * @var CompanyRepository
     */

    protected $employee_repo;
    protected $activity_repo;
    protected $docket_repo;
    protected $authorize;
    protected $db;

    /**
     * AccessControlService constructor.
     */
    public function __construct()
    {
        $this->employee_repo = new EmployeeRepository;
        $this->validation    = \Config\Services::validation();
        $this->authorize     = service('authorization');
        $this->db            = \Config\Database::connect();
    }
    public function accessControl()
    {
        $permissions = $this->authorize->permissions();
        $employees = $this->employee_repo->getAll();
        return view('dashboard/access_control/access_control',['employees'=>$employees,'permissions'=>$permissions,'authorize' => $this->authorize]);
    }
    public function addPermissions()
    {
        $permissions = $this->authorize->permissions();
        return view('dashboard/access_control/add_permissions',['permissions'=>$permissions]);
    }
    public function savePermission($data)
    {
        $permission_id = $this->authorize->createPermission($data['name'],$data['description']);
        return redirect()->to('add-permissions')->with('message','Permission Added!');
    }
    public function deletePermission($permission_id)
    {
        $permission_id = $this->authorize->deletePermission($permission_id);
        return redirect()->to('add-permissions')->with('message','Permission Deleted!');
    }
    public function assignPermissions($data)
    {
        // $this->authorize->removePermissionFromUser(5, 5);
        $delete = $this->db->table('auth_users_permissions')->where('user_id',$data['user_id'])->delete();
        if(!empty($data['permission_id'][0])){
            foreach ($data['permission_id'] as $key => $permission_id) {
                $this->authorize->addPermissionToUser($permission_id, $data['user_id']);
            }
            return redirect()->to('access-control')->with('message','Permissions Assigned!');
        }
        return redirect()->to('access-control');
    }
    public function getUserPermissions($id)
    {
        // dd($this->authorize->hasPermission(9,5));
        $user_id = $id['id'];
        $permissions = $this->authorize->permissions();
        foreach ($permissions as $key => $value) {
            $permissions[$key]['checked'] ='';
            if($this->authorize->hasPermission($value['id'],$user_id) == true ) {
                $permissions[$key]['checked'] ='checked';
            } else {
                $permissions[$key]['checked'] ='';
            }
        }
        // echo '<pre>';
        // print_r($permissions);
        // die;
        return json_encode($permissions);
    }
}