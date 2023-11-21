<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Card;

class Cards extends BaseController
{
    protected $path = 'admin/cards/';
    public function index() {

        $title['Title'] = "Business Card"; 
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }

    public function manage($id=false) {
        $req = request();
        if ( $id === false) $id = "";
        return ($req->getMethod() === 'post') ? $this->save($id) : $this->display($id);
    }
    
    private function display($id="") {
        if ( $id != "") {
            $card = new Card();
            $info = $card->find($id);
            $data['card'] = $info;
        }
        $title1 = ($id == false ) ? "Create Card" : "Update Card";

        $title['Title'] = $title1;
        $title['subMenu'] = 'cards';
        $title['subMenuPath'] = 'admin/card/';

        $data['page'] = \emp_page([$title,$this->path."manage"]);
        return view('app',$data);
    }
    
    private function save($id=""){
        $card = new Card();
        foreach ($_POST as $n=>$v) $data[$n]=$v;
        unset($data['employee']);
        $info = ['employee' => $_POST['employee'], 'updated_by' => profile('EmployeeID'),'data' => json_encode($data)];
        ( $id != "") ? $card->update($id,$info) : $card->insert($info);
        $msg = [
            'type' => 'success',
            'msg' => ($id != "") ? "Successfully Updated" : "Successfully Created",
            "id" => ($id == false) ? $card->getInsertID():""
        ];
        return $this->response->setJSON($msg);
    }

    public function find(){
        $card = new Card();
        $data = $card->getCards();
        return $this->response->setJSON($data);
    }
}
