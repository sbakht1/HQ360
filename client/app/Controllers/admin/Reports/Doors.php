<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\DoorModel;
use App\Models\Site;
use App\Models\Store;
use App\Models\FileUpload;

class Doors extends BaseController
{
    protected $path = 'admin/reports/doors/';
    public function index() {
        $title['Title'] = "Hyla";
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';
        $data['page'] = emp_page([$title,$this->path.'index']);
        
        $data['slug'] = 'hyla';
        return view('app',$data);
    }

    public function view($name) {
        $set = json_decode(json_encode(settings('doors-reports')),true)['reports'];
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

        if ( $name == "pre-month-inv" || $name == "mtd-inv") {
            $cols = ["ACCOUNT_NUMBER","YYYYMM","MASTER_DEALER","LOC_SUB_TYPE","REGION","MARKET","LOCATION_DESC","LOC_INV_ID","DOCUMENT_ID","CREATION_DATE","CREATED_USER_ID","LAST_UPDATED_DATE","LAST_UPDATE_DATE","LAST_UPDATED_USER","STATUS","TYPE","COMMENTS","ITEM_NUMBER","ITEM_DESC","SERIAL_NUMBER","ITEM_CAT","SUB_INVENTORY","QTY_EXPECTED","QTY_COUNTED","FIRST_USE_DATE","ASSOCIATED_CTN","COUNTED_IND","SCANNED"];
        }

        if ( $name == "demo-tracker") {
            $cols = ["ACCOUNT_NUMBER","REFRESH","MASTER_DEALER","INV_AROE_INBOX","LOC_SUB_TYPE","CP_LIFECYCLE","LOC_ACTIVE_FLAG","DDR_FLAG","LOC","LOCATION_DESC","PRIMARY_SKU","SKU","SKU_DESCRIPTION","REQUEST_DATE","PO_QTY","SHIP_DATE","SHIP_QTY","PO_NUMBER","WMS_NUMBER","CARTON","TRACKING_NUMBER","SERIAL_NUMBER","SHIPMENT_PRIORITY_CODE","DC","SCHEDULED_DELIVERY","DELIVERY_DATE","STATUS","DELIVERED","RECV_QTY","RECV_ID","DEM_ADJ_QTY","DEM_ADJ_ID","NON_DEM_QTY","NON_DEM_ID","NON_DEM_RSN_CODE","ALLOCATION_QTY","NON_DEM_NETWORK_DATE","NON_DEM_NETWORK_CTN","REPLACEMENT_DATE","REPL_PO_QTY","REPL_SHIP_DATE","REPL_PO_NUMBER","REPL_WMS_NUMBER","REPL_CARTON","REPL_TRACKING_NUMBER","REPL_SERIAL_NUMBER","ACTION","QOH","SALES_QTY"];
        }

        if ($name == 'in-transit') {
            $cols = ["Master_Dealer","Region","Subregion","Location_Subtype","Location","Location_Desc","Ship_Confirmed_Date","DC","WMS_Order#","Carton#","Tracking_Number","Carrier","Ship_Date_Carton","Delivery_Status_Date","Derived_Delivery_Status","Estimated_Delivery_Date","Signature","Delivery_Notes","SKU#","SKU_Desc","PO_Number","WMS_Shipped_Quantity","Carton_Quantity","WMS_Quantity_Received","WMS_Quantity_Pending","Received_Status"];
        }
        if ($name == 'shipment-detail') {
            $cols = ["REGION","MARKET","INVOICE_NUMBER","ORDER_NUMBER","PO_NUMBER","ACTUAL_SHIP_DATE","ITEM_NUMBER","ITEM_DESCRIPTION","ITEM_CATEGORY","UNIT_PRICE","EXTD_PRICE","QUANTITY_ORDERED","QUANTITY_SHIPPED","IMEI","TRACKING_NUMBER"];
        }
        
        if ( $req->getMethod() != "post") return;

        $site = new Site();
        $model = new DoorModel();
        $upload = new FileUpload();
        $file_data = $site->csvToArray($_FILES['upload']['tmp_name']);
/*
        debug([[
            "cols" => json_encode(array_keys($file_data[0])),
            "name"=>$name,
            "date" => $_POST['date']
        ],array_splice($file_data,0,100,[])]);       
*/
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
        $upload->remove_file("reports\doors\\$name\\$year\\$month\\$day.csv",true);
        $filePath = $upload->csv("reports/doors/$name/$year/$month",'upload',$day);
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
        $month = (@$_GET['date']) ? $_GET['date'] : date('Y-m');
        $model = new DoorModel();
        // if (!$date) $date = $model->where(['name'=>$name])->orderBy('date','desc')->first()['date'];

        $data = $model->get_by_month($name, $month);
        return $this->response->setJSON($data);
    }

    public function dl($name){
        $store = new Store();
        $model = new DoorModel();
        $role = user_data('Title')[1];
        $date = @$_GET['date'];
        $reps = $model->select('date,name')->findAll();
        $csv = $model->find_report($name,$date);
        $emp_dist = user_store()['DistrictName'];
        $rec = [];
        
        if($name === 'pre-month-inv' || $name === 'mtd-inv') {
            switch($role) {
                case BASE['dtl']:
                    $dist = $store->select('StoreName,DistrictName')->where('DistrictName',$emp_dist)->findAll();
                    foreach($dist as $str) $rec = array_merge($rec,search_key_value($csv,'LOCATION_DESC',$str['StoreName']));
                break;

                case BASE['stl']:
                    $str = \user_store('StoreName');
                    $rec = search_key_value($csv,'LOCATION_DESC',$str);
                break;
            }
        }
        if ( $name === 'in-transit') {
            switch($role) {
                case BASE['dtl']: 
                    $dist = $store->select('DistrictName,OpusId')->where('DistrictName',$emp_dist)->findAll();
                    foreach($dist as $str) $rec = array_merge($rec,filter_key_value($csv,'Location',$str['OpusId']));
                break;

                case BASE['stl']:
                    $str = \user_store('OpusId');
                    $rec = filter_key_value($csv,'Location',$str);
                break;
            }
        }
        if($name === 'shipment-detail') {
            switch ($role) {
                case BASE['dtl']:
                    $dist = $store->select('StoreName,DistrictName,OpusId')->where('DistrictName',$emp_dist)->findAll();
                    foreach($dist as $str) $rec = array_merge($rec,search_key_value($csv,'PO_NUMBER',$str['OpusId']));
                break;
                
                case BASE['stl']:
                    $str = \user_store('OpusId');
                    $rec = search_key_value($csv,'PO_NUMBER',$str);
                break;
            }
        }

        if($name === 'demo-tracker') {
            // debug(array_splice($csv,0,10));
            switch ($role) {
                case BASE['dtl']:
                    $dist = $store->select('StoreName,DistrictName,OpusId')->where('DistrictName',$emp_dist)->findAll();
                    foreach($dist as $str) $rec = array_merge($rec,filter_key_value($csv,'LOC',$str['OpusId']));
                break;
                
                case BASE['stl']:
                    $str = \user_store('OpusId');
                    $rec = filter_key_value($csv,'LOC',$str);
                break;
            }
        }
        // Generating CSV
        $file = (@$_GET['filename']) ? $_GET['filename']:'export';
        $file .= ".csv";
        $csv = [];
        $csv[] = array_keys($rec[0]);
        foreach($rec as $r) $csv[] = array_values($r);
        // debug([count($csv),$csv]);
        return array_to_csv_download($csv,$file);
    }
}
