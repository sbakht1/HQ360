<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\ReconciliationModel;
use App\Models\Site;
use App\Models\Store;
use App\Models\FileUpload;

class Reconciliation extends BaseController
{
    protected $path = 'admin/reports/reconciliation/';
    public function index() {
        $title1 = 'Reconciliation';
        $slug = 'reconciliation';
        if (@$_GET['name']) {
            $slug = 'sub';
            $title1 = ucwords(str_replace('_',' ',$_GET['name']));
        } 
        $data['slug'] = $slug;

        $title['Title'] = $title1;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
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

    public function upload(){
        $req = \request();
        $err = false;

        $site = new Site();
        $model = new ReconciliationModel();
        $upload = new FileUpload();
        $store = new Store();
        // debug([
        //     'opusx' => json_encode(array_keys($opus[0])),
        //     'cognito' => json_encode(array_keys($cognito[0]))
        // ]);            
            
        $cols["opusx"] = ["region","district","location","till_type","register_deposit","aroe_deposit","discrepancy_amount","float_amount","register_date"];
        $cols["cognito"] = ["closingchecklist_id","location","dateofdeposit","depositamount","depositbagserialnumber","hasallinventorybeenreceived","name_first","name_last","signature","entry_status","entry_datecreated","entry_datesubmitted","entry_dateupdated"];
        $export = [];

        if(@$_GET['export']=="opusx") {
            foreach($cols['opusx'] as $col) $export[$col] = "";
            return array_to_csv_download([$export],'Opusx upload format.csv');
        }

        if(@$_GET['export']=="cognito") {
            foreach($cols['cognito'] as $col) $export[$col] = "";
            return array_to_csv_download([$export],'Cognito Form upload format.csv');
        }
        
        
        $opus = $site->csvToArray($_FILES['opusx']['tmp_name'],true);
        $cognito = $site->csvToArray($_FILES['cognito']['tmp_name'],true);
        $file_data['opusx'] = $opus;
        $file_data['cognito'] = $cognito;


        if ( $req->getMethod() != "post") return;

        $msg = "";
        if(sizeof($opus) == 0) $msg = "Opusx File is Empty";
        if(sizeof($cognito) == 0) $msg = "Cognito Forms File is Empty";

        if( sizeof($opus) == 0 || sizeof($cognito) == 0) {
                $err = true;
        } else {
            $opus_test = find_keys($cols["opusx"],$opus[0]);
            $cognito_test = find_keys($cols["cognito"],$cognito[0]);
            if(!$opus_test) $msg = "Opusx File is wrong <br>";
            if(!$cognito_test) $msg .= "Cognito Forms File is wrong";
            if ( !$opus_test || !$cognito_test) $err = true;
        }
        if ($err) return \flash('error',$msg, $_SERVER['HTTP_REFERER']);
            

        $rep = [];
        
        foreach ($opus as $ops) {
            $loc = substr($ops["location"],3);
            $srh = trim(explode('#',$loc)[0]);
            $cog = find_in_array(["name" => "location","val"=>$ops['location']],$cognito);
            $str = $store->where(["StoreName"=>$srh])->first();
            // $rep[] = [$ops,$cog];
            $exp_amt = @round(floatval($ops["aroe_deposit"]),2);
            $dep_amt = @round(floatval($cog["depositamount"]),2);
            $var = round(($dep_amt - $exp_amt),2);
            $status =($var != 0) ? "Variance":"Reconciled";
            $status = ($exp_amt == 0 || $dep_amt == 0 && $var == 0) ? "No Deposit" : $status;

            $rep[] = [
                "District" => @$str["DistrictName"],
                "Store ID" => @$str['StoreID'],
                "ClosingChecklist_Id" => @$cog["closingchecklist_id"],
                "Location" => @$ops["location"],
                "Location code" => @$str['Abbreviation'],
                "DateOfDeposit" => $_POST['date'],
                "AT&T Expected Cash Amount" => $exp_amt,
                "Logbook image amount" => $dep_amt,
                "Variance" => $var,
                "Final Status" => $status
            ];
        }

        $model->where(['date'=> $_POST['date']])->delete();
        $model->insert([
            'date' => $_POST['date'],
            'content' => json_encode($rep),
            'uploaded_by' => profile('EmployeeID')
        ]);
        return \flash('success',"Cash Deposit Reconciliation Generated.", $_SERVER['HTTP_REFERER']);
    }

    public function find() {
        $date = @$_GET['date'];
        $model = new ReconciliationModel();
        if (!$date) $date = $model->orderBy('date','desc')->first()['date'];
        $name = 'Cash Deposit Reconciliation';
        $data = json_decode($model->where(["date" => $date])->first()['content'],true);

        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, "$name-$date.csv") 
            : $this->response->setJSON($data);

    }
}
