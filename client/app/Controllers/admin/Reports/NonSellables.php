<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\NonSellableModel;
use App\Models\Site;
use App\Models\Store;

class NonSellables extends BaseController
{
    protected $path = 'admin/reports/non-sellable/';
    public function index() {

        $title['Title'] = 'Non Sellable device';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }

    public function upload(){
        $req = \request();
        $err = false;
        $cols = ["OPUS_Location_Code","Item_Number_SKU","Item_Number_SKU_Description","Serial_Number","Last_Transaction_Date","Aging","NEXT_Return","STLID","DTLID"];

        
        if ( $req->getMethod() != "post") return;

        $site = new Site();
        $model = new NonSellableModel();
        $file_data = $site->csvToArray($_FILES['report']['tmp_name']);

        // debug([json_encode(array_keys($file_data[0]))]);
        if(\sizeof($file_data) == 0) {
            $err = true;
        } else {
            $required_columns = find_keys($cols,$file_data[0]);
            if ( !$required_columns ) $err = true;
        }
        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);
        
        
        $new_data = [];
        
        foreach($file_data as $item) if ( $item['Aging'] > 5) $new_data[] = $item;
        
        $model->where(['date'=> $_POST['date']])->delete();
        
        
        foreach($new_data as $i => $row) {
            $store = new Store();
            $batch[] = [
                "date" => $_POST['date'],
                "uploaded_by" => \profile('EmployeeID'),
                "OPUS_Location_Code" => $row["OPUS_Location_Code"],
                "Item_Number_SKU" => $row["Item_Number_SKU"],
                "Item_Number_SKU_Description" => $row["Item_Number_SKU_Description"],
                "Serial_Number" => $row["Serial_Number"],
                "Last_Transaction_Date" => $row["Last_Transaction_Date"],
                "Aging" => $row["Aging"],
                "NEXT_Return" => $row["NEXT_Return"],
                "STLID" => $row["STLID"],
                "DTLID" => $row["DTLID"]
            ];
        }
        
        //debug($batch);
        $total = $model->insertBatch($batch);
        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find() {
        $model = new NonSellableModel();
        $date = (@$_GET['date'])?$_GET['date']:date('Y-m-d');
        if (@$_GET['date']) {
            $data = $model->find_report($_GET['date'], @$_GET['type']);
        } else {
            $data = [];
        }
        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, "non-sellables-$date.csv") 
            : $this->response->setJSON($data);
    }
}
