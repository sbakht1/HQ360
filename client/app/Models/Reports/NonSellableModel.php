<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\Store;

class NonSellableModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'non_sellables';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","OPUS_Location_Code","Item_Number_SKU","Item_Number_SKU_Description","Serial_Number","Last_Transaction_Date","Aging","NEXT_Return","STLID","DTLID"];
    
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

    public function find_report($date   ) {
        $this->db->connect();
        $role = user_data('Title')[1];
        $b = $this->db->table('non_sellables as tab');
        $b->join('stores as str','tab.OPUS_Location_Code = str.OpusId');
        $b->join('employees as stl','tab.STLID = stl.EmployeeID');
        $b->join('employees as dtl','tab.DTLID = dtl.EmployeeID');
        $b->where('date', $date);

        if ( $role == BASE['dtl'] ) {
            $str = new Store();
            $district = $str->select('DistrictName')->where('StoreID', profile('DefaultLocation'))->first()['DistrictName'];
            $stores = $str->select('DistrictName,OpusId')->where('DistrictName', $district)->findAll();
            $store_ids = array_column($stores,"OpusId");
            $b->whereIn('tab.OPUS_Location_Code',$store_ids);
        }

        if ( $role == BASE['stl'] ) {
            $b->where('tab.OPUS_Location_Code',user_store('OpusId'));
        }

        $b->select('
        str.DistrictName as District, 
        tab.OPUS_Location_Code, 
        str.StoreName as Store, 
        tab.Item_Number_SKU,
        tab.Item_Number_SKU_Description, 
        tab.Serial_Number,
        date_format(tab.Last_Transaction_Date, "%Y-%m-%d") as Last_Transaction_Date,
        tab.Aging,
        tab.NEXT_Return,
        stl.Employee_Name as STL,
        dtl.Employee_Name as DTL');
        return $b->get()->getResultArray();
    }
}