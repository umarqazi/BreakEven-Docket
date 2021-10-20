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
        $this->user_repo = new UserRepository();
        $this->validation =  \Config\Services::validation();
    }
    public function create($data,$company_id=null)
    {

        $user = array(
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'username'      => $data['first_name'].$data['last_name'],
            'email'         => $data['email'],
            'password_hash' => Password::hash($data['password']),
            'user_type'     => $data['user_type'] ? $data['user_type'] : 'employee',
            'mobile'        => $data['mobile'],
            'company_id'    => $company_id,
            'is_verified'   => 1,
            'is_enabled'    => 1
        );
        if(isset($data['is_super_admin']) && $data['is_super_admin'] == 1)
        {
            $user['is_super_admin'] = 1;
        }
        $users = model(UserModel::class);
        if(!$users->save($user))
        {
			return redirect()->back()->withInput()->with('errors', $users->errors());
        } else {
            $redirectURL = site_url('login');
            return redirect()->to($redirectURL)->withCookies()->with('message', 'User Registerd Successfully!');
        }

    //    $result = $this->user_repo->insert($user);
    //    return $result;
    }
    public function all(){
       return $this->user_repo->all();
    }
    public function show($id){
        return $this->user_repo->find($id);
    }
    public function delete($id){
        return $this->user_repo->delete($id);
    }

}
