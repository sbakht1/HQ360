<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailSyncModel;
use App\Models\Site;
use App\Models\Employee;
use App\Models\Store;
use App\Models\Observation;

class Emailsync extends BaseController
{
    //$yourEmail = "scorecard.portal@tweatt.com";
    //$yourEmailPassword = "Georgia2019@";
    //$inbox = imap_open("{outlook.office365.com:993/imap/ssl}INBOX", $yourEmail, $yourEmailPassword);
    
    protected $path = 'admin/emailsync/';
    protected $Email = "scorecard.portal@gmail.com";
    protected $EmailKey = "zgbeoajmghlqfjzz"; //kjjumgucjfknhdif //zgbeoajmghlqfjzz//
        
    public function index() {

        $type = (@$_GET['type']) 
            ? ucwords($_GET['type'])
            : "Employee";

        $title['Title'] = $type .' Scorecards';
        $title['subMenu'] = '';
        $title['subMenuPath'] = '';

        $data['page'] = emp_page([$title,$this->path.'index']);
        return view('app',$data);
    }

   public function SyncEmails(){
        set_time_limit(30000);
       
        $this->SellerScorecards("Store Scorecards_This_Month");
        $this->SellerScorecards("Stores_Scorecards_Last_Month");
        $this->SellerScorecards("District_Scorecards_This_Month");
        $this->SellerScorecards("District Scorecards_Last_Month");
        $this->SellerScorecards("Seller Scorecards_This_Month");
        $this->SellerScorecards("Seller Scorecards_Last_Month");

        return flash('success', 'Scorecard successfully imported!','admin/emailsync');
    }

    public function SellerScorecards($subject){
        $inbox = imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX", $this->Email, $this->EmailKey); 
        $emails = imap_search($inbox, 'UNSEEN SUBJECT "'.$subject.'"  FROM "sisense@tweatt.com"');
                
        $attachments = array();
        /* if emails are returned, cycle through each... */
        
        if($emails) { /* begin output var */
          $output = '';
          //rsort($emails);  /* put the newest emails on top */
            foreach($emails as $email_number) {
                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox,$email_number,0);
                $message = imap_fetchbody($inbox,$email_number,2);
                $structure = imap_fetchstructure($inbox,$email_number);
            
                   if(isset($structure->parts) && count($structure->parts)) {
                     for($i = 0; $i < count($structure->parts); $i++) {
                       $attachments[$i] = array(
                          'is_attachment' => false,
                          'filename' => '',
                          'name' => '',
                          'attachment' => '');
            
                       if($structure->parts[$i]->ifdparameters) {
                         foreach($structure->parts[$i]->dparameters as $object) {
                           if(strtolower($object->attribute) == 'filename') {
                             $attachments[$i]['is_attachment'] = true;
                             $attachments[$i]['filename'] = $object->value;
                           }
                         }
                       }
            
                       if($structure->parts[$i]->ifparameters) {
                         foreach($structure->parts[$i]->parameters as $object) {
                           if(strtolower($object->attribute) == 'name') {
                             $attachments[$i]['is_attachment'] = true;
                             $attachments[$i]['name'] = $object->value;
                           }
                         }
                       }
            
                       if($attachments[$i]['is_attachment']) {
                         $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                         if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                           $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                         }
                         elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                           $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                         }
                       }             
                     } // for($i = 0; $i < count($structure->parts); $i++)
                   } // if(isset($structure->parts) && count($structure->parts))
            
                $data=[];

                if(count($attachments)!=0){

                    foreach($attachments as $att){
                        $keywords = explode("-", $att['filename']);
                        // if(count($keywords) >0){
                        //    print_r($keywords);
                        // }

                       // $keywords = str_getcsv($att['filename']);
                        //debug($keywords);
                    }
                   
                    foreach($attachments as $at){
                        
                        if($at['is_attachment']==1){
                            $imageDirectory = __DIR__  . '/Reports/sync' ;
                            $guid = bin2hex(openssl_random_pseudo_bytes(16));
                            $dname = explode(".", $at['filename']);
                            $ext = end($dname);

                            $downloaded = file_put_contents($imageDirectory.'/'. $guid."_".$at['filename'], $at['attachment']);

                            $fileName = $imageDirectory . '/' . $guid."_".$at['filename'];
                            if(file_exists($fileName)){
                                $fileSize = filesize($fileName);
                                if( $fileSize > 0 && $ext=='csv'){
                                    $temp=[];
                                    $temp = $this->readCvsData($fileName, 'store');
                                    $data = array_replace_recursive($data,$temp);
                                }
                            }
                        }
                    }
                }
                //exit;
                //debug($data);
                $this->SaveData($data);
                $data=[];
               
