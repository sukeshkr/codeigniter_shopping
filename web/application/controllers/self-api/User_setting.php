<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class User_setting extends REST_Controller {

    public function __construct() { 

        parent::__construct();
        $this->load->model('self-api/User_setting_model','model'); //load user model
    }


    public function notification_get_post() //Each seller wise with all details
    {
        $user_id = $this->post('user_id');

        if(!empty($user_id)) {

            $list = $this->model->getUserNotification($user_id);

            if($list !=""){

                $this->response([
                    'status' => $list
                    ], REST_Controller::HTTP_OK);
            }
     
            else{

                $this->response([
                    'status' => TRUE,
                    'message' => 'no row affected.'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function notification_get_put_post() //Each product with all details
    {

        $user_id = $this->post('user_id');

        $status = $this->post('status');

        if(!empty($user_id)){

            //update user data
            $update = $this->model->setNotificationStatus($user_id,$status);
            
            //check if the user data updated
            if($update){

                $list = $this->model->getUserNotification($user_id);
                //set the response and exit             
                $this->response([
                    'status' => TRUE,
                    'noti_status' => $list,
                    'message' => 'updated successfully.'
                    ], REST_Controller::HTTP_OK);

            }else{
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'noti_status' => $list,
                    'message' => 'no active seller.'
                    ], REST_Controller::HTTP_OK);
            }
        }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function user_deactivate_get_post() //Each seller wise with all details
    {
        $user_id = $this->post('user_id');
        $status = $this->post('status');

        if(!empty($user_id)) {

            $key =$this->model->putUserDeactivateData($status,$user_id); 

            $list = $this->model->getUserDeactivateData($user_id);  
 
            if($key){

                $this->response([
                    'status' => TRUE,
                    'user'=> $list
                    ], REST_Controller::HTTP_OK);
            }
         
            else{

                $this->response([
                    'status' => TRUE,
                    'user'=> $list,
                    'message' => 'No seller found'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

   public function user_phone_check_post() //Each seller wise with all details
    {
        $old_number = $this->post('old_number');

        $new_number = $this->post('new_number');

        $user_id = $this->post('user_id');

        if(!empty($old_number) && !empty($new_number) && !empty($user_id)) {

            $list = $this->model->checkPhoneData($old_number,$user_id);

            if($list) {

                $rndno1=rand(10, 99);
                $rndno2=rand(88, 10);
                $key_word = urlencode($rndno1.$rndno2);
                $date = date_default_timezone_set('Asia/Kolkata');

                $create_at = date("Y-m-d H:i:s");

                $time = date("Y-m-d H:i:s",strtotime("+3 minute"));

                $value=array('key_word'=>$key_word,'mobile'=> $new_number,'create_at'=>$create_at,'date_exp'=>$time);

                $insert = $this->model->insertKey($value,$new_number,$key_word,$time);

                if($insert) //check if the user data inserted
                {
                   $data = http_build_query(array(
                    'username' => 'ONLISTER',
                    'api_password' => '04ec1q00ke6rt7n4b',
                    'sender' => 'ONLSTR',
                    'to' => $new_number,
                    'message' => "Onlister OTP Number is: ".$key_word.". Don't share this with anyone",
                    'priority'=>'4'
                    ));

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
                        'resp'=>$response,
                        'message' => 'Otp sent successfully.'
                    ], REST_Controller::HTTP_OK);


                }else{
                    //set the response and exit
                          $this->response([
                        'status' => FALSE,
                        'message' => 'Otp not sent.'
                    ], REST_Controller::HTTP_OK);
                }

            }
     
            else{

                $this->response([
                'status' => FALSE,
                'message' => 'phone number mismatch'
                ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function change_number_put_post() 
    {
        $otp = $this->post('otp');
        $user_id = $this->post('user_id');
        
        $new_number = $this->post('new_number');
        $fcm_token = $this->post('fcm_token');

        $date = date_default_timezone_set('Asia/Kolkata');

        $time = date("Y-m-d H:i:s");

        if(!empty($user_id) && !empty($new_number)) {

            $resultExp = $this->model->checkNumberExp($otp,$new_number,$time);

            if($resultExp=="")
            {
                $this->response([
                      'status' => FALSE,
                      'id' => "",
                      'message' => 'Time expired, please try again'
                      ], REST_Controller::HTTP_OK);

            }           
            else{

                $resultcheck = $this->model->checkOtpNumber($otp,$new_number);

                if($resultcheck)
                {
                    $this->model->updateFcmToken($fcm_token,$new_number);

                    $update = $this->model->changePhoneNumber($user_id,$new_number);

                    if($update) {

                    //set the response and exit             
                    $this->response([
                        'status' => TRUE,
                        'message' => 'updated successfully.'
                        ], REST_Controller::HTTP_OK);

                    }else{
                        //set the response and exit
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Number already registered'
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

        }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }

}

?>
