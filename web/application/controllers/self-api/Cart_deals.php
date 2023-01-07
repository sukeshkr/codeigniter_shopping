<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Cart_deals extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        //$this->load->library('Image');
       
        $this->load->model('self-api/Cart_deals_model','model'); //load user model

        $this->load->library('notification_lib');
    }

    public function product_get_post() {

        $seller_id  = $this->post('seller_id');

        if(!empty($seller_id)){

            $product = $this->model->getDelasProducts($seller_id);

            if($product)
            {
                $this->response([
                        'status' => TRUE,
                        'products'=> $product
                        ], REST_Controller::HTTP_OK);
            }
     
           else{
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
    
    public function deals_by_area_post()
    {
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $radius = $this->post('radius');
        
        
        $seller_id = $this->post('seller_id');

        $date = date('Y-m-d G:i:s', time());
        //print_r('1');exit;
        //$direct_discount = $this->model->getDealProductListByArea($seller_id,$latitude,$longitude,$radius,$date);
        $direct_discount=array();
        $direct_discount_res=array('title'=>'Direct discount','result'=>$direct_discount);

        $bundel_discount = $this->model->getBundelProductListByArea($seller_id,$latitude,$longitude,$radius,$date);
        $bundel_discount_res=array('title'=>'Combo discount','result'=>$bundel_discount);

       // $buy_get_offer = $this->model->getBuyGetListByArea($seller_id,$latitude,$longitude,$radius,$date);
       $buy_get_offer =array();
        $buy_get_offer_res=array('title'=>'Buy Get Offer','result'=>$buy_get_offer);

       // $cash_back_offer = $this->model->getCashBackListByArea($seller_id,$latitude,$longitude,$radius,$date);
       $cash_back_offer=array();
        $cash_back_offer_res=array('title'=>'Cash Back Offer','result'=>$cash_back_offer);

        $result = array_merge(array($direct_discount_res,$bundel_discount_res,$buy_get_offer_res,$cash_back_offer_res));
        
        $todays_deal_offer = array_merge($direct_discount,$bundel_discount,$buy_get_offer,$cash_back_offer);

        if($direct_discount || $bundel_discount || $buy_get_offer || $cash_back_offer)
        {
            $this->response([
                    'status' => TRUE,
                    'todays_deal'=> $todays_deal_offer,
                    'value'=> $result
                    ], REST_Controller::HTTP_OK);
        }
 
        else
        {
            $this->response(NULL, REST_Controller::HTTP_OK);
        }
    }
     public function deals_by_area1_post()
    {
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $radius = $this->post('radius');
        
         $this->response([
                        'status' => TRUE,
                        'message' => 'New Offer has been inserted successfully.'
                    ], REST_Controller::HTTP_OK);
        
        
        
    }
    
    public function regencyOffer_post()
    {
        $store_id=$this->post('store_id');
        $seller_id="";
        $latitude="";
        $longitude="";
        $radius="";
        $date="";
        $direct_discount = $this->model->getRegencyoffer($seller_id,$latitude,$longitude,$radius,$date,$store_id);
        if(!empty($direct_discount)) {
        
            //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => '1',
                        'offer'=>$direct_discount
                    ], REST_Controller::HTTP_OK);
            }else{
            //set the response and exit

                $this->response([
                        'status' => TRUE,
                        'message' => '0'
                    ], REST_Controller::HTTP_OK);
            }
        
        
    }


    public function offer_put_post() {

        $offerData = array();

        $id = $this->post('id');
        
        $offerData['seller_id']  = $this->post('seller_id');
        $offerData['caption']  = $this->post('caption');
        $offerData['start_date'] = $this->post('start_date');
        $offerData['exp_date'] = $this->post('exp_date');

        if(!empty($_FILES)) {
            
            $this->image->offer_image();//call custom image library
            
            if($this->image->image_name) {
                
                $offerData['image']= $this->image->image_name;
                
            }
            else{
                
                $offerData['image']= "no image";
            }
            
        }
     
        if(!empty($offerData['caption']) && !empty($offerData['start_date']) && !empty($offerData['exp_date'])) {

                $insert = $this->model->insertOfferData($offerData,$id);
                
                //check if the user data updated
                if($insert){
                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'New Offer has been inserted successfully.'
                    ], REST_Controller::HTTP_OK);
                }else{
                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Something not correct'
                    ], REST_Controller::HTTP_OK);
                }

          

        }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function offer_user_rating_post()  { //add user rate for product

        $ratingData['user_id']  = $this->post('user_id');
        $ratingData['offer_id']  = $this->post('offer_id');
        $ratingData['rating_score']  = $this->post('rating_score');
        $ratingData['comments']  = $this->post('comments');
     
        if(!empty($ratingData['user_id']) && !empty($ratingData['offer_id'])) {
        //update user data

            $insert = $this->model->insertDealRatingData($ratingData);
            //check if the user data updated
            if($insert) {

            //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'rating has been added successfully.'
                    ], REST_Controller::HTTP_OK);
            }else{
            //set the response and exit

                $this->response([
                        'status' => FALSE,
                        'message' => 'please buy product'
                    ], REST_Controller::HTTP_OK);
            }
        }
        else{
        //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
  
    public function daily_offer_get_post() //Each product with all details
    {
        $offer_id = $this->post('offer_id');

        if(!empty($offer_id)) {

            $result = $this->model->getDailyOfferByIdData($offer_id);

            if($result){

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

   
    public function get_active_offer_post() {

        $seller_id = $this->post('seller_id');

        $search = $this->post('search');

        $row = $this->post('row');

        if(!empty($seller_id)) {

            $result = $this->model->getDailyOfferProductData($seller_id,$search,$row);

            $count = $this->model->getDailyOfferProductDataCount($seller_id,$search);

            if($result){

                $this->response([
                        'status' => TRUE,
                        'count'=> $count,
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
    
    public function delete_offer_post() {

        $offer_id = $this->post('offer_id');

        if(!empty($offer_id)) {

            $delete = $this->model->deleteOfferProductData($offer_id);
            
            $result = $this->model->getDailyOfferProductData();
            
            if($result){

                $this->response([
                        'status' => TRUE,
                        'result'=> $result
                        ], REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                        'status' => TRUE,
                        'result'=> $result,
                        'message' => 'No data found'
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
