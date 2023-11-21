<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Connection;
use App\Models\Notification;
use App\Models\Setting;

class Connections extends BaseController
{
    protected $path = 'admin/connections/';
    public function index() {
        if(@$_GET['del']) {
            return $this->delete($_GET['del']);
        }
        $model = new Connection();

        $title['Title'] = 'Connections';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        $data['connections'] = $model->get_data();
        return view('app',$data);
    }

    public function manage($id="new")
    {
        $req = request();
        return ( $req->getMethod() == 'post') ? $this->submission($id) : $this->info($id);
    }

    private function info($id)
    {
        $model = new Connection();
        
        $role = user_data('Title')[1];
       // $title = 'Add Connection';
       $title['Title'] = 'Add Connection';
       $title['subMenu'] = 'Connections';
       $title['subMenuPath'] = $this->path;
        $path = $this->path.'manage';
        
        if ( $id !== 'new') {
            //$title = 'Edit Connection';

            $title['Title'] = 'Edit Connection';
            $title['subMenu'] = 'Connections';
            $title['subMenuPath'] = $this->path;

            $item_ = $model->find($id);
            $data['item_'] = $item_;
            if ($role === 'salespeople') {
                if($item_['employee'] != profile('EmployeeID')) return \redirect()->to('/');
            }
        }
        $data['page'] = emp_page([$title,$path]);
        return view('app', $data);
    }

    public function find(){
        $mod = new Connection();
        $data = $mod->find_with_fiters();
        $month = (@$_GET['month']) ? $_GET['month'] : date('Y-m');
        // debug($_SERVER);
        return (@$_GET['export']) 
            ? array_to_csv_download($data,"connections-$month.csv")
            : $this->response->setJSON($data);
    }

    private function delete($id) {
        $m = new Connection();
        $m->delete($id);
        return flash('success','Successfully Deleted',$_SERVER['HTTP_REFERER']);
    }
    
    private function submission($id)
    {
        $role = user_data('Title')[1];
        $redirect = "/$role/connections/";
        $session = session();
        $model = new Connection();
        $notes =  new Notification();
        $isValid = $this->validate([
            'store' => 'trim|required',
            'month' => 'trim|required',
            'date' => 'trim|required',
            'employee' => 'trim|required'
        ]);
        
        foreach($_POST as $n => $v) {
            if($n != 'store' && $n != 'employee' && $n != 'date' && $n != 'month')
                $info[] = $v;
            else
                $data[$n] = $v;
        }
        
        if (!$isValid) {
            $redirect .= $id;
            $session->setFlashdata('item_', $data);
            $session->setFlashdata('validation',validation());
            $session->setFlashdata('item_', $data);
            return redirect()->to($redirect);
        }
        
        $data['info'] = json_encode($info);

        
        if ( $id != 'new' ) {
            // update
            $data['update_by'] = profile('EmployeeID');
            $model->update($id, $data);
            // generate notificatoins function 
            $user_data = session()->get('user_data'); 
            $emp_name =$user_data['Employee_Name']; 
            $notes->post_notification_agssign_to("Connection has been created by $emp_name","null","connection","unread",$user_data['EmployeeID'] , $_POST['store'],$id , $_POST['employee']);
            return flash('success','Connection successfully updated.', "$role/connections/$id");
        } else {
            // save
            $data['update_by'] = profile('EmployeeID');
            $data['submit_by'] = profile('EmployeeID');
            $model->save($data);
            $redirect .= $model->getInsertID();
             // generate notificatoins function 
            $user_data = session()->get('user_data'); 
            $emp_name =$user_data['Employee_Name']; 
            $notes->post_notification_agssign_to("New Connection has been created by $emp_name","null","connection","unread",$user_data['EmployeeID'] , $_POST['store'],$model->getInsertID(), $_POST['employee']);    
          
            return flash('success','Connection submitted Successfully!', $redirect);
        }
    }

    public function form() {
        return (request()->getMethod() == "post") ? $this->save_form() : $this->show_form();
    }

    private function save_form() {
        $setting = new Setting();
        $form = settings('connection-form',true);
        $info = [$_POST['title'],$_POST['type'],""];

        if($_POST['type'] == 'message') $info=[$_POST['title']];

        if($_POST['i'] !== "") {
            $form[(int)$_POST['i']] = $info;
        } else {
            $form[] = $info;
        } 
        $setting->_save('connection-form',$form);
        return flash("success","Form has been updated",$_SERVER['HTTP_REFERER']);
    }
    
    private function show_form() {
        if(isset($_GET['del'])) {
            $setting = new Setting();
            $form = settings('connection-form',true);
            unset($form[$_GET['del']]);
            $setting->_save('connection-form',$form);
            return flash("success","Field has been deleted",$_SERVER['HTTP_REFERER']);
        } else {
            
            $title['Title'] = 'Connection form';
            $title['subMenu'] = 'Connections';
            $title['subMenuPath'] = $this->path;

            $data['page'] = emp_page([$title,$this->path."form"]);
            return view('app', $data);
        }

    }
}
