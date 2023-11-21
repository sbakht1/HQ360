<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PulseModel;

class PulseSeeder extends Seeder
{
    public function run()
    {
        $pulse = new PulseModel();
        $data = $pulse->findAll();

        foreach($data as $item) {
            $info = json_decode($item['info']);
            $pulse->update($item['id'],[
                'feeling' => $info->feeling,
                'happiness' => $info->happiness
            ]);
        } 
    }
}
