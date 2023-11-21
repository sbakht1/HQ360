<?php

namespace App\Controllers\NoAccess;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return redirect()->to('/under-construction');
    }
}
