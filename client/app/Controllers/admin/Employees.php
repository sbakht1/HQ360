<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\Site;
use App\Models\Setting;
use App\Models\EmpMeta;
use App\Models\FileUpload;
use App\Models\Notification;

class Employees extends BaseController
{
    protected $path = 'admin/employees/';
    protected $cols = [
        "EmployeeID" => 20220101,
        "Last_Name" => "Last",
        "First_Name" => "First",
        "Employee_Name" => "First Last",
        "Email" => "user@test.com",
        "Home_Number"=> "",
        "Work_Number" => "",
        "Cellular_Number" => "",
        "Title"=> "",
        "Account_Disabled" => "TRUE/FALSE",
        "StartDate" => "",
        "DefaultLocation" => "",
        "TerminationDate" => "",
        "Username" => "unique.username",
        "DateChanged" => "",
        "UID" => "",
        "StoreOverride" => "",
        "SisenseGroup" => "",
        "BellSouthUID" => "",
        "ADPFileNumber" => "",
        "SupervisorID" => ""
    ];

    public function index()
    {
        if(@$_GET['export']) return array_to_csv_download([$this->cols],"employees-import-format.csv");
        $model = new Employee();
        $disable = ( @$_GET['Account_Disabled'] ) ? $_GET['Account_Disabled'] : 'FALSE'; 
        $emp['data'] = $model->where('Account_Disabled',$disable)->orderBy('id','DESC')->paginate(50);
        $pager = $model->pager;
        $emp['pager'] = $pager->links();
        $data['employees'] = $emp;

        $title['Title'] = 'Employees';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app', $data);
    }
    
    public function manage($id='new')
    {
        $model = new Employee();
        $empMeta = new EmpMeta();
        $notes =  new Notification();
        $redirect = "/admin/employees/";
        $method = request()->getMethod();
        $session = session();

        if ( $method == 'post') {
            $data = [];
            foreach($_POST as $n => $v) $data[$n]=$v;
            if ( !isset($data['Account_Disabled']) ) $data['Account_Disabled'] = 'FALSE';
            if ($id != 'new') {
                $redirect .= $id;
                $model->where('id',$id)->set($data)->update();
                 // generate notificatoins function 
                 $user_data = session()->get('user_data'); 
                 $emp_name =$user_data['Employee_Name']; 
                 $notes->post_notification("Employee profile: ".$_POST['Employee_Name']. " Updated By $emp_name","null","employee","unread",$user_data['EmployeeID'] , $_POST['DefaultLocation'], $id);    
             
                 $session->setFlashdata('success','Employee has been updated successfully!');
                return redirect()->to($redirect);
            } else {
                $empID = (int)$model->where('EmployeeID !=','20220322')->orderBy('EmployeeID','DESC')->first()['EmployeeID'];
                $empID = $empID+1;
                $data['EmployeeID'] = $empID;
                $model->save($data);
                $empMeta->set_meta($empID,'password',sha1($_POST['password']));
                // generate notificatoins function 
                    $user_data = session()->get('user_data'); 
                    $emp_name =$user_data['Employee_Name']; 
                    $notes->post_notification("New Employee: ".$_POST['Employee_Name']. " has been save By $emp_name","null","employee","unread",$user_data['EmployeeID'] , $_POST['DefaultLocation'], $model->getInsertID());    
                $session->setFlashdata('success','Employee has been save successfully!');
                return redirect()->to($redirect);
            }
        }
        
        $title['Title'] = "New Employee";
        $title['subMenu'] = "Employee";
        $title['subMenuPath'] = $this->path;

        if ( $id !== 'new') {
            $title['Title'] = "Edit Employee";
            $title['subMenu'] = "Employee";
            $title['subMenuPath'] = $this->path;

            $redirect .= 'new';
            //$title = 'Edit Employee';
            $data['employee'] = $model->where('id',$id)->first();
            $data['employee']['meta'] = $model->info($data['employee']['EmployeeID']);
            $data['back'] = "-";
            if (!isset($data['employee']['id'])) return redirect()->to($redirect);
        }

       

        $data['page'] = emp_page([$title,$this->path.'manage',$this->path]);
        return view('app',$data);        
    }

    public function import()
    {
        // return $this->response->setJSON($_FILES);
        $valid = ($_FILES['emp']['type'] == "text/csv") ? true : false;
        $cols = array_keys($this->cols);
        $err = ["error","Please select correct file!",$_SERVER['HTTP_REFERER']];
        if(empty($_FILES['emp']['name']) || !$valid) 
            return $this->response->setJSON([
                'success' => false,
                'message' => "Please Select CSV File"
            ]);
        // debug([$_SERVER,$cols]);
        $empMeta = new EmpMeta();
        $site = new Site();
        $employee = new Employee();
        $file_data = $site->get_array($_FILES['emp']['tmp_name']);

        
        if(!$file_data) return $this->response->setJSON([
            'success' => false,
            'message' => $err[1]
        ]);

        $required_columns = find_keys($cols,$file_data[0]);
        if(!$required_columns) return $this->response->setJSON([
            'success' => false,
            'message' => $err[1]
        ]);

        $unique_emp = unique_array($file_data, 'Username');

        $insert_data = [];

        foreach($file_data as $f) {
            $exsist = $employee->where('Username',$f['Username'])->first();

            if ($exsist) {
                $employee
                    ->where('Username',$f['Username'])
                    ->set($f)
                    ->update();                
            } else {
                $insert_data[] = $f;
            }
        }
        if ( sizeof($insert_data) > 0 ) {
            $employee->insertBatch($insert_data);
            $this->create_credential($insert_data);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Employees successfully imported!'
        ]);
    }

    private function create_credential($data)
    {
        $batch = [];
        $empMeta = new EmpMeta();
        foreach($data as $d) {
            $batch[] = [
                'employee' => $d['EmployeeID'],
                'meta_key' => 'password',
                'meta_value' => sha1($d['Username'])
            ];
        }
        $empMeta->insertBatch($batch);
        return true;
    }
    public function upload(){
        $file = new FileUpload();
        $meta = new EmpMeta();
        $up = $file->image('users','img',$_POST['name']);
        $data['success'] = $meta->set_meta($_POST['name'],'image',$up['path']);
        $data['message'] = "Employee Profile Photo has been Updated!";
        // $data = [
        //     'name' => $_POST['name'],
        //     'img' => $_FILES['img']
        // ];
        return $this->response->setJSON($data);
    }
}
