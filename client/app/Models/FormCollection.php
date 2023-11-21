<?php

namespace App\Models;

use CodeIgniter\Model;

class FormCollection extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'form_collections';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["form","submit_by","employee","data"];

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

    public function with_relation($id)
    {
        $role = \user_data('Title')[1];
        $query = $this->db->table('form_collections as fc');
        $where['fc.form'] = $id;
        
        if($role == 'salespeople') {
            $where['employee'] = user_data('EmployeeID');
        }

        $data = $query->where($where);

        if($role == BASE['dtl']) {
            $data->whereIn('employee',array_column(emp_district()['emps'],'EmployeeID'));
        }

        if($role == BASE['stl']) {
            $store_emp = json_decode(json_encode(emp_store()),true);
            $_emp=[];
            $_emp = array_merge($_emp,array_column(filter_key_value($store_emp,'Title','Salespeople'),"EmployeeID"));
            $_emp = array_merge($_emp,array_column(filter_key_value($store_emp,'Title','Store Team Leader'),"EmployeeID"));
            $data->whereIn('employee',$_emp);
        }
        

        $data = $data->select('fc.id,fc.created as submitted_date, emp.Employee_Name as submitted by, fc.data as data')
                ->join('employees as emp','emp.EmployeeID = fc.submit_by')
                ->join('forms as f', 'fc.form = f.id')
                ->orderBy('fc.id','DESC')
                ->get()
                ->getResultArray();
        return $data;
    }
}
