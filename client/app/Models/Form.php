<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\FormMeta;

class Form extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'forms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["title","status","data","type","created_by","updated_by"];

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


    public function range()
    {
        $query = $this->db->table('forms as form');
        $data = $query
                ->whereNotIn('form.id',[21,25])
                ->select('form.id,form.title,form.type as visibility,form.status,form.created_by,form.updated_by,DATE_FORMAT(form.created, "%Y-%m-%d") as created,DATE_FORMAT(form.updated,"%Y-%m-%d") as updated,cr_emp.Employee_Name as created_employee, up_emp.Employee_Name as updated_employee')
                ->join('employees as cr_emp','form.created_by = cr_emp.EmployeeID')
                ->join('employees as up_emp','form.updated_by = up_emp.EmployeeID');

        if ( user_data('Title')[1] !== 'admin') {
            $data->where('form.created_by', user_data('EmployeeID'));
        }

        return $data->get()->getResultArray();
    }

    public function view($id) {
        $meta = new FormMeta();
        $form = $this->find($id);
        if ( 
            $form['type'] == 'Select Individual Employees' ||
            $form['type'] == 'Title Base Employees'
        ) $form['meta'] = json_decode($meta->where('form',$form['id'])->first()['meta_value']);
        return $form;
    }
}
