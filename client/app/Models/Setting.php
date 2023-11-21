<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Employee;
use App\Models\EmpMeta;

class Setting extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["name","content","info"];

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

    public function sidebar()
    {
        $name = session()->get('user_data')['Title'][1].'-sidebar';
        $menu = $this->where('name',$name)->first();
        return (!$menu) ? $this->where('name','default-sidebar')->first() : $menu;
    }

    public function get($name) {
        return json_decode($this->where('name',$name)->first()['content']);
    }

    public function _save($name,$data) {
        $data = json_encode($data);
        return $this->where('name', $name)->set(['content'=>$data])->update();
    }

    public function profile() {
        $empMeta = new EmpMeta();
        $user_id = (session()->get('user_data'))?session()->get('user_data')['EmployeeID']:0;
        $image = $empMeta->value($user_id,'image');
        $user = new Employee();
        $info = $user->where('EmployeeID',$user_id)->first();

        if ( empty($image) ) $image = "users/not-found.png";

        $info['image'] = $image;
        return $info;
    }
}
