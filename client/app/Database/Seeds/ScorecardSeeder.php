<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Scorecard;
use App\Models\Employee;

class ScorecardSeeder extends Seeder
{
    public function run()
    {
        $emp = new Employee();
        $sc = new Scorecard();
        $emp = $emp->where('Account_Disabled','FALSE')->findAll();
        foreach($emp as $em) {
            $data=$this->sc('ws',$em['EmployeeID']);
            $sc->insertBatch($data);
        }
    }

    public function sc($type,$cardNum)
    {
        $data = [
            'type' => $type,
            'card-number' => $cardNum,
            'month' => '2022-09',
        ];
        return $this->column($data);
    }

    public function column($obj)
    {
        $data = '[{"items":"Post Paid Voice","sub-item":"Goal"},{"items":"Non-PPV","sub-item":"Goal"},{"items":"Upgrades","sub-item":"Goal"},{"items":"Quality","sub-item":"Goal"},{"items":"Protection","sub-item":"Goal"},{"items":"Expert","sub-item":"Goal"},{"items":"Post Paid Voice","sub-item":"MTD"},{"items":"Non-PPV","sub-item":"MTD"},{"items":"Upgrades","sub-item":"MTD"},{"items":"Quality","sub-item":"MTD"},{"items":"Protection","sub-item":"MTD"},{"items":"Expert","sub-item":"MTD"},{"items":"Post Paid Voice","sub-item":"Trend"},{"items":"Non-PPV","sub-item":"Trend"},{"items":"Upgrades","sub-item":"Trend"},{"items":"Quality","sub-item":"Trend"},{"items":"Protection","sub-item":"Trend"},{"items":"Expert","sub-item":"Trend"},{"items":"Post Paid Voice","sub-item":"Trending% to Goal"},{"items":"Non-PPV","sub-item":"Trending% to Goal"},{"items":"Upgrades","sub-item":"Trending% to Goal"},{"items":"Quality","sub-item":"Trending% to Goal"},{"items":"Protection","sub-item":"Trending% to Goal"},{"items":"Expert","sub-item":"Trending% to Goal"},{"items":"Post Paid Voice","sub-item":"Metric Value"},{"items":"Non-PPV","sub-item":"Metric Value"},{"items":"Upgrades","sub-item":"Metric Value"},{"items":"Quality","sub-item":"Metric Value"},{"items":"Protection","sub-item":"Metric Value"},{"items":"Expert","sub-item":"Metric Value"},{"items":"Post Paid Voice","sub-item":"Points Earned"},{"items":"Non-PPV","sub-item":"Points Earned"},{"items":"Upgrades","sub-item":"Points Earned"},{"items":"Quality","sub-item":"Points Earned"},{"items":"Protection","sub-item":"Points Earned"},{"items":"Expert","sub-item":"Points Earned"},{"items":"Scorecard Total","sub-item":""},{"items":"Grade","sub-item":""},{"items":"myCSP","sub-item":""},{"items":"Visit","sub-item":""},{"items":"Visit","sub-item":""},{"items":"Visit","sub-item":""},{"items":"Visit","sub-item":""},{"items":"Gross Profit","sub-item":""}]';
        $data = json_decode($data,true);
        for ( $i=0; $i < sizeof($data); $i++) {
            $data[$i]['value'] = rand(50,500)+(rand(0,100)/100);
            if ( $data[$i]['items'] == 'Visit' ) $data[$i]['value'] = rand(1,30);
            $data[$i] = array_merge($obj,$data[$i]);            
        }
        return $data;
    }
}
