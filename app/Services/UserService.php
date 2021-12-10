<?php


namespace App\Services;
use App\Controllers\AuthController;
use App\Entities\User as EntitiesUser;
use App\Models\User;
use App\Repository\UserRepository;
use App\Services\EmailService as ServicesEmailService;
use App\Services\EmployeeService;
use CodeIgniter\HTTP;
use EmailService;
use Myth\Auth\Password;

/**
 * Class UserService
 * @package Services
 */
class UserService
{
    /**
     * @var UserRepository
     */
    protected $user_repo;
    protected $validation;
    protected $email_service;
    protected $employee_service;
    protected $db;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        helper('date');
        date_default_timezone_set('Asia/Karachi');
        $this->db               = \Config\Database::connect();
        $this->validation       =  \Config\Services::validation();
        $this->user_repo        = new UserRepository();
        $this->email_service    = new ServicesEmailService();
        $this->employee_service = new EmployeeService();
    }
    public function create($data,$company_id=null,$is_company=null) //create and update user/employee here
    {
        $current_date = date('Y-m-d H:i:s');
        $user = array(
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'username'      => $data['first_name'].$data['last_name'],
            'email'         => $data['email'],
            'phone'         => !empty($data['phone']) ? $data['phone'] : '',
            'notes'         => !empty($data['notes']) ? $data['notes'] : '',
            'address'       => !empty($data['address']) ? $data['address'] : '',
            'city'          => !empty($data['city']) ? $data['city'] : '',
            'state'         => !empty($data['state']) ? $data['state'] : '',
            'zip'           => !empty($data['zip']) ? $data['zip'] : '',
            'password_hash' => !empty($data['password']) ? Password::hash($data['password']) : null,
            'user_type'     => $data['user_type'] ? $data['user_type'] : 'employee',
            'mobile'        => $data['mobile'],
            'company_id'    => $company_id,
            'is_verified'   => 1,
            'is_enabled'    => 1
        );
        if (isset($data['user_id']) && $data['user_id'] > 0) {
            $user['updated_at'] = $current_date;
            $result = $this->user_repo->update($data['user_id'],$user);
            return $result;
        } else {
            if (isset($data['create_employee'])) {
                $user['created_at'] = $current_date;
                $user['updated_at'] = $current_date;
                $result = $this->user_repo->insert($user);
                if ($result) {
                    //send email here
                    $user['user_id'] = $result;
                    $activation_code = substr(md5(mt_rand()), 0, 30);
                    $this->email_service->send_varification_mail($user,$activation_code);
                }
                //update activation code here
                $id = $result;
                $data = ['activation_code' => $activation_code ];
                $this->user_repo->update($id,$data);
                return $result;
            } else {
                if(isset($data['is_super_admin']) && $data['is_super_admin'] == 1)
                {
                    $user['is_super_admin'] = 1;
                }
                $users = model(UserModel::class);
                if(!$users->save($user))
                {
                    return redirect()->back()->withInput()->with('errors', $users->errors());
                } else {
                    if ($is_company == true) {
                        $returnData['user_id'] = $users->insertID;
                        $returnData['response'] = redirect()->to(site_url('login'))->withCookies()->with('message', 'User Registerd Successfully!');
                        return $returnData;
                    }
                    return redirect()->to(site_url('login'))->withCookies()->with('message', 'User Registerd Successfully!');
                }
            }
        }
    }
    public function all()
    {
       return $this->user_repo->all();
    }
    public function show($id)
    {
        return $this->user_repo->find($id);
    }
    public function delete($id)
    {
        return $this->user_repo->delete($id);
    }
    public function findAllWithWhere($param)
    {
        return $this->user_repo->findAllWithWhere($param);
    }
    public function deleteWhere($where)
    {
        return $this->user_repo->deleteWhere($where);
    }
    public function findByClause($where)
    {
        return $this->user_repo->findByClause($where);
    }
    public function validateUser($user_id,$code)
    {
        $user = $this->user_repo->find($user_id);
        if ($code == $user['activation_code']) {
            return $user;
        } else {
            return false;
        }
    }
    public function set_password($id,$data)
    {
        $data['password_hash'] = Password::hash($data['password']);
        return $this->user_repo->update($id,$data);
    }


}
