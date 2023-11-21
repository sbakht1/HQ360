<?php

namespace App\Models;

use CodeIgniter\Model;

class Meta extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'meta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["category","term","meta_key","meta_value"];

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


    public function get_meta($category,$term) {
        return $this->where(['category'=>$category,'term'=>$term])->findAll();
    }
    
    public function ticket_msg($ticket=false)
    {
        $this->db->connect();
        $builder = $this->db->table('meta as m');
        $builder->where(['meta_key'=>'message/'.$ticket,'category'=>'tickets']);
        $builder->join('employees as emp','m.term = emp.EmployeeID');
        $builder->select('emp.Employee_Name as employee,emp.EmployeeID, m.meta_value as message, m.created as time');
        $builder->orderBy('m.id','asc');
        return $builder->get()->getResultArray();
    }

    public function post_meta($cat,$key,$val) {
        return $this->insert(['category' => $cat,'term' => profile('EmployeeID'),'meta_key' => $key,'meta_value' => $val]);
    }

    public function find_data($cat,$key){
        return $this->where([
            'category' => $cat,
            'term' => profile('EmployeeID'),
            'meta_key' => $key
        ])->first();
    }

    public function with_term($cat,$key) {
        $this->db->connect();
        $b = $this->db->table('meta as m');
        $cols = "emp.Employee_Name, emp.EmployeeID,emp.Title,str.StoreName, str.DistrictName, m.created as acknowledged";
        if(!isset($_GET['export'])) {
            $cols .= ",empMeta.meta_value as image";
        }
        $b->where(['category'=>$cat,'m.meta_key'=>$key]);
        $b->select($cols);
        $b->join('employees as emp','m.term = emp.EmployeeID');
        $b->join('stores as str','emp.DefaultLocation = str.StoreID');
        $b->join('employee_meta as empMeta','empMeta.employee = emp.EmployeeID AND empMeta.meta_key="image" OR empMeta.meta_key="404-image"');
        $b->groupBy('m.term');
        $b->orderBy('m.id','desc');
        return $b->get()->getResultArray();
    }
}
