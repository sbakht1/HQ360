<?php

namespace App\Controllers\FullAccess;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return redirect()->to('/under-construction');
    }
}
