<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_category extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Menu_category_model','model');
	    if (!$this->is_logged_in()) //login only registered user from db
	    { 
    	    redirect('Login');
	    }
    }
  
    public function index() {

    	$this->load->view('menu_category/cart-categories');

    }

    public function cat_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $career) {

            if($career['menu_cat_status']=="1")
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
            echo "Menu category Removed Sucessfully";
        }
        else{

            echo "Menu category Set Sucessfully";

        }
        

    }


    public function menu_category_wise() {

        $data['list'] = $this->model->getMenuCategoryWise();

        $this->load->view('menu_category/menu_order',$data);

    }

    public function order() {

        $rowid=$_POST['rowid'];

        $id=$_POST['id'];

        $cat_id = explode(",", $rowid);
        
        $result=$this->model->update($cat_id,$id);
        print_r("done");
    }


}

?>
