<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Auth_Controller {

    protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
        parent::__construct();
        $this->ci_name = strtolower($this->router->fetch_class());
        $this->load->model('Category_model','model');
        $this->load->library('Image');//custom image library to crop
        if (!$this->is_logged_in()) //login only registered user from db
        { 
          redirect('Login');
        }
    }
  
    public function index() {

        $this->load->view('category/list');

    }


    public function cat_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $career) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $career['cat_name'];
        $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/category/crop/'.$career['image'].'" class="img-responsive" height=60 width=80 /></a>';
          
        //add html for action
        $row[] = '<a href="category/edit/'.$career['cat_id'].'" class="btn  btn-warning" href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
        <a data-toggle="modal" data-id='.$career['cat_id'].' data-target="#del-modal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

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

        $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
        if (empty($_FILES['image_file']['name']))
        {
            $this->form_validation->set_rules('image_file', 'Image', 'required');
        }


        if($this->form_validation->run() == FALSE) 
        {
            $data['category'] = $this->model->getCartCat();
            $this->load->view('category/add',$data);
        }
        else 
        {

             $this->image->imageCropAdd();//call custom image library

            $image= $this->image->crop_image_name;

           

            $cat_name = $this->input->post('cat_name');

            $description = $this->input->post('description');
           
            $parent = $this->input->post('parent');

            $meta_title = $this->input->post('meta_title');
            $meta_descrip = $this->input->post('meta_descrip');
            $meta_key = $this->input->post('meta_key');
            $seo_name = $this->input->post('seo_name');


            $value = array('cat_name' => $cat_name,'description' => $description,'parent_id' => $parent,'image' => $image,'meta_title' => $meta_title,'meta_descr' => $meta_descrip,'meta_key' =>$meta_key,'seo_name' => $seo_name);

            $data['result'] = $this->model->insertCategoryData($value);
            $this->session->set_flashdata('add', 'Added Successfully');

            redirect('Category');
        }

    }

    public function edit() {

        $id = $this->uri->segment(3);
        $data['category'] = $this->model->getCartCat();
        $data['result'] = $this->model->getCartParentEdit($id);
        $this->load->view('category/edit',$data);
    }

    public function update() {

        
       // $this->form_validation->set_rules('cat_name', 'Name', 'trim|required|xss_clean');
       // $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');

        

        // if (isset($_POST['submit'])) 
        // {
            $id = $this->input->post('id');

            // if($this->form_validation->run() == FALSE) 
            // {
            //     $data['category'] = $this->model->getCartCat();
            //     $data['result'] = $this->model->getCartParentEdit($id);
            //      $this->load->view('category/edit',$data);
            // }
            // else 
            // {
                $cat_name = $this->input->post('cat_name');
                $parent = $this->input->post('parent');
                $description = $this->input->post('description');

                $this->image->imageCropAdd();//call custom image library

                if($this->image->crop_image_name !="")//if there is image and pdf is null
                {
                    $image =  $this->image->crop_image_name;

                    $value = array('cat_name' => $cat_name,'description' => $description,'parent_id' => $parent,'image' => $image);

                } 
                else{

                    $value = array('cat_name' => $cat_name,'description' => $description,'parent_id' => $parent);

                }
                
                $this->model->updateCategory($id,$value);

                $this->session->set_flashdata('update', 'Added Successfully');
                redirect('Category');
           // } 

        //}
    }



    public function delete() {

        $this->load->view('category/delete');
        if (isset($_POST['delete'])) 
        {
            $id=$_POST['id'];
            $this->model->deleteProduct($id);
            redirect('Category');
        }
    }


}
