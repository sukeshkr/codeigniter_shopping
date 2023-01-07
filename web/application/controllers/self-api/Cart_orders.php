<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Cart_orders extends REST_Controller {

    public function __construct() { 
        parent::__construct();

        $this->load->library('notification_lib');

        $this->load->model('self-api/Cart_orders_model','model'); //load user model
    }

    public function cart_order_seller_post() //Each seller wise with all details
    {
		$seller_id = $this->post('seller_id');
		$search = $this->post('search');
		$row = $this->post('row');

		if(!empty($seller_id)) {

	        $list = $this->model->getCartOrderSellerWise($seller_id,$search,$row);

	        $count = $this->model->getCartOrderSellerCount($seller_id,$search);
	         
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
			 			'count'=> $count,
						'seller_details'=> $list
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response([
	                    'status' => TRUE,
	                    'message' => 'No result'
	                    ], REST_Controller::HTTP_OK);
	        }

        }

        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function priority_order_seller_post() //Each seller wise with all details
    {
		$seller_id = $this->post('seller_id');

		$search = $this->post('search');
		$row = $this->post('row');

		$status = $this->post('status');

		if(!empty($seller_id)) {

	        $list = $this->model->getPrioritySellerWise($seller_id,$status,$search,$row);

	        $count = $this->model->getPrioritySellerCount($seller_id,$status,$search);
	         
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
			 			'count'=> $count,
						'seller_details'=> $list,
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response([
	                    'status' => TRUE,
	                    'message' => 'No result'
	                    ], REST_Controller::HTTP_OK);
	        }

        }

        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function cart_order_seller_get_post() //Each product with all details
    {

		$order_id = $this->post('order_id');

		$seller_id = $this->post('seller_id');

		if(!empty($order_id) && !empty($seller_id)) {

	        $list = $this->model->getCartOrderStockList($order_id,$seller_id);
	         
	        if($list) {

	        	$this->response([
			 			'status' => TRUE,
						'order'=> $list,
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response(NULL, 404);
	        }

        }else{
			//set the response and exit
            $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
		}
    }

    public function cart_order_delivery_post() //Each seller wise with all details
    {
		$order_id = $this->post('order_id');
		$seller_id = $this->post('seller_id');
		$status = $this->post('status');
		$user_id = $this->post('user_id');

        if(!empty($order_id)){

	        $update = $this->model->updateOrderDelivery($order_id,$seller_id,$status);

			//check if the user data updated
			if($update) {
			//set the response and exit

				$this->model->SingleUserNotificationInsert($user_id,$status,$order_id);

				if($status==2)
	            {  

				$mPushNotification = array('title'=>'order place','app_id'=>$seller_id,'message'=>'Your order '.$order_id.' has been delivered','image'=>GEN_NOTIFY_IMAGE_LINK.$seller_id.'.png');

                //getting the token from database object 
                $devicetoken = $this->notification_lib->get_single_token_byuser_post($user_id);

                //sending push notification and displaying result 
                $notification= $this->notification_lib->send_post($devicetoken,$mPushNotification);

                }

				if($status==0)
	            {  

				$mPushNotification = array('title'=>'order place','message'=>'Your order '.$order_id.' was cancelled by seller','image'=>NOTIFY_IMAGE_LINK);

                //getting the token from database object 
                $devicetoken = $this->notification_lib->get_single_token_byuser_post($user_id);

                //sending push notification and displaying result 
                $notification= $this->notification_lib->send_post($devicetoken,$mPushNotification);

                }

				$this->response([
	 			'status' => TRUE,
				'message'=> 'successfully updated'
				], REST_Controller::HTTP_OK);

			} else {
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

///////////////////////user/////////////////////////////////////////////////////////////////////////////////////////////

    public function cart_order_get_post() //Each product with all details
    {

		$user_id = $this->post('user_id');
		
		$seller_id = $this->post('seller_id');

		if(!empty($user_id)) {

	        $list = $this->model->getCartOrderList($user_id,$seller_id);
         
	        if($list) {

	        	$this->response([
			 			'status' => TRUE,
						'order'=> $list
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

    public function cart_userstore_get_post() //Each product with all details
    {
		$user_id = $this->post('user_id');

		if(!empty($user_id)) {

	        $list = $this->model->getUserFollowBusList($user_id);
         
	        if($list) {

	        	$this->response([
			 			'status' => TRUE,
						'order'=> $list
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


    public function order_delivery_address_post() { //delivery adress

    	$deliveryData = array();

    	$id = $this->post('id');

    	$deliveryData['user_id'] = $this->post('user_id');
    	$deliveryData['seller_id'] = $this->post('seller_id');
    	$deliveryData['latitude'] = $this->post('latitude');
    	$deliveryData['longitude'] = $this->post('longitude');
		$deliveryData['name'] = $this->post('name');
		$deliveryData['pincode'] = $this->post('pincode');
		$deliveryData['address'] = $this->post('address');
		$deliveryData['land_mark'] = $this->post('land_mark');
		$deliveryData['country'] = $this->post('country');
		$deliveryData['phone'] = $this->post('phone');
		$deliveryData['alter_phone'] = $this->post('alter_phone');

		if(!empty($deliveryData['user_id']) && !empty($deliveryData['phone']) && !empty($deliveryData['address']) && !empty($deliveryData['pincode'])) {
		
	        $list = $this->model->putOrderDeliveryAddress($deliveryData,$id);
	        
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'message'=> 'sucessfully added'
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

    public function delivery_address_get_post() ////delivery adress
    {
        $user_id = $this->post('user_id');
        
        $seller_id = $this->post('seller_id');

		if(!empty($user_id)) {

	        $list = $this->model->getDeliveryAddressData($user_id,$seller_id);
	         
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'result'=> $list,
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

            $this->response(NULL, 404);
        }
    }

    public function delivery_address_delete_post() ////delivery adress
    {
        $id = $this->post('id');

        $user_id = $this->post('user_id');
        
        $seller_id = $this->post('seller_id');

		if(!empty($id)) {

	        $delete = $this->model->deleteDeliveryAddress($id);

	        $list = $this->model->getDeliveryAddressData($user_id,$seller_id);
	         
	        if($delete){

	        	$this->response([
			 			'status' => TRUE,
			 			'result' => $list,
						'message'=> 'Deleted sucessfully'
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

            $this->response(NULL, 404);
        }
    }

    public function address_get_id_post() ////delivery adress
    {
        $id = $this->post('id');

		if(!empty($id)) {

	        $list = $this->model->getIdWiseDeliveryAddress($id);

	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'result'=> $list,
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

            $this->response(NULL, 404);
        }
    }

    public function cart_order_user_post() //Each seller wise with all details
    {
		$user_id = $this->post('user_id');
		$search = $this->post('search');
		$row = $this->post('row');

		if(!empty($user_id)) {

	        $list = $this->model->getCartOrderUserWise($user_id,$search,$row);
	         
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'seller_details'=> $list,
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response([
	                    'status' => TRUE,
	                    'message' => 'No result'
	                    ], REST_Controller::HTTP_OK);
	        }

        }

        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function user_order_details_post() //Each seller wise with all details
    {
		$order_id = $this->post('order_id');

		if(!empty($order_id)) {

	        $list = $this->model->getUserOrderDetails($order_id);
	         
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'seller_details'=> $list,
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response([
	                    'status' => TRUE,
	                    'message' => 'No result'
	                    ], REST_Controller::HTTP_OK);
	        }

        }

        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function user_delivery_address_post() // user function
    {
		$id = $this->post('id');

		if(!empty($id)) {

	        $list = $this->model->getCartOrderDeliverySub($id);
	         
	        if($list){

	        	$this->response([
			 			'status' => TRUE,
						'result'=> $list,
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response([
	                    'status' => TRUE,
	                    'message' => 'No result'
	                    ], REST_Controller::HTTP_OK);
	        }

        }

        else{
            //set the response and exit
            $this->response("Provide complete feature information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function order_cancel_user_post() //user order cancel
    {
		$order_id = $this->post('order_id');
		$user_id = $this->post('user_id');

        if(!empty($order_id)){

	        $cancel = $this->model->cancelOrderUser($order_id,$user_id);
			//check if the user data updated
			if($cancel) {
			//set the response and exit

				$this->response([
	 			'status' => TRUE,
				'message'=> 'successfully updated'
				], REST_Controller::HTTP_OK);

			} else {
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
    
    public function cart_order_user_get_post() //Each product with all details
    {

		$seller_id = $this->post('seller_id');

		$user_id = $this->post('user_id');

		if(!empty($seller_id) && !empty($user_id)) {

	        $list = $this->model->getCartOrderUserWiseData($seller_id,$user_id);
	         
	        if($list) {

	        	$this->response([
			 			'status' => TRUE,
						'order'=> $list,
						], REST_Controller::HTTP_OK);
	        }
	 
	        else{

	            $this->response(NULL, 404);
	        }

        }else{
			//set the response and exit
            $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    
    public function cart_order_cancel_post() {

		$user_id = $this->post('user_id');

		$order_id = $this->post('order_id');
		
		$stock_id = $this->post('stock_id');

		if( !empty($user_id) && !empty($order_id) && !empty($stock_id) ) {


	        $list = $this->model->putOrderCancelUser($user_id,$order_id,$stock_id);
         
	        if($list) {

	        	$this->response([
			 			'status' => TRUE,
						'message'=> 'order Cancel Sucessfully',
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
