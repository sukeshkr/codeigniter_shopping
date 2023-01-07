<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Store extends MY_Auth_Controller {

    protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
        parent::__construct();
        $this->ci_name = strtolower($this->router->fetch_class());
        $this->load->model('Store_model','model');
        $this->load->library('Image');//custom image library to crop
        if (!$this->is_logged_in()) //login only registered user from db
        { 
          redirect('Login');
        }
    }
  
    public function index() {

        $this->load->view('store/list');

    }


    public function store_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $rows['location'];
        $row[] = $rows['phone'];
        $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/store/crop/'.$rows['image'].'" class="img-responsive" height=50 width=50 /></a>';
          
        //add html for action
        $row[] = '<a href="store/edit/'.$rows['id'].'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
        <a data-toggle="modal" data-id='.$rows['id'].' data-target="#del-modal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

        $data[] = $row;
        }
        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
     public function send() {
         
        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');

        if (empty($_FILES['image_file']['name']))
        {
            $this->form_validation->set_rules('image_file', 'Image', 'required');
        }

        if($this->form_validation->run() == FALSE) 
        {
            $this->load->view('store/notification');
        }
        else{
         
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        
        $this->image->imageNotificationCropAdd();//call custom image library

        $image= $this->image->crop_image_name;
         
        $value = array('title'=>$title,'message'=>$message,'image'=>$image); 

        $this->model->storeNotification($value); 
         
        $registrationIds = $this->model->get_tocken();
        $mPushNotification = array('title'=>$title,'message'=>$message,'image'=>'http://ahlulkaif.com/admin/uploads/notification/crop/'.$image,'click_action'=>'FLUTTER_NOTIFICATION_CLICK');

        $mPushNotification1 = array('title'=>$title,'body'=>$message,'image'=>'http://ahlulkaif.com/admin/uploads/notification/crop/'.$image,'click_action'=>'FLUTTER_NOTIFICATION_CLICK');

        $fields = array(
            'registration_ids' => $registrationIds,
            'notification' => $mPushNotification1,
            'data' => $mPushNotification,
        );

        return $this->sendPushNotification_post($fields);
        }
    }
    
    
    public function notification(){
        
        $this->load->view('store/notification_list');
        
    }
    
    
    public function notificationList(){
        
        $list = $this->model->get_datatables_notification();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $rows['title'];
        $row[] = $rows['message'];
        $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/notification/crop/'.$rows['image'].'" class="img-responsive" height=50 width=50 /></a>';
          
        //add html for action
        // $row[] = '<a href="store/edit/'.$rows['id'].'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
        //$row[] = '<a data-toggle="modal" data-id='.$rows['id'].' data-target="#del-modal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

        $data[] = $row;
        }
        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    private function sendPushNotification_post($fields) {
         define( 'FIREBASE_API_KEY', 'AIzaSyDDIwMs5O-isKR4zeOJH0xzjCEZgnqLwqI' );


        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        //building headers for the request
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
 
        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
 
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        //finally executing the curl request 
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);
        //print_r($result);exit;
        //and return the result 
        //return $result;
        $this->load->view('store/notification_list'); 
    }
    
    public function send_not() {

      
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyDDIwMs5O-isKR4zeOJH0xzjCEZgnqLwqI' );


$registrationIds = $this->model->get_tocken();
//print_r($registrationIds);exit;
// prep the bundle
$msg = array
(
	'message' 	=> 'tested by sinan',
	'title'		=> 'This is a title. title',
	'subtitle'	=> 'checked by shadiya',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'image'=>'http://onlister.in/homestaynew2/web/assets/img/inner-logo.png',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);

$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );

echo $result;
    }
    
   

    public function create() {

        $this->form_validation->set_rules('location', 'Location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('position', 'Position', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required|xss_clean');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
        if (empty($_FILES['image_file']['name']))
        {
            $this->form_validation->set_rules('image_file', 'Image', 'required');
        }

        if($this->form_validation->run() == FALSE) 
        {
            $this->load->view('store/add');
        }
        else 
        {

            $this->image->imageCropAdd();//call custom image library

            $image= $this->image->crop_image_name;

            $og_image= $this->image->image_name;

            $location = $this->input->post('location');
            $description = $this->input->post('description');
            $address = $this->input->post('address');
            $position = $this->input->post('position');
            $phone = $this->input->post('phone');
            $latitude = $this->input->post('latitude');
            $longitude = $this->input->post('longitude');
            $email = $this->input->post('email');


            $value = array('location' => $location,'description' => $description,'address' => $address,'image' => $image,'og_image' => $og_image,'position' => $position,'position' => $position,'phone' =>$phone,'email' => $email,'latitude' => $latitude,'longitude' => $longitude);

            $data['result'] = $this->model->insertStoreData($value);
            $this->session->set_flashdata('add', 'Added Successfully');

            redirect('Store');
        }

    }

    public function edit() {

        $id = $this->uri->segment(3);
        $data['result'] = $this->model->getStoreEdit($id);
        $this->load->view('store/edit',$data);
    }

    public function update() {

        
       $this->form_validation->set_rules('location', 'Location', 'trim|required|xss_clean');
       $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
       $this->form_validation->set_rules('position', 'Position', 'trim|required|xss_clean');
       $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
       $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required|xss_clean');
       $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required|xss_clean');
       $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
       $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');

        if (isset($_POST['submit'])) 
        {
            $id = $this->input->post('id');

            if($this->form_validation->run() == FALSE) 
            {
                $data['result'] = $this->model->getCartParentEdit();
                 $this->load->view('store/edit',$data);
            }
            else 
            {
                $location = $this->input->post('location');
                $description = $this->input->post('description');
                $address = $this->input->post('address');
                $position = $this->input->post('position');
                $phone = $this->input->post('phone');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $email = $this->input->post('email');

                $this->image->imageCropAdd();//call custom image library

                if($this->image->crop_image_name !="")//if there is image and pdf is null
                {
                    $image =  $this->image->crop_image_name;

                    $og_image =  $this->image->image_name;

                    $value = array('location' => $location,'description' => $description,'address' => $address,'image' => $image,'og_image' => $og_image,'position' => $position,'position' => $position,'phone' =>$phone,'email' => $email,'latitude' => $latitude,'longitude' => $longitude);

                } 
                else{

                    $value = array('location' => $location,'description' => $description,'address' => $address,'position' => $position,'position' => $position,'phone' =>$phone,'email' => $email,'latitude' => $latitude,'longitude' => $longitude);

                }
                
                $this->model->updateStoreData($id,$value);

                $this->session->set_flashdata('update', 'Added Successfully');
                redirect('Store');
            } 

        }
    }



    public function delete() {

        $this->load->view('store/delete');
        if (isset($_POST['delete'])) 
        {
            $id=$_POST['id'];
            $this->model->deleteStore($id);
            redirect('Store');
        }
    }


}
