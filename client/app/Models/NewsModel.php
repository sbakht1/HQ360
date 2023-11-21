<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['author','updated_by','title','media','content','status'];

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

    public function get_entries($type='',$entries = 20){
        $this->db->connect();
        
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page-1) * $entries;
        
        $query = $this->db->table('news n');
        $data = $query->select('n.*, emp.Employee_Name');
        if ( $type !== '' ) $data->where('status', $type);
        $data = $data->join('employees as emp','emp.EmployeeID = n.author')
                ->orderBy('id','desc')
                ->get($entries,$offset)
                ->getResultArray();
        $total = ( $type !== '') ? $query->countAll() : $query->where('status',$type)->countAll();

        return [
            'data' => $data,
            'links' => $pager->makeLinks($page,$entries,$total)
        ];
    }
}
