<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\FileUpload;

class CashDepositModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cash_deposits';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","file","closing_checklist","incomplete_closing_checklist","cash_deposit_variance","missing_signature_not_pickup"];
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

    public function find_report($name,$date) {
        
        $files = new FileUpload();
        $row = $this->where(['date'=> $date,'name'=> $name])->first();
        $path = 'uploads/'.$row['file'];
        $path = str_replace('.csv','',$path);
        return $files->get_csv($path);
    }

    public function by_name($name,$date){
        $row = $this->where('date',$date)->first();
        $role = user_data('Title')[1];
        $emp_store = user_store();

        if ($name !== "main") {
            $data = json_decode($row[$name],true);
            switch($role) {
                case BASE['dtl']:
                    $data = filter_key_value($data,'district',$emp_store['DistrictName']);
                break;
                    
                case BASE['stl']:
                    // $data = [count($data),$data];
                    $data = filter_key_value($data,'location_code',$emp_store['OpusId']);
                break;
            }
            return $data;
        } else {
            $files = new FileUpload();
            $path = 'uploads/'.$row['file'];
            $path = str_replace('.csv','',$path);
            $data = $files->get_csv($path);
            $data = filter_key_value($data,'Signature_Validated','');
            switch($role) {
                case BASE['dtl']: 
                    $data = filter_key_value($data,'District',$emp_store['DistrictName']);
                break;
                    
                case BASE['stl']:
                    $data = filter_key_value($data,'Location_code',$emp_store['OpusId']);
                break;
            }
            
            if(@$_GET['type'] == 'summary') {
                $data = sum_key($data,'Location_code','ATT_Expected_Cash_Amount');
            }
            // debug([$name,$date,$path,$data]);
            return $data;
        }
    }
}

