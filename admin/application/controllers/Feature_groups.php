<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feature_groups extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Feature_groups_model','model');
        if (!$this->is_logged_in()) //login only registered user from db
        { 
          redirect('Login');
        }
	}

	public function index() {

        $data['list'] = $this->model->getFeaturesGroup();
	 	$this->load->view('feature_group/list',$data);
	 }

	public function create() 
	{
	 	$this->form_validation->set_rules('group_name', 'Feature Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description','Description', 'trim|required|xss_clean');

        if($this->form_validation->run() == FALSE) 
        {
            $this->load->view('feature_group/add');

        }
        else 
        {

            $name = $this->input->post('group_name');
            $description = $this->input->post('description');

            $value=array('group_name'=>$name,'description'=>$description);

            $this->model->insertFeaturesGroup($value);

            $this->session->set_flashdata('add', 'Added Successfully');

            redirect('Feature_groups');
        }

	}

    public function edit()
    {
        $id = $this->uri->segment(3);
        
        $data['ftrGrpList'] = $this->model->getFeaturesGroup($id);
        $this->load->view('feature_group/edit',$data);
    }

    public function update() {

        $this->form_validation->set_rules('group_name', 'Feature Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description','Description', 'trim|required|xss_clean');
        $id = $this->input->post('id');

        if($this->form_validation->run() == FALSE) 
        {
            $data['ftrGrpList'] = $this->model->getFeaturesGroup($id);
            $this->load->view('feature_group/edit',$data);

        }
        else 
        {
            $name = $this->input->post('group_name');
            $description = $this->input->post('description');

            $value=array('group_name'=>$name,'description'=>$description);

            $this->model->updateFeatureGroups($id,$value);

            $this->session->set_flashdata('update', 'Added Successfully');
            redirect('Feature_groups');
        }
    }

    public function delete(){

        $this->load->view('feature_group/delete');
        
        if (isset($_POST['delete'])) 
        {
            $id=$_POST['rowid'];
            $this->model->deleteFeature($id);
            redirect('Feature_groups');
        }
    }


}
