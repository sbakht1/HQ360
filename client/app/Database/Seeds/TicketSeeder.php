<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use CodeIgniter\I18n\Time;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $this->types();
    }

    public function types()
    {
        $model = new Ticket();
        $tickets = $model->findAll();
        foreach($tickets as $x) {
            $model->update($x['id'],['ticket_type' => TICKET_TYPES[rand(0,7)]]);
        }
    }

    public function status()
    {
        $model = new Ticket();
        $tickets = $model->findAll();
        $status = ['Open','Waiting for Response','In Progress','Pending','Inactive','Closed','Re-Open'];

        foreach($tickets as $x) {
            $model->update($x['id'],['status' => $status[rand(0,6)]]);
        }
    }

    public function date()
    {
        
        $tick = new Ticket();
        $tickets = $tick->findAll();
        foreach($tickets as $x) {
            $month = rand(1,12); 
            $month = ($month < 9) ? '0'.$month: $month;
            $day = rand(1,30);
            $day = ($day < 9) ? '0'.$day: $day;
            $date = '2022-'.$month.'-'.$day;

            if ( $x['date'] == "") $tick->update($x['id'],['date'=>$date]);
        }
        
    }


    private function insert()
    {
        $tick = new Ticket();
        $dep = ['Inventory Management','Information Technology-IT'];

        $month = rand(1,12); 
        $month = ($month < 9) ? '0'.$month: $month;
        $day = rand(1,30);
        $day = ($day < 9) ? '0'.$day: $day;
        $date = '2022-'.$month.'-'.$day;

        $data = [
            'description' => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.",
        ];
        for ( $i=0; $i<1000; $i++) {
            $tick->save([
                'StoreID' => rand(1,200),
                'TicketID' => rand(100000,999999),
                'department' => $dep[rand(0,1)],
                'status' =>  TICKET_TYPES[rand(0,7)],
                'ticket_type' => TICKET_TYPES[rand(0,7)],
                'data' => json_encode($data),
                'date' => $date,
                'submit_by' => rand(2,3600)
            ]);
        }
    }
}
