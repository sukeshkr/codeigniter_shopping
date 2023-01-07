<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Cart_product extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->library('notification_lib');
        $this->load->model('self-api/Cart_product_model','model'); //load user model

        $this->load->helper('url');

        $this->load->helper('common');
    }
    
    public function product_home_get_post() //Home page data details
    {
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');
		$store_id= $this->post('store_id');
		$user_id = $this->post('user_id');
		$seller_id = $this->post('seller_id');

		if(!empty($latitude) && !empty($longitude) && !empty($radius) && !empty($seller_id)) {

			$list = $this->model->getCatProductListByArea($seller_id);
			
			//$service_cat = $this->model->getCatServiceListByArea($seller_id);

			if(!empty($list)) {

				$set_cat_id=$list[0]->cat_id;
			}

			else{

				$set_cat_id=1;
			}

			$user_list = $this->model->getUserDetailsList($user_id);

			$seller_banner = $this->model->getSellerPriorityBannerList($seller_id,$latitude,$longitude,$radius);

			$product_list = $this->model->getProductCatWise($seller_id,$set_cat_id);

	        $popular = $this->model->getPopularProductList($seller_id,$user_id,$latitude,$longitude,$radius);
	        $popular=array("title"=>'Popular Products',"value1"=>$popular);
	        
	        $cat_list = $this->model->getProductWiseCategoryList($seller_id);
	        
	        
	        if(!empty($cat_list)) {
	            
                shuffle($cat_list);
			}

	        if(!empty($cat_list || $seller_banner)) {

				$set_id=$cat_list[0]['cat_id'];

				$set_name=$cat_list[0]['cat_name'];
			}

			else{

				$set_id=148;

				$set_name='Cleaning Products';
			}

	        $cleaning = $this->model->getPopularProductList($seller_id,$user_id,$latitude,$longitude,$radius,$set_id);
	        $cleaning=array("title"=>$set_name,"value1"=>$cleaning);

	        $array_mege = array_merge(array($popular,$cleaning));

            $brand = $this->model->getBrandDataList($seller_id);
            $store = $this->model->getstoreList();
            
	       // $suggested_you = $this->model->getSuggestedforYou($user_id);
	        $suggested_you = "";
	        $suggested_you=array("title"=>'Suggested you',"values"=>$suggested_you);
	        
	        $cart_count = $this->model->getUserCartCountSub($user_id,$seller_id);

	        $notification_count = $this->model->getUserNotificationCountSub($user_id);
	        
	        $all_product = $this->model->getAllproductList($seller_id,$user_id,$latitude,$longitude,$radius);
	        
        $date="";
        $offer = $this->model->getRegencyoffer($seller_id,$latitude,$longitude,$radius,$date,$store_id);
        
	       
	        if($list) {

	        	$this->response([
		 			'status' => TRUE,
		 			'cart_count' => $cart_count[0]['cart_count'],
		 			'store'=>$store,
		 			'notification_count' => $notification_count,
		 			'cat_name'=> $list,
		 			'service_cat'=> "",
		 			'user'=> $user_list,
		 			'category'=> $product_list,
		 			'seller_banner'=> $seller_banner,
					'result'=> $array_mege,
					'brand'=> $brand,
					'all_products'=> $all_product,
					'suggested'=> $suggested_you,
					'offer'=>$offer
					], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response([
						'status' => TRUE,
						'message' => 'No row affected'
					], REST_Controller::HTTP_OK);
	        }

	    }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
     public function store_contact_get_post() //Home page data details
    {
    	
		$store_id= $this->post('store_id');
		
		if(!empty($store_id))
		{
		
            $store = $this->model->getstoreListbyid($store_id);
            
	       

	        if($store) {

	        	$this->response([
		 			'status' => TRUE,
		 			'store'=>$store
					], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response([
						'status' => TRUE,
						'message' => 'No row affected'
					], REST_Controller::HTTP_OK);
	        }

	    }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function product_movetowishlist_post() { //move product to wish list

		$WishListData['user_id']  = $this->post('user_id');
		$WishListData['stock_id']  = $this->post('stock_id');
     
		if( !empty($WishListData['user_id']) && !empty($WishListData['stock_id']) ) {
		//update user data
        
	        $move = $this->model->insertMoveToWishList($WishListData);
			//check if the user data updated
			if($move){

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'moved to Wish List successfully.'
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

	public function product_liketowishlist_post() { //move product to wish list

		$WishListData['user_id']  = $this->post('user_id');
		$WishListData['stock_id']  = $this->post('stock_id');
		$WishListData['status']  = $this->post('status');
     
		if( !empty($WishListData['user_id']) && !empty($WishListData['stock_id']) ) {
		//update user data
        
	        $move = $this->model->insertLikeToWishList($WishListData);
			//check if the user data updated
			if($move){

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'moved to Wish List successfully.'
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

	public function product_remove_wishlist_post() { //add product to cart

		$user_id  = $this->post('user_id');
		$stock_id = $this->post('stock_id');

	    if( !empty($user_id) && !empty($stock_id) ){
            //delete post
            $delete = $this->model->deleteWishlist($user_id,$stock_id);
            
            if($delete){
                //set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'Removed from your wishlist'
				], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
			//set the response and exit
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found.'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function product_remove_cart_post() { //add product to cart

		$user_id  = $this->post('user_id');
		$stock_id  = $this->post('stock_id');

	     if( !empty($user_id) && !empty($stock_id) ){
            //delete post
            $delete = $this->model->deleteCart($user_id,$stock_id);
            
            if($delete){
                //set the response and exit
                
                $result = $this->model->getUserWiseCartCount($user_id);  
                
				$this->response([
					'status' => TRUE,
					'cart_count' => $result,
					'message' => 'Cart has been removed successfully.'
				], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
			//set the response and exit
			$this->response([
				'status' => FALSE,
				'message' => 'No cart were found.'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function product_category_wise_post() {
    
		$seller_id = $this->post('seller_id');
		
		$cat_id = $this->post('cat_id');
		
		if(!empty($seller_id)) {

            $list = $this->model->getProductCatWise($seller_id,$cat_id);
    
            if($list) {
    
            	$this->response([
    		 			'status' => TRUE,
    					'category'=> $list
    					], REST_Controller::HTTP_OK);
            }
            else{
    
                $this->response(NULL, 404);
            }
        
		}else{
		
			
			$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
		}
    }

    public function cart_remove_post() { //add product to cart

		$user_id  = $this->post('user_id');
		$stock_id  = $this->post('stock_id');

	    if( !empty($user_id) && !empty($stock_id) ){
            //delete post
            $delete = $this->model->removeAddCart($user_id,$stock_id);

            $cart_status = $this->model->getCartCount($user_id);
            
            if($delete){
                //set the response and exit
				$this->response([
					'status' => TRUE,
					'cart_count' => $cart_status,
					'message' => 'Cart has been removed successfully.'
				], REST_Controller::HTTP_OK);

            }else{
            	//set the response and exit
    			$this->response([
				'status' => FALSE,
				'message' => 'No cart were found.'
			    ], REST_Controller::HTTP_NOT_FOUND);
				
            }
        }else{
		
			
			$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	 public function product_user_like_post() { //add user like for product

		$likeData['user_id']  = $this->post('user_id');
		$likeData['stock_id']  = $this->post('stock_id');
		$likeData['like_status']  = $this->post('like_status');
     
		if(!empty($likeData['user_id']) && !empty($likeData['stock_id'])){
		//update user data

	        $insert = $this->model->insertLikeData($likeData);
			//check if the user data updated
			if($insert){

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'Like has been added successfully.'
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

	public function product_wise_list_post() //Each product with all details
    {
        $user_id = $this->post('user_id');
        $seller_id = $this->post('seller_id');
		$stock_id = $this->post('stock_id');
		$option = $this->post('option');
	    $option = json_decode($option, true);
	    $product_id = $this->post('product_id');

		if(!empty($user_id) && !empty($stock_id)) {

	        $list = $this->model->getProductIdWiseList($stock_id,$user_id,$option,$product_id,$seller_id);

	        $status = $this->model->getProductReviewStatus($user_id,$stock_id);

	        $cart_status = $this->model->getStockCartStatus($user_id,$stock_id);
	        
	        $cart_count = $this->model->getUserCartCountSub1($user_id,$seller_id);
	        
	       
	        
	        $delivery=30;
	        if($list[0]->list_price>250)
	        {
	            $delivery=0;
	        }
	       
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
			 			'review_status'=> $status,
			 			'cart_status'=> $cart_status,
			 			'delivery'=> $delivery,
			 			'cart_count'=> $cart_count,
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

    public function product_filter_seller_post() //Each product with all details
    {
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');

		$cat_id = $this->post('cat_id');

		$min_price = $this->post('min_price');
		$max_price = $this->post('max_price');

        $list = $this->model->getProductSelleresFilter($cat_id,$latitude,$longitude,$radius,$min_price,$max_price);
         
        if($list){

        	$this->response([
		 			'status' => TRUE,
					'filter_main'=> $list,
					], REST_Controller::HTTP_OK);
        }
 
        else{

            $this->response(NULL, 404);
        }
    }

    public function product_filter_category_post() //Each product with all details
    {
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');

		$cat_id = $this->post('cat_id');

		$min_price = $this->post('min_price');
		$max_price = $this->post('max_price');

        $list = $this->model->getProductCategoryFilter($cat_id,$latitude,$longitude,$radius,$min_price,$max_price);

        $res=array("category"=>$list);
         
        if($list){

        	$this->response([
		 			'status' => TRUE,
					'filter_main'=> $res,
					], REST_Controller::HTTP_OK);
        }
 
        else{

            $this->response(NULL, 404);
        }
    }

    public function product_by_area_post()
    {
		$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');
		$order = $this->post('order');
		$row = $this->post('row');
		$cat_id = $this->post('cat_id');
		$user_id = $this->post('user_id');
		
		$seller_id = $this->post('seller_id');
		
		$data = $this->post('data');
	    $data = json_decode($data, true);

		if($order==0)
        {
	        $order= 'id desc';
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

		if(!empty($latitude) && !empty($longitude) && !empty($radius)) {

	        $list = $this->model->getProductListByArea($cat_id,$latitude,$longitude,$radius,$row,$order,$data,$seller_id,$user_id);

	        $total_count = $this->model->getProductListByAreaCount($cat_id,$latitude,$longitude,$radius,$data,$seller_id);

	        $cart_count = $this->model->getUserCartCountSub1($user_id,$seller_id);
         
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
    
    public function category_by_area_post()
    {
		$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');

        //$list = $this->model->getCatProductListByArea($latitude,$longitude,$radius);
        $list = $this->model->getCatProductListByArea();

        if($list){

        	$this->response([
		 			'status' => TRUE,
					'cat_name'=> $list
					], REST_Controller::HTTP_OK);
        }
 
        else{

            $this->response(NULL, 404);
        }
    }


    public function product_user_rating_post() { //add user rate for product

		$ratingData['user_id']  = $this->post('user_id');
		$ratingData['stock_id']  = $this->post('stock_id');
		$ratingData['rating_score']  = $this->post('rating_score');
		$ratingData['review']  = $this->post('comments');

        $user_name  = $this->post('user_name');
		$seller_id  = $this->post('seller_id');
     
		if(!empty($ratingData['user_id']) && !empty($ratingData['stock_id'])){
		//update user data

	        $insert = $this->model->insertRatingData($ratingData);
			//check if the user data updated
			if($insert){

				$message= 'Prodtct review posted by '.$user_name;

			//	$noti=$this->model->SingleSellerNotificationInsert($seller_id,$user_name,$message);

				/*if($noti) {  

					$mPushNotification = array('title'=>'product review','message'=> $message,'image'=>NOTIFY_IMAGE_LINK);

	                //getting the token from database object 
	                $devicetoken = $this->notification_lib->get_single_token_byseller_post($seller_id);

	                //sending push notification and displaying result 
	                $notification= $this->notification_lib->send_seller_post($devicetoken,$mPushNotification);

                }*/

			        //set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'rating has been added successfully.'
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

	public function product_rating_get_post() { //add user rate for product

		$stock_id  = $this->post('stock_id');
     
		if(!empty($stock_id)) {
		//update user data

	        $result = $this->model->getProductRatingData($stock_id);
			//check if the user data updated
			if($result) {

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'result' => $result,
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

	public function product_seller_rating_post() { //add user rate for product

		$ratingData['user_id']  = $this->post('user_id');
		$ratingData['seller_id']  = $this->post('seller_id');
		$ratingData['rating_score']  = $this->post('rating_score');
		$ratingData['review']  = $this->post('review');
     
		if(!empty($ratingData['user_id']) && !empty($ratingData['seller_id'])){
		//update user data

	        $insert = $this->model->insertSellerRatingData($ratingData);
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

	public function seller_review_get_post() { //add user rate for product

		$seller_id  = $this->post('seller_id');
     
		if(!empty($seller_id)) {
		//update user data

	        $result = $this->model->getSellerReviewData($seller_id);
			//check if the user data updated
			if($result){

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'result' => $result,
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

	public function seller_user_like_post() { //add user like for product

		$likeData['user_id']  = $this->post('user_id');
		$likeData['seller_id']  = $this->post('seller_id');
		$likeData['like_status']  = $this->post('like_status');

		$user_name  = $this->post('user_name');
     
		if(!empty($likeData['user_id']) && !empty($likeData['seller_id'])){
		//update user data

	        $insert = $this->model->insertSellerLikeData($likeData);
	        
			//check if the user data updated
			if($insert) {

				$total_likes = $this->model->getSelleRatingTotalLikeSub($likeData['seller_id']);

				if($likeData['like_status']==1) {

					$message= $user_name.' following You';

					$this->model->SingleSellerNotificationInsert($likeData['seller_id'],$user_name,$message);

					$mPushNotification = array('title'=>'order place','message'=> $message,'type'=>'follow','image'=>NOTIFY_IMAGE_LINK);

	                //getting the token from database object 
	                $devicetoken = $this->notification_lib->get_single_token_byseller_post($likeData['seller_id']);


	                //sending push notification and displaying result 
	                $notification= $this->notification_lib->send_seller_post($devicetoken,$mPushNotification);

				}

			        //set the response and exit
					$this->response([
						'status' => TRUE,
						'total_likes' => $total_likes[0]['like_count'],
						'message' => 'Like has been added successfully.'
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

	public function product_add_cart_qty_post() { //add product to cart

		$cartData['user_id']  = $this->post('user_id');
		$cartData['seller_id']  = $this->post('seller_id');
		$cartData['stock_id']  = $this->post('stock_id');
		$cartData['qty']  = $this->post('qty');
     
		if(!empty($cartData['user_id']) && !empty($cartData['stock_id']) && !empty($cartData['qty'])){
		//update user data

	        $insert = $this->model->insertAddCartQtyData($cartData);
			//check if the user data updated
			if($insert){
			    
    			$result = $this->model->getUserWiseCartCount($cartData['user_id'],$cartData['seller_id']);  

			    //set the response and exit
				$this->response([
					'status' => TRUE,
					'cart_count' => $result,
					'message' => 'added to cart successfully.'
				], REST_Controller::HTTP_OK);
			}else{
			//set the response and exit

				$this->response([
						'status' => FALSE,
						'message' => 'Please select less stock'
					], REST_Controller::HTTP_OK);

			}
        }
        else{
		    //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
	    }
	}

	public function product_add_cart_post() { //add product to cart

		$cartData['user_id']  = $this->post('user_id');
		$cartData['seller_id']  = $this->post('seller_id');
		$cartData['stock_id']  = $this->post('stock_id');
     
		if(!empty($cartData['user_id']) && !empty($cartData['stock_id'])){
		//update user data

	        $insert = $this->model->insertAddCartData($cartData);
			//check if the user data updated

			if($insert) {

				$cart_status = $this->model->getCartCount($cartData['user_id'],$cartData['seller_id']);

			        //set the response and exit
					$this->response([
						'status' => TRUE,
						'cart_count' => $cart_status,
						'message' => 'added to cart successfully.'
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

	public function product_click_count_post() { //add product to cart

		$click_count  = $this->post('click_count');
		$product_id  = $this->post('product_id');
     
		if(!empty($click_count) && !empty($product_id)){
		//update user data

	        $insert = $this->model->insertProductCountData($click_count,$product_id);
			//check if the user data updated
			if($insert) {

		        //set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'user clicked successfully.'
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

	public function user_recently_viewed_post() { //move recently viewed to  list

		$RecentListData['user_id']  = $this->post('user_id');
		$RecentListData['product_id']  = $this->post('product_id');
     
		if( !empty($RecentListData['user_id']) && !empty($RecentListData['product_id']) ){
		//update user data
        
	        $insert = $this->model->insertRecentlyViewed($RecentListData);
	        $delete = $this->model->deleteRecentlyViewed();

	        $this->model->insertSuggestedPost($RecentListData);

			//check if the user data updated
			if($insert){

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'add recently view List successfully.'
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

	public function product_cart_list_post() //products show that have in cartlist
    {
        $user_id = $this->post('user_id');
        $seller_id = $this->post('seller_id');

        if(!empty($user_id)) {

	        $list = $this->model->getProductCartList($user_id,$seller_id);

	        $pay_mode = $this->model->getProductGroupCartList($user_id,$seller_id);

	        $online_pay = $this->model->getProductOnlinePayList($user_id,$seller_id);

	        $count_address = $this->model->getAddressCount($user_id,$seller_id);

	        $total_mrp = 0;
	        $total_price = 0;
	        $delivery=30;

	        foreach ($online_pay as $key => $values) {

	        	$total_mrp+=$values['price'] * $values['qty'];
	        	$total_price+=$values['list_price'] * $values['qty'];

	        }
	        	 
	        $disc_amt=$total_mrp-$total_price;
	        if($total_price>250)
	        {
	            $delivery=0;
	        }
	        $total_price=$total_price+$delivery;

	        if($list) {

	        	$this->response([
			 			'status' => TRUE,
			 			'count_address'=> $count_address,
			 			'pay_mode'=> $pay_mode,
			 			'total_mrp'=> $total_mrp,
			 			'disc_amt'=> $disc_amt,
			 			'sub_total'=> $total_price,
			 			'tax'=> 0,
			 			'delivery'=> $delivery,
			 			'total_pay'=> $total_price,
						'product'=> $list
						], REST_Controller::HTTP_OK);
	        }
	        else{

	            $this->response([
						'status' => FALSE,
						'message' => 'No row affected'
					], REST_Controller::HTTP_OK);
	        }
        }
        else{

			//set the response and exit
	        $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
    }

    public function payment_mode_put_post() // user function all details
    {
        $cart_id = $this->post('cart_id');
        $mode = $this->post(trim('mode'));

        if(!empty($cart_id)) {

            $list = $this->model->putPaymentModeData($cart_id,$mode);   


            if($list){

                $this->response([
                    'status' => TRUE,
                    'message' => 'payment mode set'
                    ], REST_Controller::HTTP_OK);
            }
         
            else{

                $this->response([
                    'status' => TRUE,
                    'message' => 'no changes'
                    ], REST_Controller::HTTP_OK);
            }

        }
        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function product_wish_list_post() //products show that have in cartlist
    {
        $user_id = $this->post('user_id');

        if(!empty($user_id)) {

	        $list = $this->model->getProductWishList($user_id);
	       
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'product'=> $list
						], REST_Controller::HTTP_OK);
	        }
	        else{

	            $this->response([
						'status' => TRUE,
						'message' => 'No row affected'
					], REST_Controller::HTTP_OK);
	        }

         }else{
			//set the response and exit
            $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
		}
    }

    public function product_sort_list_post() //Each product with all details
    {
		$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');
        $order = $this->post('order');

        $cat_id = $this->post('cat_id');
        $row = $this->post('row');

        $min_pr = $this->post('min_pr');
		$max_pr = $this->post('max_pr');

		$option = $this->post('option');
	    $option = json_decode($option, true);

		$feature = $this->post('feature');
		$feature = json_decode($feature, true);

        if($order==0)
        {
          $order= 'id desc';
        }
        if($order==1)
        {
          $order= 'list_price asc';
        }
        if($order==2)
        {
          $order= 'list_price desc';
        }
        if($order==3)
        {
          $order= 'rating desc';
        }
         if($order==4)
        {
          $order= 'discount desc';
        }

        $list = $this->model->getProductSortList($order,$cat_id,$latitude,$longitude,$radius,$min_pr,$max_pr,$option,$feature,$row);
         
        if($list){

        	$this->response([
		 			'status' => TRUE,
					'category'=> $list,
					], REST_Controller::HTTP_OK);
        }
 
        else{

            $this->response(NULL, 404);
        }
    }

    public function product_filter_list_post() //Each product with all details
    {
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');

		$cat_id = $this->post('cat_id');

		$min_price = $this->post('min_price');
		$max_price = $this->post('max_price');

		if(!empty($latitude) && !empty($longitude) && !empty($radius)) {

	        $list = $this->model->getProductFilterList($cat_id,$latitude,$longitude,$radius,$min_price,$max_price);
	         
	        if($list) {

	        	$this->response([
			 			'status' => TRUE,
						'filter_main'=> $list,
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response(NULL, 404);
	        }

        }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function product_cart_order_post() { //add product to cart and add update user and seller wallet

    	$stock_id = array();
        $stock_id = json_decode($_POST['stock_id'], true);

        $qty = array();
        $qty = json_decode($_POST['qty'], true);

        $sub_total = array();
        $sub_total = json_decode($_POST['sub_total'], true);

        $seller_id  = $this->post('seller_id');
        $cart_status=$this->post('cart_status');
         $store_id=$this->post('store_id');
        $payment_type=$this->post('payment_type');
        
        $seller_name  = $this->post('seller_name');

		$cartOrder['user_id']  = $this->post('user_id');

		$cartOrder['total_amt']  = $this->post('total_amt');

		$cartOrder['address_id']  = $this->post('address_id');
		$cartOrder['payment_status']  = $this->post('payment_type');
		$cartOrder['store_id']  = $this->post('store_id');
    
		if(!empty($cartOrder['user_id'])) {

	        $insert = $this->model->insertAddCartOrder($cartOrder,$stock_id,$seller_id,$qty,$sub_total,$cart_status,$payment_type,$store_id);
			//check if the user data updated
			if($insert) {

				$message='You have a new Product order..';

				//$this->model->SingleSellerNotificationInsert($seller_id,$message);

                $mPushNotification = array('title'=>'order place','app_id'=>$seller_id,'app_name'=>$seller_name,'message'=>$message,'type'=>'order','image'=>GEN_NOTIFY_IMAGE_LINK.$seller_id.'.png');

                //getting the token from database object 
                //$devicetoken = $this->notification_lib->get_single_token_byseller_post($seller_id);

                // //sending push notification and displaying result 
                 //$notification = $this->notification_lib->send_seller_post($devicetoken,$mPushNotification);

			    //set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'added to order successfully.'
				], REST_Controller::HTTP_OK);

			} else {
			//set the response and exit

				$this->response([
						'status' => FALSE,
						'message' => 'some of products are out of stock.'
					], REST_Controller::HTTP_OK);

			}
        }
        else{
		    //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
	    }
	}

    public function product_filter_get_post() //Each product filter with all filter product
    {
        
		$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');

		$cat_id = $this->post('cat_id');
		$row = $this->post('row');

		$min_pr = $this->post('min_pr');
		$max_pr = $this->post('max_pr');
		
		$option = $this->post('option');
	    $option = json_decode($option, true);

		$feature = $this->post('feature');
		$feature = json_decode($feature, true);

		if(!empty($cat_id) && !empty($latitude) && !empty($longitude) && !empty($radius)) {
		
	        $list = $this->model->getFilterGetDataList($latitude,$longitude,$radius,$cat_id,$min_pr,$max_pr,$option,$feature,$row);
	        
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'category'=> $list,
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
    

    public function get_user_list_post() //particular user with all details
    {

		$user_id = $this->post('user_id');
		
		$seller_id = $this->post('seller_id');

        $list = $this->model->getUserDetailsList($user_id,$seller_id);
         
        if($list) {

        	$this->response([
		 			'status' => TRUE,
		 			'version'=> '1',
					'user'=> $list
					], REST_Controller::HTTP_OK);
        }
 
        else{

            $this->response(NULL, 404);
        }
    }

 
    public function bestdeal_viewall_get_post() //Each product with all details
    {
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');

		$row = $this->post('row');

		$user_id = $this->post('user_id');
		$cat_id = $this->post('cat_id');

		$data = $this->post('data');
	    $data = json_decode($data, true);


		if( !empty($latitude) && !empty($longitude) && !empty($radius)) {

			$best_deal = $this->model->getBestDealViewAllData($row,$user_id,$latitude,$longitude,$radius,$cat_id,$data);

			$count = $this->model->getBestDealViewAllCount($latitude,$longitude,$radius,$cat_id,$data);

			$cart_count = $this->model->getUserCartCountSub($user_id);


	        if($best_deal){

	        	$this->response([
			 			'status' => TRUE,
			 			'total_count'=> $count,
			 			'cart_count'=> $cart_count,
						'category'=> $best_deal
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
    
    public function category_viewall_get_post() //Each product with all details
    {
        
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');
		$user_id = $this->post('user_id');

		$result = $this->model->getCategoryViewAllList($user_id,$latitude,$longitude,$radius);

        if($result){

        	$this->response([
		 			'status' => TRUE,
					'result'=> $result,
					], REST_Controller::HTTP_OK);
        }
        else{

            $this->response(NULL, 404);
        }
    }

}

?>
