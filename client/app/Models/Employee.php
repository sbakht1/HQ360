<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\EmpMeta;

class Employee extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employees';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'EmployeeID',
        'Last_Name',
        'First_Name',
        'Employee_Name',
        'Email',
        'Home_Number',
        'Work_Number',
        'Cellular_Number',
        'Title',
        'Account_Disabled',
        'StartDate',
        'DefaultLocation',
        'TerminationDate',
        'Username',
        'DateChanged',
        'UID',
        'StoreOverride',
        'SisenseGroup',
        'BellSouthUID',
        'ADPFileNumber',
        'SupervisorID'
    ];
    
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    

    public function getEmployees()
    {
        $cols = 'emp.id,emp.EmployeeID ,emp.Email ,emp.DefaultLocation ,emp.Title, emp.Employee_Name, empMeta.meta_value as image,emp.Account_Disabled';
        $this->db->connect();
        $builder = $this->db->table('employees as emp');
        $builder->where('Account_Disabled','FALSE');
        if ( @$_GET['select'] ) {
            $sel = array_filter(explode('/',$_GET['select']));
            $builder->orWhereIn('EmployeeID',$sel);
        }
        $builder->select($cols);
        $builder->join('employee_meta as empMeta','empMeta.employee = emp.EmployeeID AND empMeta.meta_key="image" OR empMeta.meta_key="404-image"');
        $builder->orderBy('emp.Employee_Name','ASC');
        $builder->groupBy('emp.id');
        
        return $builder->get()->getResultArray();
    }

    public function store($DefaultLocation)
    {
        $sel = 'emp.id,emp.EmployeeID,emp.Title, emp.Employee_Name, meta.meta_value as image';
        $this->db->connect();
        $builder = $this->db->table('employees as emp');
        $builder->where(['DefaultLocation'=>$DefaultLocation,'Account_Disabled'=> 'FALSE']);
        $builder->join('employee_meta as meta', 'meta.employee = emp.EmployeeID AND meta.meta_key="image" OR meta.meta_key="404-image"');
        $builder->groupBy('emp.id');
        $builder->select($sel);
        $builder->orderBy('emp.Employee_Name','ASC');
        $employees['Enabled'] = $builder->get()->getResult();
        

        // $builder = $this->db->table('employees as emp');
        // $builder->where(['DefaultLocation'=>$DefaultLocation,'Account_Disabled'=> 'TRUE']);
        // $builder->join('employee_meta as meta', 'meta.employee = emp.EmployeeID AND meta.meta_key="image" OR meta.meta_key="404-image"');
        // $builder->groupBy('emp.id');
        // $builder->select($sel);
        // $employees['Disabled'] = $builder->get()->getResult();
        
        return $employees;
        
    }


    public function district()
    {
        $dist = \emp_district();
        $sel = 'emp.id,emp.UID,emp.EmployeeID,emp.Title, emp.Employee_Name,emp.Username,emp.Email, meta.meta_value as image,str.StoreName,str.City,str.DistrictName,emp.Account_Disabled';
        $this->db->connect();
        $builder = $this->db->table('employees as emp');
        $builder->where('Account_Disabled','FALSE');
        $builder->whereIn("DefaultLocation",array_column($dist['stores'],'StoreID'));
        $builder->join('employee_meta as meta', 'meta.employee = emp.EmployeeID AND meta.meta_key="image" OR meta.meta_key="404-image"');
        $builder->join('stores as str', 'emp.DefaultLocation = str.StoreID');
        $builder->select($sel); 
        $builder->orderBy("emp.Employee_Name","ASC"); 
        $employees = $builder->get()->getResultArray();
        return $employees;
        
    }
    
    public function info($emp_id,$fields='Employee_Name') {
        $fields.=",id";
        $meta = new EmpMeta();
        $emp = $this->select($fields)->where('EmployeeID',$emp_id)->first();
        if ( !$emp ) return 'Employee info not found';
        $img = $meta->where(['meta_key' =>'image','employee' => $emp_id])->first();
        
        if (!$img) {
            $emp['image'] = 'users/not-found.png';
        } else {
            $emp['image'] = $img['meta_value'];
        }
        return $emp;
    }

    public function  get_current_emp($emp_id){
       return $this->where(['Account_Disabled'=>"FALSE", "EmployeeID"=>$emp_id])->findAll();
    } 
}
