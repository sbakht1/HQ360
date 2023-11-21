<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Form;
use App\Models\FormMeta;
use App\Models\FormCollection;
use App\Models\Employee;
use App\Models\Site;
use App\Models\Store;

class FormBuilder extends BaseController
{
    protected $path = 'admin/form-builder/';
    public function index() {
        
        $title['Title'] = 'Form Builder';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }
    
    public function manage($id='new') {
        $req = \request();
        if ( $req->getMethod() == 'post' ) {
            return $this->save_form($id);
        } else {
            if ( $id == 'new') {
                //$title="New Form";

                $title['Title'] = "New Form";
                $title['subMenu'] = 'Form Builder';
                $title['subMenuPath'] = $this->path;

                $form = [
                    'id' => 0,
                    'title' => 'Untitled form',
                    'data' => [],
                    'type' => "Public",
                    'status'=> "Draft"
                ];
            } else {
                $form_model = new Form();
                $formMeta = new FormMeta();
                $form = $form_model->find($id);
                $form['data'] = json_decode($form['data']);
                $meta = $formMeta->where(['form' => $id])->findAll();
                if ( count($meta) > 0 ) $form['meta'] = json_decode($meta[0]['meta_value']);
                //$title = $form['title'];

                $title['Title'] = $form['title'];
                $title['subMenu'] = 'Connections';
                $title['subMenuPath'] = $this->path;

            }
            $data['form'] = $form;
            $data['page'] = emp_page([$title,$this->path.'manage']);
            return view('app',$data);
        }
    }

