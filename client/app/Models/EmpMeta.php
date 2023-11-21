<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpMeta extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employee_meta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee','meta_key','meta_value'];

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

    public function value($emp,$key) {
        $data = $this->where(['employee'=> $emp,'meta_key'=> $key])->first();
        if ($key ==='image' && !$data) $data = $this->where(['meta_key'=>'404-image'])->first();
        return (!$data) ? "" : $data['meta_value'];
    }

    public function set_meta($emp,$key,$val) {
        $find = $this->where(['employee' => $emp,'meta_key'=>$key])->first();
        if ( !$find ) {
            $this->insert([
                "employee" => $emp,
                "meta_key" => $key,
                "meta_value" => $val
            ]);
        } else {
            $this->update($find['id'], ['meta_value'=>$val]);
        }
        return true;
    }

    public function read_notes(){
       return $data = $this->where(['employee'=> profile('EmployeeID'),'meta_value'=> 'read'])->get()->getResultArray(); 
    }

  
}
