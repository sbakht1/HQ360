<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Card;

class Cards extends BaseController
{
    protected $path = 'card/';
    public function index() {
        if(user_data('Title')[1] !== 'admin') return redirect()->to('/');
        $req = request();
        return ($req->getMethod() === 'post') ? $this->save() : $this->display();
    }
    
    private function display() {
        $card = new Card();
        $info = $card->where('employee', profile('EmployeeID'))->first();
        
        $data['card'] = $info;
        //$title = ( !$info ) ? "Create Card" : "Update Card";

        $title['Title'] = ( !$info ) ? "Create Card" : "Update Card"; 
        $title['subMenu'] = 'Cards';
        $title['subMenuPath'] = $this->path;


        $data['page'] = emp_page([$title,$this->path."manage"]);
        return view('app',$data);
    }
    
    private function save(){
        $card = new Card();
        $id = $card->where('employee', profile('EmployeeID'))->first();
        foreach ($_POST as $n=>$v) $data[$n]=$v;
        unset($data['employee']);
        $info = ['employee' => $_POST['employee'], 'updated_by' => profile('EmployeeID'),'data' => json_encode($data)];
        ( $id )?$card->update($id,$info):$card->insert($info);
        $msg = [
            'type' => 'success',
            'msg' => ($id) ? "Successfully Updated":"Successfully Created"            
        ];
        return $this->response->setJSON($msg);
    }
}
