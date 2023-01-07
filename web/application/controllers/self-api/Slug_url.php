<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library


class Slug_url extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->library('aws3');
        $this->load->library('notification_lib');
        $this->load->model('self-api/Cart_product_model','model'); //load user model
        $this->load->helper('url');

        $this->load->helper('common');
    }

    public function product_wise_list_post() //Each product with all details
    {
        $user_id = $this->post('user_id');
        $option = $this->post('option');
        $option = json_decode($option, true);
        $product_id = $this->post('product_id');

        $encrypted_id = $this->post('encrypted_id');

        $decrypted_id_raw = base64_decode($encrypted_id);

        $stock_id = preg_replace(sprintf('/%s/', SALT_KEY), '', $decrypted_id_raw);

        if(!empty($user_id) && !empty($stock_id)) {

            $list = $this->model->getProductIdWiseList($stock_id,$user_id,$option,$product_id);

            $status = $this->model->getProductReviewStatus($user_id,$stock_id);

            $cart_status = $this->model->getStockCartStatus($user_id,$stock_id);

            if($list){

                $this->response([
                        'status' => TRUE,
                        'review_status'=> $status,
                        'cart_status'=> $cart_status,
                        'product'=> $list,
                        ], REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                        'status' => TRUE,
                        'message' => 'No combination found'
                    ], REST_Controller::HTTP_OK);
            }

        }else{
            //set the response and exit
            $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}