<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\RLOModel;
use App\Models\Site;
use App\Models\Store;

class RLO extends BaseController
{
    protected $path = 'admin/reports/rlo/';
    public function index() {
        $data['page'] = emp_page(['RL Open Transfers',$this->path.'index']);
        return view('app',$data);
    }

    public function upload(){
        $req = \request();
        $err = false;
        $cols = ["Location_Number","Transfer_Create_Date","Transfer_Out","TRANSFER_REASON_CODE","Item_Category","Item_Number","Description","Serial_Number","Qty_Expected","Aging","Carrier_Tracking","Status"];
        
        if ( $req->getMethod() != "post") return;

        $site = new Site();
        $model = new RLOModel();
        $file_data = $site->csvToArray($_FILES['report']['tmp_name']);

        //debug([json_encode(array_keys($file_data[0])),$file_data]);
        if(\sizeof($file_data) == 0) {
            $err = true;
        } else {
            $required_columns = find_keys($cols,$file_data[0]);
            if ( !$required_columns ) $err = true;
        }
        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);
        
        $model->where(['date'=> $_POST['date']])->delete();
        
        
        foreach($file_data as $i => $row) {
            $store = new Store();
            unset($row['District']);
            unset($row['Location']);
            $row['date'] = $_POST['date'];
            $row["uploaded_by"] = \profile('EmployeeID');
            $batch[] = $row;
        }
        
        $total = $model->insertBatch($batch);
        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find() {
        $model = new RLOModel();
        $date = @$_GET['date'];
        $data = (!$date) ? [] : $model->find_report($date, @$_GET['type']);
        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, "RLO-$date.csv") 
            : $this->response->setJSON($data);
    }
}
