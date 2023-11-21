<?php

namespace App\Controllers\StoreTeamLeader;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\Site;
use App\Models\Setting;
use App\Models\EmpMeta;

class Employees extends BaseController
{
    protected $path = 'store-team-leader/employees/';
    public function index()
    {
        $data['page'] = emp_page(['Employees',$this->path.'index']);
        return view('app', $data);
    }
    
    public function manage($id='new')
    {
        $model = new Employee();
        $empMeta = new EmpMeta();
        $redirect = "/store-team-leader/employees/";
        $method = request()->getMethod();
        $session = session();

        if ( $method == 'post') {
            $data = [];
            foreach($_POST as $n => $v) $data[$n]=$v;
            if ( !isset($data['Account_Disabled']) ) $data['Account_Disabled'] = 'FALSE';
            if ($id != 'new') {
                $redirect .= $id;
                $model->where('id',$id)->set($data)->update();
                $session->setFlashdata('success','Employee has been updated successfully!');
                return redirect()->to($redirect);
            } else {
                $empID = (int)$model->where('EmployeeID !=','20220322')->orderBy('EmployeeID','DESC')->first()['EmployeeID'];
                $empID = $empID+1;
                $data['EmployeeID'] = $empID;
                $model->save($data);
                $empMeta->set_meta($empID,'password',sha1($_POST['password']));
                $session->setFlashdata('success','Employee has been save successfully!');
                return redirect()->to($redirect);
            }
        }
        $title = 'New Employee';
        if ( $id !== 'new') {
            $redirect .= 'new';
            $title = 'Edit Employee';
            $data['employee'] = $model->where('id',$id)->first();
            $data['employee']['meta'] = $model->info($data['employee']['EmployeeID']);

            if (!isset($data['employee']['id'])) return redirect()->to($redirect);
        }
        $data['page'] = emp_page([$title,$this->path.'manage']);
        return view('app',$data);        
    }

    public function find()
    {
      $emp = new Employee();
      $store_emp = array_column($emp->store(profile('DefaultLocation'))['Enabled'],'EmployeeID');
      $db = db_connect();
      $builder = $db->table('employees as emp');
      $builder->where('Account_Disabled','FALSE');
      $builder->whereIn('EmployeeID',$store_emp);
      $builder->select('emp.id,emp.UID,emp.EmployeeID,emp.Title, emp.Employee_Name,emp.Username,emp.Email, empMeta.meta_value as image,str.StoreName,str.City,str.DistrictName,emp.Account_Disabled');
      $builder->join('stores as str','emp.DefaultLocation = str.StoreID');
      $builder->join('employee_meta as empMeta','empMeta.employee = emp.EmployeeID AND empMeta.meta_key="image" OR empMeta.meta_key="404-image"');
      $builder->orderBy('emp.Employee_Name','ASC');
      $data = $builder->get()->getResult();
      return $this->response->setJSON($data);
    }
}
