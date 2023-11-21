<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Scorecard;
use App\Models\Site;
use App\Models\Employee;
use App\Models\Store;

class Scorecards extends BaseController
{
    protected $path = 'admin/scorecards/';
    public function index() {

        $type = (@$_GET['type']) ? ucfirst($_GET['type']) : 'Employee';
        

        $title['Title'] = $type.' Scorecards' ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }

    public function upload() {
        $req = request();
        $site = new Site();
        $sc = new Scorecard();
        if($req->getMethod() !== 'post') return;
        $data = $site->csvToArray($_FILES['file']['tmp_name'],'lowercase');

        $filter = [];
        

        
        if(isset($data[0]['employeeid'])) {
            $resource = 'employeeid';
            $type = 'employee';
        } else {
            $resource = 'storeid';
            $type = 'store';
        }

        foreach($data as $item) {
            $detail = rem_items($item,[$resource,'type','yyyymm','scorecard','gp']);
            $new_item=[
                'resource_id' => $item[$resource],
                'type' => $type,
                'yyyymm' => $item['yyyymm'],
                'scorecard' => $item['scorecard'],
                'gp' => $item['gp'],
                'detail' => json_encode($detail)
            ];
            $filter[] = $new_item;
            $find = $sc->where([
                'yyyymm' => $new_item['yyyymm'],
                'type' => $type,
                'resource_id' => $item[$resource]
            ])->first();
            if ($find === null) {
                $sc->insert($new_item);
            } else {
                $sc->where([
                    'yyyymm'=>$new_item['yyyymm'],
                    'type'=>$type,
                    'resource_id' => $item[$resource]
                ])->set($new_item)->update();
            }
        }

        return flash('success', 'Scorecard successfully imported!','admin/scorecards');
        // return $this->response->setJSON(['success' => true,'record_inserted'=>count($ins['meta'])]);
    }

    function find_data() {
        $month = (@$_GET['month']) ? $_GET['month'] : '';
        $type = (@$_GET['type']) ? $_GET['type'] : 'employee';
        
        if(empty($month) || empty($type)) return ;
        $sc = new Scorecard();
        $cards = $sc->getScoreCard($type,$month);
        return $this->response->setJSON($cards);
    }

    public function card($id) {
        $sc = new Scorecard();
        $emp = new Employee();
        $st = new Store();
        $data = $sc->find($id);
        if($data['type'] === 'employee' || $data['type'] === 'district') {
            $emp_info = $emp->info($data['resource_id'],'Employee_Name,Title,EmployeeID,DefaultLocation');
            $store =  $st->info($emp_info['DefaultLocation'],'StoreName,DistrictName,DMID,ManagerID');
            $employee = $emp_info;
            $inf = [$emp_info['Employee_Name'],$emp_info['Title'],$emp_info['image']];
            if($data['type'] === 'district') $inf = [$store['DistrictName'],$emp_info['Employee_Name'],$store['image']];
        }
        if($data['type'] === 'store'){
            $store = $st->info($data['resource_id'],'StoreName,DistrictName,DMID,ManagerID');
            $inf = [$store['StoreName'],$store['DistrictName'],$store['image']];
        } 
        $data['info'] = $inf;
        $data['detail'] = json_decode($data['detail']);
        return $this->response->setJSON($data);
    }
}
