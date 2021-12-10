<?php

namespace App\Repository;


use App\Models\CompanyModel;

/**
 * Class CompanyRepository
 * @package App\Http\Repository
 */
class CompanyRepository extends BaseRepo
{
    protected $db;
    /**
     * CompanyRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(CompanyModel::class);
        $this->db = \Config\Database::connect();
    }
    public function getCompanyWithUser($company_id = null)
    {
        if (empty($company_id)) {
            $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
            $qry = ' SELECT companies.*,users.email AS user_email,employees.user_id, employees.job_title
            FROM companies
            LEFT JOIN users ON companies.id = users.company_id
            LEFT JOIN employees ON users.id = employees.user_id
            GROUP BY companies.id';
            $data = $this->db->query($qry);
        } else {
            $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
            $qry = ' SELECT companies.*,users.email AS user_email,employees.user_id, employees.job_title
            FROM companies
            LEFT JOIN users ON companies.id = users.company_id
            LEFT JOIN employees ON users.id = employees.user_id
            where companies.id = ?
            GROUP BY companies.id';
            $data = $this->db->query($qry,[$company_id]);
        }
        $result = $data->getResult('array');
        return !empty($result) ? $result : false;
    }
}
