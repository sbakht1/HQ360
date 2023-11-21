<?php

namespace App\Models;

use CodeIgniter\Model;

class Card extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["employee","data","updated_by"];

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

    public function getCards() {
        $this->db->connect();
        $builder = $this->db->table('cards as c');
        $builder->orderBy('c.updated','DESC');
        $builder->select('c.id,c.data,e.Employee_Name,s.StoreName,s.DistrictName,DATE_FORMAT(c.updated,"%Y-%m-%d") as updated');
        $builder->join('employees as e', 'e.EmployeeID = c.employee');
        $builder->join('stores as s', 'e.DefaultLocation = s.StoreID');
        return $builder->get()->getResult();
    }
}
