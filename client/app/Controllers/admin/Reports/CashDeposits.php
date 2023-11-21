<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Reports\CashDepositModel;
use App\Models\Site;
use App\Models\Store;
use App\Models\FileUpload;

class CashDeposits extends BaseController
{
    protected $path = 'admin/reports/cash-deposit/';
    public function index() {
        $title1 = 'Cash Deposit Reconciliation';
        $slug = 'main';
        if (@$_GET['name']) {
            $slug = 'sub';
            $title1 = ucwords(str_replace('_',' ',$_GET['name']));
        } 
        $data['slug'] = 'cash-deposit/'.$slug;

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

        if ( $req->getMethod() != "post") return;

        $site = new Site();
        $model = new CashDepositModel();
        $upload = new FileUpload();
        $file_data = $site->csvToArray($_FILES['upload']['tmp_name'],true);

        $rep = [
            'name' => 'Closing Checklist not submitted',
            'data' => []
        ];

        $colums_to_pick = [
            'district',
            'closingchecklist_id',
            'location',
            'location_code',
            'dateofdeposit',
            'att_expected_cash_amount',
            'logbook_image_amount',
            'variance',
            'signature_validated',
            'final_status',
            'explanation_for_variance',
            'pickup_status',
            'reconciliation_status'
        ];

        $file_data = floater(['variance','att_expected_cash_amount','depositamount','logbook_image_amount'],$file_data);
        $file_data = empty_dates(['dateofdeposit','entry_datesubmitted','signature_validated'],$file_data);
        $cc = $this->closing_checklist($file_data,$colums_to_pick);
        $icc = $this->incomplete_closing_checklist($file_data,$colums_to_pick);
        $cdv = $this->cash_deposit_variance($file_data,$colums_to_pick);
        $msnp = $this->missing_signature_not_pickup($file_data,$colums_to_pick);
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
            $required_columns = find_keys($colums_to_pick,$file_data[0]);
            if ( !$required_columns ) $err = true;
        }
        if ($err) return \flash('error','Wrong file selected', $_SERVER['HTTP_REFERER']);
        
        $model->where(['date'=> $_POST['date']])->delete();
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $upload->remove_file("reports\cash-deposits\\$year\\$month\\$day.csv",true);
        $filePath = $upload->csv("reports/cash-deposits/$year/$month",'upload',$day);
        $model->insert([
            'date' => $_POST['date'],
            'file' => $filePath,
            'closing_checklist' => json_encode($cc),
            'incomplete_closing_checklist'=> json_encode($icc),
            'cash_deposit_variance' => json_encode($cdv),
            'missing_signature_not_pickup' => json_encode($msnp),
            'uploaded_by' => profile('EmployeeID')
        ]);
        $total = \sizeof($file_data);
        return \flash('success',"Uploaded $total new records.", $_SERVER['HTTP_REFERER']);
    }

    public function find($name,$date=false) {
        $model = new CashDepositModel();
        if (!$date) $date = $model->orderBy('date','desc')->first()['date'];

        $data = $model->by_name($name, $date);

        $name = ($name == 'main') ? 'Cash Deposit Reconciliation': ucwords(str_replace('_', ' ',$name));
        return (@$_GET['export'] && count($data) > 0) 
            ? array_to_csv_download($data, "$name-$date.csv") 
            : $this->response->setJSON($data);

    }


    private function closing_checklist($items,$keys) {
        $data = [];
        foreach($items as $i => $item) {
            if ( 
                array_key_exists('closingchecklist_id',$item) && 
                array_key_exists('att_expected_cash_amount',$item) 
            ) {
               if ($item['closingchecklist_id'] == 0 && $item['att_expected_cash_amount'] <> 0) {
                    $newItem = [];
                    foreach($keys as $k) $newItem[$k] = $item[$k];
                    $data[] = $newItem;
               }
            }
        }
        return $data;
    }

    private function incomplete_closing_checklist($items,$keys) {
        $data = [];
        foreach($items as $item) {
            if ( 
                array_key_exists('closingchecklist_id',$item) && 
                array_key_exists('final_status',$item) 
            ) {
               if ($item['closingchecklist_id'] != 0 && $item['final_status'] == "Missing Deposit") {
                    $newItem = [];
                    foreach($keys as $k) $newItem[$k] = $item[$k];
                    $data[] = $newItem;
               }
            }
        }

        return $data;
    }

    private function cash_deposit_variance($items,$keys) {
        $data = [];
        foreach($items as $item) {
            if ( 
                array_key_exists('variance',$item) && 
                array_key_exists('final_status',$item) 
            ) {
               if ($item['variance'] <= -10 || $item['variance'] >= 50) {
                    if ( $item['final_status'] !== "Missing Deposit"){
                        $newItem = [];
                        foreach($keys as $k) $newItem[$k] = $item[$k];
                        $data[] = $newItem;
                    }
                }
            }
        }

        return $data;
    }

    private function missing_signature_not_pickup($items,$keys) {
        $data = [];
        foreach($items as $item) {
            if ( 
                isset($item['signature_validated']) && empty($item['signature_validated']) &&
                isset($item['att_cashout_image']) && empty($item['att_cashout_image']) &&
                isset($item['final_status']) && strpos($item['final_status'],"Not Pickup") !== false
            ) {
                $newItem = [];
                foreach($keys as $k) $newItem[$k] = $item[$k];
                $data[] = $newItem;
            }
        }
        return $data;
    }
}
