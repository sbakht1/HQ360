<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Reportings extends BaseController
{
    protected $path = 'admin/reportings/';
    public function index() {

        $title['Title'] = 'Operations & Reporting' ;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }
}
