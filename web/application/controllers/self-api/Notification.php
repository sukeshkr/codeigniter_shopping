<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Notification extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('self-api/Notification_model','model'); //load user model
    }

    public function notification_get_post() //seller function
    {
    	$user_id=$this->post('user_id');

        if(!empty($user_id)) {

            $result = $this->model->getUserNotificationData($user_id);
             
            if($result)
            {
                $this->model->updateUserNotification($user_id);

            	$this->response([
    		 			'status' => TRUE,
    					'result'=> $result
    					], REST_Controller::HTTP_OK);
            }
     
            else{

                 $this->response([
                    'status' => TRUE,
                    'message' => 'No row affected'
                ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function notification_get_seller_post() //seller function
    {
    	$seller_id=$this->post('seller_id');

        if(!empty($seller_id)) {

            $result = $this->model->getSellerNotificationData($seller_id);
             
            if($result) {

                $this->model->updateSellerNotification($seller_id);

            	$this->response([
    		 			'status' => TRUE,
    					'result'=> $result
    					], REST_Controller::HTTP_OK);
            }
     
            else{

                $this->response([
                        'status' => TRUE,
                        'message' => 'No row affected'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

	
}

?>
