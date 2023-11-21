<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\ProductNoteModel;
use App\Models\Site;
use App\Models\Store;

class ProductNote extends BaseController
{
    protected $path = 'admin/reports/product-note/';
    public function index() {
        $data['page'] = emp_page(['Product Note',$this->path.'index']);
        $data['slug'] = 'product-note';
        return view('app',$data);
    }

    public function upload(){
        $req = \request();
        $err = false;
        $cols = ["Activity_Date","Master_Dealer","Channel","Region","Market","Loc_ID","Location_Name","SKU_Code","SKU_Description","QTY_to_transfer"];
        
        if ( $req->getMethod() != "post") return;
        
        $site = new Site();
        $model = new ProductNoteModel();
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
            $row['date'] = $_POST['date'];
            $row["uploaded_by"] = \profile('EmployeeID');
            $batch[] = $row;
        }
        
        $total = $model->insertBatch($batch);
        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find($date=false) {
        $model = new ProductNoteModel();
        $type = (@$_GET['type']) ? $_GET['type'] : "main";
        if (!$date) $date = $model->orderBy('id','desc')->first()['date'];

        $data = $model->find_report($date, @$_GET['type']);
        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, "Product-Note-$type-$date.csv") 
            : $this->response->setJSON($data);
    }
}
