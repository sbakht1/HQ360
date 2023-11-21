<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\EmpMeta;
use App\Models\ComplianceModel;
use App\Models\PulseModel;

class Auth extends BaseController
{
    protected $path = 'auth/';
    public function index()
    {
        
         $user_data = session()->get('user_data');
        if ( isset($user_data['Title']) ) {
            $des = strtolower($user_data['Title'][1]);
            return redirect()->to($des.'/');
        } else if($this->request->getPost('sso') =='sso'){
             return $this->AuthSSO("");
        } else {
            $req = request()->getMethod();
            return ($req === 'post') ? $this->verify() : $this->login();
        }
        
    }
    
    public function authCallback(){
            $session = session();
            $accesscode = $this->request->getPost('code');
             
            $model = new Employee();
            $empMeta = new EmpMeta();
            $session = session();

            // Storing session data
            $dashboard = str_replace(' ','-',strtolower("Administrator"));
            if ($dashboard == 'administrator') $dashboard = 'admin';
            if ($dashboard == 'human-resources') $dashboard = 'human-resource';
            $user_data = [
                'id' => 1,
                'EmployeeID' => '20220322',
                'Employee_Name' => 'Ahmed Waqar',
                'Title' => ['Administrator', $dashboard]
            ];
        $session->set('user_data',$user_data);
        $session->setFlashdata('loggedIn', true);
        return flash('success','You have successfully logged in',"$dashboard/");
        
    }
    
    public function AuthSSO($return_to){
        
        if(($this->request->getPost('code')) ==null){
        $session = session();
        $_SESSION['state']=session_id();
        
        $appid      =   "87577aed-a005-41e0-b169-15ec4c41c5cd";
        $tennantid  =   "11ac2a93-81ae-473c-a036-755ccdaa23fc";
        $secret     =   "uq58Q~qsNBeUZaoADHvNNwu1ade2iwYu~5z0ra99";
        $login_url  =   "https://login.microsoftonline.com/".$tennantid."/oauth2/v2.0/authorize";
        
        $params = array (
            'client_id' =>$appid,
            'redirect_uri' =>'https://tekhq360.com/sso',
            'response_type' =>'token',
            'response_mode' =>'form_post',
            'scope' =>'https://graph.microsoft.com/User.Read',
            'state' =>$_SESSION['state']);

	    return $this->response->redirect($login_url.'?'.http_build_query ($params));
	
        } else {
            $accesscode = $this->request->getPost('code'); // $_GET['code']; 
          
        }
    }

