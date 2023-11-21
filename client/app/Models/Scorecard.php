<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Employee;
use App\Models\Store;

class Scorecard extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'scorecards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'resource_id',
        'type',
        'yyyymm',
        'gp',
        'scorecard',
        'detail'
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

    public function getScoreCard($type,$month)
    {
        $limit = 4;
        $offset = (@$_GET['start']) ? $_GET['start'] : 0;
        $end = $offset+$limit;
        $role = user_data('Title')[1];
        $dtl = 'district-team-leader';
        $stl = 'store-team-leader';


        if ($type === 'employee' || $type === 'district') {
            $select = 'score.id,score.resource_id,score.type,score.yyyymm,score.gp,score.scorecard,emp.Employee_Name,emp.Title,str.StoreName,str.DistrictName';
        }

        if ($type === 'store') {
            $select = 'score.id,score.resource_id,score.type,score.yyyymm,score.gp,score.scorecard,str.StoreName,str.DistrictName';
        }

        if($role === $stl) {
            $store = user_store()['StoreID'];
            $find_users = ['DefaultLocation' => $store,'Account_Disabled'=> 'FALSE','Title'=>'Salespeople'];
            if ($type === 'employee') {
                $emp = new Employee();
                $emps = $emp->select('EmployeeID')->where($find_users)->findAll();
                $emp_ids = array_column($emps,'EmployeeID');
                $emp_ids[] = profile('EmployeeID');
            }
            if($type === 'store') {
                $emp_ids=[$store];
            }
        }

        if ($role === $dtl) {
            $emp = new Employee();
            $emp_ids = array_column($emp->district(),'EmployeeID');

            if($type === 'store') {
                $emp_ids = array_column(emp_district()['stores'],'StoreID');
            }
        }

        $this->db->connect();
        
        $query = $this->db->table('scorecards score');
        
        $query
            ->select($select)
            ->where(['type'=>$type,'yyyymm'=>$month]);
        if($role === $stl || $role === $dtl) $query->whereIn('score.resource_id',$emp_ids);
        if ($type === 'employee' || $type === 'district') {
            $query
                ->join('employees as emp','score.resource_id = emp.EmployeeID')
                ->join('stores as str','str.StoreID = emp.DefaultLocation');
        }
        if ($type==='store') {
            $query
                ->join('stores as str','str.StoreID = score.resource_id');
        }

        $data = $query->get(50)->getResultArray();
        return $data;
    }

    public function range()
    {
        $query = $this->db->table('scorecards as score');
        $from = (@$_GET['from']) ? $_GET['from'] : date('Y-m-d',strtotime('-1 month'));
        $to = (@$_GET['to']) ? $_GET['to'] : date('Y-m-d');

        $data = $query
                ->select('score.*,emp.Employee_Name,str.StoreName,str.DistrictName,str.RegionName')
                ->where(['month >=' => $from,'month <=' => $to]);

        if($type === 'employee') {
            $data
                ->join('employees as emp','score.resource_id = emp.EmployeeID')
                ->join('stores as str','str.StoreID = emp.DefaultLocation');
        }
        if($type === 'store') $data->join('stores as str','str.StoreID = score.resource_id');
                $data->get()->getResultArray();
        foreach($data as $i => $item) {
            $visit =json_decode($data[$i]['visit']);
            $data[$i]['visit'] = $visit->count;
            $data[$i]['last_visit'] = $visit->dates[count($visit->dates)-1];
        }
        return $data;
    }

    public function yearly() {
        $query = $this->db->table('scorecards as score');
        $year = (@$_GET['year']) ? $_GET['year'] : date('Y');

        if ( strtolower(profile('Title')) === 'salespeople') $query->where(['resource_id' => profile('EmployeeID'),'type'=>'employee']);
        if ( strtolower(profile('Title')) === 'store team leader') {
            $emp = new Employee();
            $store_emp = $emp->store(profile('DefaultLocation'))['Enabled'];
            $emp_ids = array_column($store_emp,'EmployeeID');
            $query->whereIn('card_number', $emp_ids);
        }

        if ( strtolower(profile('Title')) === 'district team leader') {
            // debug([array_column(emp_district()['emps'],"EmployeeID")]);
            $emp_ids = array_column(emp_district()['emps'],"EmployeeID");
            $query->whereIn('card_number', $emp_ids);
        }

        $data = $query
                ->select('score.*,emp.Employee_Name,str.StoreName,str.DistrictName,str.RegionName')
                ->like('yyyymm', $year,'after')
                ->join('employees as emp','score.resource_id = emp.EmployeeID')
                ->join('stores as str','str.StoreID = emp.DefaultLocation')
                ->get()
                ->getResultArray();
        return $data;
    }

    public function filter_meta($data) {
        $filter = [];
        $sc = [];
        $sc_meta = [];

        foreach( $data as $d ) { 
            if ($d['meta'] != '' ) $sc_meta[] = $d;
            else $sc[] = $d;
        }

        return [
            'data' => $this->scorecard_data($sc),
            'meta' => $this->scorecard_meta($sc_meta),
        ];
    }

    private function scorecard_data($data) {
        $filter = $data[0];
        $filter = rem_items($filter,['items','values','meta']);
        $visit = [];
        foreach ($data as $d) {
            $f = str_replace([' ','-'],'_',strtolower($d['items']));
            if ( $f == 'visit') $visit[] = $d['values'];
            $filter[$f] = $d['values'];
        }        
        $filter['visit'] = json_encode(['count' => sizeof($visit),'dates' => $visit]);
        return $filter;
    }

    private function scorecard_meta($meta_data) {
        $filter = [];
        $un = unique_array($meta_data,'meta');

        foreach($un as $u) {
            $k = $u['meta'];
            $filter[$k] = [];
            
            foreach($meta_data as $mt) {                
                if($mt['meta'] == $k) $filter[$k][$mt['items']] = $mt['values'];
            }
        }

        $filter = [
            'month' => $un[0]['month'],
            'meta_key' => $un[0]['card_number'],
            'meta_value' => json_encode($filter)
        ];

        return $filter;
    }


    public function admin(){
        $keys = [
            "ppv_%_to_goal_d1",
            "non_ppv_%_to_goal_d2",
            "accessories_%_to_goal_d3",
            "upgrade_%_to_goal_d4",
            "protection_%_to_goal_d5",
            "expert_%_to_goal_d6",
            "quality_%_to_goal_d7"
        ];
        $month = $this->where('type','store')->orderBy('id','desc')->first()['yyyymm'];
        $scores = $this->select('detail')->where(['type' => 'store', 'yyyymm' => $month])->findAll();
        $data = [];
        $filt = [];

        foreach($scores as $s) {
            $det = \json_decode($s['detail'],true);
            $k = $keys[0];
            $data[] = $det;
        }
        foreach($keys as $k) {
            $sum = array_column($data,$k);
            $filt[$k] = (count($sum) > 0) ? round(array_sum($sum)/count($sum),2) : 0;
        }

        return $filt;
    }

    public function district()
    {
        $keys = [
            "ppv_%_to_goal_d1",
            "non_ppv_%_to_goal_d2",
            "accessories_%_to_goal_d3",
            "misc_%_to_goal_d4",
            "protection_%_to_goal_d5",
            "expert_%_to_goal_d6",
            "quality_%_to_goal_d7"
        ];
        $sc = $this->select('detail')->where(['type' => 'district','resource_id'=>user_data('EmployeeID')])->orderBy('id','desc')->first();
        if($sc) {
            $data = \json_decode($sc['detail'],true);
            $filt = [];
    
            foreach($keys as $k) {
                $filt[$k] = round($data[$k],2);
            }
            return $filt;
        } else {
            return [];
        }
    }

    public function employee()
    {
        
        $keys = [
            "ppv_%_to_goal_d1",
            "non_ppv_%_to_goal_d2",
            "accessories_%_to_goal_d3",
            "upgrades_%_to_goal_d4",
            "protection_%_to_goal_d5",
            "expert_%_to_goal_d6",
            "quality_%_to_goal_d7"
        ];
        $sc = $this->select('detail')->where(['type' => 'employee','resource_id'=>user_data('EmployeeID')])->orderBy('id','desc')->first();
        if($sc) {
            $data = \json_decode($sc['detail'],true);
            $filt = [];
            foreach($keys as $k) {
                $data[$k] = ($data[$k] == "") ? 0 : $data[$k];
                $filt[$k] = round($data[$k],2);
            } 
            return $filt;
        } else {
            return [];
        }
        
    }

    public function my(){
        
        $role = user_data('Title')[1];
        $userID = user_data('EmployeeID');

        switch ($role) {
            case 'admin': return $this->admin();break;
            case 'district-team-leader': return $this->district();break;
            default: return $this->employee();break;
        }

        if($role == 'admin') return $this->admin();


        if($role === 'salespeople') {
            $month = $this->where(['type'=>'employee','resource_id'=>$userID])->orderBy('id','desc')->first();
            if($month === null) {
                return [];
            } else {
                $month = $month['yyyymm'];
                $find = ['resource_id' => user_data('EmployeeID'),'type' => 'employee','yyyymm'=>$month];
                return json_decode($this->where($find)->first()['detail'],true);
            }
        }
        $month = $this->where('type','store')->orderBy('id','desc')->first();
        if($month === null) return [];
        $month = $month['yyyymm'];
        if($role === 'store-team-leader') {
            $find = ['resource_id' => user_store()['StoreID'],'type' => 'store','yyyymm'=>$month];
          
            return json_decode($this->where($find)->first()['detail'],true);
        }

        if ( $role !== 'store-team-leader' || $role !== 'salespeople') {
            $keys = [
                "ppv_%_to_goal_d1",
                "non_ppv_%_to_goal_d2",
                "accessories_%_to_goal_d3",
                "upgrades_%_to_goal_d4", //"upgrades_%_to_goal_d4", //Updated
                "protection_%_to_goal_d5",
                "expert_%_to_goal_d6",
                "quality_%_to_goal_d7"
            ];
            $find = $this
                ->select('detail')
                ->where(['type'=>'employee','yyyymm'=>$month]);

               

            if($role === 'district-team-leader') {
                $find->whereIn('resource_id',array_column(emp_district()["stores"],"StoreID"));
            }

            //debug($find->findAll());
            foreach($find->findAll() as $item) {
                $det = json_decode($item['detail'],true);
                foreach($keys as $k) $data[$k][] = @$det[$k]; 
            }
            debug($det);
            $data = [];
            foreach($keys as $k) {
                if(sizeof($data) > 0) {
                    $filter = array_filter($data[$k]);
                    $av[$k] = (count($filter) > 0) ? (array_sum($filter)/count($filter)) : 0;
                } else {
                    $av[$k] = 0;
                }
            }
            return $av;
        }
    }
}

