<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\EOLModel;
use App\Models\Site;
use App\Models\Store;

class EOL extends BaseController
{
    protected $path = 'admin/reports/eol/';
    public function index() {

        $title['Title'] = 'EOL Devices Transfer and Ship';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }

    public function upload(){
        $req = \request();
        $err = false;
        $cols = ["Loc_ID","Location_Name","SKU","SKU_Description","IMEI"];

        // export report format for upload
        if(@$_GET['export']) {
            foreach($cols as $col) $export[$col] = "";
            return \array_to_csv_download([$export],'EOL upload format.csv');
        } 
        
        if ( $req->getMethod() != "post") return;

        $site = new Site();
        $model = new EOLModel();
        $file_data = $site->csvToArray($_FILES['report']['tmp_name']);
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
            $NA = $store->where(['OpusId' => $row['Loc_ID']])->first();
            $batch[] = [
                "date" => $_POST['date'],
                "uploaded_by" => \profile('EmployeeID'),
                "Loc_ID" => $row["Loc_ID"],
                "Location_Name" => $row["Location_Name"],
                "SKU" => $row["SKU"],
                "SKU_Description" => $row["SKU_Description"],
                "IMEI" => $row["IMEI"]
            ];
            if ($NA != NULL) {}
        }
        
        // debug($batch);
        $total = $model->insertBatch($batch);
        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find($date=false) {
        $date = (@$_GET['date'])?$_GET['date']:date('Y-m-d');
        $type = (@$_GET['type'])?$_GET['type']:"main";
        if (@$_GET['date']) {
            $model = new EOLModel();
            $date = $_GET['date'];
            $data = $model->find_report($date, @$_GET['type']);
        } else {
            $data = [];
        }
        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, "EOL-$type-$date.csv") 
            : $this->response->setJSON($data);
    }
}
