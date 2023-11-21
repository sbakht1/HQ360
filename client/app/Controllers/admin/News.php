<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NewsModel;
use App\Models\FileUpload;
use App\Models\Employee;
use App\Models\Notification;

class News extends BaseController
{
    protected $path = 'admin/news/';
    public function index() {
        return (@$_POST) ? $this->submit() : $this->display();
    }

    public function manage($id=false) {
        if ($id==false) return "";
        $news_model = new NewsModel();
        $emp = new Employee();
        $news = $news_model->where('id', $id)->first();
        $news['author'] = $emp->where('EmployeeID', $news['author'])->select('Employee_Name')->first();
        $data['news'] = $news;

        $title['Title'] = 'News & Announcements' ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'manage']);
        return view('app',$data);
        
    }
    
    private function submit(){
        $news_model = new NewsModel();
        $upload = new FileUpload();
        $notes =  new Notification();
        $news = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'status' => 'publish'
        ];
        if ($_FILES['media']['name'] != "") $news['media'] = $upload->image('news','media',time())['path'];
        if ($_POST['id'] != "") {
            $id = $_POST['id'];
            $news['updated_by'] = profile('EmployeeID');
                // generate notificatoins function 
                $user_data = session()->get('user_data'); 
                $emp_name =$user_data['Employee_Name']; 
           
            $news_model->update($id,$news);
            if($news['status'] == '')
            $notes->post_notification("News ".$_POST['title']." Posted Updated By $emp_name","null","news","unread",$user_data['EmployeeID'] , 0, $id);    
           
            $msg = 'Successfully Updated';
        } else {
            $news['author'] = profile('EmployeeID');
                // generate notificatoins function 
                $user_data = session()->get('user_data'); 
                $emp_name =$user_data['Employee_Name']; 
               
            $news_model->save($news);
            $notes->post_notification("News ".$_POST['title']." Posted By $emp_name","null","news","unread",$user_data['EmployeeID'] , 0, $news_model->getInsertID());    
           
            $msg = 'Successfully Submitted';
        }
        return flash('success',$msg, user_data('Title')[1].'/news');
    }
    
    private function display() {
        $news_model = new NewsModel();

        $title['Title'] = 'News & Announcements' ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        $data['news'] = $news_model->get_entries();
        return view('app',$data);
    }
}
