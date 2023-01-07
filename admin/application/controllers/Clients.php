<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MY_Auth_Controller {

    protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() {
        parent::__construct();
        $this->ci_name = strtolower($this->router->fetch_class());
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('Clients_model','model');
        $this->load->helper('url');    
        
        if (!$this->is_logged_in()) {
            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('clients/list');
    }

    public function user_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $product) {

                if($product->status=='1') {

                $selected='<option value="1" selected>Active</option>
                           <option value="0" >Deactive</option>';
            }

            else if($product->status=='0') {

                $selected='<option value="0" selected>Deactive</option>
                           <option value="1" >Active</option>';
            }

            else{

                $selected='';

            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $product->phone;
            $row[] = $product->user_name;

            $row[] = '<img alt="no image" src="'.CUSTOM_BASE_URL.'uploads/profile/'.$product->prof_image.'" class="img-responsive" height=60 width=80 /></a>';

            $row[] = '<select  name='.$product->id.' onchange="getval(this);" id="mySelect">'.$selected.'</select>';
              
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
   
  
    public function setStatus() 
    {
        $status=$_POST['status'];

        $id=$_POST['rowid'];

        $result=$this->model->setOrderStatus($id,$status);

   }
   
}
