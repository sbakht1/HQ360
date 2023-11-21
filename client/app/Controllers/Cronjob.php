<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\admin\EmailSync;


class Cronjob extends BaseController
{
    public function index() {
        $oHome =  new Emailsync();
        $oHome->SyncEmails();
        return '';
    }
}