    public function collection($id=false){
        if (!$id) return redirect()->to('/'.user_data('Title')[1].'/form-builder');

        $formModel = new Form();
        $form = $formModel->where('id', $id)->first();

        $title['Title'] = $form['title'];
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'collection']);
        $data['form'] = $form;
        return view('app',$data);
    }

    public function view($id=false) {
        if (!$id) return redirect()->to('/admin/form-builder');
        $form = new Form();
        $coll = new FormCollection();
        $emp = new Employee();
        $store = new Store();

        $collection = $coll->select('id,form,submit_by, data,created')->where('id',$id)->first();
        $entry = array_values(json_decode($collection['data'],true));
        $get_form = $form->select('title')->where('id', $collection['form'])->first();

        // $collection['data'] = \json_decode($collection['data']);
        // debug($collection);
        
        for($x=0;$x<count($entry);$x++) if(empty($entry[$x][0])) unset($entry[$x]);

        foreach($entry as $i => $e) {
            if(strpos($e[0],"/stores") !== false) 
                $entry[$i] = [
                    explode("/",$e[0])[0],
                    $store->select("StoreName")->where("StoreID",$e[1])->first()['StoreName']
                ];
            if(strpos($e[0],"/employees") !== false) 
                $entry[$i] = [
                    explode("/",$e[0])[0],
                    $emp->select("Employee_Name")->where("EmployeeID",$e[1])->first()['Employee_Name']
                ];
            if(str_inc(strtolower($e[0]),"amount") || str_inc(strtolower($e[0]), "variance")) $entry[$i][1] = "$".$e[1];
        }
        $form_inf = [
            array_values($get_form)[0],
            $emp->select("Employee_Name")->where("EmployeeID",$collection['submit_by'])->first()['Employee_Name'],
            $collection['created']

        ];

        $view["form"] = $form_inf;
        $view['data'] = array_values($entry);
        return $this->response->setJSON($view);

    }

    private function save_form($id){
        $form = new Form();
        $formMeta = new FormMeta();
        foreach($_POST as $n => $v) {$data[$n]=$v;}
        unset($data['id']);

        $fields = (@$_POST['data']) ? $_POST['data'] : [];


        if ($_POST['id'] != 0) {
            $form->update($id,[
                'title'=> $_POST['title'],
                'data' => json_encode($fields),
                'type' => $_POST['type'],
                'status' => $_POST['status'],
                'updated_by' => profile('EmployeeID')
            ]);
            if ( @$_POST['meta'] ) {
                $meta = $formMeta->where('form', $id)->findAll();
                if (sizeof($meta) != 0) {
                    $formMeta->where('form', $id)->set([
                        'meta_key' => $_POST['type'],
                        'meta_value' => json_encode($_POST['meta'])
                    ])->update();
                } else {
                    $formMeta->insert([
                        'form' => $id,
                        'meta_key' => $_POST['type'],
                        'meta_value' => json_encode($_POST['meta'])
                    ]);
                }
            }
            $msg = ['success'=> true,'message' => 'Form has been updated!'];
        } else {
            $form->insert([
                'title'=> $_POST['title'],
                'data' => json_encode($fields),
                'type' => $_POST['type'],
                'status' => $_POST['status'],
                'created_by' => profile('EmployeeID'),
                'updated_by' => profile('EmployeeID')
            ]);

            $form_id = $form->getInsertID();
            if ( @$_POST['meta'] ) {
    
                $formMeta->insert([
                    'form' => $form_id,
                    'meta_key' => $_POST['type'],
                    'meta_value' => json_encode($_POST['meta'])
                ]);
            }
            $msg = ['success'=> true,'message' => 'Form has been added!','form_id' => $form_id];
        }
        $msg['data'] = $data;
        return $this->response->setJSON($msg);
    }

    public function find() {
        $form = new Form();
        $site = new Site();
        $data = $form->range();
        foreach($data as $i => $f) $data[$i]['link'] = $site->encrypt($f['id']);
        return $this->response->setJSON($data);
    }

    public function collect($id=false) {
        if ( !$id ) return $this->response->setJSON(['msg'=>'Invalid Route!']);
        $form = new Form();
        $site = new Site();
        $store = new Store();
        $emp = new Employee();
        $collection = new FormCollection();
        $data = $collection->with_relation($id);
        $db = db_connect();

        $the_form = $form->find($id);

        
        if(@$_GET['export']) {
            foreach($data as $i => $d) {
                $forms = array_values(json_decode($d['data'],true));
                foreach($forms as $x => $f) {
                    if (!empty($f[0])) {
                        if(str_inc($f[1],"public_uploads")) {
                            $f[0] .= " - image";
                            $f[1] = str_replace("public_uploads/",base_url()."/public/uploads/public_uploads/",$f[1]);
                        }
                    if(strpos($f[0],'/') !== false) {
                        $tab = explode('/',$f[0]);
                        $f[0] = $tab[0];
                        $un = $db->query("SELECT Employee_Name FROM employees WHERE `EmployeeID`=0")->getResultArray()[0]['Employee_Name'];
                        if($tab[1] == 'employees') {
                            $emp_id = $f[1];
                            $res = $db->query("SELECT Employee_Name FROM employees WHERE `EmployeeID`='$emp_id'")->getResultArray()[0]['Employee_Name'];
                        }
                        $f[1] = (@$res) ? $res : $un;
                        unset($res);
                        $unStr = $db->query("SELECT StoreName FROM stores WHERE `StoreID`=0")->getResultArray()[0]['StoreName'];
                        if($tab[1] == 'stores') {
                            $str_id = $f[1];
                            $loc = $db->query("SELECT StoreName FROM stores WHERE `StoreID`='$str_id'")->getResultArray()[0]['StoreName'];
                        }
                        $f[1] = (@$loc) ? $loc : $unStr;
                        unset($loc);
                    }
                    $f[0] = str_replace(".","",$f[0]);
                    if(str_inc($f[1],"data:image/")) {
                        $f[0] .= " - image";
                        $f[1] = base_url("sign/".$data[$i]['id']);
                    }
                    $data[$i][$f[0]] = $f[1];
                }
                unset($data[$i]['data']);
                }
            }
            if(sizeof($data) == 0) 
                echo "No Collection Found!";
            else
                // debug($data); 
            return array_to_csv_download($data,$the_form['title']." - ".date('Y-m-d').".csv");
        } else {
            if (sizeof($data) > 0) {
              foreach($data as $i => $f) {
                $f = array_values(json_decode($f['data'],true));

                foreach($f as $n => $x) {
                    if($x[1] == 'undefined') $f[$n][1] = "Not Found";
                    if(\strpos($x[0],'/stores') !== false) {
                        $f[$n][0] = explode('/',$x[0])[0];
                        $f[$n][1] = $store->where('StoreID',$x[1])->first()['StoreName'];
                    }
                    if(\strpos($x[0],'/employees') !== false) {
                        $f[$n][0] = explode('/',$x[0])[0];
                        $f[$n][1] = $emp->where('EmployeeID',$x[1])->first()['Employee_Name'];
                    }

                    if(str_inc($x[1],"data:image/")) {
                        $f[$n][0] .= " - image";
                        $f[$n][1] = base_url("sign/".$data[$i]['id']);
                    }

                    if(str_inc($x[1],"public_uploads/")) {
                        $f[$n][0] .= " - image";
                        $f[$n][1] = str_replace("public_uploads/",base_url()."/public/uploads/public_uploads/",$x[1]);
                    }
                }
                foreach($f as $fi => $fx) {
                    if(!empty($fx[0])) {
                        $data[$i][str_replace(".","",$fx[0])] = $fx[1];
                    }
                }
                unset($data[$i]['data']);
              }
            } 
            return $this->response->setJSON($data);
        }
    }

    public function trash($id){
        $coll = new FormCollection();
        $coll->delete($id);
        return flash("success","Successfully Trashed",$_GET['to']);
    }


    public function forms(){

        if(@$_GET['type'] == 'list') {

            $m = new Form();
            $fm = new FormMeta();
            $site = new Site();
            $role = @user_data('Title')[1];
            $title = @user_data('Title')[0];
            $sel = 'id,title,type,DATE_FORMAT(created,"%Y-%m-%d") as created,DATE_FORMAT(updated,"%Y-%m-%d") as updated';
    
            $where = [
                'status'=>'Publish',
            ];
    
            $whereIn = [];
    
            $whereIn = (!empty($role)) 
                ? ['public','Logged In Employees']
                : ['public'];
    
            $forms = $m->where($where)->whereIn('type',$whereIn)->whereNotIn('id',[21,25])->select($sel)->findAll();
    
            $where['type'] = 'Title Base Employees';
    
            $title_forms = $m->where($where)->select($sel)->findAll();
    
            foreach($title_forms as $f) {
                $ft = json_decode($fm->where('form',$f['id'])->select('meta_value')->first()['meta_value']);
                if(in_array($title,$ft)) $forms[] = $f;
            }
    
            $where['type'] = 'Select Individual Employees';
    
            $user_forms = $m->where($where)->select($sel)->findAll();
    
            foreach($user_forms as $uf) {
                $ursf = json_decode($fm->where('form',$uf['id'])->select('meta_value')->first()['meta_value']);
                if(in_array(user_data('EmployeeID'),$ursf)) $forms[] = $uf;
            }

            foreach($forms as $i => $f) $forms[$i]['link'] = $site->encrypt($f['id']);

            return $this->response->setJSON($forms);
        } else {
            $title['Title'] = 'Forms';
            $title['subMenu'] = '';
            $title['subMenuPath'] = '';

            $data['page'] = emp_page([$title,$this->path.'forms']);
            return view('app',$data);
        }
    }

    public function sign($col_id) {
        $collection = new FormCollection();
        $ent = json_decode($collection->select("data")->find($col_id)['data'],true);
        $ent = array_values($ent);
        $sign = array_values(array_filter($ent, function ($f) {return str_inc($f[1],"data:image/");}))[0][1];
        
        $code_base64 = str_replace('data:image/png;base64,','',$sign);
        $code_binary = base64_decode($code_base64);
        $image= imagecreatefromstring($code_binary);
        header('Content-Type: image/png');
        readfile(imagepng($image));
        imagedestroy($image);

    }

}