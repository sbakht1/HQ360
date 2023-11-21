<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Store;
use App\Models\FileUpload;
use App\Models\Meta;

class Tickets extends BaseController
{
    protected $path = 'admin/tickets/';
    public function index() {
        $model = new Ticket();

        $title['Title'] = 'Tickets';
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
