<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Hub;
use App\Models\FileUpload;
use App\Models\Notification;
class Hubs extends BaseController
{
    protected $path = 'admin/hubs/';
    public function index() {
        $hub = new Hub();

        $title['Title'] = 'Hub Management';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        $data['hubs'] = $hub->where(['category'=>0,'panel'=>0])->findAll();

        if ( @$_GET['category'] ) {
            $panel = $hub->where(['category'=>$_GET['category'],'panel'=>0])->findAll();
            $panel = panel_items($panel);
            $data['panel'] = $panel;
        } else {
            return redirect()->to($_SESSION['user_data']['Title'][1].'/hubs?category='.$data['hubs'][0]['id']);
        }

        return view('app',$data);
    }


    public function create()
    {
        $hub = new Hub();
        $notes =  new Notification();
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
                    $new_cont = [$_POST['title'],$_POST['link']];
                    if ($_FILES['icon']['name'] !== "") {
                        $file = $fileUpload->image('quick-links','icon',time())['path'];
                        $new_cont[2] = $file;
                    } else {
                        if ( $_POST['id'] !== "") {
                            $content = json_decode($hub->where('id', $_POST['id'])->first()['content']);
                            if ( sizeof($content) > 2 ) $new_cont[2] = $content[2];
                        }
                    }
                    $data = [
                        'category' => $_POST['category'],
                        'panel' => $_POST['panel'],
                        'content' => json_encode($new_cont)
                    ];
                    break;
                case 'delete':
                    $hub->delete($_POST['id']);
                    break;
                default:
                    # code...
                    break;
            }

            // return $this->response->setJSON($data);
           
            if ( $type !== 'delete' ) {
                if ( $_POST['id'] !== '') {
                 // generate notificatoins function 
                 $user_data = session()->get('user_data'); 
                 $emp_name =$user_data['Employee_Name']; 
                 $notes->post_notification("New Hub: ".$_POST['title']. " Updated By $emp_name","null","hub","unread",$user_data['EmployeeID'] , 0 , $data['category']);    
            
                 $hub->update($_POST['id'],$data);
             
                } else {
                         // generate notificatoins function 
                 $user_data = session()->get('user_data'); 
                 $emp_name =$user_data['Employee_Name']; 
                 $notes->post_notification("New Hub: ".$_POST['title']. " Created By $emp_name","null","hub","unread",$user_data['EmployeeID'] , 0 , $data['category']);    
             
                 $hub->save($data);
              
                }
            }
            return $this->response->setJSON(['success'=> true]);
        }
    }

    public function delete()
    {
        $hub = new Hub();
        $hub->where(['id'=>$_POST['id']])->delete();
        if($_POST['type'] == "panel") $hub->where(['panel'=>$_POST['id']])->delete();
        if($_POST['type'] == "hub") $hub->where(['category'=>$_POST['id']])->delete();
        return $this->response->setJSON(['success'=>true,'type'=>$_POST['type']]);
    }

    public function remove_icon()
    {
        $hub = new Hub();
        $file = new FileUpload();
        if (@$_POST['id']) {
            $item = $hub->find($_POST['id']);
            $item['content'] = json_decode($item['content']);
            $file->remove_file(str_replace('/',"\\",$item['content'][2]));
            unset($item['content'][2]);
            
            $item['content'] = json_encode($item['content']);
            $hub->update($_POST['id'],$item);
            return $this->response->setJSON(['success' => true, 'item' => json_decode($item['content'])]);
        }
    }
}
