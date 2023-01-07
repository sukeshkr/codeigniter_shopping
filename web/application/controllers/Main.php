<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    protected $CI;

    public function __construct() {
        parent::__construct();

        $this->CI =& get_instance();
        $this->load->model('Main_Model', 'model');
        $this->load->helper(array('form', 'url')); 
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->helper('text');

        if(!empty($this->userDetails)){ 

            $this->user_id = $this->userDetails->id;
        }
        else{

            $this->user_id = "";
        }
    }
   
    public function home() { 


        //  $this->load->view('product_filter');

        // exit;

        //$this->load->view('my');

        


        $data['stor_result'] = $this->model->getStoreResult();

        $data['main_category'] = $this->model->getMainCategorys();

        // //$data['cat_list'] = $this->model->getSubCategoryData();

        // $data['cart_count'] = $this->model->getCartCount($this->user_id);

        // $data['list'] = $this->model->getOfferCategory();

        // $data['banner'] = $this->model->getBannerData();

        $data['category'] = $this->model->getBestCategoryData();

        $data['best_deal'] = $this->model->getBestDealDataList();
        
        $res = $this->model->getCatProductListByArea();

        if(!empty($res)) {

            $set_cat_id=$res[0]['cat_id'];

            $set_cat_name=$res[0]['cat_name'];
        }

        else{

            $set_cat_id=65;

            $set_cat_name="Grocery ";
        }

         $data['best_deal_title'] = "Top Selling ".$set_cat_name;

         $data['top_selling'] = $this->model->getTopSellingData($set_cat_id);
        
        // if(!empty($this->user_id)){ 

        //     $data['item'] = $this->model->getRecentlyVisitData($this->user_id);
        // }
        // else{

        //     $data['item'] = "";

        // }

        // $data['combo'] = $this->model->getBestComboList();
        
        $data['our_items'] = $this->model->getOurItemsData();
                
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';

        $this->load->view('home',$data);
    }

    public function about() 
    {
      
        //$data['cat_list'] = $this->model->getSubCategoryData();

        $data['stor_result'] = $this->model->getStoreResult();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['cart_count'] = $this->model->getCartCount($this->user_id);

        $data['list'] = $this->model->getOfferCategory();
        
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';

	    $this->load->view('about-us',$data);
    }
 
    public function career() {

        //$data['cat_list'] = $this->model->getSubCategoryData();
        $data['stor_result'] = $this->model->getStoreResult();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['cart_count'] = $this->model->getCartCount($this->user_id);
        $data['list'] = $this->model->getOfferCategory();

        $data['career'] = $this->model->getCareer();
        
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';

	    $this->load->view('career',$data);
    }


    public function career_post() {

        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $position = $this->input->post('position');
        $message = $this->input->post('message');

        if (!is_dir('admin/uploads/career')) {

        mkdir('admin/uploads/career', 0755, TRUE);
        }

        $config['upload_path'] = 'admin/uploads/career/';
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
        $config['file_name'] = $_FILES['image_file']['name'];
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['min_width'] = '0';
        $config['min_height'] = '0';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $this->upload->initialize($config);
        $upload = $this->upload->do_upload('image_file');
        $data = $this->upload->data();
        $image_name = $data['file_name'];

        $value  = array('name' => $name,'phone' => $phone,'position' => $position,'message' => $message,'image_file' => $image_name );

        $res =  $this->model->putCareerInbox($value);

        $this->session->set_flashdata('add', 'Added Successfully');

        redirect(CUSTOM_BASE_URL.'career');
    }

    public function contact() 
    {
     
        //$data['cat_list'] = $this->model->getSubCategoryData();

        $data['stor_result'] = $this->model->getStoreResult();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['cart_count'] = $this->model->getCartCount($this->user_id);

        $data['list'] = $this->model->getOfferCategory();
        
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';

        $this->load->view('contact-us',$data);
    }

    public function offers() {

        //$data['cat_list'] = $this->model->getSubCategoryData();

        $data['stor_result'] = $this->model->getStoreResult();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['cart_count'] = $this->model->getCartCount($this->user_id);

        $data['list'] = $this->model->getOfferCategory();

        $data['result'] = $this->model->getOfferData();
        
        if(!empty($this->user_id)){ 

            $data['item'] = $this->model->getRecentlyVisitData($this->user_id);

            $data['title'] = "Recently Viewed";
        }
        else{

            $data['item'] = $this->model->getTopSellingData();

            $data['title'] = "Recommended Items";

        }
        
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';

        $this->load->view('offers',$data);
        
    }
    
    public function offer_details() {
        
        $encrypted_id = $this->uri->segment(2);

        $decrypted_id = base64_decode($encrypted_id);

        $id = preg_replace(sprintf('/%s/', SALT_KEY.CKRAT_KEY), '', $decrypted_id);

        $data['main_category'] = $this->model->getMainCategorys();
        $data['cart_count'] = $this->model->getCartCount($this->user_id);
        $data['list'] = $this->model->getOfferCategory();
        
        $data['offer'] = $this->model->getOfferDetailsData($id);

        $data['result'] = $this->model->getOtherOfferData($id);
        
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';

        $this->load->view('offer-details',$data);
        
    }

    public function offers_category() {

        //$data['cat_list'] = $this->model->getSubCategoryData();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['cart_count'] = $this->model->getCartCount($this->user_id);

        $encrypted_id = $this->uri->segment(2);

        $decrypted_id = base64_decode($encrypted_id);

        $cat_id = preg_replace(sprintf('/%s/', SALT_KEY.CKRAT_KEY), '', $decrypted_id);

        $data['list'] = $this->model->getOfferCategory();

        $data['result'] = $this->model->getOfferData($cat_id);

        $this->load->view('offers',$data);
        
    }

    public function customer_care() 
    {

        //$data['cat_list'] = $this->model->getSubCategoryData();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['cart_count'] = $this->model->getCartCount($this->user_id);
        $data['list'] = $this->model->getOfferCategory();
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';
        
        $this->load->view('24X7-customer-care',$data);
        
    }

    //  public function product_list() {

    //     $min_price = "";
    //     $max_price = "";
    //     $search = "";
    //     $feature='';
    //     $option='';

    //     $cat_id = $this->uri->segment(2);

    //     $data['cart_count'] = $this->model->getCartCount($this->user_id);

    //     $data['list'] = $this->model->getOfferCategory();

    //     $data['cat_list'] = $this->model->getSubCategoryData();

    //     $data['result'] = $this->model->getAllProductCategoryWise($cat_id,$min_price,$max_price,$search,$feature,$option);

    //     $data['category'] = $this->model->getProductFilterCategoryList($cat_id,$min_price,$max_price,$search);

    //     $data['price_range'] = $this->model->getProductFilterPriceList($cat_id,$min_price,$max_price,$search);

    //     $data['feature'] = $this->model->getProductFeatureList($cat_id,$min_price,$max_price,$search);

    //     $data['option'] = $this->model->getProductOptionList($cat_id,$min_price,$max_price,$search);

    //     $this->load->view('product-list',$data);
    // }

    //   public function filter_list() {

    //     $min_price = "";
    //     $max_price = "";
    //     $search = "";

    //     if(!empty($_POST['feature'])) {

    //         $feature_chk = array();

    //         $feature_chk = $_POST['feature'];
            
    //     }

    //     else{

    //         $feature_chk = "";

    //     }

    //     if(!empty($_POST['chk_option'])) {

    //         $option_chk = array();

    //         $option_chk = $_POST['chk_option'];
            
    //     }

    //     else{

    //         $option_chk = "";

    //     }

    //     $data['feature_chks'] = $feature_chk;

    //     $data['option_chks'] = $option_chk;
         
    //     $cat_id = "";

    //     $data['cart_count'] = $this->model->getCartCount($this->user_id);

    //     $data['list'] = $this->model->getOfferCategory();

    //     $data['cat_list'] = $this->model->getSubCategoryData();

    //     $data['result'] = $this->model->getAllProductCategoryWise($cat_id,$min_price,$max_price,$search,$feature_chk,$option_chk);

    //     $data['category'] = $this->model->getProductFilterCategoryList($cat_id,$min_price,$max_price,$search);

    //     $data['price_range'] = $this->model->getProductFilterPriceList($cat_id,$min_price,$max_price,$search);

    //     $data['feature'] = $this->model->getProductFeatureList($cat_id,$min_price,$max_price,$search);

    //     $data['option'] = $this->model->getProductOptionList($cat_id,$min_price,$max_price,$search);

    //     $this->load->view('product-list',$data);
    // }

    public function search() {

        $search = trim($this->input->post('search'));

        $search = strtolower($search);

        $data['category_id'] = "";

        $min_price = "";
        $max_price = "";

        $cat_id = "";

        $data['cart_count'] = $this->model->getCartCount($this->user_id);

        $data['list'] = $this->model->getOfferCategory();

        //$data['cat_list'] = $this->model->getSubCategoryData();
        
        $data['main_category'] = $this->model->getMainCategorys();
        
        $data['result'] = $this->model->getAllProductCategoryWise($cat_id,$min_price,$max_price,$search);

        $data['category'] = $this->model->getProductFilterCategoryList($cat_id,$min_price,$max_price,$search);

        $data['price_range'] = $this->model->getProductFilterPriceList($cat_id,$min_price,$max_price,$search);

        $data['feature'] = $this->model->getProductFeatureList($cat_id,$min_price,$max_price,$search);

        $data['option'] = $this->model->getProductOptionList($cat_id,$min_price,$max_price,$search);
 
        $this->load->view('product-list',$data);

    }

    public function list_item() {

        $search = trim($_POST['search']);

        $search = strtolower($search);

        $result = $this->model->getSearchKeyword($search);

        echo '<ul class="search-drop-ab">';

            foreach ($result as $rs) { ?>

                <li  onclick='fill("<?php echo $rs['product_name']; ?>")'><a><?php echo $rs['product_name']; ?></a></li>
                
            <?php } 

            echo '</ul>';

    }

    public function product_details() {

        $encrypted_id = $this->uri->segment(2);

        $decrypted_id = base64_decode($encrypted_id);

        $id = preg_replace(sprintf('/%s/', SALT_KEY.CKRAT_KEY), '', $decrypted_id);

        $data['cart_count'] = $this->model->getCartCount($this->user_id);
        
        $data['wish_list'] = $this->model->getWishList($this->user_id,$id);

        $data['list'] = $this->model->getOfferCategory();

        //$data['cat_list'] = $this->model->getSubCategoryData();
        
        $data['main_category'] = $this->model->getMainCategorys();

        $data['result'] = $this->model->getProductDetailsById($id);

        $data['rating'] = $this->model->getProductRating($id);

        $data['rating_avg'] = $this->model->getProductRatingRateAvg($id);

        if($data['result']) {

            $cat_id = $data['result'][0]['cat_id'];
        }
        else{

            $cat_id = '';
        }

        $data['similar_item'] = $this->model->getProductSimilar($cat_id);
        $data['ratingeach1'] = $this->model->getProductRatingEach($id,1);
        $data['ratingeach2'] = $this->model->getProductRatingEach($id,2);
        $data['ratingeach3'] = $this->model->getProductRatingEach($id,3);
        $data['ratingeach4'] = $this->model->getProductRatingEach($id,4);
        $data['ratingeach5'] = $this->model->getProductRatingEach($id,5);
        
        if(!empty($this->user_id)) { 

            $this->model->putProductRecentlyView($this->user_id,$id);

        }
        
        $data['title'] = 'Ahlul Kaif Coffee & Dates';

        $this->load->view('product-details',$data);
    }
    
    public function subscribe_create() {

        if(!empty($_POST['email'])) { 

            $email = trim($_POST['email']);

            $result = $this->model->putSubscriber($email);

            echo '1';
        }
        else{

            echo '2';
        }
    }
    
    public function get_sub_category() { //Ajax calling

        $cat_id = $_POST['rowid'];

        $cat_list = $this->model->getAllCategorys($cat_id);
        

        foreach ($cat_list as $catLists) { 
                     
            $catmackratt = base64_encode($catLists['cat_id'] .SALT_KEY.CKRAT_KEY);

                 $res.= '
                 
                  
                     
                        <li><a href="'.CUSTOM_BASE_URL. 'product-list/'.$catmackratt.'">'.$catLists['cat_name'].'</a></li>
                   
                      
                  
               ';
        } 
        
        echo $res;

    }
    
    public function store_list() {

        $data['main_category'] = $this->model->getMainCategorys();
        $data['cart_count'] = $this->model->getCartCount($this->user_id);
        
        $data['list'] = $this->model->getOfferCategory();
        
        $data['store_list'] = $this->model->getStoreData();
        
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';
        
        $this->load->view('store',$data);
        
    }
    
    public function store_details() {
        
        $encrypted_id = $this->uri->segment(2);

        $decrypted_id = base64_decode($encrypted_id);

        $id = preg_replace(sprintf('/%s/', SALT_KEY.CKRAT_KEY), '', $decrypted_id);
        
        $data['main_category'] = $this->model->getMainCategorys();
        $data['cart_count'] = $this->model->getCartCount($this->user_id);
        
        $data['list'] = $this->model->getOfferCategory();

        $data['store_data'] = $this->model->getStoreData();
        
        $data['store_list'] = $this->model->getStoreData($id);
        
        $data['title'] = 'Ahlul Kaif,Al Qeema,Al Majalis';
        
        $this->load->view('store-details',$data);
        
    }
    
    public function email() 
    {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $place=$_POST['place'];
        $msg=$_POST['message'];
        $from = '<noreply@ahlulkaif.com>';
        $to = 'it@ahlulkaif.com';

        $config = Array(
        'protocol' => 'sendmail',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1'
        );

        $this->load->library('email',$config);
        $this->email->from($from, $name);
        $this->email->to($to);
        $this->email->subject("Contact Enquiry from - " . $name);
        $this->email->set_mailtype("html");

        $email_body = "<table style='width:700px;border:0px #e5e5e5 solid;background:#eeeeee;color:#000000;padding:10px; font-family:Tahoma, Geneva, sans-serif;'><tbody><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Name:</strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $name . "</td></tr><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Email:</strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $email . "</td></tr><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Mobile: </strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $phone . "</td></tr><tr><td style='width:120px;padding-left:3px;border:1px #f4981e solid;background:#f4981e;color:#FFFFFF;'><strong>Message:</strong></td><td style='border:1px #FFFFFF solid; padding:5px;background:#FFFFFF;color:#000000;'>" . $msg . "</td> </tr></tbody></table>";
        
        $body = str_replace("\n", "<br/>", $email_body);
        
        $this->email->message($body);

        if ($this->email->send()) 
        {
            echo 'Thank you';
        }   
        else 
        {
            echo 'Error in sending Email';
        }
    }

    public function change_location() {

        $location = $_POST['location'];

        $result = $this->model->getStoreLocation($location);

        $id=$result->id;
    
        $location=$result->location;

        if($id!="")
        {
            $this->session->set_userdata('storeLoc', $result);
    
            $this->session->userdata('storeLoc');

            echo "1";exit;

        }
        else {

            echo "2";exit;
    
        }


    }


}
