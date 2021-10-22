<?php


namespace App\Services;
use App\Controllers\AuthController;
use App\Entities\User as EntitiesUser;
use App\Models\User;
use App\Repository\UserRepository;
use CodeIgniter\HTTP;
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

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        helper('date');
        $this->user_repo = new UserRepository();
        $this->validation =  \Config\Services::validation();
    }
    public function create($data,$company_id=null)
    {
        $current_date = date('Y-m-d H:i:s', time());
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
                // dd($user);
                $result = $this->user_repo->insert($user);
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


}
