<?php

namespace App\Models;
use CodeIgniter\Model;
class EmployeeModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'employees';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['ss#','w4fed','w4state','hourly_rate','salary','user_id','job_title','parmissions','hire_rate','hire_date','release_date','birth_date','created_at','updated_at','deleted_at'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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
    public function user()
    {
        return $this->belongsTo('users', 'App\Models\User');
        // $this->belongsTo('propertyName', 'model', 'foreign_key', 'owner_key');
    }
}
