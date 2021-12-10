<?php

namespace App\Models;
use CodeIgniter\Model;
use \Tatter\Relations\Traits\ModelTrait;

class User extends Model
{
    protected $with                 = ['employees'];
    protected $DBGroup              = 'default';
    protected $table                = 'users';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields = [
        'email', 'username','first_name','last_name','phone','mobile','address','address1','zip','city','notes','user_type','profile_pic','invoice_signature','state','company_id','company_name','activation_code','token','display_name','is_verified','password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash', 'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at','is_super_admin'];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules = [
        // 'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        // 'username'      => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
        // 'password_hash' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function employee()
    {
        return $this->hasOne('employees', 'App\Models\EmployeeModel');
        // $this->hasOne('propertyName', 'model', 'foreign_key', 'local_key');
    }
}
