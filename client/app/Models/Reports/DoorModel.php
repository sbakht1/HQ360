<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\FileUpload;

class DoorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'doors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","name","file"];
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

    public function find_report($name,$date) {
        
        $files = new FileUpload();        
        $row = $this->where(['date'=> $date,'name'=> $name])->first();
        $path = 'uploads/'.$row['file'];
        $path = str_replace('.csv','',$path);
        return $files->get_csv($path);
    }

    public function get_by_month($name,$month){
        $this->db->connect();
        $b = $this->db->table('doors as d');
        $b->join('employees as emp', 'd.uploaded_by = emp.EmployeeID');
        $b->select('d.*,emp.Employee_Name');
        return $b->where('name',$name)->like('date',$month)->orderBy('date','DESC')->get()->getResult();
    }
}

