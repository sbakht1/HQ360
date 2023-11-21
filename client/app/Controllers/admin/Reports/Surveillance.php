<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\SurveillanceModel;
use App\Models\Site;
use App\Models\Store;
use App\Models\FileUpload;

class Surveillance extends BaseController
{
    protected $path = 'admin/reports/surveillance/';
    public function index() {
        $data['page'] = emp_page(['Digital Sales',$this->path.'index']);
        $data['slug'] = 'digital-sales';
        return view('app',$data);
    }

    public function view($name) {
        $set = json_decode(json_encode(settings('surveillance-reports')),true)['reports'];
        $info = ['name' => 'link','val' => $name];
        $title = find_in_array($info, $set)['title'];
        $data['page'] = emp_page([$title,$this->path.'index']);
        $data['slug'] = $name;
        return view('app',$data);
    }

    public function upload($name){
        $req = \request();
        $err = false;
        if ( $req->getMethod() != "post") return;
        $site = new Site();
        $upload = new FileUpload();


        // $emp_cols = array_keys($file_data['employee'][0]);
        // $str_cols = array_keys($file_data['store'][0]);
        // debug([[
        //     "emp" => json_encode($emp_cols),
        //     "str" => json_encode($str_cols),
        //     "name"=>$name,
        //     "date" => $_POST['date']
        // ]]);

        
        
        switch($name) {
            case 'conversion':
                return $this->conversion($name);
            break;

            case 'conversion-mtd':
                return $this->conversion($name);
            break;

            case 'traffic-count':
                return $this->traffic_count();
            break;
        }

    }

