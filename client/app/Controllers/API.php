<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\Notification;

class Api extends BaseController
{
    public function index() {
        echo "";
    }
    
    public function store($list) {
        $db = db_connect();
        $store = $db->query("select StoreName,StoreID from stores")->getResultArray();
        $data = [];
        foreach( $store as $s ) {
            $data[$s['StoreID']] = $s['StoreName'];
        }
        return $this->response->setJSON($data);
    }

    public function employee($list) {
        $db = db_connect();
        $collect = $db->query("select Employee_Name,EmployeeID from employees where Account_Disabled='FALSE'")->getResultArray();
        // if (user_data('Title')[1] === 'store-team-leader') {
        //     $collect->where('DefaultLocation',profile('DefaultLocation'));
        // }
        $data = [];
        foreach( $collect as $s ) {
            $data[$s['EmployeeID']] = $s['Employee_Name'];
        }
        return $this->response->setJSON($data);
    }

    public function test(){
        $notes = get_notification_by_user();
        $note = new Notification();
        debug([$notes,$_SESSION['user_data']]);
    }
    
}
