<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Site;
class FileUpload extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'uploads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    public function image($dir,$input,$name)
    {
        $allow = [];
        foreach(IMAGES_EXT as $e) $allow[] = str_replace('.','image/',$e);
        $allow = implode(',',$allow);
        $validation = $this->validate([
            $input => ["uploaded[$input]","mime_in[$input,$allow]","max_size[$input,10240]"]
        ]);

        if ($validation) {
            $img = request()->getFile($input);
            $file = $_FILES[$input];
            $file['ext'] = ".".pathinfo($file['name'], PATHINFO_EXTENSION);

            if ( $img->isValid() ) {
                $filepath = PUBLIC_PATH."\uploads\\$dir\\$name";
                foreach(IMAGES_EXT as $e) {
                    $fullpath = $filepath.$e;
                    if (file_exists($fullpath)) unlink($fullpath);
                }
                $img->move(PUBLIC_PATH."/uploads/$dir/", $name.$file['ext']);
                $ext = $file['ext'];
                return [
                    "msg" => "success",
                    "path" => "$dir/$name$ext"
                ];
            }
        } else {
            return [
                "msg" => "failed",
                "errors" => $validation->getErrors()
            ];
        }
    }

    public function doc($dir,$input,$name)
    {
        $file['name'] = request()->getFile($input);
        $file['ext'] = ".".pathinfo($_FILES[$input]['name'], PATHINFO_EXTENSION);
        $ext = $file['ext'];
        
        $filepath = PUBLIC_PATH."\uploads\\$dir\\$name\\$ext";
        if (file_exists($filepath)) unlink($filepath);
        $file['name']->move("./public/uploads/$dir/", $name.$ext);
        return ["msg"=>"success","path"=>"$dir/$name".$ext];
    }

    public function csv($dir,$input,$name)
    {
        $input = request()->getFile($input);
        $file['name'] = $input->getName();
        $file['ext'] = ".".pathinfo($file['name'], PATHINFO_EXTENSION);
        
        $filepath = PUBLIC_PATH."\uploads\\$dir\\$name\\.csv";
        if (file_exists($filepath)) unlink($filepath);
        $input->move("./uploads/$dir/", $name.$file['ext']);
        return "$dir/$name.csv";
    }

    public function remove_file($old_file,$is_report=false) {
        $fullpath = PUBLIC_PATH."\uploads\\$old_file";
        if ($is_report) {
            $fullpath = str_replace('\public', '',$fullpath);
        }
        if (file_exists($fullpath)) {
            unlink($fullpath);
            $msg = ['path' => $old_file, 'delete' => true];
        } else {
            $msg = ['path' => $old_file, 'delete' => false];
        }
        $msg['fp'] = $fullpath;
        return $msg;
    }

    public function get_csv($path) {
        $site = new Site();
        $path = str_replace('.csv','',$path);
        if(strpos(FCPATH,":\\") !== false) {
            $back = str_replace('/',"\\",$path);
            $fullpath = PUBLIC_PATH."\\$back";
            if (\strpos($fullpath,'public') !== false) $fullpath = str_replace('\public', '',$fullpath);
            $fullpath = \str_replace('\\\\',"\\",$fullpath);
        } else {
            $fullpath = FCPATH.$path;
        }
        $fullpath .= ".csv";
        if ( !file_exists($fullpath) ) {
            return [];
        } else {
            return $site->csvToArray($fullpath,false,false);
        }
    }
}
