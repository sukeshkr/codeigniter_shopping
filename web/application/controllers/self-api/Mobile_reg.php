<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Mobile_reg extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        //$this->load->library('bcrypt');

		//load user model
        $this->load->model('self-api/Otp_model','model');
    }
	
	public function put_otp_post() {

		if(!empty($this->post('mobile'))) {
			//insert user data

            $mobile = $this->post('mobile');
           // $hash = $this->bcrypt->hash_password($mobile);//bcrypt mobile number to create token

		    $rndno1=rand(10, 99);
	       	$rndno2=rand(88, 10);
	        $key_word = urlencode($rndno1.$rndno2);
	        $date = date_default_timezone_set('Asia/Kolkata');

	        $create_at = date("Y-m-d H:i:s");

	        $time = date("Y-m-d H:i:s",strtotime("+3 minute"));

	        $value=array('key_word'=>$key_word,'mobile'=> $mobile,'create_at'=>$create_at,'date_exp'=>$time);

			$insert = $this->model->insertKey($value,$mobile,$key_word,$time);
			
			if($insert) //check if the user data inserted
			{

				$data = http_build_query(array(
				'username' => 'ONLISTER',
				'api_password' => '04ec1q00ke6rt7n4b',
				'sender' => 'ONLSTR',
				'to' => $mobile,
				'message' => "Onlister OTP Number is: ".$key_word.". Don't share this with anyone",
				'priority'=>'4'
				));

				$context = array();

				// Create HTTP stream context
				$context = stream_context_create(array(
				'http' => array(
				    'method' => 'POST',
				    'header' => 'Content-Type: application/x-www-form-urlencoded',
				    'content' => $data
				)
				));

               // Make POST request
               $response = file_get_contents('http://sms.getlead.co.uk/pushsms.php', false, $context);
               
				//set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'User has been added successfully.'
				], REST_Controller::HTTP_OK);


			}else{
				//set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
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
			$number = $this->post('number');
			$name = $this->post('name');
			$fcm_token = $this->post('fcm_token');
			
			if(!empty($this->post('seller_id')))
		    {
    			$app_id = $this->post('seller_id');

	   	    }
		    else{

    			$app_id = "";

		    }

			$date = date_default_timezone_set('Asia/Kolkata');

			$time = date("Y-m-d H:i:s");

			$data['resultExp'] = $this->model->checkNumberExp($otp,$number,$time);

			if($data['resultExp']=="")
			{
				
				$this->response([
					  'status' => FALSE,
					  'id' => "",
					  'message' => 'Time expired, please try again'
				      ], REST_Controller::HTTP_OK);
				
			}
			else{


				$resultcheck = $this->model->checkOtpNumber($otp,$number);


		    	if($resultcheck !="")
	            {

                    $this->model->updateFcmToken($fcm_token,$number);
	            	
			        $resultNumber = $this->model->checkNumber($number);

				    if($resultNumber !="")
			        {
                        $this->model->updateStatus($number);
			            //$this->model->userAppIdUpdate($app_id,$resultNumber);

                        $this->response([
                        'status' => TRUE,
                        'message' => '1',
                        'id' => $resultNumber,
                        'action' => 'login'
                        ], REST_Controller::HTTP_OK);

			        }


			        else {

			        	$insert_id = $this->model->userInsert($number,$name,$app_id);
			        	
			        	$this->model->userAppIdUpdate($app_id,$insert_id);

			        	$this->response([
					  'status' => TRUE,
					  'message' => '0',
					  'id' => $insert_id,
					  'default_path' => DEFUALT_IMAGE_LINK,
					  'action' => 'register'
				      ], REST_Controller::HTTP_OK);

			        }
			        
	            }

	            else {
			         
			           $this->response([
					  'status' => FALSE,
					  'id' => "",
					  'message' => 'Otp wrong'
				      ], REST_Controller::HTTP_OK);
	            }

			}
        
    }
	
	
	
	
	
	

/*	public function otp_check_post() 
    {

		$otp = $this->post('otp');
		$number = $this->post('number');
		$name = $this->post('name');
		$fcm_token = $this->post('fcm_token');

		if(!empty($this->post('seller_id')))
		{
			$app_id = $this->post('seller_id');

		}
		else{

			$app_id = "";

		}

		$date = date_default_timezone_set('Asia/Kolkata');

		$time = date("Y-m-d H:i:s");

		$data['resultExp'] = $this->model->checkNumberExp($otp,$number,$time);

		if($data['resultExp']=="")
		{
			$this->response([
				  'status' => FALSE,
				  'id' => "",
				  'message' => 'Time expired, please try again'
			      ], REST_Controller::HTTP_OK);
			
		}
		else{

			$resultcheck = $this->model->checkOtpNumber($otp,$number);

	    	if($resultcheck !="")
            {
            	$this->model->updateFcmToken($fcm_token,$number);

		        $resultNumber = $this->model->checkNumber($number);

			    if($resultNumber !="")
		        {
		            
		            $this->model->userAppIdUpdate($app_id,$resultNumber);

					$this->response([
					'status' => TRUE,
					'message' => '1',
					'id' => $number,
					'action' => 'login'
					], REST_Controller::HTTP_OK);

		        }

		        else {

		        	$insert_id = $this->model->userInsert($number,$name,$app_id);
		        	
		        	$this->model->userAppIdUpdate($app_id,$insert_id);

					$this->response([
					'status' => TRUE,
					'message' => '0',
					'id' => $insert_id,
					'default_path' => DEFUALT_IMAGE_LINK,
					'action' => 'register'
					], REST_Controller::HTTP_OK);

		        }
		        
            }

            else {
		         
				$this->response([
				'status' => FALSE,
				'id' => "",
				'message' => 'Otp wrong'
				], REST_Controller::HTTP_OK);
            }

		}
        
    }*/



	
	public function user_delete($id) {
        //check whether post id is not empty
        if($id){
            //delete post
            $delete = $this->user->delete($id);
            
            if($delete){
                //set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'User has been removed successfully.'
				], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
			//set the response and exit
			$this->response([
				'status' => FALSE,
				'message' => 'No user were found.'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }  
}

?>
