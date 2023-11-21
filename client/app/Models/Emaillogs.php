<?php

namespace App\Models;

use CodeIgniter\Model;

class Emaillogs extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'email_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['m_from','m_to','subject','message','note_id','user_id'];

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


    public function gen_email_logs($m_from,$m_to,$subject,$message,$user_id)
    {   
      $find = $this->where(['user_id' => $user_id])->first();

      if ( !$find ) {
        $this->insert([
            'm_from'  => $m_from,
            'm_to'    => $m_to,
            'subject' => $subject,
            'message' => $message,
            'user_id' => $user_id,
           ]);
       } else {
        $this->update($user_id, [
            'm_from'  => $m_from,
            'subject' => $subject,
            'message' => $message,
           ]);
    }
      return true;
    }

}
