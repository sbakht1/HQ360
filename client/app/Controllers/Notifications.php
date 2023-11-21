<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Notification;
use App\Models\Employee;
use App\Models\EmpMeta;
use App\Models\Emaillogs;

class Notifications extends BaseController
{
    protected $path = 'notification/';
   
    public function index(){

        $pager = service('pager');
        $notes    = new notification();
        $get_emp  = new Employee();
        $get_notes_read = new EmpMeta();
        // $data['read_notes']  = $get_notes_read->read_notes();
        $whr = ['usr_to' => user_data('EmployeeID')];
        $lastMonth = $notes->where($whr)->orderBy('created','desc')->first()['created'];

        $m = (@$_GET['month']) ? $_GET['month'] : date("Y-m",strtotime($lastMonth));

        
        $sel = "created,detail,category,usr_from";

        $nots = $notes->select($sel)->where($whr)->havingLike('created',$m)->findAll();

        // debug($nots);
        
 
        // $data['view_all_notes'] =  $notes->get_by_user_paginate(profile('Title'),$DefaultLocation,'unread');
        $data['view_all_notes']['data'] =  $nots;
        $data['view_all_notes']['links'] =  "";
        $data['month'] = $m;


        $title['Title'] = "Notifications" ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([ $title,$this->path.'index']);

        $this->updateallnotifications();

        return view('app',$data);
    }

    
    public function updatenotifications(){
        $id=$_POST['nid'];
        $model    = new notification();
        $data['status'] = 'read';
        $model->update($id, $data);
       // print_r($id);
    }

    public function updateallnotifications(){ //Update All Notifications
        $notes    = new notification();
        $DefaultLocation = profile('DefaultLocation'); 
        $get_notes_read = new EmpMeta();
        $notifications = $notes->get_by_user_paginate_dup(profile('Title'),$DefaultLocation,'unread');
        $data['status'] = 'read';
        foreach ($notifications['data'] as $n) {
            $notes->update($n['id'], $data);
          }
    }

    public function set_notification_meta(){

        $emp_meta = new EmpMeta();
        for ($i=0; $i < count($_POST['nid']); $i++) { 
             $emp_meta->set_meta(profile('EmployeeID'),$_POST['nid'][$i],'read');
        }
        
    }

     public function sendmail(){
      

        // sql query SELECT * FROM `notifications` WHERE created > DATE_SUB(NOW(), INTERVAL 24 HOUR)
        $email = \Config\Services::email();

        $get_emp        = new Employee();
        $gen_email_logs = new Emaillogs();
        $get_notes      = new Notification();
        $setMessage     = [];   
       
       
        $usersEmails    = $get_emp->getEmployees();
        $mails          = [];
        $setFName       = 'The Wireless Experience';
        $setFrom        = 'portal@tweatt.com';
        $setSubject     = 'Daliy Notifications Update!';
        $setTo          = [];
        $setUsersLocation = [];
        $setEmpId       = [];
       
       
        foreach($usersEmails as $k => $d):
        $setUsersLocation[$k] = $d['DefaultLocation'];
        endforeach;
        $user_locations = array_unique($setUsersLocation);
       
        foreach($user_locations as $i => $n):
        $notes_data =  $get_notes->get_records_last_24_hours($n,'unread');
        if(!empty($notes_data)):
       
         foreach($notes_data as $arryK => $user):
     
            $setTo[$arryK]      = $user['Email'];
            $setMessage[$arryK] = $user['detail'];
            $setEmpId[$arryK]   = $user['EmployeeID'];

            $email->setFrom($setFrom,$setFName);
            $email->setSubject($setSubject);
            $email->setMessage($setMessage[$arryK]);
            
            $get_uniqueEmails = array_unique($setTo);
            $email->setTo($get_uniqueEmails);
            $gen_email_logs->gen_email_logs($setFrom,$user['Email'],$setSubject,$user['detail'],$user['EmployeeID']);
          
            if ($email->send()) 
            {
                echo 'Email successfully sent';
          
            } 
            else 
            {
                $data = $email->printDebugger(['headers']);
                // print_r($data);
            }


          endforeach;
         endif;
        endforeach;
    
    }
}
