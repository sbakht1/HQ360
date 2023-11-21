<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Observation;
use App\Models\Notification;
use App\Models\Setting;

class Observations extends BaseController
{
    protected $path = 'admin/observations/';
    public function index() {
        if(@$_GET['del']) {
            return $this->delete($_GET['del']);
        }
        $model = new Observation();
        $data['observations'] = $model->getObservation();


        $title['Title'] = 'Observations';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';


        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }

    public function form(){

        return (request()->getMethod() != "post") ? $this->form_view() : $this->form_sub();
    }

    public function find(){
        $mod = new Observation();
        $data = $mod->find_with_fiters();
        $month = (@$_GET['month']) ? $_GET['month'] : date('Y-m');
        // debug($_SERVER);
        if(@$_GET['export']) {
            foreach($data as $i => $d) {
                foreach($d['detail']['behavior'] as $b) $data[$i][$b['question']] = array_search($b['value'][0],$b['options']);
                foreach($d['detail']['sales'] as $s) $data[$i][$s['question']] = array_search($s['value'][0],$s['options']);
                foreach($d['detail']['twe_way'] as $t) $data[$i][$t['question']] = array_search($t['value'][0],$t['options']);
                unset($data[$i]['detail']);
            }
            // debug($data);
            return array_to_csv_download($data,"observations-$month.csv");
        } else {
            return $this->response->setJSON($data);
        }
    }

    private function delete($id) {
        $m = new Observation();
        $m->delete($id);
        return flash('success','Successfully Deleted',$_SERVER['HTTP_REFERER']);
    }
    
    private function form_view() {

        $title['Title'] = 'Observations form';
        $title['subMenu'] = 'Observations';
        $title['subMenuPath'] = $this->path;

        $data['page'] = emp_page([$title,$this->path.'form']);
        return view('app',$data);
    }
    private function form_sub() {
        $setting = new Setting();
        $setting->_save('observation_question',$_POST['data']);
        session()->setFlashdata('success','Form has been Updated');
        return $this->response->setJSON(['success'=>true]);
    }


    public function manage($id='new')
    {
        $model = new Observation();
        $notes =  new Notification();
        $role = user_data('Title')[1];
        $redirect = "/$role/observations/";
        $ptitle = "Observation";
        $method = request()->getMethod();
        $session = session();
        $docError = 'Please upload pdf file';

        if ( $method == 'post') {
            $data = [];
            foreach($_POST as $n => $v) $data[$n]=$v;
            $data['submit_by'] = profile('EmployeeID');
            $data['last_updated_by'] = profile('EmployeeID');

            // $data['detail'] = \json_decode($data['detail'],true);


            $validate = [
                'store'=> 'required',
                'employee' => 'required',
                'interaction_type' => 'required'
            ];
            
            $isValid = $this->validate($validate);
            
            if (!$isValid) {
                $redirect .= $id;
                $session->setFlashdata('validation',validation());
                $session->setFlashdata('item_', $data);
                return redirect()->to($redirect);
            }
                        
            if ($id != 'new') {
                $redirect .= $id;
                $model->update($id, $data);
                $session->setFlashdata('success','Observation has been updated successfully!');
                  // generate notificatoins function 
                  $user_data = session()->get('user_data'); 
                  $emp_name =$user_data['Employee_Name']; 
                  $notes->post_notification_agssign_to("New Observation has been updated by $emp_name","null","observations","unread",$user_data['EmployeeID'] , $_POST['store'],$id, $_POST['employee']);    
               
               
                return redirect()->to($redirect);

            } else {
                $data['month'] = date('Y-m');
                $model->save($data);
                $in_id = $model->getInsertID();
                $session->setFlashdata('success','Observation has been submitted successfully!');
                  // generate notificatoins function 
                  $user_data = session()->get('user_data'); 
                  $emp_name =$user_data['Employee_Name']; 
                  $notes->post_notification_agssign_to("New Observation has been created by $emp_name","null","observations","unread",$user_data['EmployeeID'] , $_POST['store'],$model->getInsertID() , $_POST['employee']);    
               
                return redirect()->to($redirect.$in_id);
            }
        }
        //$title = "New $title";
        $title['Title'] = "New $ptitle";
        $title['subMenu'] = 'Tickets';
        $title['subMenuPath'] = $this->path;

        $data['action'] = 'new';
        if ( $id !== 'new') {
            $redirect .= 'new';
            $title['Title'] = "Edit $ptitle";
            $title['subMenu'] = 'Tickets';
            $title['subMenuPath'] = $this->path;

            //$title = "Edit $title";
            $item_ = $model->find($id);
            $data['action'] = 'edit';
            if ($role === 'salespeople') {
                if($item_['employee'] != profile('EmployeeID')) return \redirect()->to('/');
            }
            $data['item_'] = $item_;
            if (!isset($data['item_']['id'])) return redirect()->to($redirect);
        }


       

        $data['page'] = emp_page([$title,$this->path.'manage']);
        return view('app',$data);        
    }
}
