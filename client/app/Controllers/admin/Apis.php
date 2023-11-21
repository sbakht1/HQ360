<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\Setting;
use App\Models\Store;
use App\Models\Site;
use App\Models\Ticket;
use App\Models\Scorecard;
use App\Models\Form;
use App\Models\FormCollection;
use App\Models\Article;
use App\Models\Urgent;
use App\Models\PulseModel;
use App\Models\ComplianceModel;

class Apis extends BaseController
{
    public function index() {
      //
    }

    public function employees($for="") {
      switch ($for) {
        case 'aggrid': return $this->aggrid_emp(); break;
        default: return $this->getEmployees(); break;
      }
    }

    private function aggrid_emp() {
      $status = 'FALSE';
      if (@$_GET['status']) $status = $_GET['status'];
      $db = db_connect();
      $builder = $db->table('employees as emp');
      $builder->where('Account_Disabled',$status);
      $builder->select('emp.id,emp.UID,emp.EmployeeID,emp.Title, emp.Employee_Name,emp.Username,emp.Email, empMeta.meta_value as image,str.StoreName,str.City,str.DistrictName,emp.Account_Disabled');
      $builder->join('stores as str','emp.DefaultLocation = str.StoreID');
      $builder->join('employee_meta as empMeta','empMeta.employee = emp.EmployeeID AND empMeta.meta_key="image" OR empMeta.meta_key="404-image"');
      $builder->groupBy('emp.id');
      $builder->orderBy('emp.Employee_Name','ASC');
      $data = $builder->get()->getResult();
      return $this->response->setJSON($data);
    }
    
    private function getEmployees() {
      $emps = new Employee();
      $data = $emps->getEmployees();
      return $this->response->setJSON($data);
    }

    public function stores($for="") {
      switch ($for) {
        case 'aggrid':return $this->aggrid_str();break;
        default:return $this->getStr();break;
      }
    }

    private function aggrid_str() {
      $str = new Store();
      $emp = new Employee();
      $status = 'TRUE';
      if (@$_GET['status']) $status = $_GET['status'];
      $cols = "StoreID, OpusId, StoreName as Store,DistrictName as District,RegionName as Region,Enabled, ManagerID,DMID";
      $data = $str->select($cols)->where(['Enabled' => $status, "StoreID !=" => "0"])->findAll();
      foreach($data as $i => $d) {
        $stl = $emp->select("Employee_Name")->where('EmployeeID',$d["ManagerID"])->first();
        $dtl = $emp->select("Employee_Name")->where('EmployeeID',$d["DMID"])->first();
        $img = $str->info($d['StoreID']);
        $data[$i]['STL'] = ($stl) ? $stl['Employee_Name'] : "";
        $data[$i]['DTL'] = ($dtl) ? $dtl['Employee_Name'] : "";
        $data[$i]['image'] = $img['image'];
      }
      return $this->response->setJSON($data);
    }

    private function aggrid_str_() {
      $status = (@$_GET['status']) ? $_GET['status'] : 'true';
      $cols = 'str.StoreID,str.OpusId,str.StoreName,meta.meta_value as image,str.DistrictName,str.RegionName,manager.Employee_Name as Manager,dm.Employee_Name as DM,str.DistrictName,str.RegionName,rm.Employee_Name as RM,str.Enabled';
      $site = new Site();
      $db = db_connect();
      $builder = $db->table('stores as str');
      $builder
        ->where('str.Enabled', $status)
        ->join('employees as manager','manager.EmployeeID = str.managerID')
        ->join('employees as rm','rm.EmployeeID = str.RMID')
        ->join('employees as dm','dm.EmployeeID = str.DMID')
        ->join('store_meta as meta','meta.store = str.StoreID OR (meta.meta_key="404-store")')
        ->select($cols);
        $data = $builder->get()->getResultArray();

        $builder = $db->table('stores as str');
      $builder
        ->where('str.Enabled', $status)
        ->join('employees as manager','manager.EmployeeID = str.managerID')
        ->join('employees as rm','rm.EmployeeID = str.RMID')
        ->join('employees as dm','dm.EmployeeID = str.DMID')
        ->join('store_meta as meta','meta.store = str.StoreID')
        ->select($cols);
        $rem = $builder->get()->getResultArray();
        
      $data = $site->over_write($data,$rem,"StoreID");
      usort($data, function($a, $b) { return strcmp($a['StoreName'], $b["StoreName"]);});
      return $this->response->setJSON($data);
    }

    private function getStr() {
      $model = new Store();
      return $this->response->setJSON($model->api_store());
    }

    public function tickets($for='')
    {
      switch ($for) {
        case 'aggrid':
          return $this->aggrid_tickets();
          break;
        default:
          echo "Tickets";
          break;
      }
    }

    private function aggrid_tickets()
    {
      $ticket = new Ticket();
      $data = $ticket->get_tickets();
      return $this->response->setJSON($data);
    }

    public function question($for=false)
    {
      switch ($for) {
        case 'observation': $data = $this->observation(); break;
        default:$data = "QUESTION";break;
      }
      return $this->response->setJSON($data);
    }

    private function observation()
    {
      $setting = new Setting();
      return $setting->get('observation_question');
    }

    public function employee($id = false) {
      $emp = new Employee();
      if (!$id) $id = $_SESSION['user_data']['EmployeeID'];
      $find = $emp->where('EmployeeID', $id)->orderBy('Employee_Name','ASC')->first();
      return $this->response->setJSON($find);
    }

    public function store($id = false) {
      $str = new Store();
      if (!$id) return $this->response->setJSON(['Store_name'=>'Not Found!']);
      $find = $str->where('StoreID', $id)->first();
      return $this->response->setJSON($find);
    }
    
    public function articles() {
      $article = new Article();
      $articles = $article->getAll();
      return $this->response->setJSON($articles);
    }

    public function urgents() {
      $urgent = new Urgent();
      $urgent = $urgent->getAll();
      return $this->response->setJSON($urgent);
    }
    
    public function test()
    {
      $comp = new ComplianceModel();
      $data = $comp->first();
      debug([count($data),$data]);
    }

    // public function del()
    // {
      
    //     foreach($_GET as $n => $v) {
    //       $data[$n] = $v;
    //     }

    //     $emp = new Employee();

    //     $found = $emp->like($data)->delete();
    //     debug($found);
    // }

}
