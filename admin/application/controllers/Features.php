<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Features extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Features_model','model');
        if (!$this->is_logged_in()) //login only registered user from db
        { 
          redirect('Login');
        }
	}

	public function index() {

        $data['list'] = $this->model->getFeat();
	 	$this->load->view('feature/features',$data);

	}

    public function feature_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $feature) {

            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $feature['name'];
            $row[] = $feature['group_name'];
            
            // //add html for action
            $row[] = '<a data-toggle="modal" data-id='.$feature['id'].' data-target="#view-modal" class="btn  btn-info" href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>

                <a href="features/edit/'.$feature['id'].'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>

                <a data-toggle="modal" data-id='.$feature['id'].' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

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

    	$this->form_validation->set_rules('name', 'User Name', 'trim|required|xss_clean');

        $this->form_validation->set_rules('group_name','Group name', 'trim|required|xss_clean');

        $this->form_validation->set_rules('cat_name[]','category name', 'trim|required|xss_clean');

        $this->form_validation->set_rules('variants_name[]','Variants', 'trim|required|xss_clean');

        if($this->form_validation->run() == FALSE) {

        	$data['group'] = $this->model->getFeatureGroup();
            $data['catList'] = $this->model->getCategory();
            $this->load->view('feature/add',$data);

        }
        else 
        {

            $name = $this->input->post('name');
            $group_name = $this->input->post('group_name');
            $variant_check = $this->input->post('variant_check');
            $description = $this->input->post('description');
            $cat_name = $this->input->post('cat_name');


            if($this->input->post('variants_name')) {
                
                $variants_name = $this->input->post('variants_name'); 

            }

            $value=array('f_grp_id'=>$group_name,'name'=>$name,'go_to_variant'=>$variant_check,'description'=>$description);

            $this->model->insertFeatures($value,$variants_name,$cat_name);

            $this->session->set_flashdata('add', 'Added Successfully');

            redirect('Features');
        }

	}

    public function edit()
    {
        $id = $this->uri->segment(3);
        $data['ftrList'] = $this->model->getFeatures($id);
        $data['group'] = $this->model->getFeatureGroup();
        $data['ftrVariants'] = $this->model->getFeatureVariants($id);
        $data['catAllList'] = $this->model->getCategory();
        $data['catList'] = $this->model->getSelectedCat($id);

        $this->load->view('feature/edit',$data);
    }

    public function update() {

        $this->form_validation->set_rules('name', 'User Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description','Description', 'trim|required|xss_clean');

        $id = $this->input->post('id');

        if($this->form_validation->run() == FALSE) 
        {
            $data['ftrList'] = $this->model->getFeatures($id);
            $data['group'] = $this->model->getFeatureGroup();
            $data['ftrVariants'] = $this->model->getFeatureVariants($id);
            $data['catAllList'] = $this->model->getCategory();
            $data['catList'] = $this->model->getSelectedCat($id);
            $this->load->view('feature/edit',$data);

        }
        else 
        {
            $name = $this->input->post('name');
            $group_id= $this->input->post('group_name');
            $variant_check = $this->input->post('variant_check');
            $description = $this->input->post('description');

            $cat_name = $this->input->post('cat_name');
            
            $variants_name = $this->input->post('variants_name'); 

            $value=array('f_grp_id'=>$group_id,'name'=>$name,'go_to_variant'=>$variant_check,'description'=>$description);

            $this->model->updateFeature($id,$value,$variants_name,$cat_name);

            $this->session->set_flashdata('update', 'Added Successfully');
            redirect('Features');
        }
    }

    public function delete(){

        $this->load->view('feature/delete');

        if (isset($_POST['delete'])) 
        {
            $id=$_POST['rowid'];
            $this->model->deleteFeature($id);
            redirect('Features');
        }
    }

    public function deleteFeatureCatList(){

        $id=$_POST['rowid'];
        $this->model->deleteFeatureCat($id);
    }
    
    public function deleteFeatureList(){
       
        $id=$_POST['rowid'];
        $this->model->deleteFeaturesList($id);
    }

}
