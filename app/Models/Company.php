<?php

namespace App\Models;

use CodeIgniter\Model;

class Company extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'companies';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['company_name','company_owner','address','phone','fax','email','company_website','company_logo','credit_card_no','expiry_date','cvv','card_address','subscription_start_date','subscription_plan_id','plan_agreement_id','renew_date','renew_cost','total_users','is_enabled','city','state','zip','is_paid','company_abbreveation','client'];

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
}
