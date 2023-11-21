<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\Store;

class RLOModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rlos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","Location_Number","Transfer_Create_Date","Transfer_Out","TRANSFER_REASON_CODE","Item_Category","Item_Number","Description","Serial_Number","Qty_Expected","Aging","Carrier_Tracking","Status"];
    
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

    public function find_report($date,$type="main") {
        $this->db->connect();
        $role = user_data('Title')[1];
        $b = $this->db->table('rlos as tab');
        $b->join('stores as str','tab.Location_Number = str.OpusId');
        $b->where('date', $date);
        
        if ( $role == BASE['dtl'] ) {
            $str = new Store();
            $district = $str->select('DistrictName')->where('StoreID', profile('DefaultLocation'))->first()['DistrictName'];
            $stores = $str->select('DistrictName,OpusId')->where('DistrictName', $district)->findAll();
            $store_ids = array_column($stores,"OpusId");
            $b->whereIn('tab.Location_Number',$store_ids);
        }

        if ( $role == BASE['stl'] ) {
            $b->where('tab.Location_Number',user_store('OpusId'));
        }
        
        $b->select('
        str.DistrictName as District,
        str.StoreName as Store,
        tab.Location_Number,
        date_format(tab.Transfer_Create_Date,"%Y-%m-%d") as Transfer_Create_Date,
        tab.Transfer_Out,
        tab.TRANSFER_REASON_CODE,
        tab.Item_Category,
        tab.Item_Number,
        tab.Description,
        tab.Serial_Number,
        tab.Qty_Expected,
        tab.Aging,
        tab.Carrier_Tracking,
        tab.Status');
        return $b->get()->getResultArray();
    }
}