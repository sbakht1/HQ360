<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Article;
use App\Models\Meta;
use App\Models\Notification;

class Articles extends BaseController
{
    protected $path = 'admin/articles/';
    public function index()
    {
        $data['page'] = emp_page(['Knowledge Base',$this->path.'index']);
        return view('app',$data);
    }

    public function view($id=''){
        $req = request();
        return ( $req->getMethod() == 'post') ? $this->submit($id) : $this->display($id);
    }

    private function submit($id) {
        if ( @$_POST['type'] == 'category' ) {
            $meta = new Meta();
            if ( isset($_POST['parent']) && isset($_POST['name'])) {
                $meta->post_meta('article-category',$_POST['parent'],$_POST['name']);
            }
            $data = $meta->select('meta_key as parent, meta_value as name, id')->where(['category' => 'article-category'])->findAll();
            return $this->response->setJSON($data);
        } else {
            $article = new Article();
            $notes =  new Notification();
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'status' => $_POST['status'],
                'category' => $_POST['category'],
                'updated_by' => profile('EmployeeID')
            ];
            if ( $id == "") {
                $data['author'] = profile('EmployeeID');
                $article->insert($data);
                 
                // generate notificatoins function 
                $user_data = session()->get('user_data'); 
                $emp_name =$user_data['Employee_Name']; 
                if($_POST['status'] == "Publish"):
                 $notes->post_notification("New Article: ".$_POST['title']. " Created By $emp_name","null","article","unread",$user_data['EmployeeID'] , 0, $article->getInsertID());    
                endif;
                $msg = 'Successfully Added.';
                $url = user_data('Title')[1].'/articles/view/'.$article->getInsertID();
            } else {
                $article->update($id,$data);
                // generate notificatoins function 
                $user_data = session()->get('user_data'); 
                $emp_name =$user_data['Employee_Name']; 
                if($_POST['status'] == "Publish"):
                $notes->post_notification("New Article: ".$_POST['title']. " Updated By $emp_name","null","article","unread",$user_data['EmployeeID'] , 0 ,$id);    
                endif;

                $msg = 'Successfully Updated';
                $url = user_data('Title')[1].'/articles/view/'.$id;
            }
            return flash('success',$msg,$url);
        }
    }

    private function display($id) {
        $article = new Article();
        $data['page'] = emp_page(['Knowledge Base',$this->path.'view']);
        $data['id'] = $id;
        $found = $article->find($id);
        if ( $found == NULL && $id != "" ) return redirect()->to('/'.user_data('Title')[1].'/articles/view');
        $data['article'] = $found;
        return view('app',$data);
    }
}


//check status of articals 
// store team leader 
// hr need to be fix for all by category