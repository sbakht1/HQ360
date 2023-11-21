<?php
use App\Models\Setting;
use App\Models\EmpMeta;
use App\Models\Urgent;
use App\Models\Site;
use App\Models\ComplianceModel;
use App\Models\PulseModel;
use App\Models\Employee;
use App\Models\Store;
use App\Models\Hub;
use App\Models\Notification;

function get_notification_by_user(){
    $notes =  new Notification();
    $get_emp = new Employee();
    
    $emp_id =  profile('EmployeeID');
    $cur_emp = $get_emp->get_current_emp($emp_id);  
    $cur_type = profile('Title');//[0];
    $current_user = $cur_emp[0]['DefaultLocation'];
    return $notes->get_by_user($cur_type ,$current_user,"unread");
}

function get_user($id){
    $get_emp = new Employee();
   return $get_emp->info($id);
}

function get_readed_notes(){

    $notes =  new Notification();
    $get_emp = new Employee();
    
    $emp_id =  profile('EmployeeID');
    $cur_emp = $get_emp->get_current_emp($emp_id);  
    $cur_type = profile('Title');//[0];
    $current_user = $cur_emp[0]['DefaultLocation'];
    return $notes->get_by_user($cur_type ,$current_user,"read");

    // $get_notes_read = new EmpMeta();
    // return $get_notes_read->read_notes();
}



function sendMail($to,$sub,$msg) {
    $email = \Config\Services::email();
    $email->setTo($to);
    $email->setFrom('scorecard.portal@tweatt.com', 'TWE Portal');
    $email->setSubject($sub);
    $email->setMessage($msg);
    return ($email->send()) ? true : false;
}


function urgent_messages() {
    $urgent = new Urgent();
    return $urgent->getActive();
}

function emp_page($info,$layout='employee') {
    //debug($info);
    $setting = new Setting();
    return [
        'title' => $info[0],
        'path' => $info[1],
        'layout' => $layout,
        'sidebar' => json_decode($setting->sidebar()['content']),
        'RootTitle' => ""
    ];
}

function my_sort($arr,$col,$sort='asc') {

    $filter = array_column($arr, $col);

    ($sort == 'asc') 
        ? array_multisort($filter, SORT_ASC, $arr) 
        : array_multisort($filter, SORT_DESC, $arr);
    return $arr;
};


function emp_meta($id,$key="image",$one=true) {
    $empMeta = new EmpMeta();
    $meta = $empMeta->where(['employee'=>$id,'meta_key'=>$key]);
    return ($one) ? $meta->first(): $meta->findAll();
}

function settings($name,$array=false) {
    $setting = new Setting();
    $content = $setting->where('name',$name)->first()['content'];
    $data = ($array) ? json_decode($content,true) : json_decode($content);
    return $data;
}

function profile($name = false) {
    $setting = new Setting();
    $info = $setting->profile();
    switch ($name) {
        case 'image':
            return base_url(UI['upload']).'/'.$info[$name];
            break;
        case 'status':
            return ($info['Account_Disabled']) ? "Enable" : "Disabled";
            break;
        default:
            if ($name == false) {
                return $info;
            } else {
                return (isset($info[$name])) ? $info[$name] : "";
            }
            break;
    }
}

function card($type="start",$cls="") {
    return ($type == 'start') ? "<div class='card shadow $cls'><div class='card-body'>":"</div></div>";
}

function page_url($add="") {
    $qs = ($_SERVER['QUERY_STRING'] !== "") ? "?".$_SERVER['QUERY_STRING']."&" : "?";
    return current_url().$qs.$add;
}

function radio($config) {
    $radioInput = '<div class="form-check form-check-primary">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" name="'.$config[0].'" id="'.$config[0].'" '.$config[2].'>
      '.$config[1].'
    <i class="input-helper"></i></label>
  </div>';
  return $radioInput;
}

function checkbox($config,$val='FALSE') {
    $radioInput = '<div class="form-check form-check-primary">
    <label class="form-check-label">
      <input type="checkbox" class="form-check-input" name="'.$config[0].'" id="'.$config[0].'" value="'.$val.'" '.$config[2].'>
      '.$config[1].'
    <i class="input-helper"></i></label>
  </div>';
  return $radioInput;
}

