<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Home_page extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('self-api/Home_page_model','model'); //load user model
    }
	
    public function home_get_post() //Each product with all details
    {
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');
		$row = $this->post('row');
		$user_id = $this->post('user_id');
		$seller_id = $this->post('seller_id');
		
        $date = date('Y-m-d G:i:s', time());

        $home_banner = $this->model->getHomeBannerList($latitude,$longitude,$radius);   

		$result = $this->model->getHomeDataList($seller_id,$user_id,$row,$latitude,$longitude,$radius);   

        $count=$this->model->getHomeTotalCount($seller_id,$latitude,$longitude,$radius);   

        $seller = $this->model->getHomeBusDataList($user_id,$row,$latitude,$longitude,$radius);

        if($result || $seller || $deals) {

        	$this->response([
		 			'status' => TRUE,
                    'count'=> $count,
                    'home_banner'=> $home_banner,
					'result'=> $result,
                    'seller'=> $seller
					], REST_Controller::HTTP_OK);
        }
        else{

        	$this->response([
                'status' => FALSE,
                'message' => 'No results found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function product_by_area_post()
    {
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $radius = $this->post('radius');

        $order = $this->post('order');
        $row = $this->post('row');
        $home_id = $this->post('home_id');
        $user_id = $this->post('user_id');
        
        $seller_id = $this->post('seller_id');

        $data = $this->post('data');
        $data = json_decode($data, true);

        if($order==0)
        {
            $order= 'distance';
        }
        if($order==1)
        {
            $order= 'id desc';
        }
        if($order==2)
        {
            $order= 'list_price asc';
        }
        if($order==3)
        {
            $order= 'list_price desc';
        }
        if($order==4)
        {
            $order= 'rating desc';
        }
         if($order==5)
        {
            $order= 'discount desc';
        }

        if(!empty($home_id) && !empty($latitude) && !empty($longitude) && !empty($radius)) {

            $list = $this->model->getProductListByArea($seller_id,$home_id,$latitude,$longitude,$radius,$row,$order,$data);

            $total_count = $this->model->getProductListByAreaCount($seller_id,$home_id,$latitude,$longitude,$radius,$data);

            $cart_count = $this->model->getUserCartCountSub($user_id);
         
            if($list)
            {
                $this->response([
                    'status' => TRUE,
                    'total_count'=> $total_count,
                    'cart_count'=> $cart_count,
                    'category'=> $list,
                    ], REST_Controller::HTTP_OK);
            }
     
            else
            {
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

    public function product_filter_list_post() //Each product with all details
    {
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $radius = $this->post('radius');

        $home_id = $this->post('home_id');
        
        $seller_id = $this->post('seller_id');

        $min_price = $this->post('min_price');
        $max_price = $this->post('max_price');

        if(!empty($home_id) && !empty($latitude) && !empty($longitude) && !empty($radius)) {

            $option = $this->model->getProductFilterOption($seller_id,$home_id,$latitude,$longitude,$radius,$min_price,$max_price);

            $feature = $this->model->getProductFilterFeature($seller_id,$home_id,$latitude,$longitude,$radius,$min_price,$max_price);

            $price = $this->model->getProductFilterPrice($seller_id,$home_id,$latitude,$longitude,$radius,$min_price,$max_price);

            $category = $this->model->getProductFilterCategory($seller_id,$home_id,$latitude,$longitude,$radius,$min_price,$max_price);

            $seller = $this->model->getProductFilterSeller($seller_id,$home_id,$latitude,$longitude,$radius,$min_price,$max_price);

            $option=array("option"=>$option);

            $price=array("price"=>$price);
 
            $feature=array("feature"=>$feature);

            $category=array("category"=>$category);

            $seller=array("seller"=>$seller);

            $list = array_merge($option,$feature,$price,$category,$seller);

            if($list) {

                $this->response([
                        'status' => TRUE,
                        'filter_main'=> $list,
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

    public function stock_wise_list_post() //Each product with all details
    {

        $stock_id = $this->post('stock_id');

        $user_id = $this->post('user_id');

        if(!empty($stock_id)) {

            $list = $this->model->getStockIdWiseList($stock_id,$user_id);


            if($list){

                $this->response([
                        'status' => TRUE,
                        'product'=> $list
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

?>
