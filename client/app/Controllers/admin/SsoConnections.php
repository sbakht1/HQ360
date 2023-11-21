<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SsoConnections extends BaseController
{
    protected $path = 'admin/sso-connections/';
    public function index() {

        $title['Title'] = 'SSO Connections';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }
}
