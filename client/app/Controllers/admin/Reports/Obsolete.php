<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\ObsoleteModel;
use App\Models\Site;

class Obsolete extends BaseController
{
    protected $path = 'admin/reports/obsolete/';
    public function index() {
        $data['page'] = emp_page(['Obsolete Accessories Adjust and Ship',$this->path.'index']);

        $title['Title'] = "";
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';
        
        return view('app',$data);
    }

    public function upload(){
        $req = \request();
        $err = false;
        $cols = ["Loc_ID","Location_Name","SKU","SKU_Description","On_Hand"];
        
        // export report format for upload
        if(@$_GET['export']) {
            foreach($cols as $col) $export[$col] = "";
            return \array_to_csv_download([$export],'Obsolete upload format.csv');
        }
        
        if ( $req->getMethod() != "post") return;
        $site = new Site();
        $obs = new ObsoleteModel();
        $file_data = $site->csvToArray($_FILES['report']['tmp_name']);
        if(\sizeof($file_data) == 0) {
            $err = true;
        } else {
            $required_columns = find_keys($cols,$file_data[0]);
            if ( !$required_columns ) $err = true;
        }
        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);

        $obs->where(['date'=> $_POST['date']])->delete();

        foreach($file_data as $i => $row) {
            $batch[] = [
                "date" => $_POST['date'],
                "uploaded_by" => \profile('EmployeeID'),
                "Loc_ID" => $row["Loc_ID"],
                "Location_Name" => $row["Location_Name"],
                "SKU" => $row["SKU"],
                "SKU_Description" => $row["SKU_Description"],
                "On_Hand" => $row["On_Hand"]
            ];
        }

        $total = $obs->insertBatch($batch);

        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find() {
        $obs = new ObsoleteModel();
        $date = (@$_GET['date'])?$_GET['date']:date('Y-m-d');
        $type = (@$_GET['type'])?$_GET['type']:"main";

        if (@$_GET['date']) {
            $data = $obs->find_report($_GET['date'], @$_GET['type']);
        } else {
            $data = [];
        }

        return (@$_GET['export'] && count($data) > 0) ? array_to_csv_download($data, "Obsolete-$type-$date.csv") : $this->response->setJSON($data);
    }
}
