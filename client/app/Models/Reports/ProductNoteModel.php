<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\Store;

class ProductNoteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'product_notes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","Activity_Date","Master_Dealer","Channel","Region","Market","Loc_ID","Location_Name","SKU_Code","SKU_Description","QTY_to_transfer"];
        
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
        $b = $this->db->table('product_notes as tab');
        $b->join('stores as str','tab.Loc_ID = str.OpusId');
        $b->where('date', $date);

        if ( $role == BASE['dtl'] ) {
            $str = new Store();
            $stores = $str->select('DistrictName,OpusId')->where('DistrictName', user_store('DistrictName'))->findAll();
            $store_ids = array_column($stores,"OpusId");
            $b->whereIn('tab.Loc_ID',$store_ids);
        }

        if ( $role == BASE['stl'] ) {
            $b->where('tab.Loc_ID',user_store('OpusId'));
        }

        if ($type == "summary") {
            $b->select('
            str.DistrictName as District,
                str.StoreName as Store,
                tab.Master_Dealer,
                date_format(tab.Activity_Date,"%Y-%m-%d") as Activity_Date,
                tab.Channel,
                tab.Region,
                tab.Market,
                tab.Loc_ID,
                tab.Location_Name,
                tab.SKU_Code,
                tab.SKU_Description,
                sum(tab.QTY_to_transfer) as Sum_of_QTY_to_transfer');
                $b->groupBy('tab.Loc_ID');

        } else {
            $b->select('
                str.DistrictName as District,
                str.StoreName as Store,
                tab.Master_Dealer,
                date_format(tab.Activity_Date,"%Y-%m-%d") as Activity_Date,
                tab.Channel,
                tab.Region,
                tab.Market,
                tab.Loc_ID,
                tab.Location_Name,
                tab.SKU_Code,
                tab.SKU_Description,
                tab.QTY_to_transfer');
        }
        return $b->get()->getResultArray();
    }
}

