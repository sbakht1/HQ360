<?php

namespace App\Models;

use CodeIgniter\Model;

class Ticket extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["store","assign_to","assign_emp","department","status","data",'TicketID','submit_by','date','ticket_type','level'];

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

    public function get_tickets()
    {
        $this->db->connect();
        
        $builder = $this->db->table('tickets as tic');
        $builder
            ->select('tic.status, asg.Employee_Name as assign_emp, tic.assign_emp as emp_id, tic.TicketID, str.StoreName,str.StoreID,sub.Employee_Name,sub.EmployeeID,tic.department,tic.assign_to,tic.date,str.DistrictName,str.City,str.RegionName');
        if ( @$_GET['from'] && @$_GET['to']) {
            $builder->where(['date >=' => $_GET['from']]);
            $builder->where(['date <=' => $_GET['to']]);
        } else {
            $builder->where(['date >=' => date('Y-m-d',strtotime('-1 month'))]);
            $builder->where(['date <=' => date('Y-m-d')]);
        }
        if (@strtolower($_GET['status']) != 'all') {
            if ( @$_GET['status'] ) $builder->where('status',$_GET['status']);
        }
        if(@$_GET['department'] && $_GET['department']!== "") {
            $builder->where('tic.assign_to',$_GET['department']);
        }


        if ( profile('Title') == 'Salespeople' ) $builder->where('tic.store', profile('DefaultLocation'));
        
        if ( profile('Title') == "Store Team Leader" ) $builder->where('tic.store', profile('DefaultLocation'));
        if ( profile('Title') == "District Team Leader" ) $builder->whereIn('tic.store', array_column(emp_district()['stores'],'StoreID'));
        if ( profile('Title') == 'Human Resource' || profile('Title') == 'Inventory' || profile('Title') == "IT") {
            if(@$_GET['department'] && $_GET['department']!== "") {
                $builder->where('tic.assign_to',$_GET['department']);
                $builder->where('tic.submit_by', profile('EmployeeID'));
            } else {
                $dep = user_data('Title')[0];
                if ($dep == 'Human Resource') $dep = 'HR';
                if ($dep == 'Information Technology') $dep = 'IT';
                $builder->where('tic.assign_to',$dep);
            }
        }

        if(
            user_data('Title')[1] != "admin" &&
            user_data('Title')[1] != "human-resource" &&
            user_data('Title')[1] != "it" &&
            user_data('Title')[1] != "inventory"
        ) $builder->orWhere('assign_emp',profile('EmployeeID'));

        $data = $builder
            ->join('employees as sub','sub.EmployeeID = tic.submit_by')
            ->join('stores as str','str.StoreID = tic.store')
            ->join('employees as asg', 'asg.EmployeeID = tic.assign_emp')
            ->orderBy('tic.id', 'DESC')
            ->get()
            ->getResult();

        // debug($data);

        return $data;
    }
}
