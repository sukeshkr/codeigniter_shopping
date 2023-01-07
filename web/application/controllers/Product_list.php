<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_list extends MY_Controller {
 
    public function __construct() {

        parent::__construct();
        $this->load->model('Product_list_model','model');

        $this->load->helper(array('form', 'url')); 
        $this->load->library('upload');
        $this->load->library('session');

        if(!empty($this->userDetails)) { 

            $this->user_id = $this->userDetails->id;
        }
        else{

            $this->user_id = "";
        }

    }

    public function index() {
        
        $data['list'] = $this->model->getOfferCategory();

        if(!empty($this->input->post('search'))) {

            $search = trim($this->input->post('search'));

            $search = strtolower($search);
        }
        else{

            $search = "";
        }

        if(!empty($this->uri->segment(2))) {

            $encrypted_id = $this->uri->segment(2);

            $decrypted_id = base64_decode($encrypted_id);

            $cat_id = preg_replace(sprintf('/%s/', SALT_KEY.CKRAT_KEY), '', $decrypted_id);
        }
        else{

            $cat_id = "";
        }
        
        //$data['cat_list'] = $this->model->getSubCategoryData();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['cart_count'] = $this->model->getCartCount($this->user_id);

        $price_range = $this->model->getProductFilterPriceList($cat_id,$search);

        $min_price = 0;

        $max_price = 0;

        foreach ($price_range as $key => $rows) {

            $min_price = $rows->SmallestPrice;
            $max_price = $rows->LargestPrice;
        }

        $data['min_price'] = $min_price;

        $data['max_price'] = $max_price;

        $data['feature'] = $this->model->getProductFeatureList($cat_id,$search);

        $data['option'] = $this->model->getProductOptionList($cat_id,$search);

        $data['category'] = $this->model->getProductFilterCategoryList($cat_id,$search);
        
        if(!empty($cat_id)) {

            $data['cat_name'] = $this->model->getCategoryName($cat_id);
            
            $data['cat_id'] = $cat_id;

        }
        else{

           $data['cat_name'] = "";
           
           $data['cat_id'] = 0;
        }
        
        
        $data['title'] = 'Shop '.$data['cat_name'].' online';

        $this->load->view('product-list', $data);
    }

    public function fetch_data() {

        $minimum_price = $this->input->post('minimum_price');
        $maximum_price = $this->input->post('maximum_price');
        $feature = $this->input->post('feature');
        $option = $this->input->post('option');
        $availability = $this->input->post('availability');
        $pop = $this->input->post('pop');
        $high = $this->input->post('high');
        $low = $this->input->post('low');
        $first = $this->input->post('first');
        $cat_id = $this->input->post('cat_id');
        $config = array();
        $config['base_url'] = '#';
        $config['total_rows'] = $this->model->count_all($minimum_price, $maximum_price, $feature, $option,$cat_id,$availability,$pop,$high,$low,$first);
        $config['per_page'] = 16;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='active'><a href='#'>";
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['num_links'] = 3;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config['per_page'];
        $output = array(
         'pagination_link'  => $this->pagination->create_links(),
         'product_list'   => $this->model->fetch_data($config["per_page"], $start, $minimum_price, $maximum_price, $feature, $option,$cat_id,$availability,$pop,$high,$low,$first)
        );

        echo json_encode($output);
    }
  
}

?>
   

