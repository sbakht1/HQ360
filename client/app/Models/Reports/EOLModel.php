<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\Store;

class EOLModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'eols';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","Loc_ID","Location_Name","SKU","SKU_Description","IMEI"];

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
        $b = $this->db->table('eols as tab');
        $b->join('stores as str','tab.Loc_ID = str.OpusId');
        $b->where('date', $date);

        if ( $role == BASE['dtl'] ) {
            $str = new Store();
            $district = $str->select('DistrictName')->where('StoreID', profile('DefaultLocation'))->first()['DistrictName'];
            $stores = $str->select('DistrictName,OpusId')->where('DistrictName', $district)->findAll();
            $store_ids = array_column($stores,"OpusId");
            $b->whereIn('Loc_ID',$store_ids);
        }

        if ( $role == BASE['stl'] ) {
            $b->where('Loc_ID',user_store('OpusId'));
        }

        $b->select('str.DistrictName as District, tab.Loc_ID, str.StoreName, tab.Location_Name,tab.SKU, tab.SKU_Description,tab.IMEI');
        
        return $b->get()->getResultArray();
    }
}