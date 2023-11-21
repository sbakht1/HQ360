<?php

namespace App\Controllers\Salespeople;

use App\Controllers\BaseController;
use App\Models\Scorecard;
use App\Models\ScorecardMeta;
use App\Models\Site;
use App\Models\Employee;

class Scorecards extends BaseController
{
    protected $path = 'salespeople/scorecards/';
    public function index() {
        $data['page'] = emp_page(['Scorecards',$this->path.'index']);
        return view('app',$data);
    }

    public function view($card_number,$month){
        if ( $card_number !== profile("EmployeeID")) return $this->response->setJSON([]);
        $sc = new Scorecard();
        $meta = new ScorecardMeta();
        $emp = new Employee();
        $data = $sc->where(['card_number' => $card_number,'month' => $month])->first();
        $data['visit'] = json_decode($data['visit']);
        $data['meta'] = $meta->where(['meta_key' => $card_number,'month'=>$month])->first();
        $data['meta']['meta_value'] = json_decode($data['meta']['meta_value']);
        $data['employee'] = $emp->info($data['card_number'],'Employee_Name,Title,EmployeeID');
        return $this->response->setJSON($data);
    }


    public function find() {
        $sc = new Scorecard();
        $data = $sc->yearly();
        return $this->response->setJSON($data);
    }
    
}
