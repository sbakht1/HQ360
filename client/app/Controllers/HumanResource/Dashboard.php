<?php

namespace App\Controllers\HumanResource;


use App\Controllers\BaseController;
use App\Models\Hub;

 class Dashboard extends BaseController {
    protected $path = 'human-resource/dashboard/';

    public function index()
    {
        $data['page'] = emp_page(['Dashboard',$this->path.'index']);
        // debug(['session'=> $_SESSION]);
        return view('app',$data);
        
    }
 }
 