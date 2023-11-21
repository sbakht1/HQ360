<?php

namespace App\Controllers\DistrictTeamLeader;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\Store;
use App\Models\Hub;

class Dashboard extends BaseController
{
    protected $path = 'district-team-leader/dashboard/';
    public function index() {
        $hub = new Hub();
        $data['page'] = emp_page(['Dashboard', $this->path.'index']);
        $panel = $hub->where(['category'=>89,'panel'=>0])->findAll();
        $panel = panel_items($panel);
        $data['panel'] = $panel;
        return view('app',$data);
    }
}
