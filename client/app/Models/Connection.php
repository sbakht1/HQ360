<?php

namespace App\Models;

use CodeIgniter\Model;

class Connection extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'connections';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['store','employee','month','date','info','submit_by','update_by'];

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


    public function get_data()
    {
        $this->db->connect();
        $builder = $this->db->table('connections as con');
        $builder->orderBy('id','DESC');
        $builder->select('con.id, con.date, str.StoreName as store, empId.Employee_Name as employee,empSub.Employee_Name as submit_by,empUp.Employee_Name as update_by');

        if ( user_data('Title')[1] === 'store-team-leader') $builder->where('store', profile('DefaultLocation'));

        if ( user_data('Title')[1] === 'district-team-leader' ) {
            $str = new Store();
            $str_ids = $str->select('DistrictName,StoreID')->where('DistrictName',user_store()['DistrictName'])->findAll();
            $builder->whereIn('str.StoreID',array_column($str_ids,'StoreID'));
        }

        $builder->join('stores as str','str.StoreID = con.store');
        $builder->join('employees as empId', 'empId.EmployeeID = con.employee');
        $builder->join('employees as empSub', 'empSub.EmployeeID = con.submit_by');
        $builder->join('employees as empUp', 'empUp.EmployeeID = con.update_by');
        return $builder->get()->getResult();
    }

    public function find_with_fiters() {
        $month = (@$_GET['month']) ? $_GET['month'] : date('Y-m');
        $role = user_data('Title')[1];

        $this->db->connect();
        $builder = $this->db->table('connections as con');
        $builder->orderBy('id','DESC');
        $builder->select('con.id, con.date, str.StoreName as store,str.DistrictName, empId.Employee_Name as employee,con.info,empSub.Employee_Name as submit_by,empUp.Employee_Name as update_by,con.created');
        $where['month'] = $month;

        if ( $role === 'store-team-leader') $where['store'] = profile('DefaultLocation');

        if ( $role === 'district-team-leader' ) {
            $str = new Store();
            $str_ids = $str->select('DistrictName,StoreID')->where('DistrictName',user_store()['DistrictName'])->findAll();
            $builder->whereIn('str.StoreID',array_column($str_ids,'StoreID'));
        }

        if($role === 'salespeople') $where['con.employee'] = \profile('EmployeeID');

        $builder->where($where);

        $builder->join('stores as str','str.StoreID = con.store');
        $builder->join('employees as empId', 'empId.EmployeeID = con.employee');
        $builder->join('employees as empSub', 'empSub.EmployeeID = con.submit_by');
        $builder->join('employees as empUp', 'empUp.EmployeeID = con.update_by');
        $data = $builder->get()->getResultArray();
        foreach($data as $i => $d) {
            $upd = [];
            foreach(json_decode($data[$i]['info'],true) as $item) {
                $upd[$item[0]] = $item[1];
            }
            $data[$i] = array_merge($data[$i],$upd);
            unset($data[$i]['info']);
        }
        return $data;
    }

}
