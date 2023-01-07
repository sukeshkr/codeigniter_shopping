<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stock_update extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Stock_update_model','model');
	    $this->session_data=$this->session->userdata('userAdminDetails');
	    if (!$this->is_logged_in()) //login only registered user from db
	    { 
	      redirect('Login');
	    }
    }
  
    public function index() {

    	$this->load->view('stock/list');

    }

    public function stock_list() {

        $list = $this->model->get_datatables();
        $data = array();

        $no = $_POST['start'];

        foreach ($list as $rows) {

	        if($rows['status']==1) {

	        	$status="Active";
	        }
	        if($rows['status']==2) {
	        	
	        	$status="Deactive";
	        }
	        if($rows['status']==0) {
	        	
	        	$status="Deleted";
	        }

	        $no++;
	        $row = array();
	        $row[] = $no;
	        $row[] = $rows['stock_name'];
	        $row[] = $rows['cat_name'];
	        $row[] = '<input size="4" id="'.$rows['id'].'price" type="text" value="'.$rows['price'].'" onkeyup = "checkPrice('.$rows['id'].')" >';
	        $row[] = '<input size="4" id="'.$rows['id'].'list_price" type="text" value="'.$rows['list_price'].'" onkeyup = "checkListPrice('.$rows['id'].')" >';
	        $row[] = '<input size="2" id="'.$rows['id'].'stock" type="text" value="'.$rows['stock'].'" onkeyup = "checkStock('.$rows['id'].')" >';
	                
	        $row[] = '<input type="file" name="images[]" id="file_input'.$rows['id'].'" multiple /><a data-toggle="modal" data-id='.$rows['id'].' data-target="#priceModal" class="btn btn-primary  btn-sm" role="button" href="#">Upload</a>';

	        $row[] = '<img alt="No image" src="'.CUSTOM_BASE_URL.'uploads/product_multimage/'.$rows['image'].'" class="img-responsive" height=50 width=50 /></a>';
	       

	        $row[] = $status;	

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

    public function setPrice() {

        $value=$_POST['value'];

        $id=$_POST['rowid'];

        $result=$this->model->UpdatePriceSet($value,$id);
        
    }

    public function setListPrice() {

        $value=$_POST['value'];

        $id=$_POST['rowid'];

        $result=$this->model->UpdateListPriceSet($value,$id);
        
    }

    public function setStock() {

        $value=$_POST['value'];

        $id=$_POST['rowid'];

        $result=$this->model->UpdateStockSet($value,$id);
        
    }

    public function process()
    {

    	$id=$_POST['rowid'];

    	  if($_FILES['images']['name'])
	        {
	        	$multi_images=array();

			    $number_of_files_uploaded = count($_FILES['images']['name']);

	            for ($i = 0; $i < $number_of_files_uploaded; $i++) :

					$_FILES['userfile']['name']     = $_FILES['images']['name'][$i];
				    $_FILES['userfile']['type']     = $_FILES['images']['type'][$i];
				    $_FILES['userfile']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
				    $_FILES['userfile']['error']    = $_FILES['images']['error'][$i];
				    $_FILES['userfile']['size']     = $_FILES['images']['size'][$i];
				    $config = array(
				    'allowed_types' => 'jpg|jpeg|png|gif',
				    'max_size'      => 300000,
				    'overwrite'     => FALSE,
				    'upload_path'   => 'uploads/product_multimage/',
				    'encrypt_name'  => TRUE,
				    'remove_spaces' =>  TRUE,
				    );
			        $this->upload->initialize($config);
			        if ( ! $this->upload->do_upload()) :
			        $error = array('error' => $this->upload->display_errors());
			        else :
			        $data = $this->upload->data();
			        // Continue processing the uploaded data
			        $multi_images[] = $data['file_name'];

			        $this->load->library('upload', $config);

			        $file_name = $data['file_name'];  
			        $params['gambar'] = $file_name;
			        $this->load->library('image_lib');
			        $config['image_library'] = 'gd2';
			        $config['source_image'] = 'uploads/product_multimage/'.$file_name;
			        $config['create_thumb'] = FALSE;
			        $config['maintain_ratio'] = TRUE;
			        $config['width']     = 400;
			        $config['height']   = 400;
			        $config['new_image']        = 'uploads/product_multimage/' .$file_name;

			        $this->image_lib->clear();
			        $this->image_lib->initialize($config);
			        $this->image_lib->resize();

			        endif;
	            endfor;
	        }
	        else{

	        	$multi_images[] = "";

	        }

	        $result = $this->model->insertCartStock($id,$multi_images);

	     print_r("Sucessfully Uploaded");exit;
    }

	 	
} 

?>
