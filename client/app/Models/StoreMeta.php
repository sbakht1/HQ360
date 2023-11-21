<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreMeta extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'store_meta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'store',
        'meta_key',
        'meta_value'
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

    public function value($str,$key) {
        $data = $this->where(['store'=> $str,'meta_key'=> $key])->first();
        return (!$data) ? $this->where('meta_key','404-store')->first()['meta_value'] : $data['meta_value'];
    }

    public function set_meta($str,$key,$val) 
    {
        $check = $this->where(['store' => $str, 'meta_key' => $key])->first();
        if ( !$check ) {
            $this->insert([
                "store" => $str,
                "meta_key" => $key,
                "meta_value" => $val
            ]);
        } else {
            $this->where(['store'=>$str,'meta_key'=>$key])->set(['meta_value'=>$val])->update();
        }

        return true;
    }
}
