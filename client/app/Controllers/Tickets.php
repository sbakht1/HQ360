<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Store;
use App\Models\FileUpload;
use App\Models\Meta;
use App\Models\Notification;


class Tickets extends BaseController
{
    protected $path = 'tickets/';
    public function index() {
        $model = new Ticket();

        $t = '';
        if(@$_GET['department']) $t = strtoupper($_GET['department']);
        if($t === 'INVENTORY') $t = ucwords(strtolower($t));

        $title['Title'] = $t." Tickets";
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }

    public function view($id) {
        $model = new Ticket();
        $employee = new Employee();
        $store = new Store();
        $ticket = $model->where('TicketID',$id)->first();
        $ticket['submit_by'] = $employee->info($ticket['submit_by'],$fields='Employee_Name,EmployeeID,Title,Email');
        $ticket['store'] = $store->info($ticket['store'],$fields='StoreName,StoreID,DistrictName,RegionName,City,Address');
        $ticket['data'] = json_decode($ticket['data'],true);
        $data['ticket'] = $ticket;

        $title['Title'] = 'View Ticket';
        $title['subMenu'] = 'Tickets';
        $title['subMenuPath'] = $this->path;

        $data['page'] = emp_page([$title,$this->path.'view']);
        return view('app',$data);
    }

    public function manage($id='new')
    {
        $model = new Ticket();
        $setting = new Setting();
        $notes =  new Notification();
        $redirect = "/admin/tickets/";
        $method = request()->getMethod();
        $session = session();

        if ( $method == 'post') {
            $data = [];
            foreach($_POST as $n => $v) $data[$n]=$v;
            
            $data['data'] = json_encode(rem_items($data,['store','ticket_type','department']));
            $data['assign_to'] = $data['department'];
            $file = new FileUpload();
            
            if ($id != 'new') {
                $redirect .= $id;
                $model->update($id, $data);

                if (@$_FILES) {
                    foreach($_FILES as $n=>$v) {
                        if ($_FILES[$n]['name'] !== "") {
                            $up = $file->doc('tickets',$n,$id);
                            if ($up['msg'] == 'success') {
                                $old_data = json_decode($model->where('id',$id)->first()['data'],true);
                                $old_data[$n] = $up['path'];
                                $new_data = json_encode($old_data);
                                $model->update($id, ['data'=>$new_data]);
                            } else {
                                return flash('danger','Store Image uploading Error.','admin/stores/'.$id);
                            }
                        }
                    }
                }
                 // generate notificatoins function 
                 $user_data = session()->get('user_data'); 
                 $emp_name =$user_data['Employee_Name']; 
                 $id = $model->getInsertID();
                 $ticket_id = digit_len($id,6);
                  $notes->post_notification("Updated Ticket ".$data['department']." has opened By $emp_name","null","ticket/".$data['department'],"unread",$user_data['EmployeeID'],$_POST['store'],$ticket_id);    
                  return $this->response->setJSON(['success'=>true,"message"=>"Ticket has been updated successfully!"]);
           
                } else {
           
                $data['status'] = 'New';
                $data['date'] = date('Y-m-d');
                $model->save($data);
                $id = $model->getInsertID();
                $ticket_id = digit_len($id,6);
                $model->update($id,['TicketID' => $ticket_id,'submit_by'=> profile('EmployeeID')]);
                
                if (@$_FILES) {
                    foreach($_FILES as $n=>$v) {
                        if ($_FILES[$n]['name'] !== "") {
                            $up = $file->doc('tickets',$n,$id);
                            if ($up['msg'] == 'success') {
                                $old_data = json_decode($model->where('id',$id)->first()['data'],true);
                                $old_data[$n] = $up['path'];
                                $new_data = json_encode($old_data);
                                $model->update($id, ['data'=>$new_data]);
                            } else {
                                return flash('danger','Store Image uploading Error.','admin/stores/'.$id);
                            }
                        }
                    }
                }
                // generate notificatoins function 
                $user_data = session()->get('user_data'); 
                $emp_name =$user_data['Employee_Name']; 
                $notes->post_notification("New Ticket ".$data['department']." has opened By $emp_name","null","ticket/".$data['department'],"unread",$user_data['EmployeeID'] , $_POST['store'],$ticket_id);    
                return $this->response->setJSON(['success'=>true,"message"=>"Ticket has been generated successfully!"]);
            }
        }
        $title1 = 'New Ticket';
        if ( $id !== 'new') {
            $redirect .= 'new';
            $title1 = 'Edit Ticket';
            $ticket = $model->where('TicketID', $id)->first();
            
            if (!isset($data['employee']['id'])) return redirect()->to($redirect);
        }
        $dep = (@$_GET['department']) ? $_GET['department'] : 'inventory';
        $data['form'] = $setting->get("ticket-form-$dep");

        $title['Title'] = $title1;
        $title['subMenu'] = 'Tickets';
        $title['subMenuPath'] = $this->path;

        $data['page'] = emp_page([$title,$this->path.'manage']);
        return view('app',$data);        
    }

