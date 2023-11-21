<?php

namespace App\Models;

use CodeIgniter\Model;

class Notification extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["category","detail","status","description","usr_from","usr_to","url_id","assign_to"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function get_all()
    { 
        $this->db->connect();
        $b = $this->db->table('notifications');
        $b->orderBy('id', 'desc');
        $query   = $b->get()->getResultArray();
        return  $query;
    }
    
    public function get_by_category($category ,$status) {
        return $this->where(['category'=>$category , "status"=>$status])->findAll();
    }
    
    public function get_category_by_user($category, $emp_id, $status) {
        return $this->where(['category'=>$category , "usr_from"=>$emp_id,"status"=>$status])->findAll();
    }
    
    // public function update_by_user($emp_id){
    //     $this->db->connect();
    //     $b = $this->db->table('notifications');

    //     $this->db->set('status','read')
    //     ->where('usr_to',$emp_id)
    //    ->update('notifications');

    // }


    public function get_by_user($emp_type,$emp_id,$status) {
        $this->db->connect();

        $emp_currentID =  profile('EmployeeID'); 
        $builder = $this->db->table('notifications as n');
        $builder->orderBy('n.id','desc');
        if($emp_type != "Administrator" && $emp_type != "Human Resource" && $emp_type == "Store Team Leader" ){
           $builder->select('n.*,stores.StoreName,stores.StoreID');
           $builder->join('stores', 'n.id =  stores.StoreID');
        }

        if($emp_type == "Administrator"):
            $where = "usr_from !='$emp_currentID' AND status='$status'";
            $builder->where($where);
            return $query   = $builder->get()->getResultArray();

        elseif($emp_type == "District Team Leader"):
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID'  OR usr_to='0'  OR category='hub' OR category='article' OR category='employee' OR category='Observation' or category='connection' or category='Form Submission'";
            $builder->where($where);
            return $query = $builder->get()->getResultArray();

        elseif($emp_type == "Store Team Leader"):
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID' OR usr_to='0' OR (category='hub' OR category='article'  OR category='connection') ";
            $builder->where($where);
            return $query = $builder->get()->getResultArray();

        elseif($emp_type == "Human Resource"):
            $where = "usr_from !='$emp_currentID' AND  (category='ticket/HR' or category='employee' or category='Form Submission' or category='connection' or category='observations') AND status='$status' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='employee' OR category='hub' OR category='article'";
            $builder->where($where);
            return $query = $builder->get()->getResultArray();

        elseif($emp_type == "Inventory"):
            $where = "usr_from !='$emp_currentID' AND category='ticket/Inventory' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='hub' OR category='article'  AND status='$status' ";
            $builder->where($where);
            return $query = $builder->get()->getResultArray();
      
        elseif($emp_type == "IT"):
            $where = "usr_from !='$emp_currentID' AND  category='ticket/IT' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='hub' OR category='article' AND status='$status' ";
            $builder->where($where);
            return $query = $builder->get()->getResultArray();

        elseif($emp_type == "Salespeople"):
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID'  ";
            $builder->where($where);
            return $query = $builder->get()->getResultArray();    
       
        else:
            $builder->where("usr_to",profile('DefaultLocation'));
            $builder->orWhere('usr_to',profile('EmployeeID'));
            return $query = $builder->get()->getResultArray();   

        endif;

    }
  
    public function post_notification($detail, $dsc, $cat ,$status, $emp_from , $emp_to,$url_id) {
        return $this->insert(['detail' => $detail,'description' => $dsc,'category' => $cat, 'status' => $status , "usr_from"=>$emp_from , "usr_to"=>$emp_to, "url_id"=>$url_id]);
    }

    public function post_notification_agssign_to($detail, $dsc, $cat ,$status, $emp_from , $emp_to,$url_id , $assign_to) {
        return $this->insert(['detail' => $detail,'description' => $dsc,'category' => $cat, 'status' => $status , "usr_from"=>$emp_from , "usr_to"=>$emp_to, "url_id"=>$url_id,'assign_to'=>$assign_to]);
    }

    
    public function get_by_user_paginate_dup($emp_type,$emp_id,$status) {
      
        $this->db->connect();
        $entries = 80000;
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page-1) * $entries;
        $emp_currentID =  profile('EmployeeID');
        $builder = $this->db->table('notifications as n');
        $builder->select('n.id,n.category,n.detail,n.created,n.usr_from');
        $builder->orderBy('n.id','desc');
        //$data = $builder->join('stores', 'n.id =  stores.StoreID');

        if($emp_type == "Administrator"):
            //debug("usr_from !='$emp_currentID' AND status='unread'");
            $where = "usr_from !='$emp_currentID' AND status='unread'";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "District Team Leader"):
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID'  OR usr_to='0'  OR category='hub' OR category='article'";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Store Team Leader"):
          
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID' OR usr_to='0' OR category='hub' OR category='article'  ";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Human Resource"):

            $where = "usr_from !='$emp_currentID' AND category='ticket/HR' AND status='$status' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='employee' OR category='hub' OR category='article'";
            $builder->where($where);
            $data = $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Inventory"):

            $where = "usr_from !='$emp_currentID' AND category='ticket/Inventory' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='hub' OR category='article'  AND status='$status' ";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();
      
        elseif($emp_type == "IT"):

            $where = "usr_from !='$emp_currentID' AND category='ticket/IT' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='hub' OR category='article' AND status='$status' ";
            $builder->where($where);
            $data = $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Salespeople"):

            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID'  ";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();    
            $total = $builder->countAll();

        else:
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID' ";
            $builder->where($where);
            $data = $builder->get($entries,$offset)->getResultArray();   
            $total = $builder->countAll();


        endif;

        return [
            'data' => $data,
            'links' => $pager->makeLinks($page,$entries,$total)
        ];
            return [
                'data' => $data,
                'links' => $pager->makeLinks($page,$entries,$total)
            ];
        }

    public function get_by_user_paginate($emp_type,$emp_id,$status) {
      
        $this->db->connect();
        $entries = 50;
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page-1) * $entries;
        $emp_currentID =  profile('EmployeeID');
        $builder = $this->db->table('notifications as n');
        $builder->select('n.id,n.category,n.detail,n.created,n.usr_from');
        $builder->orderBy('n.id','desc');
        //$data = $builder->join('stores', 'n.id =  stores.StoreID');

        
        if($emp_type == "Administrator"):
            //debug("usr_from !='$emp_currentID' AND status='unread'");
            $where = "usr_from !='$emp_currentID' AND status='unread'";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "District Team Leader"):
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID'  OR usr_to='0'  OR category='hub' OR category='article'";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Store Team Leader"):
          
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID' OR usr_to='0' OR category='hub' OR category='article'  ";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Human Resource"):

            $where = "usr_from !='$emp_currentID' AND category='ticket/HR' AND status='$status' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='employee' OR category='hub' OR category='article'";
            $builder->where($where);
            $data = $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Inventory"):

            $where = "usr_from !='$emp_currentID' AND category='ticket/Inventory' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='hub' OR category='article'  AND status='$status' ";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();
      
        elseif($emp_type == "IT"):

            $where = "usr_from !='$emp_currentID' AND category='ticket/IT' OR assign_to='$emp_currentID'  OR usr_to='0' OR category='hub' OR category='article' AND status='$status' ";
            $builder->where($where);
            $data = $builder->get($entries,$offset)->getResultArray();
            $total = $builder->countAll();

        elseif($emp_type == "Salespeople"):

            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID'  ";
            $builder->where($where);
            $data =  $builder->get($entries,$offset)->getResultArray();    
            $total = $builder->countAll();

        else:
            $where = "usr_from !='$emp_currentID' AND usr_to='$emp_id' AND status='$status' OR assign_to='$emp_currentID' ";
            $builder->where($where);
            $data = $builder->get($entries,$offset)->getResultArray();   
            $total = $builder->countAll();


        endif;

        return [
            'data' => $data,
            'links' => $pager->makeLinks($page,$entries,$total)
        ];

    }
  

        public function get_records_last_24_hours($emp_location , $status){
     
        $this->db->connect();
        $emp_currentID =  profile('EmployeeID'); 
        $builder = $this->db->table('notifications as n');
        $builder->select('n.id,n.usr_from,n.usr_to,n.category,n.detail,n.status,n.created,emp.EmployeeID,emp.DefaultLocation,emp.DefaultLocation,emp.Title,emp.Email,stores.StoreID');
        $builder->orderBy('n.id','desc');
        $builder->join('stores', 'n.id = stores.StoreID');
        $builder->join('employees as emp', 'n.usr_from = emp.EmployeeID'); 
        $where = "usr_to = '$emp_location' AND n.created > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        $builder->where($where);
        return $query   = $builder->get()->getResultArray();
         

    }


}
