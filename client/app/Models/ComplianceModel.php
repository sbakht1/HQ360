<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplianceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'compliance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "name",
        "attuid",
        "job_role",
        "hire_date",
        "location",
        "dealer_code",
        "master_dealer",
        "region",
        "market",
        "training_section",
        "course_code",
        "course_name",
        "course_status"
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function ple_compliance() {
        $this->db->connect();
        $builder = $this->db->table('compliance as com');
        $builder->orderBy('id','DESC');
        $builder->select('emp.Username, emp.Employee_Name as Employee,com.*, COUNT(com.ATTUID) as Total');
        $builder->join('employees as emp', 'emp.UID = com.ATTUID');
        $builder->groupBy('com.ATTUID');
        return $builder->get()->getResult();
    }

    public function find_course($UID) {
        return $this->where('ATTUID',$UID)->findAll();
    }

    
}
