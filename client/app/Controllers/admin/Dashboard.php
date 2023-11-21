<?php

namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use App\Models\Hub;
use App\Models\Notification;
use App\Models\Employee;


 class Dashboard extends BaseController {
    protected $path = 'admin/dashboard/';

    public function view_all_notifications(){
      $data['page'] = emp_page(['Notification',$this->path.'index']);
      return view('app',$data);
    }

    public function index()
    {
        $db = db_connect();
        $hub = new Hub();
        $notes =  new Notification();
        $emp = new Employee();
        $title['Title'] = 'Dashboard';
        $title['subMenu'] = '';
        $data['page'] = emp_page([$title,$this->path.'index']);
      //   $numbers = [];
      //   $numbers['employees'] = $db->query('select * from employees where `Account_Disabled` = "FALSE"')->getNumRows();
      //   $numbers['stores'] = $db->query('select * from stores where `Enabled`="TRUE"')->getNumRows();
      //   $numbers['districts'] = $db->query('select DistrictName from stores where `Enabled`="TRUE" group by DistrictName')->getNumRows();
      //   $numbers['open_tickets'] = $db->query('select * from tickets where `status` != "Closed"')->getNumRows();
      //   $data['numbers'] = $numbers;

        
        $panel = $hub->where(['category'=>89,'panel'=>0])->findAll();
        $panel = panel_items($panel);
       
        $data['panel'] = $panel;
        // $user_data = session()->get('user_data'); 
        // $data['get_notification_by_user']  = $notification->get_by_user($user_data['EmployeeID']);
        
        
        //   echo "<pre>";
        
         // generate notificatoins function 
         $user_data = session()->get('user_data'); 
        //  print_r($user_data['EmployeeID']);
        //  print_r($user_data['Employee_Name']);
        //  print_r($user_data['Title'][0]);
         $emp_name =$user_data['Employee_Name']; 
         $emp_id   =$user_data['EmployeeID'];
        //  $notes->post_notification("New Ticket has opened By $emp_name","null","tickets","unread",$emp_id,35);    

        // $cur_emp = $emp->get_current_emp($emp_id);  
        // print_r($cur_emp[0]['DefaultLocation']);

         // get all notifications 
            // print_r($notification->get_all());  
         
         // get notifications by category
            // print_r($notification->get_by_category("Sales Notification Detial" , "unread"));
       
         // get category by user
            // print_r($notification->get_category_by_user("Notification Detial",$user_data['EmployeeID'] , "unread"));
 
         // get nofications by user
            // print_r($notification->get_by_user($user_data['EmployeeID', "unread"]));
     

        // // debug($ql);
       
        return view('app',$data);
        
    }
 }
 