function validation(){return \Config\Services::validation();}

function digit_len($num,$len){ return str_pad($num, $len, '0', STR_PAD_LEFT); }
function rem_items($array,$keys) {
    for( $i=0;$i<sizeof($keys);$i++) unset($array[$keys[$i]]);
    return $array;
}

function btn($config) {
    return "<a href='$config[0]' class='btn btn-$config[2]'>$config[1]</a>";
}


function form_input_required($config) {
    
    // [name,title,type,value] -> input
    // [name,title,textara/rows,value] -> textarea
    if( strpos($config[1],'*') !== false ) $config[1] = str_replace('*','<span class="text-danger">*</span>',$config[1]);
    $output = '<div class="form-group">';
    $output .= "<label for='$config[0]'>$config[1]</label>";
    if (strpos($config[2], 'textarea') !== false) {
        $con = explode('/',$config[2]);
        $output .= "<textarea id='$config[0]' class='form-control' name='$config[0]' rows='$con[1]'>$config[3]</textarea>";
    } else {
        $output .= "<input id='$config[0]' class='form-control' type='$config[2]' name='$config[0]'  '$config[4]' value='$config[3]'>";
    }
    $output .="<span id='error_$config[0]' class='text-danger'></span>";
    $output .= "</div>";
    return $output;

}

function form_input($config) {
    
    // [name,title,type,value] -> input
    // [name,title,textara/rows,value] -> textarea
    if( strpos($config[1],'*') !== false ) $config[1] = str_replace('*','<span class="text-danger">*</span>',$config[1]);
    $output = '<div class="form-group">';
    $output .= "<label for='$config[0]'>$config[1]</label>";
    if (strpos($config[2], 'textarea') !== false) {
        $con = explode('/',$config[2]);
        $output .= "<textarea id='$config[0]' class='form-control' name='$config[0]' rows='$con[1]'>$config[3]</textarea>";
    } else {
        $output .= "<input id='$config[0]' class='form-control' type='$config[2]' name='$config[0]'   value='$config[3]'>";
        
    }
    $output .="<span id='error_$config[0]' class='text-danger'></span>";
    $output .= "</div>";
    return $output;

}

function form_file($config,$req=false) {
    $r = ($req) ? 'required="required"' : "";
    $output = '<div class="custom-file o-hidden">
        <input '.$r.' type="file" name="'.$config[0].'" class="custom-file-input" id="'.$config[0].'" accept="'.$config[2].'">
        <label class="custom-file-label" for="'.$config[0].'">'.$config[1].'</label>
        
    </div>';
    return $output;
}

function date_form($date=false){ 
    return ( $date == false) ? date('Y-m-d') : date('Y-m-d', strtotime($date));
}


function select($config,$attr="") {
    if( strpos($config[1],'*') !== false ) $config[1] = str_replace('*','<span class="text-danger">*</span>',$config[1]);
    $output = '<div class="form-group">';
    $output .= "<label for='$config[0]'>$config[1]</label>";
    $output .= "<select id='$config[0]' class='form-control' name='$config[0]' ".$attr.">";
    
    foreach ($config[2] as $c) {
        $sel = '';
        if (isset($config[3])) {
            if (strtolower($c) === strtolower($config[3])) $sel = 'selected';
        }
        $output .= "<option $sel value='$c'>$c</option>";
    }

    $output .= "</select>";
    $output .="<span id='error_$config[0]' class='text-danger'></span>";
    $output .= "</div>";
    return $output;
}


function select2($config,$attr="") {
    $output = select($config);
    return str_replace("class='form-control'","class='select2' ".$attr,$output);
}

function request() {
    return \Config\Services::request();
}

function loader($text) {
    return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" r="0" fill="none" stroke="#e67336" stroke-width="2" stroke-dasharray="15 15 15 15">
            <animate attributeName="r" repeatCount="indefinite" dur="2s" values="0;36" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="0s"></animate>
            <animate attributeName="opacity" repeatCount="indefinite" dur="2s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="0s"></animate>
        </circle>
        <circle cx="50" cy="50" r="0" fill="none" stroke="#e67336" stroke-width="2" stroke-dasharray="15 15 15 15">
            <animate attributeName="r" repeatCount="indefinite" dur="2s" values="0;36" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-1s"></animate>
            <animate attributeName="opacity" repeatCount="indefinite" dur="2s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-1s"></animate>
        </circle>
    </svg>
    <h4 class="text-center">'.$text.'</h4>';
}

