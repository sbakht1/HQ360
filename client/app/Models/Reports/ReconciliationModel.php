<?php

namespace App\Models\Reports;

use CodeIgniter\Model;
use App\Models\FileUpload;

class ReconciliationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'reconciliations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["date","uploaded_by","content"];
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

}

