<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Combo_offer extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Combo_offer_model','model');
        $this->load->library('Image');//custom image library to crop
	     
	    if (!$this->is_logged_in()) //login only registered user from db
	    { 
	      redirect('Login');
	    }
    }
  
    public function index() {

    	$this->load->view('combo/list');

    }

    public function combo_list() {

        $list = $this->model->get_datatables();
        $data = array();

        $no = $_POST['start'];

        foreach ($list as $offer) {
            
            $offer_start = date( 'm-d-y g:i A', strtotime($offer->offer_start));

            $offer_end = date( 'm-d-y g:i A', strtotime($offer->offer_end));

	        $no++;
	        $row = array();
	        $row[] = $no;
	        $row[] = $offer->caption;
            $row[] = $offer->actual_price;
            $row[] = $offer->offer_price;
            $row[] = $offer_start;
            $row[] = $offer_end;
            $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/combo_offer/'.$offer->image.'" class="img-responsive" height=60 width=80 /></a>';

	        //add html for action
	         $row[] = '<a data-toggle="modal" data-id='.$offer->id.' data-target="#view-modal" class="btn  btn-info" href="#"><i class="fa fa-eye" aria-hidden="true"> Products</i></a>

	         <a href="combo_offer/edit/'.$offer->id.'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>

	         <a data-toggle="modal" data-id='.$offer->id.' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

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

	    $this->form_validation->set_rules('caption', 'Caption Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('actual_price', 'Actual price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('offer_price', 'Offer price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('deal_qty', 'Deal qty', 'trim|required|xss_clean');
        $this->form_validation->set_rules('offer_start', 'Offer Start', 'trim|required|xss_clean');
        $this->form_validation->set_rules('offer_end', 'Offer End', 'trim|required|xss_clean');

        if (empty($_FILES['image_file']['name']))
        {
            $this->form_validation->set_rules('image_file', 'Image', 'required');
        }
	   
	    if($this->form_validation->run() == FALSE) {

    	   $data['list'] = $this->model->getProductData();
	       $this->load->view('combo/add',$data);
	    }
	    else 
	    {
            $stock_name = $this->input->post('stock_name');

    	    $caption = $this->input->post('caption');
    	    $actual_price = $this->input->post('actual_price');
            $offer_price = $this->input->post('offer_price');
            $min_purchase = $this->input->post('min_purchase');
            $deal_qty = $this->input->post('deal_qty');
            $offer_start = $this->input->post('offer_start');
            $offer_end = $this->input->post('offer_end');
            $description = $this->input->post('description');
            
            if( ($actual_price!=0) && ($offer_price!=0) ){

            $disc = (($actual_price - $offer_price)*100) /$actual_price;

            $discount=round($disc);
            }
            else{

            $discount=0;
            }
            
        	$this->image->generalCropAdd();//call custom image library

            $image_name= $this->image->image_name;

    	    $value = array('discount' => $discount,'actual_price' => $actual_price,'offer_price' => $offer_price,'min_purchase' => $min_purchase,'order_qty' => $deal_qty,'offer_start' => $offer_start,'offer_end' => $offer_end,'caption' => $caption,'description' => $description,'image' => $image_name);
            $data['result'] = $this->model->insertComboOffer($value,$stock_name);
            $this->session->set_flashdata('add', 'Added Successfully');
            redirect('Combo_offer');

	    }
	}

    public function view() {

        $id = $this->input->post('rowid');
        $data['result'] = $this->model->viewComboData($id);
        $this->load->view('combo/view', $data);
    }


    public function edit() {

        $id = $this->uri->segment(3);

        $data['list'] = $this->model->getProductData();

        $data['result'] = $this->model->getOfferData($id);

        $this->load->view('combo/edit',$data);
    }

    public function update() {

        $this->form_validation->set_rules('caption', 'Banner Name', 'trim|required|xss_clean');

        $id = $this->input->post('id');

        if (isset($_POST['submit'])) 
        {

            if($this->form_validation->run() == FALSE) {

                $data['list'] = $this->model->getProductData();
                $data['result'] = $this->model->getOfferData($id);
                $this->load->view('combo/edit',$data);
            }
            else 
            {

                $caption = $this->input->post('caption');
                $actual_price = $this->input->post('actual_price');
                $offer_price = $this->input->post('offer_price');
                $min_purchase = $this->input->post('min_purchase');
                $deal_qty = $this->input->post('deal_qty');
                $offer_start = $this->input->post('offer_start');
                $offer_end = $this->input->post('offer_end');
                $description = $this->input->post('description');
                
                
                if( ($actual_price!=0) && ($offer_price!=0) ){

                    $disc = (($actual_price - $offer_price)*100) /$actual_price;

                    $discount=round($disc);
                }
                else{

                    $discount=0;
                }

                $this->image->generalCropAdd();//call custom image library

                if(isset($this->image->image_name)) {

                    $image_name= $this->image->image_name;

                }

                if($image_name !="")
                {

                    $value = array('discount' => $discount,'actual_price' => $actual_price,'offer_price' => $offer_price,'min_purchase' => $min_purchase,'order_qty' => $deal_qty,'offer_start' => $offer_start,'offer_end' => $offer_end,'caption' => $caption,'description' => $description,'image' => $image_name);
                }

              

                else
                {
                    $value = array('discount' => $discount,'actual_price' => $actual_price,'offer_price' => $offer_price,'min_purchase' => $min_purchase,'order_qty' => $deal_qty,'offer_start' => $offer_start,'offer_end' => $offer_end,'caption' => $caption,'description' => $description);
                }


                $data['result'] = $this->model->updateComboOffer($id,$value);

                $this->session->set_flashdata('update', 'Added Successfully');
                redirect('Combo_offer');
            } 

        }
    }

     public function getPriceList() {

        $id=$_POST['rowid'];

        $result = $this->model->getTotalProductPrice($id);

        $sum_list_price = 0;

        foreach ($result as $key => $value) {

            $sum_list_price += $value['list_price'];
            
        }

        echo $sum_list_price;
        
    }

	 public function delete() {

        $this->load->view('combo/delete');
        if (isset($_POST['delete'])) 
        {
            $id=$_POST['rowid'];
            $this->model->deleteCombo($id);
            redirect('Combo_offer');
        }
    }





}