<?php

namespace App\Controllers\StoreTeamLeader;

use App\Controllers\BaseController;

use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Store;
use App\Models\FileUpload;
use App\Models\Meta;

class Tickets extends BaseController
{
    protected $path = 'store-team-leader/tickets/';
    public function index() {
        $model = new Ticket();
        $store = new Store();
        // debug($model->where('store',profile('DefaultLocation'))->findAll());
        $data['page'] = emp_page(['Tickets',$this->path.'index']);
        return view('app',$data);
    }

    public function manage($id='new')
    {
        $model = new Ticket();
        $setting = new Setting();
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
                
                return $this->response->setJSON(['success'=>true,"message"=>"Ticket has been generated successfully!"]);
            }
        }
        $title = 'New Ticket';
        if ( $id !== 'new') {

            
            $redirect .= 'new';
            $title = 'Edit Ticket';
            $ticket = $model->where('TicketID', $id)->first();
            
            if (!isset($data['employee']['id'])) return redirect()->to($redirect);
        }
        $dep = (@$_GET['department']) ? $_GET['department'] : 'inventory';
        $data['form'] = $setting->get("ticket-form-$dep");
        $data['page'] = emp_page([$title,$this->path.'manage']);
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
        $data['page'] = emp_page(['Ticket',$this->path.'view']);
        return view('app',$data);
    }
    public function status()
    {
        $ticket = new Ticket();
        $ticket->update($_POST['ticket'], ['status'=> $_POST['status']]);
        return $this->response->setJSON(['success'=>'true']);
    }

    public function conversation() {
        $meta = new Meta();
        $method = request()->getMethod();
        if ( $method == 'post' ) {
            $data = [
                'category' => 'tickets',
                'term' => profile('EmployeeID'),
                'meta_key' => 'message/'.$_POST['ticket'],
                'meta_value' => $_POST['msg']
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
