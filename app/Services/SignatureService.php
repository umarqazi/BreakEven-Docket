<?php


namespace App\Services;
use App\Repository\SignatureRepository;

/**
 * Class SignatureService
 * @package Services
 */
class SignatureService
{
    /**
     * @var SignatureRepository
     */
    protected $signature_repo;
    protected $validation;
    protected $db;

    /**
     * SignatureService constructor.
     */
    public function __construct()
    {
        helper('date');
        date_default_timezone_set('Asia/Karachi');
        $this->db               = \Config\Database::connect();
        $this->validation       =  \Config\Services::validation();
        $this->signature_repo        = new SignatureRepository();
    }
    public function create($data)
    {
        $data['user_id'] = user_id();
        return $this->signature_repo->insert($data);
    }
    public function update($signature_id,$data)
    {
        $data['user_id'] = user_id();
        return $this->signature_repo->update($signature_id,$data);
    }
    public function findAll()
    {
       return $this->signature_repo->findAll();
    }
    public function show($id)
    {
        return $this->signature_repo->find($id);
    }
    public function delete($id)
    {
        return $this->signature_repo->delete($id);
    }
}
