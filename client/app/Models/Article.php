<?php

namespace App\Models;

use CodeIgniter\Model;

class Article extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'articles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title','author','content','updated_by','category','status'
    ];

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


    public function getAll() {
        $this->db->connect();
        $b = $this->db->table('articles as art');
        $b->orderBy('id','DESC');
        $b->join('employees as ath', 'ath.EmployeeID = art.author');
        $b->join('employees as upd', 'upd.EmployeeID = art.updated_by');
        $b->join('meta as m', 'm.id = art.category');

        $b->select('art.id,art.title,ath.Employee_Name as author,upd.Employee_Name as updated_by,m.meta_value as category,art.status,DATE_FORMAT(art.created,"%Y-%m-%d") as created,DATE_FORMAT(art.updated, "%Y-%m-%d") as updated');
        return $b->get()->getResult();
    }

    public function show($status) {
        $this->db->connect();
        $b = $this->db->table('articles as art');
        $b->where('status',$status);
        $b->orderBy('id','DESC');
        $b->join('employees as ath', 'ath.EmployeeID = art.author');
        $b->join('employees as upd', 'upd.EmployeeID = art.updated_by');
        $b->join('meta as m', 'm.id = art.category');

        $b->select('art.id,art.title,ath.Employee_Name as author,upd.Employee_Name as updated_by,m.meta_value as category,art.status,DATE_FORMAT(art.created,"%Y-%m-%d") as created,DATE_FORMAT(art.updated, "%Y-%m-%d") as updated');
        return $b->get()->getResult();
    }
}
