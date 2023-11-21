<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Urgent;
use App\Models\Meta;

class Urgents extends BaseController
{
    protected $path = 'admin/urgents/';
    public function index(){

        $title['Title'] = "Urgent Messages" ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }
    
    public function view($id=""){
        $req = request();
        return ($req->getMethod() == "post") ? $this->submit($id): $this->show($id);
    }

    public function acknowledge() {
        $req = request();
        if ( $req->getMethod() !== "post" ) return;
        $meta = new Meta();
        foreach($_POST as $n => $v) $data[$n] = $v;
        return $meta->post_meta("urgent",$_POST["msg_id"],"acknowledge");
    }

    public function seen($id){
        $meta = new Meta();
        $urgent = new Urgent();
        $data = $meta->with_term('urgent',$id);
        if(@$_GET['export']) {
            $msg = $urgent->find($id)['title'];
            $dt = date('Y-m-d Hi');
            // return $this->response->setJSON($msg);
            return array_to_csv_download($data,"$msg - $dt.csv");
        } else {
            return $this->response->setJSON($data);
        }
    }
    

    private function submit($id) {
        $urgent = new Urgent();
        $data = [
            'title' => $_POST['title'],
            'message' => $_POST['message'],
            'status' => $_POST['status'],
            'updated_by' => profile('EmployeeID'),
            'limit' => $_POST['limit'],
            'start' => strtotime($_POST['start']),
            'end' => strtotime($_POST['end'])
        ];
        if ($_POST['limit'] != 'Limited') $data['start'] = $data['end'] = "";
        if ( $id == "" ) $data['author'] = profile('EmployeeID');

        if ( $id !== "" ) {
            $urgent->update($id,$data);
            $msg = "Message has been updated.";
        } else {
            $urgent->insert($data);
            $urgent->getInsertID();
            $msg = "Message has been submitted.";
            return flash('success',$msg,"/admin/urgent/view");
        }
        return flash('success',$msg,"/admin/urgent/view/$id");
    }
    private function show($id){
        $urgent = new Urgent();

        $title['Title'] = "Urgent Messages" ;
        $title['subMenu'] = 'Messages';
        $title['subMenuPath'] = 'admin/urgent/';

        $data['page'] = emp_page([$title,$this->path.'view']);
        $data['id'] = $id;
        $found = $urgent->find($id);
        if ( $found == NULL && $id != "" ) return redirect()->to('/admin/articles/view');
        $data['message'] = $found;
        return view('app',$data);
    }
}
