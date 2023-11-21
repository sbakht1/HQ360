<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NewsModel;
use App\Models\FileUpload;
use App\Models\Employee;
use App\Models\Notification;


class News extends BaseController
{
    protected $path = 'news/';
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
        $data['page'] = emp_page(['News & Announcements',$this->path.'manage']);
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
             
            $news_model->update($id,$news);
            $msg = 'Successfully Updated';
        } else {
            $news['author'] = profile('EmployeeID');
             
            $news_model->save($news);
            $msg = 'Successfully Submitted';
        }
        return flash('success',$msg, 'admin/news');
    }
    
    private function display() {
        $news_model = new NewsModel();
        $data['page'] = emp_page(['News & Announcements',$this->path.'index']);
        $data['news'] = $news_model->get_entries();
        return view('app',$data);
    }
}
