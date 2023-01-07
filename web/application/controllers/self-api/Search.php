<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Search extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('self-api/Search_model','model'); //load user model
    }
  
    public function data_search_get_post() //Each product with all details
    {
    	$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$radius = $this->post('radius');
		$row = $this->post('row');
		
		$cat_id = $this->post('cat_id');
		
		$user_id = $this->post('user_id');

        $seller_id = $this->post('seller_id');

		$search = trim($this->post('search'));

		$search = strtolower($search);

		$result = $this->model->getSearchAllDataList($user_id,$seller_id,$search,$row,$latitude,$longitude,$radius,$cat_id);
		//$ret;
	    //print_r($result['cats']);exit;
		$count =$this->model->getSearchAllDataListCounter($seller_id,$search,$latitude,$longitude,$radius,$cat_id);
		
		if(!empty($result[0])) {

            $cat_id=$result[0]->cat_id;
        }

        else{

            $cat_id="";
        }
		
		$cat_list = $this->model->getSearchCatList($seller_id,$search,$row,$latitude,$longitude,$radius,$cat_id);
                 
        if($result){

        	$this->response([
		 			'status' => TRUE,
					'total_count'=> $count,
					'result'=> $result['result'],
                    'category'=> $result['cats'],
					], REST_Controller::HTTP_OK);
        }
        else{

        	 $this->response([
                'status' => TRUE,
                'message' => 'No results found'
            ], REST_Controller::HTTP_NOT_FOUND);

        }
    }


}

?>
