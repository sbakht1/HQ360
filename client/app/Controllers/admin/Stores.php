<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Site;
use App\Models\Store;
use App\Models\StoreMeta;
use App\Models\Employee;
use App\Models\FileUpload;

class Stores extends BaseController
{
    protected $path = 'admin/stores/';
    protected $cols = [
        "StoreID" => "",
        "LongName" => "",
        "StoreName" => "",
        "Enabled" => "",
        "Abbreviation" => "",
        "Address" => "",
        "City" => "",
        "State" => "",
        "Zip" => "",
        "LocationCode" => "",
        "ManagerID" => "",
        "DistrictName" => "",
        "DMID" => "",
        "RegionName" => "",
        "DateUpdated" => "",
        "OpusId" => "",
        "SystemNotificationPhoneNumber" => "",
        "QBClass" => "",
        "IPAddress" => "",
        "StoreType" => "",
        "PlazaName" => "",
        "ShoppertrakID" => "",
        "RMID" => "",
        "MainPhoneNumber" => ""
    ];

    public function index()
    {
        $model = new Store();

        if(@$_GET['export']) return array_to_csv_download([$this->cols],"Stores-import-format.csv");
       
        $title['Title'] = 'Stores';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        $status = (@$_GET['enable']) ? $_GET['enable'] : "TRUE";

        $data['stores'] = $model->getStores(50, $status);
        return view('app',$data);
    }

    public function manage($id,$type="")
    {
        if($id == 'export') return $this->export($type);
        if ($id == 'new') {
            $title['Title'] = 'New Store';
            $title['subMenu'] = 'Stores';
            $title['subMenuPath'] = $this->path;

            $data['page'] = emp_page([$title,$this->path.'new']);
        } else {
            $model = new Store();
            $emp = new Employee();
            $strMeta = new StoreMeta();
            $str = $model->where('StoreID', $id)->first();
            $str['RMID'] = $emp->info($str['RMID'],'EmployeeID,Employee_Name');
            $str['DMID'] = $emp->info($str['DMID'],'EmployeeID,Employee_Name');
            $str['ManagerID'] = $emp->info($str['ManagerID'],'EmployeeID,Employee_Name');
            $data['store'] = $str;
            $data['store']['image'] = $strMeta->value($id,'image');
            $data['store']['employees'] = $emp->store($id);

            $title['Title'] = 'Edit Store';
            $title['subMenu'] = 'Stores';
            $title['subMenuPath'] = $this->path;

            $data['page'] = emp_page([$title,$this->path.'manage']);
        }
        return view('app',$data);
    }
    
    public function update($id)
    {
        $model = new Store();
        $file = new FileUpload();
        $strMeta = new StoreMeta();
        $last_item = $model->orderBy('id','desc')->first()['StoreID']+1;
        
        
        foreach($_POST as $n => $v) $data[$n] = $v;
        foreach($_FILES as $n => $v) $data[$n] = $v;
        
        $status = (isset($data['Enabled'])) ? 'TRUE' : 'FALSE';

        $data['Enabled'] = $status;
        
        $upd = $data;
        
        if ($id != 'new') {
            if (@$_FILES['image']['name'] !== "") {
                $up = $file->image('stores','image',$id);
                if ($up['msg'] == 'success') {
                    $strMeta->set_meta($id,'image',$up['path']);
                } else {
                    return flash('danger','Store Image uploading Error.','admin/stores/'.$id);
                }
            }
            unset($upd['image']);
            $model->where("StoreID",$id)->set($upd)->update();
            $msg = 'Store has been Updated Successfully.';
        } else {
            $data['Enabled'] = "TRUE";
            $data['StoreID'] = $last_item;
            $msg = 'Store has been Added Successfully.';
            $model->insert($data);
            $id = $last_item;
        }
        $redirect = "admin/stores/$id";
        return flash('success',$msg,$redirect);

    }

    public function export($get="format")
    {
        // debug(['stst']);
        $stores = new Store();
        $remCol = ['id','created','updated'];
        if($get === 'format') {
            $cols = array_keys($stores->first());
            foreach($remCol as $c) unset($cols[array_search($c,$cols)]);
            $exp = array_values($cols);
            $data[] = [];
            foreach($exp as $e) $data[0][$e] = "";
        }
        debug([json_encode($exp)]);
        // return array_to_csv_download($data,"Stores Import Format.csv");
    }
    public function import()
    {
        $req = request();
        $store = new Store();
        $site = new Site();
        $valid = ($_FILES['store']['type'] == "text/csv") ? true : false;
        
        if(!$valid) return $this->response->setJSON([
            'success' => false,
            'message' => "Invalid file"
        ]);
        
        $file_data = $site->get_array($_FILES['store']['tmp_name']);
        if($file_data == "") return $this->response->setJSON([
            'success' => false,
            'message' => "Invalid file"
        ]);
        if(sizeof($file_data) == 0 ) return $this->response->setJSON([
            'success' => false,
            'message' => "Empty file"
        ]);

        $required_columns = find_keys(array_keys($this->cols),$file_data[0]);
        if(!$required_columns) return $this->response->setJSON([
            'success' => false,
            'message' => "Invalid file"
        ]);

        $unique_store = unique_array($file_data, 'StoreID');
        $insert_data = [];

        foreach( $unique_store as $item ) {
            $is_exist = $store->where('StoreID', $item['StoreID'])->first();
            if ( $is_exist ) {
                $store->where('StoreID', $item['StoreID'])->set($item)->update();
            } else {
                $insert_data[] = $item;
            }
        }
        if (sizeof($insert_data) > 0) {
            $store->insertBatch($insert_data);
        }

        flash('success','Stores has been imported Successfully.','admin/stores');

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Stores has been imported Successfully.'
        ]);
    }
}