                //imap_delete($inbox, $email_number);
          }
        }

       // imap_expunge($inbox);
        imap_close($inbox);

    }

    public function readCvsData($varFile, $doctype){
        $site = new Site();
        $sc = new EmailSyncModel();
        $data = $site->csvToArrayEml($varFile,'lowercase');

        return $data;
    }
    public function SaveData($data){
        $site = new Site();
        $sc = new EmailSyncModel();
        $filter = [];

        if(isset($data[0]['employeeid'])) {
             $resource = 'employeeid';
             $type = 'employee';
         } if(isset($data[0]['storeid'])) {
             $resource = 'storeid';
             $type = 'store';
         }if(isset($data[0]['dtldtlid'])) {
             $resource = 'dtldtlid';
             $type = 'district';
         }
 
       
        foreach($data as $item) {
             $detail = rem_items($item,[$resource,'type','yyyymm','scorecard','gp']);
             $new_item=[
                 'resource_id' => $item[$resource],
                 'type' => $type,
                 'yyyymm' => $item['yyyymm'],
                 'scorecard' => $item['scorecard_aa'],
                 'gp' => $item['gp_ab'],
                 'detail' => json_encode($detail)
             ];
             $filter[] = $new_item;
             $find = $sc->where([
                 'yyyymm' => $new_item['yyyymm'],
                 'type' => $type,
                 'resource_id' => $item[$resource]
             ])->first();
             if ($find === null) {
                 $sc->insert($new_item);
             } else {
                 $sc->where([
                     'yyyymm'=>$new_item['yyyymm'],
                     'type'=>$type,
                     'resource_id' => $item[$resource]
                 ])->set($new_item)->update();
                 
             }
         }
    }

    public function uploadFile($varFile, $doctype) {
        $site = new Site();
        $sc = new EmailSyncModel();
        $data = $site->csvToArrayEml($varFile,'lowercase');
        $filter = [];

       if(isset($data[0]['employeeid'])) {
            $resource = 'employeeid';
            $type = 'employee';
        } if(isset($data[0]['storeid'])) {
            $resource = 'storeid';
            $type = 'store';
        }if(isset($data[0]['dtldtlid'])) {
            $resource = 'dtldtlid';
            $type = 'district';
        }

      
       foreach($data as $item) {
            $detail = rem_items($item,[$resource,'type','yyyymm','scorecard','gp']);
            $new_item=[
                'resource_id' => $item[$resource],
                'type' => $type,
                'yyyymm' => $item['yyyymm'],
                'scorecard' => $item['scorecard_aa'],
                'gp' => $item['gp_ab'],
                'detail' => json_encode($detail)
            ];
            $filter[] = $new_item;
            $find = $sc->where([
                'yyyymm' => $new_item['yyyymm'],
                'type' => $type,
                'resource_id' => $item[$resource]
            ])->first();
            if ($find === null) {
                $sc->insert($new_item);
            } else {
                $sc->where([
                    'yyyymm'=>$new_item['yyyymm'],
                    'type'=>$type,
                    'resource_id' => $item[$resource]
                ])->set($new_item)->update();
                
            }
        }
        
        return true; //flash('success', 'Scorecard successfully imported!','admin/emailsync');
       //return $this->response->setJSON(['success' => true,'record_inserted'=>count($ins['meta'])]);
    }
    

    public function upload() {
        $req = request();
        $site = new Site();
        $sc = new EmailSyncModel();
        if($req->getMethod() !== 'post') return;
        $data = $site->csvToArray($_FILES['file']['tmp_name'],'lowercase');

        $filter = [];
        
        if(isset($data[0]['employeeid'])) {
            $resource = 'employeeid';
            $type = 'employee';
        } else if(isset($data[0]['storeid'])){
            $resource = 'storeid';
            $type = 'store';
        }else if(isset($data[0]['dtldtlid'])){  //DTL.DTLID
            $resource = 'dtldtlid';
            $type = 'district';
        }

       foreach($data as $item) {
            $detail = rem_items($item,[$resource,'type','yyyymm','scorecard','gp']);
           // debug($detail);
            $new_item=[
                'resource_id' => $item[$resource],
                'type' => $type,
                'yyyymm' => $item['yyyymm'],
                'scorecard' => $item['scorecard_aa'],
                'gp' => $item['gp_ab'],
                //'scorecard' => $item['scorecard'],
                //'gp' => $item['gp'],
                'detail' => json_encode($detail)
            ];
            $filter[] = $new_item;
            $find = $sc->where([
                'yyyymm' => $new_item['yyyymm'],
                'type' => $type,
                'resource_id' => $item[$resource]
            ])->first();
            if ($find === null) {
                $sc->insert($new_item);
            } else {
                $sc->where([
                    'yyyymm'=>$new_item['yyyymm'],
                    'type'=>$type,
                    'resource_id' => $item[$resource]
                ])->set($new_item)->update();
            }
        }
        

        return flash('success', 'Scorecard successfully imported!','admin/emailsync');
       //return $this->response->setJSON(['success' => true,'record_inserted'=>count($ins['meta'])]);
    }


    function find_data() {
       
        $month = (@$_GET['month']) ? $_GET['month'] : '';
        $type = (@$_GET['type']) ? $_GET['type'] : 'employee';
        
        if(empty($month) || empty($type)) return ;
        $sc = new EmailsyncModel();
        $cards = $sc->getEmailsync($type,$month);
        
        //print_r($this->response->setJSON($cards));
       
        return $this->response->setJSON($cards);
    }

    public function card($id) {
        $sc = new EmailsyncModel();
        $emp = new Employee();
        $st = new Store();
        $data = $sc->find($id);

        
        if($data['type'] === 'employee') {
            $scDate =  substr($data['yyyymm'],0,4) ."-". substr($data['yyyymm'],-2); //Calculate Current Month
            $emp_info = $data['employee'] = $emp->info($data['resource_id'],'Employee_Name,Title,EmployeeID,DefaultLocation');
            $store =  $st->info($emp_info['DefaultLocation'],'StoreName,DistrictName,DMID,ManagerID');
            $data['store'] = $st->where('StoreID',$emp_info['DefaultLocation'])->select('StoreName,DistrictName')->first();
            $data['employee'] = $emp_info;
            $data['observations'] = ($sc->getObservationsEmployee($emp_info['EmployeeID'],$scDate)); //2023-05
            $data['connections'] = ($sc->getConnectionsEmployee($emp_info['EmployeeID'], $scDate ));
            $data['month'] = substr($data['yyyymm'],-2);
        }
        
        if($data['type'] === 'store') {
            //$data['store'] = $st->info($data['resource_id'],'StoreName,DistrictName,DMID,ManagerID');
            //$data['observations'] = "";
            //$data['connections'] = "";
            $scDate =  substr($data['yyyymm'],0,4) ."-". substr($data['yyyymm'],-2); //Calculate Current Month
            $emp_info = $st->info($data['resource_id'],'StoreName,DistrictName,DMID,ManagerID, storeId'); //$data['employee'] = $emp->info($data['resource_id'],'Employee_Name,Title,EmployeeID,DefaultLocation');
            $data['store'] = $st->info($data['resource_id'],'StoreName,DistrictName,DMID,ManagerID');
            $data['employee'] = $emp_info;
            $data['observations'] = ($sc->getObservationsStore($emp_info['storeId'],$scDate)); //2023-05
            $data['connections'] = ($sc->getConnectionsStore($emp_info['storeId'], $scDate ));
            $data['month'] = substr($data['yyyymm'],-2);
            $inf = [$data['store']['StoreName'],$data['store']['DistrictName'],$data['store']['image']];
        }

        if($data['type'] === 'district'){
            // debug($data);
            $emp_info = $emp->info($data['resource_id'],'Employee_Name,Title,EmployeeID,DefaultLocation');
            $store = $st->info($emp_info['DefaultLocation'],'StoreName,DistrictName,DMID,ManagerID');
            $data['store'] = $store;
            $data['observations'] = "";
            $data['connections'] = "";
        }
        if($data['type'] === 'district' || $data['type'] === 'employee') 
            $inf = [$store['DistrictName'],$emp_info['Employee_Name'],$store['image']];
        $data['info'] = $inf;
        $data['detail'] = json_decode($data['detail']);
        return $this->response->setJSON($data);
    }

    // public function card($id) {
    //     $sc = new Scorecard();
    //     $emp = new Employee();
    //     $st = new Store();
    //     $data = $sc->find($id);
    //     if($data['type'] === 'employee' || $data['type'] === 'district') {
    //         $emp_info = $emp->info($data['resource_id'],'Employee_Name,Title,EmployeeID,DefaultLocation');
    //         $store =  $st->info($emp_info['DefaultLocation'],'StoreName,DistrictName,DMID,ManagerID');
    //         $employee = $emp_info;
    //         $inf = [$emp_info['Employee_Name'],$emp_info['Title'],$emp_info['image']];
    //         if($data['type'] === 'district') $inf = [$store['DistrictName'],$emp_info['Employee_Name'],$store['image']];
    //     }
    //     if($data['type'] === 'store'){
    //         $store = $st->info($data['resource_id'],'StoreName,DistrictName,DMID,ManagerID');
    //         $inf = [$store['StoreName'],"",$store['image']];
    //     }
    //     $data['info'] = $inf;
    //     $data['detail'] = json_decode($data['detail']);
    //     return $this->response->setJSON($data);
    // }
}