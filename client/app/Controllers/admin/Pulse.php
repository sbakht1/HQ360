<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PulseModel;

class Pulse extends BaseController
{
    protected $path = 'admin/pulse/';
    public function index(){

        $title['Title'] = "Daily Pulse" ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = \emp_page([$title,$this->path."index"]);
        return view('app',$data);
    }
    public function find(){
        $mod = new PulseModel();
        return $this->response->setJSON($mod->find_all());
    }
    public function add() {
        $pulse = new PulseModel();
        
        $data = [
            'employee' => profile('EmployeeID'),
            'feeling' => $_POST['feeling'],
            'happiness' => $_POST['happiness']
        ];

        $pulse->insert($data);
        unset($_SESSION['user_data']['pulse']);
        return $this->response->setJSON(['success' => true, 'msg' => 'Thank you for your feedback!']);
    }
}