function isErr($name,$title){
    $error = session()->getFlashdata('validation');
    $output = "";
    if (  @$error && $error->getError($name) != "" ) {
        $output .= "<span class='text-danger'>";
        $output .= str_replace($name,$title,$error->getError($name));
        $output .= "</span>";
        $output = str_replace("The This","This", $output);
    }
    return $output;
}

function table_btn($config) {
    $url = base_url($config[0]);
    return "<a href='$url' class='btn btn-$config[2] '>$config[1]</a>";
}

function flash($type,$msg,$path) {
    session()->setFlashdata($type, $msg);
    return redirect()->to($path);
}

function modal($act=false) {
    if ( $act == false ) {
        return '</div></div></div></div>';
    } else {
        if (!isset($act[1])) $act[1] = 'md';
        return '<div class="modal fade" id="'.$act[0].'"><div class="modal-dialog modal-'.$act[1].'"><div class="modal-content"><a href="javascript:void(0)" data-dismiss="modal">&times;</a><div class="modal-body">';
    }
}

function selection($config) {
    if( strpos($config[1],'*') !== false ) $config[1] = str_replace('*','<span class="text-danger">*</span>',$config[1]);
    return '<div class="form-group">
        <label for="'.$config[0].'">'.$config[1].'</label>
        <select class="'.$config[2].'" name="'.$config[0].'" id="'.$config[0].'" data-selected="'.$config[3].'"><option></option></select>
    </div>';
}

function debug($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}

function is_date($val){
    $time = strtotime($val);
    return (!empty($time) && str_contains($val,'-')) ? true:false;
}

function excerpt($str,$num=35){
    $str = strip_tags($str);
    if ($str == "") return "";
    $strArr = explode(" ",$str);
    $strArrLim = array_splice($strArr,0, $num);
    return implode(" ", $strArrLim)."...";
}

function find_keys($required, $data) {
    return (count(array_intersect_key(array_flip($required), $data)) === count($required)) ? true : false;
}

function last_report($table) {
    $site = new Site();
    return $site->last_report($table);
}

function str_to_num($str) {
    $num = str_replace(['$',')','('],'',$str);
    return (strpos($str, '(') !== false) ? -(float)$num : (float)$num;
}

function find_in_array($info, $array) {
    foreach ($array as $item) {
        if (strpos($item[$info['name']],$info['val']) !== false) {
            return $item;
        }
    }
    return null;
 }


 function floater($keys,$data) {
    foreach( $data as $i => $item) {
        foreach($keys as $k) {
            if ( isset($item[$k]) ) {
                if ( strpos($item[$k], '(') !== false ) {
                    $data[$i][$k] = -(float)str_replace(['$',',','(',')'],'',$item[$k]);
                } else {
                    $data[$i][$k] = (float)str_replace(['$',',','(',')'],'',$item[$k]);
                }
            }
        }
    }
    return $data;
}

function empty_dates($keys,$data) {
    foreach($data as $i => $item) {
        foreach($keys as $k) 
            if ( isset($item[$k]) && $item[$k] == "1970-01-01 00:00:00") $data[$i][$k] = "";
            else $item[$k] = "";
    }
    return $data;
}

function sum_values($array,$key){
    $array = floater([$key],$array);
    $test = array_column($array,$key);
    debug($test);
}

function sum_key($array, $key, $sum) {
    $unique = unique_value($array,$key);
    $array = floater([$sum],$array);
    foreach($unique as $i => $un) {
        $values = [];
        foreach($array as $item) {
            if ($item[$key] == $un[$key] && $item[$sum] != 0) $values[]=$item[$sum];
        }
        // $unique[$i]['calc'] = array_sum($values);
        $unique[$i]['calc'] = [array_sum($values), sizeof($values), json_encode($values)];
    }
    debug($unique);
}