    public function find() {
        $ticket = new Ticket();
        $find = $ticket->get_tickets();
        return $this->response->setJSON($find);
    }

    public function status()
    {        
        $ticket = new Ticket();
        $notes =  new Notification();
        $ticket_info = $ticket->where('TicketID',$_POST['ticket'])->first();
        $emp_Name = profile('Employee_Name');

        foreach($_POST as $n => $v) $data[$n] = $v;

   
        $ticket->update($_POST['ticket'], [
            'level' => (@$_POST['level']) ? $_POST['level'] : 0,
            'status'=> $_POST['status'],
            'assign_to' => $_POST['assign_to'],
            'assign_emp' => $_POST['assign_emp']
        ]);

        $detail = "Ticket updated By $emp_Name";
        $_note = [
            'detail' => $detail,
            'dsc' => 'null',
            'cat' => "ticket/".$_POST['assign_to'],
            'status' => "unread",
            'from' => profile('EmployeeID'),
            'to' => $ticket_info['store'],
            'id' => $_POST['ticket']
        ];
        $notes->post_notification($_note['detail'],$_note['dsc'],$_note['cat'],$_note['status'],$_note['from'],$_note['to'],$_note['id']);

        if($ticket_info['assign_emp'] != $_POST['assign_emp']) $_note['detail'] = "You have assign new ticket by $emp_Name";
        $_note['to'] = $_POST['assign_emp'];
   
        $notes->post_notification($_note['detail'],$_note['dsc'],$_note['cat'],$_note['status'],$_note['from'],$_note['to'],$_note['id']);
        return $this->response->setJSON(['success'=>'true']);
    }

    public function conversation() {

        $meta = new Meta();
        $method = request()->getMethod();
        $upload = new FileUpload();

        
        if ( $method == 'post' ) {

            foreach($_POST as $n => $v) $data[$n]=$v;
            $msg = $_POST['msg'];
            $userFileName = $_FILES['file']['name'];

            if($userFileName !== "") {
                $filePath = $upload->doc("tickets/".$_POST['ticket'],'file',time())['path'];
                $msg = json_encode([$msg, [$filePath,$userFileName]]);
            }

            $data = [
                'category' => 'tickets',
                'term' => profile('EmployeeID'),
                'meta_key' => 'message/'.$_POST['ticket'],
                'meta_value' => $msg
            ];
            $meta->save($data);
            unset($data['meta_value']);
            $data = $meta->where($data)->orderBy('id','DESC')->first();
            $data = [
                'employee'=> profile('Employee_Name'),
                'EmployeeID' => profile('EmployeeID'),
                'message' => $data['meta_value'],
                'time' => $data['created']
            ];
        } else {
            if ( @$_GET['status'] && @$_GET['ticket']) {
                $data = $meta->where([
                    'category'=>'tickets',
                    'meta_key' => 'message/'.$_GET['ticket']
                ])->orderBy('id','desc')->first();
                $data['status'] = $_GET['status'];
                $msg['msg'] = ($data['created'] === $_GET['status'])?'same':'updated';
                $data = $msg;
            } else {
                $data = $meta->ticket_msg(@$_GET['ticket']);
            }
        }
        return $this->response->setJSON($data);
        // $meta->get_meta($_POST['tickets'],$_)
        // $this->request->setJSON($data);
    }
}
