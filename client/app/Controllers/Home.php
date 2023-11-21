<?php

namespace App\Controllers;
use App\Models\Employee;
use App\Models\Site;
use App\Models\Form;
use App\Models\FileUpload;
use App\Models\FormCollection;
use App\Models\PulseModel;
use App\Models\Notification;

class Home extends BaseController
{
    protected $path = 'home/';
    public function index()
    {
        return redirect()->to('/login');
    }

    public function profile()
    {
        $data['page'] = emp_page(['Profile',$this->path.'profile'], '','');
        return view('app',$data);
    }

    public function update_profile() {
        $validation = $this->validate([
            'image' => [
                'uploaded[image]',
                'mime_in[image,image/jpg,image/jpeg,image/png,image/gif]',
                'max_size[image,10240]'
            ]
        ]);
       
        if ($validation) {
            $img = $this->request->getFile('image');
            $file = $_FILES['image'];
            $file['ext'] = ".".pathinfo($file['name'], PATHINFO_EXTENSION);

            if ( $img->isValid() ) {
                $name = profile('id');
                $filepath = PUBLIC_PATH."\uploads\users\\$name";
                foreach(IMAGES_EXT as $e) {
                    $fullpath = $filepath.$e;
                    if (file_exists($fullpath)) unlink($fullpath);
                }
                $img->move('./uploads/users/', $name.$file['ext']);
                session()->setFlashdata('success', 'Image Successfully updated.');
                return redirect('profile');
            }
        } else {
            session()->setFlashdata('danger', 'Invalid File');
            return redirect('profile');
        }
    }

    public function under_construction()
    {
        $data['page'] = emp_page(['',$this->path.'under-construction']);
        return view('app',$data);
    }
    
    public function check($type) {
        switch ($type) {
            case 'employee':
                $emp = new Employee();
                $check = $emp->where($_POST['name'],$_POST['value'])->first();
                echo ($check) ? 'false' : 'true';
                break;
                
                default:
                # code...
                break;
            }
        }
        
        
    public function form($id) {
        $req = request();
        return ($req->getMethod() == 'post') 
            ? $this->form_submit($id)
            : $this->form_view($id);
    }
    
    private function form_submit($id) {
        $site = new Site();
        $file = new FileUpload();
        $form = new Form();
        $collection = new FormCollection();
        $note = new Notification();
        $id = $site->decrypt($id);
        $form_info = (object) $form->find($id);

        foreach($_POST as $k => $v) {
            if($k !== 'employee') $data[$k] = $v;
        }
        foreach($_FILES as $k=>$v) {
            $up = $file->image('public_uploads',$k,time().'-'.$k);
            $data[$k] = $up['path'];
        }
        $__info = json_decode($data['__info'],true);
        unset($data['__info']);

        foreach ($data as $n => $v) {
            $nd[$n] = (@$__info[$n]) ? [$__info[$n], $v] : ["",""];
        }

        $emp = (@profile('EmployeeID')) ? profile('EmployeeID') : 0;

        
        $form_data = [
            'submit_by' => $emp,
            'data' => json_encode($nd),
            'form' => $id
        ];

        if(@$_POST['employee']) $form_data['employee'] = $_POST['employee'];

        $collection->insert($form_data);

        $detail = "Form Submission for $form_info->title by ".user_data('Employee_Name');
        $dsk = "/form-builder/view/".$collection->getInsertID();
        $cat = "Form Submission";
        $status="unread";
        $from = user_data('EmployeeID');
        $to = $form_info->created_by;
        $url_id = "";

        if($from != $to) $note->post_notification($detail,$dsk,$cat,$status,$from,$to,$url_id);

        return $this->response->setJSON(['success'=> true,'type'=>'success','msg' => 'Form has been submitted!']);
    }
    
    private function form_view($id) {
        $site = new Site();
        $formModel = new Form();
        $id = $site->decrypt($id);
        $form = $formModel->view($id); 
        $form = (!$form) ? ['title'=>'Form Not Found!','data'=>'[]'] : $form;
        $form['data'] = json_decode($form['data']);
        $data['page'] = [
            'title' => $form['title'],
            'path' => $this->path.'form',
            'layout' => 'auth'
        ];
        $data['form'] = $form;
        return view('app',$data);
    }
    
    public function upload() {
        $req = request();
        if ($req->getMethod() === 'post') {
            $file = new FileUpload();
            $up = $file->image('public_uploads','image',$_POST['name']);
            // $up['msg'] = $file->remove_file($_POST['file']);
            return $this->response->setJSON($up);
        }
    }
}
 