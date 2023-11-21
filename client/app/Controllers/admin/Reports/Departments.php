<?php

namespace App\Controllers\Admin\Reports;

use App\Controllers\BaseController;
use App\Models\Setting;


class Departments extends BaseController{
    protected $path = 'admin/reports/departments/';
    protected $reps = ['obsoletes','eols'];

    public function index($name=false) {
        $set = new Setting();
        return (!$name) ? $this->all():$this->single($name);
    }

    private function single($name) {
        $set = new Setting();
        $rep = $set->select('content')->where(["name" => "$name-reports"])->first();
        $rep = json_decode($rep['content']);


        $title['Title'] = $rep->title;
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'single']);
        $data['report'] = $rep;
        return view('app',$data);
    }

    private function all() {
        $set = new Setting();

        $title['Title'] = "Reports";
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        $rep = $set->select('content')->like(["name" => "-reports"])->findAll();
        foreach($rep as $i => $item) $rep[$i] = json_decode($item['content']);
        $data['reports'] = $rep;
        return view('app',$data);
    }
}
