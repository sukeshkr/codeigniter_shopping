<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_banner extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Cart_banner_model','model');
	    $this->load->library('Image');//custom image library to crop
	     
	    if (!$this->is_logged_in()) //login only registered user from db
	    { 
	      redirect('Login');
	    }
    }
  
    public function index() {

    	$this->load->view('banner/list');
    }

    public function bannerlist() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $banner) {

	        $no++;

	        $row = array();

	        $row[] = $no;
	        $row[] = $banner['banner_name'];
	        $row[] = $banner['banner_type'];
	        $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/cart_banner/'.$banner['image'].'" class="img-responsive" height=60 width=80 /></a>';
	          
	        //add html for action
	        $row[] = '<a href="cart_banner/edit/'.$banner['id'].'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
	        <a data-toggle="modal" data-id='.$banner['id'].' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

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

    public function create() {

	    $this->form_validation->set_rules('banner_name', 'Banner Name', 'trim|required|xss_clean');
	    $this->form_validation->set_rules('exp_date', 'exp Date', 'trim|required|xss_clean');

	    if(empty($_FILES['image_file']['name']))
        {
	        $this->form_validation->set_rules('image_file', 'image','trim|required|xss_clean');
        }

	    if($this->form_validation->run() == FALSE) 
	    {
		    $this->load->view('banner/add');
	    }
	    else 
	    {

	    	if(!empty($this->input->post('type_id')))
	    	{
	    		$type_id = $this->input->post('type_id');

	    	}
	    	else{

	    		$type_id ="";

	    	}

		    $banner_type = $this->input->post('banner_type');

		    $banner_name = $this->input->post('banner_name');

		    $exp_date = $this->input->post('exp_date');

		    $date =  date('Y-m-d h:m:s', strtotime($exp_date));
	          	
	    	$this->image->generalCropAdd();//call custom image library

            $image_name= $this->image->image_name;	       

	        if(empty($banner_type)) {

	        	$value = array('banner_name' => $banner_name,'exp_date' => $date,'date'=> date("Y-m-d H:i:s"),'image' => $image_name);
		    }
		    else {

	        	$value = array('banner_name' => $banner_name,'banner_type' => $banner_type,'type_id' => $type_id,'exp_date' => $date,'date'=> date("Y-m-d H:i:s"),'image' => $image_name);
		    }

			$data['result'] = $this->model->insertForBanner($value);
			$this->session->set_flashdata('add', 'Added Successfully');
			redirect('Cart_banner');

	    }
	}

	public function edit() {

	 	$id = $this->uri->segment(3);
	 	$data['result'] = $this->model->getBanner($id);
    	$this->load->view('banner/edit',$data);
    }

    public function update() {

		$this->form_validation->set_rules('banner_name', 'Banner Name', 'trim|required|xss_clean');
	    $this->form_validation->set_rules('exp_date', 'exp Date', 'trim|required|xss_clean');

	    $id = $this->input->post('id');

		if (isset($_POST['submit'])) 
		{

			if($this->form_validation->run() == FALSE) 
		    {
			    $data['result'] = $this->model->getBanner($id);
			    $this->load->view('banner/edit',$data);
		    }
			else 
			{
			    $banner_name = $this->input->post('banner_name');
			    $exp_date = $this->input->post('exp_date');
			    $date =  date('Y-m-d h:m:s', strtotime($exp_date));
			    $location_name = $this->input->post('location_name');

			    $banner_type = $this->input->post('banner_type');

	    	    $type_id = $this->input->post('type_id');


			    if($location_name)
			    {
				    $address = $this->input->post('location');
				    $postal = $this->input->post('postal_code');
				    $lat = $this->input->post('lat');
				    $long = $this->input->post('lon');
				    $country = $this->input->post('country');
                }

            $this->image->generalCropAdd();//call custom image library

                if(isset($this->image->image_name)) {

                    $image_name= $this->image->image_name;

                }

		    	if($image_name !="")
		    	{

					$value = array('banner_name' => $banner_name,'exp_date' => $date,'date'=> date("Y-m-d H:i:s"),'image' => $image_name);
		    	}

		    	else if($location_name !="")
		    	{

					$value = array('banner_name' => $banner_name,'exp_date' => $date,'date'=> date("Y-m-d H:i:s"),'address' => $address,'postal_code' => $postal,'latitude' => $lat,'longitude' => $long,'country' => $country);
		    	}

		    	else if($banner_type !="")
		    	{

					$value = array('banner_type' => $banner_type,'type_id' => $type_id,'banner_name' => $banner_name,'exp_date' => $date,'date'=> date("Y-m-d H:i:s"));
		    	}

		    	else
		    	{
			    	 $value = array('banner_name' => $banner_name,'exp_date' => $date,'date'=> date("Y-m-d H:i:s"));
		    	}


				$data['result'] = $this->model->updateBanner($id,$value);

				$this->session->set_flashdata('update', 'Added Successfully');
				redirect('Cart_banner');
			} 

		}
	}

	public function delete(){

	    $this->load->view('banner/delete');
	    if (isset($_POST['delete'])) 
	    {
		    $id=$_POST['rowid'];
		    //$name=$_POST['name'];
			$this->model->deleteBanner($id);
	        redirect('Cart_banner');
	    }
	}

	public function setPriority()
	{
		    $id=$_POST['rowid'];
		    $value=$_POST['value'];
			$result=$this->model->setPriorityValue($id,$value);
			if($result==""){
				echo "Sorry..Already Exist";

			}
			else{
				echo "Sucessfully";
			}
	}


	public function setBannerType()
	{

		$id=$_POST['id'];

		if($id=="category")
		{

			$result=$this->model->getBannerCategoryValue();
		}

		else if($id=="product")
		{

			$result=$this->model->getBannerProductValue();

		}

		else{

			$result="";

		}


		echo '<div class="col-md-12">
	            <div class="form-group col-md-5">
                <label class="form-control-label" for="inputBasicFirstName">'.ucfirst($id).'</label> 
                </div>
                <div class="form-group col-md-7">  
                <select title="None" class="form-control" name="type_id">
	                <option value="">Please Select</option>';
                    foreach ($result as $rs) { 

		                echo '<option value="'.$rs['id'].'">'.$rs['name'].'</option>';
                    } 
        echo '</select>
              </div>
              </div>';

	}

}