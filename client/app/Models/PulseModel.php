<?php

namespace App\Models;

use CodeIgniter\Model;

class PulseModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pulses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["employee", "feeling","happiness"];

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

    public function find_all(){
        $month = (@$_GET['month']) ? $_GET['month'] : date('Y-m');
        $this->db->connect();
        $db = $this->db->table('pulses as p')
              ->like('p.created',$month)
              ->select('p.id,avg(p.happiness) as happiness,avg(p.feeling) as feeling,DATE_FORMAT(p.created,"%Y-%m-%d") as date,emp.Employee_Name,str.StoreName,str.DistrictName')
              ->join('employees as emp',"emp.EmployeeID = p.employee")
              ->join('stores as str','emp.DefaultLocation = str.StoreID OR emp.DefaultLocation=""')
              ->groupBy('p.employee')
              ->orderBy('str.DistrictName','ASC')
              ->get()
              ->getResultArray();
        foreach($db as $i => $d) {
            $db[$i]['happiness'] = round(floatval($d['happiness']),2);
            $db[$i]['feeling'] = round(floatval($d['feeling']),2);
        }
        return $db;
    }
}
