<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\BiReport;
use App\Models\Site;
use App\Models\Store;
use App\Models\FileUpload;
use App\Models\ComplianceModel;

class BiReports extends BaseController
{
    protected $path = 'admin/reports/bi-reports/';
    public function index() {

        $title['Title'] = 'Digital Sales';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page(['Digital Sales',$this->path.'index']);
        $data['slug'] = 'digital-sales';
        return view('app',$data);
    }

    public function view($name) {
        $set = json_decode(json_encode(settings('bi-reports')),true)['reports'];
        $info = ['name' => 'link','val' => $name];
        $title1 = find_in_array($info, $set)['title'];

        $title['Title'] = $title1;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        $data['slug'] = $name;
        return view('app',$data);
    }

    public function upload($name){
        $req = \request();
        $err = false;
        $site = new Site();
        $model = new BiReport();
        $upload = new FileUpload();
        $file_data = $site->csvToArray($_FILES['upload']['tmp_name']);
        
        switch($name) {
            case 'digital-sales':
                $cols = ["Source","Activity_Date","Master_Dealer_Name","Region","Market_Group","Location_Name","Location_Id","Dealer_1_Cd","Agent","Agent_UID","Dealer_2_Cd","Liability","Account_Number","CTN","Device_Type","Order_ID","SOC_Code","SDG_SOC_Code","SDF_SOC_Code","Sum_of_Mobility_Gross_Add_Prepaid_Cnt","Sum_of_Mobility_Gross_Add_Postpaid_New_Cnt","Sum_of_Mobility_Gross_Add_Postpaid_Add_a_Line_Cnt","Sum_of_Mobility_Upgrade_Cnt","Sum_of_Protection_Cnt","Sum_of_Protection_Rev","Sum_of_Accessory_Cnt","Sum_of_Accessory_Rev","Sum_of_DTV_Posted_Cnt","Sum_of_ATT_TV_Posted_Cnt","Sum_of_IPBB_Posted_Cnt"];
            break;

            case '1674-1801-reps':
                $cols = ["Level","Level_ID","Date","NextUp_Installment_Plan_Mix","Overall_CSAT"];
            break;

            case 'expanded-course-detail':
                $cols = ["Name","ATTUID","Job_Role","Hire_Date","Location","Dealer_Code","Master_Dealer","Region","Market","TRAINING_SECTION","COURSE_CODE","COURSE_NAME","Course_Status"];
                $comp = new ComplianceModel();
                $db = \db_connect();
                $db->query('TRUNCATE TABLE compliance');
                $upload_data =[];
                $complince_data = lower_keys($file_data);
                foreach($complince_data as $f) if ( $f['course_status'] !== 'Complete' ) $upload_data[] = $f;
                $res = $comp->insertBatch($upload_data);
            break;

            case 'discounts':
                // $cols = ["MasterDealerName","Region","Market","DOS","ARSM","DiscountApprover","ApproverJobTitle","TransactionDate","Location","CompassID","DiscountCode","InvoiceID","ItemCategory","ItemLongDescription","ItemNumber","ItemSubcategory","MobileNumber","RepATTUID","RepName","RepJobTitle","SerialNumber","Sum_of_Per_Unit_Price","Sum_of_Amount_Not_Collected","InvalidReason","CoachingTemplateComments","AuditorComments"];
                $cols = ["MasterDealerName","Region","Market","DOS","ARSM","DiscountApprover","ApproverJobTitle","TransactionDate","Location","CompassID","DiscountCode","InvoiceID","ItemCategory","ItemLongDescription","ItemNumber","ItemSubcategory","MobileNumber","RepATTUID","RepName","RepJobTitle","SerialNumber","Sum_of_Quantity","Sum_of_Per_Unit_Price","Sum_of_Amount_Not_Collected","InvalidReason","CoachingTemplateComments"];
            break;

            case 'jline': 
                $cols = ["Master_Dealer","Region","Location_ID","Location_Name","ATTUID","Date_Year","Date_Quarter","Date_Month","Date_Day","CTN","Sku","Sum_of_Amount_Not_Collected","Sum_of_Net_Price","Sum_of_Original_Price","Sum_of_QTY","Line_Type","Invoice_ID_INV","Item_Description","Sum_of_Total_Discount","Drill_Down","Auditor_Notes"];
            break;

            case 'intangible':
                $cols = ["Master_Dealer","Region","Loc","Location_Description","User_ID","Cat","Date_Year","Date_Quarter","Date_Month","Date_Day","Dealer_Code","Sum_of_Extended_Price","Invoice_ID","Item_ID","Sum_of_Qty","Mobile_Number","Reason_Code","Sum_of_Amount_Not_Collected","Drill_Down","Coaching_Template"];
            break;

            case 'wired-credits':
                $cols = ["MasterDealer","Region","Market","DOS","ARSM","Location","BAN","Product","AdjustmentText","ATTUID","Rep","TransactionDate","Sum_of_CreditAmount","Valid_Invalid","AdjustmentReason","DrillDown","CoachingTemplate","AuditorNotes","Sum_of_AdjustmentCount","DPID"];
            break;
        }


        if ( $req->getMethod() != "post") return;

        

        if (sizeof($file_data) == 0) return \flash('error','Empty File selected.', $_SERVER['HTTP_REFERER']);

        $comp = new ComplianceModel();
        $c_col = $comp->first();

        
        // debug([[
        //     "cols" => \json_encode($cols),
        //     "file" => strtolower(json_encode(array_keys($file_data[0]))),
        //     "comp" => json_encode(array_keys($c_col)),
        //     "name"=>$name,
        //     "date" => $_POST['date']
        // ],array_splice($file_data,0,100,[])]);

        if(\sizeof($file_data) == 0) {
            $err = true;
        } else {
            $required_columns = find_keys($cols,$file_data[0]);
            if ( !$required_columns ) $err = true;
        }
        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);
        
