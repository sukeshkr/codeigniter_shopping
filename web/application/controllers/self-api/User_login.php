<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class User_login extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->library('bcrypt');
        $this->load->model('self-api/User_login_model','model'); //load user model
    }

    public function user_reg_put_post() {

    	$userData=array();

	//	$id = $this->post('id');
		
		$create_at = date("Y-m-d H:i:s");
		$token  = $this->post('token');
		
		$userData['user_name']  = $this->post('name');
		$userData['email']  = $this->post('email');
		
        $password  = $this->post('password');
        
        $userData['auth_key'] = $this->bcrypt->hash_password($password);

		if(!empty($userData['user_name']) && !empty($userData['email']) && !empty($userData['auth_key'])){//insert user 

	        $insert = $this->model->insertUserRegister($userData,$id);
			$userData['user_id']  =$insert;
			//check if the user data updated
			if($insert){
				//set the response and exit
				
				$value=array('mobile'=> $userData['email'],'fcm_token'=> $token,'user_id'=>$userData['user_id'],'create_at'=>$create_at);

			    $this->model->insertKey($value,$userData['user_id']);
				
				$this->response([
					'status' => TRUE,
					'user_id' => $insert,
					'user_name'=>$userData['user_name'],
					'image' => "",
					'reg_stat'=>1,
					'message' => 'User has been inserted successfully.'
				], REST_Controller::HTTP_OK);
			}else{
				//set the response and exit
				$this->response([
					'status' => FALSE,
					'user_id' => '',
					'image' => "",
					'reg_stat'=>0,
					'message' => 'User Already Exist..please login..'
				], REST_Controller::HTTP_OK);
			}
        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function user_login_post($id='') {

		$email  = $this->post('email');
		$password  = $this->post('password');

		$hash = $this->bcrypt->hash_password($password);

		if(!empty($email) && !empty($password)){//insert user 

	        $res = $this->model->loginWithCredentials($email);
	        
	        if($res) //check if the user data inserted
			{

    	        $userid=$res->id;
    
    	        $db_password=$res->auth_key;
    
    	        $user_id=$res->user_id;
    
    	        $db_name=$res->user_name;
    
    	        $db_image=$res->prof_image;
    
    			if (($this->bcrypt->check_password($password, $db_password)) && ($user_id==$user_id))
    			{
    				//set the response and exit
    				$this->response([
    					'status' => TRUE,
    					'user_id' => $userid,
    					'user_name' => $db_name,
    					'login_stat' => 1,
    					'image' => $db_image,
    					'message' => 'login'
    				], REST_Controller::HTTP_OK);
    			}else{
    				//set the response and exit
    				$this->response([
    					'status' => FALSE,
    					'user_id' => $userid,
    					'login_stat' => 0,
    					'message' => 'Invalid Password'
    				], REST_Controller::HTTP_OK);
    			}
    			
			}else{
				//set the response and exit
				$this->response([
					'status' => FALSE,
    				'login_stat' => 2,
					'message' => 'No user exist, please register'
				], REST_Controller::HTTP_OK);
			}
			
        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	
	public function send_email_otp_post() {

		$email  = $this->post('email');
		
		
		if(!empty($email)) { //insert user data
			
		    $rndno1=rand(10, 99);
	       	$rndno2=rand(88, 10);
	        $key_word = urlencode($rndno1.$rndno2);
	        $date = date_default_timezone_set('Asia/Kolkata');

	        $create_at = date("Y-m-d H:i:s");

	        $time = date("Y-m-d H:i:s",strtotime("+10 minute"));

	        $value=array('mobile'=>$email,'key_word'=>$key_word,'create_at'=>$create_at,'date_exp'=>$time);
            $check_res=$this->model->checkEmailexist($email);
            //print_r($check_res);exit;

			if($check_res)
			{
			    $insert = $this->model->insertKeyByEmail($value,$email);
			
			if($insert) //check if the user data inserted
			{
				
		        $subject="Password Verification";
		        $msg="Please note Otp for further proceedings.. ";
		        $from = '<noreply@onlister.com>';
		        $to = $email;

		        $config = Array(
		        'protocol' => 'sendmail',
		        'mailtype' => 'html',
		        'charset' => 'iso-8859-1'
		        );

		        $this->load->library('email',$config);
		        $this->email->from($from, $email);
		        $this->email->to($to);
		        $this->email->subject("Passsword resett " . $email);
		        $this->email->set_mailtype("html");

		        $email_body = "<table style='width:700px;border:0px #e5e5e5 solid;background:#eeeeee;color:#000000;padding:10px; font-family:Tahoma, Geneva, sans-serif;'><tbody><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Verification code:</strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $key_word . "</td></tr><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Email:</strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $email . "</td></tr><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Subject:</strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $subject . "</td> </tr><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Message:</strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $msg . "</td> </tr></tbody></table>";
	        
		        $body = str_replace("\n", "<br/>", $email_body);
	        
		        $this->email->message($body);

		        $this->email->send(); 
		     
				//set the response and exit
				$this->response([
					'status' => TRUE,
					'sent_stat'=>0,
					'message' => 'Email sent successfully.'
				], REST_Controller::HTTP_OK);


			}else{
				//set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
			}
			}
			else
			{
			    $this->response([
					'status' => FALSE,
					'sent_stat'=>1,
					'message' => 'Email not found'
				], REST_Controller::HTTP_OK);

			}
			
			
        }else{
			//set the response and exit
			//BAD_REQUEST (400) being the HTTP response code
            $this->response("Provide complete user information to create.", REST_Controller::HTTP_BAD_REQUEST);
		}

	}
	
	public function otp_check_post() 
    {

		$otp = $this->post('otp');
		$email = $this->post('email');

		$date = date_default_timezone_set('Asia/Kolkata');

		$time = date("Y-m-d H:i:s");

		$result = $this->model->checkOtpNumber($otp,$email);

    	if($result)
        {
            
            $res = $this->model->getWithCredentialsByEmail($email);

        	$userid=$res->id;

        	$this->response([
			'status' => TRUE,
			'user_id' => $userid,
			'message' => 'go ahead'
			], REST_Controller::HTTP_OK);
	      
        }

        else {
	         
			$this->response([
			'status' => FALSE,
			'message' => 'Otp wrong'
			], REST_Controller::HTTP_OK);
        }
        
    }
    
    public function update_tocken_post() 
    {

		$user_id = $this->post('user_id');

		$tocken = $this->post('tocken');

       
    	if(!empty($tocken) && !empty($user_id))//insert user 
        {

        	$insert =$this->model->updatetocken($tocken,$user_id);

            if($insert) {
                
            	$this->response([
					'status' => TRUE,
					'user_id' => $user_id,
					'message' => 'updated'
				], REST_Controller::HTTP_OK);

	      
            }

            else {
	         
				$this->response([
				'status' => FALSE,
				'message' => 'not updated'
				], REST_Controller::HTTP_OK);

            }

        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
        
    }
    public function password_update_post() 
    {

		$user_id = $this->post('user_id');

		$password = $this->post('password');

        $password = $this->bcrypt->hash_password($password);

    	if(!empty($password) && !empty($user_id))//insert user 
        {

        	$insert =$this->model->updatePassword($password,$user_id);

            if($insert) {

            	$res = $this->model->getWithCredentials($user_id);

		        $userid=$res->id;

		        $db_name=$res->user_name;

		        $db_image=$res->prof_image;

            	$this->response([
					'status' => TRUE,
					'user_id' => $userid,
					'user_name' => $db_name,
					'image' => $db_image,
					'message' => 'login'
				], REST_Controller::HTTP_OK);

	      
            }

            else {
	         
				$this->response([
				'status' => FALSE,
				'message' => 'not updated'
				], REST_Controller::HTTP_OK);

            }

        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
        
    }


}

?>