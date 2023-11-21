<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\FileUpload;
use App\Models\Store;

class HylaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'hylas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","Company","StoreName","DistrictName","Awaiting_Pickup_Trades","Oldest_Trade_Date","30_Day_Discrepancy_Charge"];
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
        $role = user_data('Title')[1];
        if ($type == "main" || $type == "") {
            $this->db->connect();
            $b = $this->db->table('hylas as tab');
            $b->where('date', $date);


            if ( $role == BASE['dtl'] ) {
                $b->where('tab.districtName',user_store()['DistrictName']);
            }

            if ( $role == BASE['stl'] ) {
                $b->where('tab.StoreName',user_store()['StoreName']);
            }


            $b->select('
                tab.Company,
                tab.StoreName,
                tab.DistrictName,
                tab.Awaiting_Pickup_Trades,
                tab.Oldest_Trade_Date,
                tab.30_Day_Discrepancy_Charge'
            );
            return $b->get()->getResultArray();
        } else {
            $files = new FileUpload();
            $date = date('Ymd',strtotime($date));
            $path = "uploads/reports/hyla/$type/$date";
            $data = $files->get_csv($path);

            if ($role === BASE['stl']) {
                $store_data = search_key_value($data,'Company',\user_store()['StoreName']);
                $data = $store_data;
            }

            if ( $role == BASE['dtl'] ) {
                $str = new Store();
                $district = $str->select('DistrictName')->where('StoreID', profile('DefaultLocation'))->first()['DistrictName'];
                $stores = $str->select('DistrictName,StoreName')->where('DistrictName', $district)->findAll();
                $store_ids = array_column($stores,"StoreName");

                $dist_data = [];

                foreach($store_ids as $name) {
                    $dist_data = array_merge($dist_data,search_key_value($data,'Company',$name));
                }

                $data = $dist_data;
            }
            
            return $data;
        }
    }
}

