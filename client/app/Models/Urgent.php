<?php

namespace App\Models;

use CodeIgniter\Model;

class Urgent extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'urgents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "title","message","limit","author","updated_by","start","end","status"
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


    public function getAll(){
        
        $this->db->connect();
        $b = $this->db->table('urgents as ur');
        $b->orderBy('id', 'desc');
        $b->join('employees as ath', 'ath.EmployeeID = ur.author');
        $b->join('employees as upd','upd.EmployeeID = ur.updated_by');

        $b->select('ur.id,ur.title,ur.limit as type,ath.Employee_Name as author,upd.Employee_Name as updated_by,DATE_FORMAT(ur.created, "%Y-%m-%d") as created, DATE_FORMAT(ur.updated,"%Y-%m-%d") as updated,ur.start,ur.end,ur.status');
        return $b->get()->getResultArray();
    }

    public function getActive() {
        $limited = $this
        ->where(['status'=>'publish','limit !=' => 'limited'])
        ->select('id,title,message')
        ->findAll();

        $date = time();
        $not_limited = $this->where(
            [
                'status' => 'publish',
                'limit' => 'limited',
                'start <' => $date,
                'end >' => $date
            ]
        )->select('id,title,message')
        ->findAll();
        return array_merge($limited,$not_limited);
    }
}
