<?php

namespace App\Models;

use CodeIgniter\Model;

class Site extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
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

    // custom
    protected $key = ['tekvysion','waqar'];
    
    
        public function csvToArrayEml($csvFile,$format=false,$upd_date=true) {
        $data = array_map('str_getcsv', file($csvFile));

        $csv = [];

        try {
            $headers = ($format) ? $this->headers($data[0],$format):$this->headers($data[0]);
        } catch (\Exception $e) {
            print_r($csvFile); exit;
            return $csv;
        }
        


        array_shift($data);
       
        
        foreach ($data as $r) {
            $obj = [];
            for ( $i=0; $i < sizeof($r); $i++ ) {
                $val = $r[$i];
                if($upd_date) {
                    if (
                        strpos($headers[$i],'date') !== false ||
                        strpos($headers[$i],'Date') !== false && $val !="") $val =  date('Y-m-d H:i:s', strtotime($val));
                }
                $obj[$headers[$i]] = trim($val);
            }
            $csv[]=$obj;
        }
        return $csv;
    }

    public function get_array($csvFile){
        $data = array_map('str_getcsv', file($csvFile));
        if(\sizeof($data) == 0) return false;
        $headers = $data[0];
        array_shift($data);
        $csv = [];
        // debug($data);
        $bug=[];
        foreach($data as $d) {
            foreach($d as $i => $x) {
                if (!array_key_exists($i,$d) || !isset($headers[$i])) {
                    return false;
                } else {
                    $item[$headers[$i]] = $x;
                }
            }
            $csv[] = $item;
        }
        return $csv;
    }
    
    public function csvToArray($csvFile,$format=false,$upd_date=true) {
        $data = array_map('str_getcsv', file($csvFile));
        $headers = ($format) ? $this->headers($data[0],$format):$this->headers($data[0]);
        array_shift($data);

        $csv = [];
        foreach ($data as $r) {
            $obj = [];
            for ( $i=0; $i < sizeof($r); $i++ ) {
                // $obj[] =
                // if (array_key_exists($i,$r)) return false;
                $val = (isset($r[$i])) ? $r[$i] : "";
                if($upd_date) {
                    if (
                        strpos($headers[$i],'date') !== false ||
                        strpos($headers[$i],'Date') !== false && $val !="") $val =  date('Y-m-d H:i:s', strtotime($val));
                }
                $obj[$headers[$i]] = ($val != null) ? trim($val) : "";
            }
            $csv[]=$obj;
        }
        return $csv;
    }

    private function headers($data, $type=false)
    {
        $updated = [];
        foreach($data as $d) {
            $h = trim($d);
            $h = trim(str_replace(['(',')','.','&'],'',$h));
            $h = trim(str_replace([' ','-'], '_', $h));
            $h = trim(str_replace(['___','__'], '_', $h));
            $h = trim(str_replace(['/','\\'], '_', $h));
            if ( $type ) {
                switch($type) {
                    case 'lowercase': $h = strtolower($h);break;
                }
            }
            $updated[] = $h;
        }
        return $updated;
    }

    public function over_write($arr, $rem,$key="StoreID") {

        $new = $arr;
        for ( $i=0;$i<sizeof($arr);$i++) {
            for ( $x=0;$x<sizeof($rem);$x++) {
                if ($arr[$i][$key] == $rem[$x][$key]) unset($new[$i]);
            }
        }

        $data = array_merge($rem,$new);
        
        $key_sort = array_column($data, $key);

        array_multisort($key_sort, SORT_ASC, $data);

        return $data;
    }

    public function json_to_array($data,$key) {
        for ( $i=0; $i<count($data); $i++) $data[$i][$key] = json_decode($data[$i][$key]);
        return $data;
    }

    public function encrypt($str) {
        $k = $this->key;
        return base64_encode($k[0].$str.$k[1]);
    }

    public function decrypt($encrypt) {
        return str_replace($this->key,'',base64_decode($encrypt));
    }

    public function last_report($table_name){
        $this->db->connect();
        if (gettype($table_name) == 'array') {
            return $b = $this->db->table($table_name[0])->where($table_name[1],$table_name[2])->orderBy('date','DESC')->get(1)->getRow();
        } else {
            return $b = $this->db->table($table_name)->orderBy('date','DESC')->get(1)->getRow();
        }
    }

    public function calculate($conditions, $array){
        $data = [];
        foreach( $array as $item ) {
            foreach($conditions as $con) {
                $data[] = $item[$con['key']];
                // if ($item[$con['key']] == $con['value']) $data[] = $item;
                // if (gettype($con['value']) == 'integer') {
                // } 
            }
        }

        return $data;
        // return [
        //     'conditions' => $conditions,
        //     'array' => $array[0][$conditions[0]['key']]
        // ];
    }
}