<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_category extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Home_category_model','model');
	    if (!$this->is_logged_in()) //login only registered user from db
	    { 
    	    redirect('Login');
	    }
    }
  
    public function index() {

    	$this->load->view('home_category/cart-categories');

    }

    public function cat_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $career) {

            if($career['top_category_status']=="1")
            { 
                $check= "checked";
            }

            else{

                $check= "unchecked ";
            }

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $career['cat_name'];
        $row[] = $career['display_name'];

        $row[] = '<input type="checkbox" '.$check.' id="'.$career['cat_id'].'lifecheck" onclick = "Check('.$career['cat_id'].')" value='.$career['cat_id'].' />';

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


     public function setCartTopCat() {

        $status=$_POST['status'];

        $id=$_POST['rowid'];

        $result=$this->model->putCartTopData($status,$id);

        if($status==0)
        {
            echo "Cart Top category set Removed Sucessfully";
        }
        else{

            echo "Cart Top category Set Sucessfully";

        }
        

    }


}

?>
