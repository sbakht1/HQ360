<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class QuickLinks extends BaseController
{
    protected $path = 'admin/quick-links/';
    public function index() {

        $title['Title'] = 'Quick Links' ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }
}
