<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class Feedback extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('self-api/Feedback_model','model'); //load user model
    }


    public function feedback_user_put_post() {

		$feedData = array();

		$feedData['user_id']=$this->post('user_id');
		$feedData['feel_about']  = $this->post('feel_about');
		$feedData['feedback_message']  = $this->post('feedback_message');

		if(!empty($feedData['user_id'])){
			//update user data
			$insert = $this->model->insertFeedback($feedData);
			//check if the user data updated
			if($insert){ //set the response and exit

				$this->response([
					'status' => TRUE,
				    'message' => 'added successfully.',
				], REST_Controller::HTTP_OK);

			}else{
				//set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
			}
        }else{

             $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function reportissue_user_put_post() {

		$issueData = array();

		$issueData['user_id']=$this->post('user_id');
		$issueData['priority']  = $this->post('priority');
		$issueData['problem']  = $this->post('problem');
		$issueData['report_message']  = $this->post('report_message');

		if(!empty($issueData['user_id'])){
			//update user data
			$insert = $this->model->insertUserReportIssue($issueData);
			//check if the user data updated
			if($insert){ //set the response and exit

				$this->response([
					'status' => TRUE,
				    'message' => 'added successfully.',
				], REST_Controller::HTTP_OK);

			}else{
				//set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
			}
        }else{

             $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function get_user_feedback_post() { 

    	$user_id = $this->post('user_id');

    	if(!empty($user_id)) {

	        $list = $this->model->getUserFeedBackList($user_id);
	         
	        if($list)
	        {
	        	$this->response([
			 		'status' => TRUE,
					'quotation_result'=> $list
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

            $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_user_reportissue_post() { 

    	$user_id = $this->post('user_id');

    	if(!empty($user_id)) {

	        $list = $this->model->getUserReportIssue($user_id);
	         
	        if($list)
	        {
	        	$this->response([
			 		'status' => TRUE,
					'quotation_result'=> $list
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

            $this->response("Provide complete user information to insert.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }


}