    public function find($name) {
        $role = user_data('Title')[1];
        $date = ($_GET['date']) ? $_GET['date']: "";
        $user_dist = user_store()['DistrictName'];
        
        $data = [];
        if($date === "") {
            $data = [];
        } else {
            $model = new SurveillanceModel();
            $file = new FileUpload();
            $row = $model->where(['name'=>$name,'date'=>$date])->first();
            // \debug([$date,$name,$row]);
            if($name === 'conversion' || $name === 'conversion-mtd') {
                $get = (@$_GET['get']) ? $_GET['get'] : "employee";
                $file_path = json_decode($row['file'],true)[$get];
                $csv = ($row === null) ? [] : $file->get_csv("/uploads/".$file_path);
            } else {
                $csv = ($row === null) ? [] : $file->get_csv("/uploads/".$row['file']);
            }
            $data = $csv;
            
            if (
                $role !== 'admin' && 
                $role !== 'human-resource' && 
                $role !== 'it' && 
                $role !== 'inventory'
            ) {
                $search = ($role === BASE['dtl']) ? 'District': "Store_Name";
                if(isset($search)) {
                    $data = $this->search_user_data($data,$search);
                }
            }
        }

        // if(@$_GET['_sort'] && @$_GET['_order']) {
        //     $data = my_sort($data,@$_GET['_sort'],@$_GET['_order']);
        // } 
        // if(@$_GET['total']) {
        //     $data = ['total'=>count($data)];
        // } else {
        //     $data = array_splice($data,@$_GET['_start'],@$_GET['_end']);
        // }
        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, "$name-$date.csv") 
            : $this->response->setJSON($data);
    }

    private function search_user_data($data,$search_col) {
        // debug([$search_col,array_splice($data,5)]);
        $role = user_data('Title')[1];
        $store = new Store();
        $empStr = user_store();
        $filterData = [];
        switch($role) {
            case BASE['dtl']: 
                $filterData = search_key_value($data,$search_col,$empStr['DistrictName']);
            break;

            case BASE['stl']: 
                $filterData = search_key_value($data,$search_col,$empStr['StoreName']);
            break;
        }
        return $filterData;
        // return [$search_col,$empStr['StoreName'],$role,$empStr,count($filterData),$filterData,$data];
    }

    private function filter_user_data($data,$search_col) {
        $role = user_data('Title')[1];
        $store = new Store();
        $empStr = user_store();
        $filterData = [];
        switch($role) {
            case BASE['dtl']: 
                $dist = $store->select('OpusId')->where('DistrictName',$empStr['DistrictName'])->findAll();
                foreach($dist as $str) $filterData = array_merge($filterData,filter_key_value($data,$search_col,$str['OpusId']));
            break;

            case BASE['stl']: 
                $filterData = filter_key_value($data,$search_col,$empStr['OpusId']);
            break;
        }
        return $filterData;
        // return [$search_col,$empStr['StoreName'],$role,$empStr,count($filterData),$filterData,$data];
    }

    private function traffic_count() {
        $name = "traffic-count";
        $site = new Site();
        $model = new SurveillanceModel();
        $upload = new FileUpload();
        $err = false;
        $cols = ["Date","District","Store_ID","Store_Name","Employee_ID","Employee_Name","Total_Customer_Count"];

        $file_data = $site->csvToArray($_FILES['upload']['tmp_name']);
        if(sizeof($file_data) == 0) $err = true;
        if(!find_keys($cols, $file_data[0])) $err = true;

        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);

        $model->where(['date'=> $_POST['date'], 'name' => $name])->delete();
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $upload->remove_file("reports\surveillance\\$name\\$year\\$month\\$day.csv",true);
        $filePath = $upload->csv("reports/surveillance/$name/$year/$month",'upload',$day);

        $model->insert([
            'name' => $name,
            'date' => $_POST['date'],
            'file' => $filePath,
            'uploaded_by' => profile('EmployeeID')
        ]);
        return \flash('success',"Successfully uploaded.", $_SERVER['HTTP_REFERER']);

        // debug([[
        //     "cols" => json_encode(array_keys($file_data[0])),
        //     "name"=>$name,
        //     "date" => $_POST['date']
        // ],array_splice($file_data,0,100,[])]);
    }

    private function conversion($name){
        $site = new Site();
        $model = new SurveillanceModel();
        $upload = new FileUpload();
        $err = false;
        
        $file_data[] = $site->csvToArray($_FILES['employee']['tmp_name']);
        $file_data[] = $site->csvToArray($_FILES['store']['tmp_name']);
        switch($name) {
            case 'conversion': 
                $cols[] = ["District","Employee_Name","Store_Name","Total_Customer_Count","Total_Opps","Activation","Activation_Closing_Rate","Upgrade","SPs","Gross_Profit","Accessories_Profit","APO","Breaktime"];
                $cols[] = ["District","Store_Name","Total_Customer_Count","Total_Opps","Activation","Activation_Closing_Rate","Upgrades","SPs","Gross_Profit","Accessories_Profit","APO","Store_Open","Store_Closed","10:00_AM_11:00_AM","11:00_AM_12:00_PM","12:00_PM_01:00_PM","01:00_PM_02:00_PM","02:00_PM_03:00_PM","03:00_PM_04:00_PM","04:00_PM_05:00_PM","05:00_PM_06:00_PM","06:00_PM_07:00_PM","07:00_PM_08:00_PM","08:00_PM_09:00_PM"];
            break;

            case 'conversion-mtd':
                $cols[] = ["District","Employee_Name","Store_Name","Total_Customer_Count","Total_Opps","Net_Conversion","Activation","Activation_Closing_Rate","Upgrade","SPs","Gross_Profit","Accessories_Profit","APO"];
                $cols[] = ["District","Store_Name","Total_Customer_Count","Total_Opps","Net_Conversion","Activation","Activation_Closing_Rate","Upgrades","SPs","Gross_Profit","Accessories_Profit","APO","10:00_AM_11:00_AM","11:00_AM_12:00_PM","12:00_PM_01:00_PM","01:00_PM_02:00_PM","02:00_PM_03:00_PM","03:00_PM_04:00_PM","04:00_PM_05:00_PM","05:00_PM_06:00_PM","06:00_PM_07:00_PM","07:00_PM_08:00_PM","08:00_PM_09:00_PM"];
            break;

        }

        // debuging

        // $file_headers = [
        //     json_encode(array_keys($file_data[0][0])),
        //     json_encode(array_keys($file_data[1][0]))
        // ];

        // debug($file_headers);

        if(\sizeof($file_data[0]) == 0 || \sizeof($file_data[1]) == 0) $err = true;
        if(!find_keys($cols[0], $file_data[0][0])) $err = true;
        if(!find_keys($cols[1], $file_data[1][0])) $err = true;
        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);

        $model->where(['date'=> $_POST['date'], 'name' => $name])->delete();
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $upload->remove_file("reports\surveillance\\$name\employees\\$year\\$month\\$day.csv",true);
        $filePath['employee'] = $upload->csv("reports/surveillance/$name/employees/$year/$month",'employee',$day);

        $upload->remove_file("reports\surveillance\\$name\stores\\$year\\$month\\$day.csv",true);
        $filePath['store'] = $upload->csv("reports/surveillance/$name/stores/$year/$month",'store',$day);

        $model->insert([
            'name' => $name,
            'date' => $_POST['date'],
            'file' => json_encode($filePath),
            'uploaded_by' => profile('EmployeeID')
        ]);
        return \flash('success',"Successfully uploaded.", $_SERVER['HTTP_REFERER']);
    }

    
}
