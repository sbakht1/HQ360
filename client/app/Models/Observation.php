<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Store;

class Observation extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'observations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["store","employee","month","interaction_type","detail","submit_by","last_updated_by"];

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

    protected $db;

    
    public function getObservation()
    {
        $cols = 'obs.id,obs.detail,obs.interaction_type,empId.Employee_Name as employee,str.StoreName as store,empBy.Employee_Name as submit_by,obs.created as date';
        $this->db = db_connect(); // Loading database
        $builder = $this->db->table("observations as obs");
        $builder->orderBy('id','DESC');
        $builder->select($cols);        

        if ( user_data('Title')[1] === 'store-team-leader' ) {
            $builder->where('store', profile('DefaultLocation'));
        }

        if ( user_data('Title')[1] === 'district-team-leader' ) {
            $str = new Store();
            $str_ids = $str->select('DistrictName,StoreID')->where('DistrictName',user_store()['DistrictName'])->findAll();
            $builder->whereIn('str.StoreID',array_column($str_ids,'StoreID'));
            // $builder->where('store', profile('DefaultLocation'));
        }

        $builder->join('employees as empId', 'empId.EmployeeID = obs.employee');
        $builder->join('employees as empBy', 'empBy.EmployeeID = obs.submit_by');
        $builder->join('stores as str', 'str.StoreID = obs.store');
        $data = $builder->get()->getResult();
        return $data;
    }

    public function find_with_fiters() {
        $month = (@$_GET['month']) ? $_GET['month'] : date('Y-m');
        $role = user_data('Title')[1];
        $this->db->connect();
        $builder = $this->db->table('observations as obs');
        $builder->orderBy('id','DESC');
        $builder->select('obs.id, str.StoreName as store,str.DistrictName, empId.Employee_Name as employee,obs.detail,empSub.Employee_Name as submit_by,empUp.Employee_Name as update_by,obs.created');
        $where['month'] = $month;

        if ( $role === 'store-team-leader') $where['store'] = profile('DefaultLocation');

        if ( $role === 'district-team-leader' ) {
            $str = new Store();
            $str_ids = $str->select('DistrictName,StoreID')->where('DistrictName',user_store()['DistrictName'])->findAll();
            $builder->whereIn('str.StoreID',array_column($str_ids,'StoreID'));
        }

        if($role === 'salespeople') $where['obs.employee'] = \profile('EmployeeID');

        $builder->where($where);

        $builder->join('stores as str','str.StoreID = obs.store');
        $builder->join('employees as empId', 'empId.EmployeeID = obs.employee');
        $builder->join('employees as empSub', 'empSub.EmployeeID = obs.submit_by');
        $builder->join('employees as empUp', 'empUp.EmployeeID = obs.last_updated_by');
        $data = $builder->get()->getResultArray();
        foreach($data as $i => $d) {
            $det = json_decode($d['detail'],true);
            $data[$i]['detail'] = $det;
            $data[$i]['atntScore'] = $det['atntScore'][0]."/".$det['atntScore'][1]." ".$det['atntScore'][2];
            $data[$i]['tweScore'] = $det['tweScore'][0]."/".$det['tweScore'][1]." ".$det['tweScore'][2];
        }
        // foreach($data as $i => $d) {
        //     $upd = [];
        //     foreach(json_decode($data[$i]['detail'],true) as $item) {
        //         $upd[$item[0]] = $item[1];
        //     }
        //     $data[$i] = array_merge($data[$i],$upd);
        //     unset($data[$i]['detail']);
        // }
        return $data;
    }
}
