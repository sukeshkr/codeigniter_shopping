<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber extends MY_Auth_Controller {

    protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() {
        parent::__construct();
        $this->ci_name = strtolower($this->router->fetch_class());
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('Subscriber_model','model');
        $this->load->helper('url');    
        
        if (!$this->is_logged_in()) {
            redirect('Login');
        }
    }

    public function index() {

        $this->load->view('subscribe/list');
    }

    public function Subscriber_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $subscriber) {
        
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $subscriber->mail;
            $row[] = $subscriber->created_at;
            $row[] = '<a data-toggle="modal" data-id='.$subscriber->id.' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';
              
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
   
  
    public function delete(){

        $this->load->view('subscribe/delete');

        if (isset($_POST['delete'])) 
        {
            $id=$_POST['rowid'];
            $this->model->delete($id);
            redirect('Subscriber');
        }
    }
   
}
