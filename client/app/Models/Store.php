<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Employee;
use App\Models\Site;
use App\Models\StoreMeta;

class Store extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "StoreID",
        "LongName",
        "StoreName",
        "Enabled",
        "Abbreviation",
        "Address",
        "City",
        "State",
        "Zip",
        "LocationCode",
        "ManagerID",
        "DistrictName",
        "DMID",
        "RegionName",
        "DateUpdated",
        "OpusId",
        "SystemNotificationPhoneNumber",
        "QBClass",
        "IPAddress",
        "StoreType",
        "PlazaName",
        "ShoppertrakID",
        "RMID",
        "MainPhoneNumber"
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


    public function getStores($rows=20,$status='TRUE')
    {
        $emp = new Employee();
        $meta = new StoreMeta();
        $stores = $this->where('Enabled',$status)->orderBy('StoreID','DESC')->paginate($rows);
        $links = $this->pager->links();
        for ( $i=0; $i<sizeof($stores); $i++ ) {
            $stores[$i]['image'] = $meta->value($stores[$i]['StoreID'],'image');
            $stores[$i]['RMID'] = $emp->info($stores[$i]['RMID'],'Employee_Name,Title,EmployeeID');
            $stores[$i]['DMID'] = $emp->info($stores[$i]['DMID'],'Employee_Name,Title,EmployeeID');
            $stores[$i]['ManagerID'] = $emp->info($stores[$i]['ManagerID'],'Employee_Name,Title,EmployeeID');
        }
        return [
            'data' => $stores,
            'links' => $links
        ];
    }

    public function api_store()
    {
        $site = new Site();
        $this->db->connect();
        $builder = $this->db->table('stores as str');
        
        if ( profile('Title') == 'Salespeople' ) $builder->where('str.StoreID', profile('DefaultLocation'));
        if ( profile('Title') == "Store Team Leader" ) $builder->where('str.StoreID', profile('DefaultLocation'));
        if ( profile('Title') == "District Team Leader" ) $builder->whereIn('str.StoreID', array_column(emp_district()['stores'],'StoreID'));

        // debug([profile('Title'),array_column(emp_district()['stores'],'StoreID')]);

        $cols = 'str.StoreID,str.StoreName,str.City, str.State, meta.meta_value as image,str.DistrictName as District';
        $builder->select($cols);
        $builder->join('store_meta as meta','(meta.meta_key="image" AND meta.store = str.StoreID)');
        $builder->groupBy('str.id');
        
        $data[] = $builder->get()->getResultArray();

        $builder = $this->db->table('stores as str');
       
        if ( profile('Title') == 'Salespeople' ) $builder->where('str.StoreID', profile('DefaultLocation'));
        if ( profile('Title') == "Store Team Leader" ) $builder->where('str.StoreID', profile('DefaultLocation'));
        if ( profile('Title') == "District Team Leader" ) $builder->whereIn('str.StoreID', array_column(emp_district()['stores'],'StoreID'));

        $builder->select($cols);
        $builder->join('store_meta as meta','meta.store = str.StoreID OR (meta.meta_key="404-store")');
        $builder->groupBy('str.id');

        $data = $builder->get()->getResultArray();
        // return $site->over_write($data[1],$data[0],'StoreID');
        return $data;
    }


    public function getWithRelations($perPage=10)
    {
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $this->db->connect();
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table('stores as str');
        //'str.StoreID, str.StoreName, str.Enabled str.DistrictName,str.RegionName'
        $data = $builder
            ->where('Enabled','TRUE')
            ->select('str.StoreID, str.StoreName, str.Enabled, district[str.DistrictName],str.RegionName,RM.Employee_Name as RM_Name, DM.Employee_Name as DM_Name, Manager.Employee_Name as Manager_Name')
            ->join('employees as RM','RM.EmployeeID = str.RMID')
            ->join('employees as DM','DM.EmployeeID = str.DMID')
            ->join('employees as Manager','Manager.EmployeeID = str.ManagerID')
            ->orderBy('str.StoreName', 'ASC')
            ->get($perPage,$offset)
            ->getResult();

        $total = $builder->where('Enabled','TRUE')->countAllResults();

        return [
            'data'=>$data,
            'links' => $pager->makeLinks($page,$perPage,$total)
        ];
    }

    public function info($StoreID,$fields='StoreName') {
        $fields.=",id";
        $meta = new StoreMeta();
        $employee = new Employee();
        $str = $this->select($fields)->where('StoreID',$StoreID)->first();
        if ( !$str ) return 'Store info not found';

        // // Store Employees
        // $str['employees'] = $employee->where(['DefaultLocation' => $StoreID,'Account_Disabled' => 'FALSE'])->findAll();
        
        // store image
        $img = $meta->where(['meta_key' =>'image','store' => $StoreID])->first();
        if (!$img) $img = $meta->where(['meta_key' =>'404-store'])->first();
        $str['image'] = $img['meta_value'];
        return $str;
    }
    
}
