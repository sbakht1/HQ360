<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Hub;
use App\Models\FileUpload;

class Hubs extends BaseController
{
    protected $path = 'hubs/';
    public function index() {
        $hub = new Hub();
        $data['page'] = emp_page(['Hubs',$this->path.'index']);
        $data['hubs'] = $hub->where(['category'=>0,'panel'=>0])->findAll();

        if ( @$_GET['category'] ) {
            $panel = $hub->where(['category'=>$_GET['category'],'panel'=>0])->findAll();
            $panel = $this->panel_items($panel);
            $data['panel'] = $panel;
        } else {
            return redirect()->to($_SESSION['user_data']['Title'][1].'/hubs?category='.$data['hubs'][0]['id']);
        }

        return view('app',$data);
    }


    public function create()
    {
        $hub = new Hub();
        $req = request();
        if ( $req->getMethod() == 'post' ) {

            $type = $_POST['type'];

            switch ($type) {
                case 'category':
                    $data = [
                        'category' => 0,
                        'panel' => 0,
                        'content' => json_encode([$_POST['title'],$_POST['description']])
                    ];
                    break;
                case 'panel':
                    $data = [
                        'category' => $_POST['category'],
                        'panel' => 0,
                        'content' => json_encode([$_POST['title'], $_POST['description']])
                    ];
                    break;
                case 'item':
                    $fileUpload = new FileUpload();
                    $file = "";
                    if ($_FILES['icon']['name'] !== "") {
                        $file = $fileUpload->image('quick-links','icon',time())['path'];
                    } else {
                        if ( $_POST['id'] !== "" ) {
                            $content = json_decode($hub->where('id', $_POST['id'])->first()['content']);
                            $file = $content[2];
                        }
                    }
                    $data = [
                        'category' => $_POST['category'],
                        'panel' => $_POST['panel'],
                        'content' => json_encode([$_POST['title'],$_POST['link'],$file])
                    ];
                    break;
                case 'delete':
                    $hub->delete($_POST['id']);
                    break;
                default:
                    # code...
                    break;
            }

            if ( $type !== 'delete' ) {
                if ( $_POST['id'] !== '') {
                    $hub->update($_POST['id'],$data);
                } else {
                    $hub->save($data);
                }
            }
            return $this->response->setJSON(['success'=> true]);
        }
    }

    private function panel_items($panel) {
        $hub = new Hub();
        for ($i=0; $i < sizeof($panel); $i++) { 
            $panel[$i]['items'] = $hub->where(['panel'=>$panel[$i]['id']])->findAll();
        }
        return $panel;
    }
}
