<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Cart_enquiry extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        $this->load->library('Sm_notification_lib');
        $this->load->model('self-api/Cart_enquiry_model','model'); //load user model
    }
  
    public function put_enquiry_post() {

        $data = $this->post('data');
        $data = json_decode($data, true);

        $user_id = $this->post('user_id');
        $seller_id = $this->post('seller_id');
        $seller_name = $this->post('seller_name');

        if( !empty($data) && !empty($user_id) && !empty($seller_id)) {

        //update user data
          
            $result = $this->model->insertCartEnquiry($data,$user_id,$seller_id);

            //check if the user data updated
            if($result){
                
                $message='You have a new Products Enquiry..';

                $this->model->SingleSellerNotificationInsert($seller_id,$message);
                
                $mPushNotification = array('title'=>'order place','app_id'=>$seller_id,'app_name'=>$seller_name,'message'=>$message,'type'=>'enquiry','image'=>GEN_NOTIFY_IMAGE_LINK.$seller_id.'.png');

                //getting the token from database object 
                $devicetoken = $this->sm_notification_lib->get_single_token_byseller_post($seller_id);

                //sending push notification and displaying result 
                $notification= $this->sm_notification_lib->send_seller_post($devicetoken,$mPushNotification);
                
                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'sucessfuly inserted'
                    ], REST_Controller::HTTP_OK);
            }else{

                //set the response and exit
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
    
    public function get_enquiry_post() {

        $user_id = $this->post('user_id');

        $seller_id = $this->post('seller_id');

        if(!empty($user_id) && !empty($seller_id)) {

        $list = $this->model->getEnquiryData($user_id,$seller_id);

            if($list) {

                $this->response([
                        'status' => TRUE,
                        'result'=> $list
                        ], REST_Controller::HTTP_OK);
            }
            else{

                    $this->response([
                    'status' => FALSE,
                    'message' => 'No result were found.'
                ], REST_Controller::HTTP_NOT_FOUND);

            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_enquiry_seller_post() {

        $seller_id = $this->post('seller_id');

        if(!empty($seller_id)) {

            $pending = $this->model->getEnquirySellerData($seller_id,$status=2);

            $delivered = $this->model->getEnquirySellerData($seller_id,$status=1);

            $canceled = $this->model->getEnquirySellerData($seller_id,$status=0);

            if(!empty($pending) || !empty($delivered) || !empty($canceled)) {

                $this->response([
                        'status' => TRUE,
                        'pending'=> $pending,
                        'delivered'=> $delivered,
                        'canceled'=> $canceled
                        ], REST_Controller::HTTP_OK);
            }
            else{

                    $this->response([
                    'status' => FALSE,
                    'message' => 'No result were found.'
                ], REST_Controller::HTTP_NOT_FOUND);

            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    public function enquiry_by_id_post() {

        $enquiry_id = $this->post('enquiry_id');

        if(!empty($enquiry_id)) {

        $list = $this->model->getEnquiryByIdData($enquiry_id);

            if($list) {

                $this->response([
                        'status' => TRUE,
                        'result'=> $list
                        ], REST_Controller::HTTP_OK);
            }
            else{

                    $this->response([
                    'status' => FALSE,
                    'message' => 'No result were found.'
                ], REST_Controller::HTTP_NOT_FOUND);

            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }


}

?>