        $model->where(['date'=> $_POST['date'], 'name' => $name])->delete();
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $upload->remove_file("reports\bi\\$name\\$year\\$month\\$day.csv",true);
        $filePath = $upload->csv("reports/bi/$name/$year/$month",'upload',$day);
        $model->insert([
            'name' => $name,
            'date' => $_POST['date'],
            'file' => $filePath,
            'uploaded_by' => profile('EmployeeID')
        ]);
        $total = \sizeof($file_data);
        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find($name) {
        $role = user_data('Title')[1];
        $date = ($_GET['date']) ? $_GET['date']: "";
        $user_dist = user_store()['DistrictName'];

        
        
        $data = [];
        if($date === "") {
            $data = [];
        } else {
            $bi = new BiReport();
            $file = new FileUpload();
            $row = $bi->where(['name'=>$name,'date'=>$date])->first();
            // debug($row);
            $csv = ($row === null) ? [] : $file->get_csv("/uploads/".$row['file']);
            $data = $csv;
            
            if (
                $role !== 'admin' && 
                $role !== 'human-resource' && 
                $role !== 'it' && 
                $role !== 'inventory'
            ) {
                switch($name) {
                    case 'digital-sales': $search = 'Location_Name';break;
                    case 'expanded-course-detail': $search = 'Location';break;
                    case 'wired-credits': $search = 'Location';break;
                }
    
                if(isset($search)) {
                    $data = $this->search_user_data($data,$search);
                }

                switch($name) {
                    case 'jline': $filter = 'Location_ID';break;
                    case 'discounts': $filter = 'CompassID';break;
                    case 'intangible': $filter = 'Loc';break;
                }

                if(isset($filter)) {
                    $data = $this->filter_user_data($data,$filter);
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
            ? array_to_csv_download($data, "BI-$name-$date.csv") 
            : $this->response->setJSON($data);
        return $this->response->setJSON($data);
    }

    private function search_user_data($data,$search_col) {
        $role = user_data('Title')[1];
        $store = new Store();
        $empStr = user_store();
        $filterData = [];
        switch($role) {
            case BASE['dtl']: 
                $dist = $store->select('StoreName,DistrictName')->where('DistrictName',$empStr['DistrictName'])->findAll();
                foreach($dist as $str) $filterData = array_merge($filterData,search_key_value($data,$search_col,$str['StoreName']));
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

    
}
