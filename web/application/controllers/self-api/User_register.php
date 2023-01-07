<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php'; //include Rest Controller library

class User_register extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        //$this->load->library('aws3');//load aws3 bucket

        $this->load->model('self-api/User_register_model','model'); //load user model
    }
    
    public function userput_post($id='') {


		$id = $this->post('id');
		//print_r($id);exit();
        $user_name = $this->post('user_name');
        $base = $_POST["image_file"];

        if (isset($base)) {
            
            if (!is_dir('uploads/userprofile'))
		    {
			    mkdir('uploads/userprofile', 0755, TRUE);
		    }

            $url = "uploads/userprofile/";
            $image_name = md5(uniqid(time(), true)).".jpg";
            $path = $url."".$image_name; // path of saved image 

            // base64 encoded utf-8 string
            $binary = base64_decode($base);

            // binary, utf-8 bytes
            header("Content-Type: bitmap; charset=utf-8");
            $file = fopen("uploads/userprofile/" . $image_name, "wb"); // 
            $filepath = $image_name; 
            $tempFile = "uploads/userprofile/" . $image_name;
            fwrite($file, $binary);
          //  $this->aws3->sendFile_post('onlister-upload',$tempFile);  
            fclose($file);          

        }


		if(!empty($id) && !empty($user_name) && !empty($image_name)){
			//update user data

			$value = array('user_name' => $user_name,'prof_image' => $image_name);

	       
	        $update = $this->model->insertUserRegister($value,$id);
			
			
			//check if the user data updated
			if($update){
				//set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'User has been updated successfully.'
				], REST_Controller::HTTP_OK);
			}else{
				//set the response and exit
				$this->response("No row affected.", REST_Controller::HTTP_OK);
			}
        }else{
			//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function user_locput_post($id='') {

	    $id = $this->post('id');
	    $location = $this->post('location');
        $postal = $this->post('postal_code');
        $lat = $this->post('lat');
        $lon = $this->post('lon');
        $country = $this->post('country');

		if(!empty($id) && !empty($location)){
		//update user data

			$value = array('location' => $location,'postal_code' => $postal,'lat' => $lat,'lon' => $lon,'country' => $country);

	        $update = $this->model->insertUserRegister($value,$id);
			//check if the user data updated

			if($update){
				//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'User has been updated successfully.'
					], REST_Controller::HTTP_OK);
			}else{
				//set the response and exit
					$this->response("No row affected.", REST_Controller::HTTP_OK);
			}
        }
        else{
		//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
	    }
	}

	public function user_basicput_post($id='') {

		$id = $this->post('id');
		$user_name = $this->post('user_name');
		$address = $this->post('address');
		$address1 = $this->post('address1');
		$address2 = $this->post('address2');
		$address3 = $this->post('address3');
		$gender = $this->post('gender'); 
		$birth_date = $this->post('birth_date'); 
		$birth_date = date('Y-m-d H:i:s', strtotime($birth_date));
		$joining_date = $this->post('joining_date'); 
		$joining_date = date('Y-m-d H:i:s', strtotime($joining_date));
		$martial_status = $this->post('martial_status'); 
		$bio_quto = $this->post('bio_quto'); 

		if(!empty($id)){
		//update user data

			$value = array('user_name' => $user_name,'address' => $address,'address1' => $address1,'address2' => $address2,'address3' => $address3,'joining_date' => $joining_date,'birthday' => $birth_date,'gender' => $gender,'bio_quto' => $bio_quto,'martial_status' => $martial_status);

	        $update = $this->model->insertUserRegister($value,$id);
			//check if the user data updated

			if($update){
			//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'User has been updated successfully.'
					], REST_Controller::HTTP_OK);
			}else{
			//set the response and exit
					$this->response("No row affected.", REST_Controller::HTTP_OK);
			}
        }
        else{
		//set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
	    }
	}

	public function user_contactput_post() {

		$id = $this->post('id');

	    $facebook = $this->post('facebook'); 
		$twitter = $this->post('twitter'); 
		$linkedin = $this->post('linkedin'); 
		$youtube = $this->post('youtube'); 
	    $whatsapp = $this->post('whatsapp');
	    $instagram = $this->post('instagram'); 
	    $email = $this->post('email');

        
        $phone = array();
        $phone = json_decode($_POST['phone'], true);
        

        // $course = $_POST['course'];
        // $univercity = $_POST['univercity']; 
        // $date_from = $_POST['date_from'];
        // $date_to = $_POST['date_to']; 

        // $company_name = $_POST['company_name'];
        // $position = $_POST['position']; 
        // $work_date_from = $_POST['work_date_from'];
        // $work_date_to = $_POST['work_date_to']; 


		if(!empty($id)){
		//update user data

			$value = array('youtube' => $youtube,'linkedin' => $linkedin,'twitter' => $twitter,'facebook' => $facebook,'whatsapp' => $whatsapp,'instagram' => $instagram,'email' => $email);

	        $update = $this->model->insertUserRegister($value,$id,$phone);
			//check if the user data updated
			if($update){

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'User has been updated successfully.'
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
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
	    }
	}

	public function user_personalput_post() {

		$id = $this->post('id');


        $education_type = $this->post('education_type'); 

        $school_name = $this->post('school_name'); 

        $subject = $this->post('subject'); 

        $date_from = $this->post('date_from'); 
        $date_from = date('Y-m-d', strtotime($date_from));

        $date_to = $this->post('date_to'); 
        $date_to = date('Y-m-d', strtotime($date_to));

        $action = $this->post('action'); 

        $ed_id = $this->post('ed_id'); 



        // $company_name = array();
        // $company_name = json_decode($_POST['company_name'], true);

        // $position = array();
        // $position = json_decode($_POST['position'], true);

        // $work_date_from = array();
        // $work_date_from = json_decode($_POST['work_date_from'], true);

        // $work_date_to = array();
        // $work_date_to = json_decode($_POST['work_date_to'], true);

 
		if(!empty($id)){
		//update user data

			$value = array('user_reg_id' => $id,'education_type' => $education_type,'school_name' => $school_name,'subject' => $subject,'from_date' => $date_from,'to_date' => $date_to);

	        $update = $this->model->insertUserPersonal($value,$action,$ed_id);
			//check if the user data updated
			if($update){

			//set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'Education data has been added successfully.'
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
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
	    }
	}


	public function user_education_get_post() {

		$id = $this->post('id');

		 $users = $this->model->getUserEducaDetail($id);

		 	if(!empty($users)){

		 		$this->response([
		 			'status' => TRUE,
						'edu_data'=> $users
					], REST_Controller::HTTP_OK);
			
		}else{
			//set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'status' => FALSE,
				'message' => 'No user were found.'
			], REST_Controller::HTTP_NOT_FOUND);
		}

	}

	public function user_delete_post(){
        
        $id = $this->post('id');  //check whether post id is not empty

        if($id){
            
            $delete = $this->model->deleteUserEduDetail($id); //delete post
            
            if($delete){
                //set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'User has been removed successfully.'
				], REST_Controller::HTTP_OK);
            }
            else{
                //set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
			//set the response and exit
			$this->response([
				'status' => FALSE,
				'message' => 'No user were found.'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    } 

    public function user_location_update_post() { //add product to cart and add update user and seller wallet

    	$user_id = $this->post('user_id');

		$userData['location']  = $this->post('location');
		$userData['lat']  = $this->post('lat');
		$userData['lon']  = $this->post('lon');
		$userData['postal_code']  = $this->post('postal_code');
		$userData['user_name']  = $this->post('name');
    
		if(!empty($user_id) && !empty($lat) && !empty($lon)){

	        $update = $this->model->updateUserLocation($userData,$user_id);
			//check if the user data updated
			if($update){

			//set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'added  successfully.'
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

}

?>