function unique_value($array, $key) { 
    $temp_array = []; 
    $i = 0; 
    $key_array = []; 

    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
}

function filter_key_value($data, $key, $value) {
    $new = [];
    foreach($data as $item) {
        if ( $item[$key] == $value) $new[] = $item;
    }
    return $new;
}

function search_key_value($arr,$k,$v) {
    $new = [];
    foreach($arr as $item) if(strpos(strtolower($item[$k]),strtolower($v)) !== false) $new[] = $item;
    return $new;
}

function emp_district() {
    $emp = new Employee();
    $str = new Store();
    $employee = $emp->where('EmployeeID', profile('EmployeeID'))->first();
    $data['name'] = $str->where('StoreID', profile('DefaultLocation'))->first()['DistrictName'];
    $data['stores'] = $str->where('DistrictName', $data['name'])->findAll();
    $data['emps'] = $emp->where('Account_Disabled','FALSE')->whereIn('DefaultLocation',array_column($data['stores'],"StoreID"))->findAll();
    return $data;
}

function emp_store() {
    $emp = new Employee();
    return $emp->store(profile('DefaultLocation'))['Enabled'];
}

function panel_items($panel) {
    $hub = new Hub();
    for ($i=0; $i < sizeof($panel); $i++) { 
        $panel[$i]['items'] = $hub->where(['panel'=>$panel[$i]['id']])->findAll();
    }
    return $panel;
}

function user_store($key=false) {
    $str = new Store();
    $str->where('StoreID', profile('DefaultLocation'));
    return ( $key ) ? $str->select($key)->first()[$key] : $str->first();
}

function user_data($k) { 
    return (@$_SESSION['user_data']) ? $_SESSION['user_data'][$k] : "";
}

function _find($arr) { 
    $t = $arr[0];
    $k = $arr[1];
    $f = $arr[2];
    $r = $arr[3];
    $db = db_connect(); 
    return $db->query("select $r from $t where `$k`=$f")->getRowArray()[$r];
}

function ops() {
    $db = db_connect();
    $ops = [];
    $role = user_data('Title')[1];
    if($role !== 'admin') {
        $UID = \profile('UID');
        $loc = profile("DefaultLocation");
        $empID = \profile('EmployeeID');
        $ops[] = ["PLE Courses Incomplete",$db->query("SELECT * FROM compliance WHERE `ATTUID`='$UID'")->getNumRows()];
        $ops[] = ["Tickets Not Closed",$db->query("SELECT * FROM tickets WHERE `status`!='Closed' AND `store`='$loc'")->getNumRows()];
        $ops[] = ["Observations",$db->query("SELECT * FROM observations WHERE `employee`='$empID'")->getNumRows()];
        $ops[] = ["Connections",$db->query("SELECT * FROM connections WHERE `employee`='$empID'")->getNumRows()];
    } else {
        $month = date('Y-m');
        $ops[] = ["PLE Courses Incomplete",$db->query("SELECT * FROM compliance")->getNumRows()];
        $ops[] = ["Tickets Not Closed",$db->query("SELECT * FROM tickets WHERE `status`!='Closed'")->getNumRows()];
        $ops[] = ["Observations",$db->query("SELECT * FROM observations WHERE `month`='$month'")->getNumRows()];
        $ops[] = ["Connections",$db->query("SELECT * FROM connections WHERE `month`='$month'")->getNumRows()];
    }
    return $ops;
}

function str_inc($str,$inc) {
    return (strpos($str,$inc) !== false) ? true : false;
}

function form($id){
    $s = new Site();
    return $s->encrypt($id);
}

$pulse = new PulseModel();
$ses = @$_SESSION;
$popup = [];

$is_submit = $pulse->where(['created >'=> date('Y-m-d'),'employee' => profile('EmployeeID')])->orderBy('id','desc')->first();
if( !$is_submit ) $popup['pulse'] = true;
if(@$ses['loggedIn']) {
    $comp = new ComplianceModel();
    $_SESSION['courses'] = $comp->where('attuid', profile('UID'))->findAll();
    $popup["PLE"] = $_SESSION['courses'];
    $popup['urgent_msg'] = 'open';
}

session()->setFlashdata('popups', $popup);