     public function sso(){
    
      $session = session();
            $_SESSION['t'] = $this->request->getPost('access_token'); //$_POST['access_token'];
            $t = $_SESSION['t'];
            $ch = curl_init ();
            curl_setopt ($ch, CURLOPT_HTTPHEADER, array ('Authorization: Bearer '.$t, 'Conent-type: application/json'));
            curl_setopt ($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me/");
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $rez = json_decode (curl_exec ($ch), 1);

            if (array_key_exists('error', $rez)){
                var_dump ($rez['error']);   
	
            }else{
                $model = new Employee();
                $empMeta = new EmpMeta();
                $session = session();
                
                $find_user = $model->where('Email',$rez['mail'])->first();
                if ( !$find_user ) return flash('danger',"No Employee found with this email.",'login');
                
                // checking account status
                if ( strtolower($find_user['Account_Disabled']) == 'true' ) return flash('danger',"Your account has been disabled",'login');

                // HR role switch to admin
                if ($find_user['Title'] == 'Human Resource') $find_user['Title'] = 'Administrator';
        
                // Storing session data
                $dashboard = str_replace(' ','-',strtolower($find_user['Title']));
                if ($dashboard == 'administrator') $dashboard = 'admin';
                if ($dashboard == 'human-resources') $dashboard = 'human-resource';
                $user_data = [
                    'id' => $find_user['id'],
                    'EmployeeID' => $find_user['EmployeeID'],
                    'Employee_Name' => $find_user['Employee_Name'],
                    'Title' => [$find_user['Title'], $dashboard]
                ];

                $user_data = [
                    'id' => $find_user['id'],
                    'EmployeeID' => $find_user['EmployeeID'],
                    'Employee_Name' => $find_user['Employee_Name'],
                    'Title' => [$find_user['Title'], $dashboard]
                ];
                
                $session->set('user_data',$user_data);
                $session->setFlashdata('loggedIn', true);
                return flash('success','You have successfully logged in',"$dashboard/");
        
            }
    }


    public function forgot()
    {
        $method = request()->getMethod();
        if ( $method == 'post') {
            $data = [];
            foreach($_POST as $n => $v) $data[$n]=$v;
            if (isset($data['email'])){
                $model = new Employee();
                $meta = new EmpMeta();
                $Email = $data['email'];
                $find_user = $model->where('Email',$Email)->first();
                if ( !$find_user ) return flash('danger',"No Employee found with this email.",'forgot');
                
                $matchData = ['employee' => $find_user['EmployeeID'],'meta_key' => 'password'];
                $empMeta = new EmpMeta();
                $match = $empMeta->where($matchData)->first();
                $verification_code = rand(100000,999999);
                $empMeta->where(['employee'=> $find_user['EmployeeID'],'meta_key'=>'code'])->delete();
                $empMeta->insert([
                    'employee' => $find_user['EmployeeID'],
                    'meta_key' => 'code',
                    'meta_value' => $verification_code
                ]);
                $un = $find_user['Username'];
                $info = ['username' => $un,'code' => $verification_code,'EmployeeID' => $find_user['EmployeeID']];
                $url = base_url('verification?token='.base64_encode(json_encode($info)));
                $msg = "Dear ".$find_user['Employee_Name'];
                $msg .= "<br>Your login details as follows. <br> Username: $un <br><a href='$url'>click here to reset password</strong>";
                $mail = sendMail($find_user['Email'],"TWE Portal Password Reset",$msg);

                return ($mail) 
                    ? flash('success',"Please check your email to continue","/login")
                    : flash('danger',"Something went wrong try again later.","/login"); 

                // $message = "Your Password is: " . $match['meta_value'];
                // $this->forgotEmail("aamir.hameed7@gmail.com", "Subject", $message);
            }
        }

        $title['Title'] = 'Forgot Password';
        $title['subMenu'] = '';
        
        $data['page'] = [
            'title' =>  $title,
            'path' => $this->path.'forgot',
            'layout' => 'auth'
        ];
        return view('app',$data);
    }

    public function verification(){

        $reset = false;
        $req = request()->getMethod();

        if(@$_GET['token']) {
            $empMeta = new EmpMeta();
            $info = json_decode(base64_decode($_GET['token']));
            $meta = $empMeta->where(['employee' => @$info->EmployeeID, 'meta_key' => 'code', 'meta_value' => @$info->code])->first();
            if(!$meta) {
                $msg = "Link has been expired";
                $data['reset'] = false;
            } else {
                $msg = "Reset your password";
                $data['reset'] = true;

            }

            if($req == 'post') {
                if($meta) {
                    $empMeta
                        ->where(['employee'=> $info->EmployeeID, 'meta_key'=> 'password'])
                        ->set(['meta_value'=> sha1($_POST['password'])])
                        ->update();
                    
                    $empMeta->where(['employee'=> $info->EmployeeID,'meta_key'=>'code'])->delete();
                }
                $resp = ($meta) ? ['success' => true] : ['success' => false, 'msg'=>$msg];
                return $this->response->setJSON($resp); 
            }
            $data['msg'] = $msg;
            $data['info'] = $info;
        }
        $title['Title'] = 'Reset Password';
        $title['subMenu'] = '';
        
        $data['page'] = [
            'title' =>  $title,
            'path' => $this->path.'verification',
            'layout' => 'auth'
        ];
        return view('app',$data);
    }




    
function forgotEmail($to, $subject, $message){
    $email = \Config\Services::email();
    $email->setTo($to);
    $email->setFrom('thewairelessexp@noreplay.com', 'notification update');
    $email->setSubject($subject);
    $email->setMessage($message);

    $headers = 'From: webmaster@example.com'       . "\r\n" .
                 'Reply-To: webmaster@example.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
             mail($to, $subject, $message, $headers);

    if ($email->send()) 
    {
        echo 'Email successfully sent';
    } 
    else 
    {
        $data = $email->printDebugger(['headers']);
        print_r($data);
    }
}

    public function logout()
    {
        $session = session();
        $session->remove('user_data');
        unset($_SESSION['loggedIn']);
        return redirect()->to('login');
    }
    
    private function login() {

        $title['Title'] = 'Login';
        $title['subMenu'] = '';

        $data['page'] = [
            'title' => $title,
            'path' => $this->path.'index',
            'layout' => 'auth'
        ];
        
        return view('app',$data);
    }
    
    private function verify() {
        $model = new Employee();
        $empMeta = new EmpMeta();
        $session = session();
        
        // searching for employee
        $find_user = $model->where('Username',$_POST['username'])->first();
        if ( !$find_user ) return flash('danger',"No Employee found with this email.",'login');
        
        // matching entered password
        $matchData = ['employee' => $find_user['EmployeeID'],'meta_key' => 'password','meta_value' => sha1($_POST['password'])];
        $match = $empMeta->where($matchData)->first();
        if ( !$match ) return flash('danger',"Invalid Password",'login');

        // HR role switch to admin
        $titl = $find_user['Title'];
        if ($titl == 'Human Resource'|| $titl == 'Full Access') $find_user['Title'] = 'Administrator';
        if ($titl == 'B2B Supervisor' || $titl == 'Corporate') $find_user['Title'] = 'Salespeople';

        // checking account status
        if ( strtolower($find_user['Account_Disabled']) == 'true' ) return flash('danger',"Your account has been disabled",'login');

        // Storing session data
        $dashboard = str_replace(' ','-',strtolower($find_user['Title']));
        if ($dashboard == 'administrator') $dashboard = 'admin';
        if ($dashboard == 'human-resources') $dashboard = 'human-resource';

        $user_data = [
            'id' => $find_user['id'],
            'EmployeeID' => $find_user['EmployeeID'],
            'Employee_Name' => $find_user['Employee_Name'],
            'Title' => [$find_user['Title'], $dashboard]
        ];
        $session->set('user_data',$user_data);
        $session->setFlashdata('loggedIn', true);
        return flash('success','You have successfully logged in',"$dashboard/");
    }
}
