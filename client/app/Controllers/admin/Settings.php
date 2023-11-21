<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Setting;

class Settings extends BaseController
{
    protected $path = 'admin/settings/';
    public function index()
    {
        $model = new Setting();
        
        $title['Title'] = 'Settings' ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        $data['settings'] = $model->findAll();
        return view('app',$data);
    }

    public function create()
    {
        $reqType = request()->getMethod();
        if ( $reqType == 'post') {
            $model = new Setting();
            $info = $this->collect();
            $model->insert($info);
            session()->setFlashdata('success','The Setting has been added.');
            return redirect()->to('/admin/settings');
        } else {

            $title['Title'] = 'Add Setting' ;
            $title['subMenu'] = '';
            $title['subMenuPath'] = '';

            $data['page'] = emp_page([$title,$this->path.'create']);
            return view('app',$data);
        }
    }

    public function edit($id)
    {
        $model = new Setting();
        $reqType = request()->getMethod();
        if ( $reqType == 'post') {
            $info = $this->collect();
            $model->update($id,$info);
            session()->setFlashdata('success','Setting successfully updated');
            return redirect()->to('/admin/settings/'.$id);
        } else {
            $data['set'] = $model->where('id',$id)->first();

            $title['Title'] = 'Edit Setting' ;
            $title['subMenu'] = '';
            $title['subMenuPath'] = '';

            $data['page'] = emp_page([$title,$this->path.'create']);
            return view('app',$data);
        }
    }

    public function del($id)
    {
        $model = new Setting();
        $model->where('id', $id)->delete();
        session()->setFlashdata('success','Setting has been deleted successfully.');
        return redirect()->to('/admin/settings');
    }

    private function collect()
    {
        $data = [];
        foreach ( $_POST as $n => $v ) $data[$n] = $v;
        return $data;
    }
}
