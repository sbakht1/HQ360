<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\HylaModel;
use App\Models\Site;
use App\Models\Store;
use App\Models\FileUpload;

class Hyla extends BaseController
{
    protected $path = 'admin/reports/hyla/';
    public function index() {

        $title['Title'] = 'Hyla';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page(['Hyla',$this->path.'index']);
        $data['slug'] = 'hyla';
        return view('app',$data);
    }

    public function upload(){
        $req = \request();
        $err = false;
        $cols = ["Company","StoreName","DistrictName","Awaiting_Pickup_Trades","Oldest_Trade_Date","30_Day_Discrepancy_Charge"];
        
        if ( $req->getMethod() != "post") return;
        
        $site = new Site();
        $model = new HylaModel();
        $file_data = $site->csvToArray($_FILES['hyla']['tmp_name']);
        $discrepancy = $site->csvToArray($_FILES['discrepancy']['tmp_name']);
        $tradeIn = $site->csvToArray($_FILES['trade-in']['tmp_name']);
        
        // debug([$file_data,$discrepancy,$tradeIn]);


        foreach($tradeIn as $x => $xtem) {
            $tradeIn[$x]['Invoice_#'] = (int)$xtem['Invoice_#'];
            $tradeIn[$x]['IMEI'] = (int)$xtem['IMEI'];
        }

        foreach($discrepancy as $i => $item) $discrepancy[$i]['Invoice_#'] = (int)$item['Invoice_#'];

        if(\sizeof($file_data) == 0) {
            $err = true;
        } else {
            $required_columns = find_keys($cols,$file_data[0]);
            if ( !$required_columns ) $err = true;
        }
        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);
        
        $model->where(['date'=> $_POST['date']])->delete();
        
        
        foreach($file_data as $i => $row) {
            $row['Oldest_Trade_Date'] = date('Y-m-d', strtotime($row['Oldest_Trade_Date']));
            $row['date'] = $_POST['date'];
            $row["uploaded_by"] = \profile('EmployeeID');
            $batch[] = $row;
        }
        
        $total = $model->insertBatch($batch);

        $upload = new FileUpload();

        $name = date('Ymd',strtotime($_POST['date']));

        $dis = $upload->remove_file("reports\hyla\discrepancy\\$name.csv", true);
        $trIn = $upload->remove_file("reports\hyla\\trade-in\\$name.csv", true);

        $upload->csv('reports/hyla/discrepancy','discrepancy',$name);
        $upload->csv('reports/hyla/trade-in','trade-in',$name);
        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find() {
        $type = (@$_GET['type']) ? $_GET['type']:"";
        $date = (@$_GET['date']) ? $_GET['date']: false;
        $model = new HylaModel();
        if ($date == false) $date = $model->orderBy('id','desc')->first()['date'];
        
        if ($type == "") {
            $data = $model->find_report($date, $type);
        } else {
            $data = $model->find_report($date,$type);
            $num_cols = [
                'Invoice_#','IMEI','Trade_in_Value','Discrepancy_Total','Post_Inspection_Value','Base_Amount_Used',
                'Promotion_Amount_Used','Pre_Inspection_Trade_in_Value','Post_Processed_Value','Promo_TIV','Bonus_TIV',
                'Bonus_PIV','Promo_PIV'
            ];
            if($data !== false) {
                foreach( $data as $i => $item ) {
                    foreach($num_cols as $k) if (isset($item[$k])) $data[$i][$k] = str_to_num($item[$k]);
                }
            }
        }
        $exp = ($type == "") ? "hyla-$date.csv" : "hyla-$type-$date.csv";
        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, $exp) 
            : $this->response->setJSON($data);

    }
}
