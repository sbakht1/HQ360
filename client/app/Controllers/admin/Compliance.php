<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplianceModel;
use App\Models\FileUpload;
use App\Models\Site;
use App\Models\Employee;
use App\Models\EmpMeta;
use App\Models\Notification;

class Compliance extends BaseController
{
    protected $path = 'admin/compliance/';
    protected $cols = [
        'dtl' => "District",
        'Store' => "Store Name",
        'Dealer_Code' => "Dealer Code",
        'ATTUID' => "AT&T UID",
        'Name' => "Name",
        'Job_Role' => 'Job_Role',
        'Start_Date' => 'Start Date',
        'Section' => 'Section',
        'Code' => "code",
        'Course_Name' => 'Course Name',
        'Type' => 'Type',
        'Status' => 'Status',
        'Abbrv' => "Abbrv"
    ];
    public function index() {
        if(@$_GET['export']) return \array_to_csv_download([$this->cols],'compliance upload format.csv');

        $title['Title'] = 'PLE Compliance';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }
/*
    public function import()
    {
        $valid = $this->validate([
            "compliance" => ["uploaded[compliance]","mime_in[compliance,text/csv]"]
        ]);
        $cols = array_keys($this->cols);
        if(empty($_FILES['compliance']['name']) || !$valid) return flash('error','Please Select CSV file',$_SERVER['HTTP_REFERER']);
        $err = ["error","Please select correct file!",$_SERVER['HTTP_REFERER']];
 
        
        $site = new Site();
        $compliance = new ComplianceModel();
        $notes =  new Notification();
        $file_data = $site->get_array($_FILES['compliance']['tmp_name']);
        
        if(!$file_data) return flash($err[0],$err[1],$err[2]);
        $required_columns = find_keys($cols,$file_data[0]);
        
        if(!$required_columns) return flash($err[0],$err[1],$err[2]);

        $db = \db_connect();
        $db->query('TRUNCATE TABLE compliance');
        $upload_data =[];
        foreach($file_data as $f) if ( $f['Status'] !== 'Complete' ) $upload_data[] = $f;
        $res = $compliance->insertBatch($upload_data);
        
        // generate notificatoins function 
        // $user_data = session()->get('user_data'); 
        // $emp_name =$user_data['Employee_Name']; 
        // $notes->post_notification("PLE Compliance ".$_POST['title']. "Imported By $emp_name","null","hub","unread",$user_data['EmployeeID'] , 0);    
    

        return flash('success','PLE Compliance Updated', $this->path);
    }
*/
    public function find(){
        $model = new ComplianceModel();
        return $this->response->setJSON($model->ple_compliance());
    }

    public function manage($id='new')
    {
        $model = new ComplianceModel();
        $emp = new Employee();
        $meta = new EmpMeta();
       // $title = 'PLE Compliance';
        $data['emp_info'] = $emp->where('UID',$id)->first();
        $data['emp_info']['image'] = $meta->value($data['emp_info']['EmployeeID'],'image');
        $data['courses'] = $model->where('attuid', $id)->findAll();

        $title['Title'] = 'View PLE Compliance';
        $title['subMenu'] = 'PLE Compliance';
        $title['subMenuPath'] = $this->path;

        $data['page'] = emp_page([$title,$this->path.'manage']);
        return view('app',$data);        
    }

    public function session_user() {
        return $this->manage(profile('UID'));
    }
}
