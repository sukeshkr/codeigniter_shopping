<?php

class Main_Model extends MY_Model {

    public function __construct() {

    parent::__construct();

    }

    public function getCareer() {

        $this->db->select('*');
        $this->db->from('career');
        $query = $this->db->get();

        return $query->result_array();
        
    }

    public function putCareerInbox($value='') {

        $this->db->insert('career_inbox', $value);

        return true;
        
    }

    public function getAllCategorys($cat_id='')
    {

        $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

        $result = $query->result_array();

        return $result;

    }

    public function getStoreResult() {
   
        $this->db->select('store.id,store.location,store.og_image,store.address,store.phone');
        $this->db->from('store');
        $parent = $this->db->get();

        $categories = $parent->result_array();
    
        return $categories;
    }

    public function getStoreLocation($id) {
   
        $this->db->select('store.id,store.location');
        $this->db->from('store');
        $this->db->where('id',$id);
        $query = $this->db->get();

        return $query->row();
    
    }
    
    public function getMainCategorys() {
   
        $this->db->select('cart_category.cat_id,cart_category.parent_id,cart_category.cat_name,cart_category.image as img_name,cart_category.cat_icon');
        $this->db->from('cart_category');
        $this->db->where('cart_category.top_category_status',1);
        $this->db->where('cart_category.status',1);
        $this->db->where('cart_category.parent_id',0);
        $this->db->order_by('cart_category.cart_page_order','ASC');
        $this->db->limit(9);
        $parent = $this->db->get();

        $categories = $parent->result_array();
    
        return $categories;
    }
    
    public function getProductRating($id='') {

        $this->db->select('cart_rating.rating_id');
        $this->db->from('cart_rating');
        $this->db->where('cart_rating.stock_id',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->num_rows();

        }
        else{
            return false;
        }

        
    }

    public function getProductRatingEach($id='',$num='') {

        $this->db->select('cart_rating.rating_id');
        $this->db->from('cart_rating');
        $this->db->where('cart_rating.stock_id',$id);
        $this->db->where('cart_rating.rating_score',$num);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->num_rows();

        }
        else{
            return false;
        }

        
    }

    public function getProductRatingRateAvg($id='')
    {
            $this->db->select('ROUND(AVG(cart_rating.rating_score),1) as average');
            $this->db->from('cart_rating');
            $this->db->where('cart_rating.stock_id',$id);
            $query = $this->db->get();

            if($query->num_rows() > 0)
            {

                return $query->result()[0]->average;

            }
            else{
                return false;
            }
    }

    // public function getSubCategoryData($parent = 0,$category_tree_array = '') {

    //     if (!is_array($category_tree_array))

    //     $category_tree_array = array();

    //     $this->db->from('cart_category');
    //     $this->db->where('parent_id', $parent);
    //     $this->db->where('top_category_status', 1);
    //     $this->db->order_by('cat_id','asc');
    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0) {

    //         foreach($query->result_array() as $rowCategories){

    //             $category_tree_array[] = array("cat_id" => $rowCategories['cat_id'],"parent_id" => $rowCategories['parent_id'], "cat_name" => $rowCategories['cat_name']);
    //             $category_tree_array = $this->getSubCategoryData($rowCategories['cat_id'], $category_tree_array);
    //         }
    //     }
    //     return $category_tree_array;
    // }

    public function getCartCount($user_id='') {
   
        $this->db->select('cart_addtocart.id');
        $this->db->from('cart_addtocart');
        $this->db->where('cart_addtocart.user_id',$user_id);
        $query = $this->db->get();

        $categories = $query->num_rows();
    
        return $categories;
    }
    
     public function getWishList($user_id='',$stock_id='') {
   
        $this->db->select('cart_movetowishlist.move_id');
        $this->db->from('cart_movetowishlist');
        $this->db->where('cart_movetowishlist.user_id',$user_id);
        $this->db->where('cart_movetowishlist.stock_id',$stock_id);
        $query = $this->db->get();

        $categories = $query->num_rows();
    
        return $categories;
    }


    public function getOfferCategory() {

        $date = date('Y-m-d G:i:s', time());

        $this->db->select('cart_category.cat_id,cart_category.cat_name');
        $this->db->from('cart_combo_offer');
        $this->db->join('cart_combo_products', 'cart_combo_offer.id = cart_combo_products.deal_id');
        $this->db->join('cart_stock', 'cart_combo_products.stock_id = cart_stock.id');
        $this->db->join('cart_product', 'cart_stock.product_id = cart_product.id');
        $this->db->join('cart_category', 'cart_product.cat_id = cart_category.cat_id');
        $this->db->where('cart_combo_offer.offer_start <=', $date);
        $this->db->where('cart_combo_offer.offer_end >=', $date);
        $this->db->group_by('cart_category.cat_id');
        $this->db->order_by('cart_category.cat_name','ASC');
        $query = $this->db->get();

        $categories=$query->result();

        return $categories;

    }

    public function getOfferData($cat_id='') {

        $date = date('Y-m-d G:i:s', time());

        $this->db->select('cart_combo_offer.id,cart_combo_offer.offer_price,cart_combo_offer.actual_price,cart_combo_offer.discount,cart_combo_offer.image,cart_combo_offer.caption');
        $this->db->from('cart_combo_offer');
        $this->db->join('cart_combo_products', 'cart_combo_offer.id = cart_combo_products.deal_id');
        $this->db->join('cart_stock', 'cart_combo_products.stock_id = cart_stock.id');
        $this->db->join('cart_product', 'cart_stock.product_id = cart_product.id');
        $this->db->join('cart_category', 'cart_product.cat_id = cart_category.cat_id');
        $this->db->where('cart_combo_offer.offer_start <=', $date);
        $this->db->where('cart_combo_offer.offer_end >=', $date);

        if($cat_id!='') {

            $this->db->where('cart_category.cat_id',$cat_id);

        }
        
        $this->db->group_by('cart_combo_offer.id');
        $this->db->order_by('cart_combo_offer.id','DESC');
        $query = $this->db->get();

        $categories=$query->result();

        return $categories;

    }
    
    public function getOfferDetailsData($id='') {

        $date = date('Y-m-d G:i:s', time());

        $this->db->select('cart_combo_offer.id,cart_combo_offer.offer_price,cart_combo_offer.discount,cart_combo_offer.actual_price,cart_combo_offer.image,cart_combo_offer.caption,cart_combo_offer.description,cart_combo_offer.offer_end');
        $this->db->from('cart_combo_offer');
        $this->db->where('cart_combo_offer.offer_start <=', $date);
        $this->db->where('cart_combo_offer.offer_end >=', $date);
        $this->db->where('cart_combo_offer.id', $id);
        $this->db->order_by('cart_combo_offer.id','ASC');
        $query = $this->db->get();

        $categories=$query->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['items'] = $this->getOfferDetailsDataSub($p_cat['id']);

            $i++;
        }
        
        return $categories;    
    }

    public function getOfferDetailsDataSub($id='') {

        $this->db->select('cart_stock.id,cart_stock.stock_name,cart_stock.discount,cart_stock.stock,cart_product_image.image as product_image,cart_stock.status');
        $this->db->from('cart_combo_products');
        $this->db->join('cart_stock', 'cart_combo_products.stock_id = cart_stock.id');
        $this->db->join('cart_product_image', 'cart_stock.id = cart_product_image.stock_id');
        $this->db->where('cart_combo_products.deal_id',$id);
        $this->db->group_by('cart_product_image.stock_id','ASC');
        $query = $this->db->get();


        $result = $query->result_array();
      
        return $result;

    }
    
    public function getOtherOfferData($id='') {

        $date = date('Y-m-d G:i:s', time());

        $this->db->select('cart_combo_offer.id,cart_combo_offer.offer_price,cart_combo_offer.actual_price,cart_combo_offer.discount,cart_combo_offer.image,cart_combo_offer.caption');
        $this->db->from('cart_combo_offer');
        $this->db->where('cart_combo_offer.offer_start <=', $date);
        $this->db->where('cart_combo_offer.offer_end >=', $date);
        $this->db->where_not_in('cart_combo_offer.id', $id);
        $this->db->order_by('cart_combo_offer.id','DESC');
        $this->db->limit(6);
        $query = $this->db->get();

        $categories=$query->result();

        return $categories;

    }

    public function getBannerData() { 

        $this->db->select('id,banner_name,image');
        $this->db->from('cart_banner');
         $this->db->order_by('id','DESC');
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getBestCategoryData() { 

        $this->db->select('cart_category.cat_id,cart_category.cat_name,cart_category.image');
        $this->db->from('cart_category');
        $this->db->where('cart_category.menu_cat_status',1);
        $this->db->where('cart_category.status',1);
        $this->db->order_by('rand()');
        $this->db->limit(9);
        $query = $this->db->get();

        $categories = $query->result();

        return $categories;

    }

    public function getBestDealDataList() {

        if ($this->session->has_userdata('storeLoc')) {

            $store_name=$this->session->userdata('storeLoc');

            $store_cond="AND z.reg_id = $store_name->id";   

        } else {

            $store_cond="AND z.reg_id = 1";   
        }
    
        $parent = $this->db->query("SELECT cart_stock.id,cart_stock.price,cart_stock.list_price,cart_stock.discount,cart_stock.stock,cart_stock.stock_name
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        WHERE cart_stock.status=1
        $store_cond 
        ORDER BY RAND()
        LIMIT 10");

        $categories = $parent->result_array();

        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]['image_name'] = $this->getSingleImageSub($p_cat['id']);

            $i++;
        }
        
        return $categories;    
    }

    public function getSingleImageSub($id='') {

        $this->db->select('cart_product_image.image');
        $this->db->from('cart_product_image');
        $this->db->where('cart_product_image.stock_id',$id);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $result = $query->result_array()[0]['image'];

            return $result;
        }

        else {

            $result = 'no image';

            return $result;
        }

    }

    public function getCatProductListByArea($latitude='',$longitude='',$radius='') {

        $query = $this->db->query("SELECT MAX(cart_stock.discount) as discount,z.cat_id,cart_category.cat_name
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        WHERE cart_stock.status=1 
        GROUP BY cat_id
        ORDER BY rand(),discount DESC
        LIMIT 1");

        $categories = $query->result_array();

        return $categories;    
    }
    
    public function getRecentlyVisitData($user_id='') {

        if ($this->session->has_userdata('storeLoc')) {

            $store_name=$this->session->userdata('storeLoc');

            $store_cond="AND z.reg_id = $store_name->id";   

        } else {

            $store_cond="AND z.reg_id = 1";   
        }
    
        $parent = $this->db->query("SELECT cart_stock.id,cart_stock.price,cart_stock.list_price,cart_stock.discount,cart_stock.stock,cart_stock.stock_name,cart_stock.url_slug,z.cat_id,cart_category.cat_name, z.description
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_recently_view ON cart_stock.id=cart_recently_view.stock_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        WHERE cart_stock.status=1 
        AND cart_recently_view.user_id = $user_id 
        $store_cond
        ORDER BY cart_recently_view.id DESC LIMIT 10");

        $categories = $parent->result_array();

        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]['image_name'] = $this->getSingleImageSub($p_cat['id']);

            $i++;
        }
        
        return $categories;    
    }

    public function getOurItemsData() {

        if ($this->session->has_userdata('storeLoc')) {

            $store_name=$this->session->userdata('storeLoc');

            $store_cond="AND z.reg_id = $store_name->id";   

        } else {

            $store_cond="AND z.reg_id = 1";   
        }

        $parent = $this->db->query("SELECT cart_stock.id,cart_stock.price,cart_stock.list_price,cart_stock.discount,cart_stock.stock,cart_stock.stock_name,cart_stock.url_slug,z.cat_id,cart_category.cat_name, z.description
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        WHERE cart_stock.status=1
        AND cart_category.cat_id IN(6,7,17,19,20)
        $store_cond  
        ORDER BY id ASC LIMIT 12");

        $categories = $parent->result_array();

        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]['image_name'] = $this->getSingleImageSub($p_cat['id']);

            $i++;
        }
        
        return $categories;    
    }

    public function getTopSellingData($cat_id='') {

        if( !empty($cat_id) ) {

            $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

            $result = $query->result();

            $category= array();
        
            $f=0;

            foreach ($result as $row) {

                $category[$f]=$row->cat_id;

                $f++;
            }

            array_unshift($category,$cat_id);

            $comma_list = implode(",", $category);

            $cat_condition="AND cart_category.cat_id IN($comma_list)";
        }
        else
        {
            $cat_condition="";
        }

        if ($this->session->has_userdata('storeLoc')) {

            $store_name=$this->session->userdata('storeLoc');

            $store_cond="AND z.reg_id = $store_name->id";   

        } else {

            $store_cond="AND z.reg_id = 1";   
        }
    
        $parent = $this->db->query("SELECT cart_stock.id,cart_stock.price,cart_stock.list_price,cart_stock.discount,cart_stock.stock,cart_stock.stock_name,cart_stock.url_slug,z.cat_id,cart_category.cat_name, z.description
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        WHERE cart_stock.status=1 
        $cat_condition
        $store_cond
        ORDER BY discount DESC LIMIT 10");

        $categories = $parent->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['image_name'] = $this->getSingleImageSub($p_cat['id']);

            $i++;
        }
        
        return $categories;    
    }

    public function getBestComboList()
    {
        $date = date('Y-m-d G:i:s', time());

        $this->db->select('cart_combo_offer.id,cart_combo_offer.image,cart_combo_offer.caption');
        $this->db->from('cart_combo_offer');
        $this->db->join('cart_combo_products', 'cart_combo_offer.id = cart_combo_products.deal_id');
        $this->db->where('cart_combo_offer.offer_start <=', $date);
        $this->db->where('cart_combo_offer.offer_end >=', $date);
        $this->db->order_by('cart_combo_offer.id','DESC');
        $this->db->limit(6);
        $query = $this->db->get();

        $categories=$query->result();

        return $categories;

    }

    public function getAllProductCategoryWise($cat_id='',$min_price='',$max_price='',$st_name='',$feature='',$option='')
    {

        $conditions = array();

        if(!empty($st_name)){

            $conditions[] = 'z.product_name  LIKE "%' . $st_name . '%"';
            $conditions[] = 'cart_category.cat_name  LIKE "%' . $st_name . '%"';
            $conditions[] = 'cart_stock.stock_name  LIKE "%' . $st_name . '%"';

            $sqlStatement = 'AND '. implode(' OR ', $conditions);
        }
            else {

                $sqlStatement = "";
        }

        if( !empty($cat_id) ) {

            $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

            $result = $query->result();

            $category= array();
            
            $f=0;
            foreach ($result as $row) {

               $category[$f]=$row->cat_id;

               $f++;
            }

            array_unshift($category,$cat_id);

            $comma_list = implode(",", $category);

            $cat_condition="AND z.cat_id IN($comma_list)";

        }
        else
        {
            $cat_condition="";
        }

        if( !empty($option) && !empty($feature) )
        {
            $option = implode(',', $option);
            $feature = implode(',', $feature);

            $cond=" JOIN cart_stock_option ON cart_stock.id=cart_stock_option.comb_id INNER JOIN cart_stock_feature ON z.id=cart_stock_feature.product_id WHERE cart_stock_option.option_id in ($option) AND cart_stock_feature.feature_id in ($feature) AND";
        }

        else if(!empty($option))
        {
            $option = implode(',', $option);

            $cond="JOIN cart_stock_option ON cart_stock.id=cart_stock_option.comb_id WHERE cart_stock_option.option_id in ($option) AND";

        }
           
        else if(!empty($feature))
        {
            $feature = implode(',', $feature);


            $cond="JOIN cart_stock_feature ON z.id=cart_stock_feature.product_id WHERE cart_stock_feature.feature_id in ($feature) AND";
        }

        else
        {
            $cond='WHERE'; 
        }



        $parent = $this->db->query("SELECT cart_stock.id,z.cat_id,z.id as product_id,cart_stock.price,cart_stock.list_price,cart_stock.stock_name,cart_stock.url_slug,cart_stock.discount,cart_stock.stock,z.description
        FROM cart_product AS z  
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        $cond
        cart_stock.status=1 
        $cat_condition
        $sqlStatement
        ORDER BY cart_stock.id");

        $categories = $parent->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['image_name'] = $this->getSingleImageSub($p_cat['id']);

            $i++;
        }
                
        return $categories;   
    }

    public function getProductDetailsById($id='') {
        
        $this->db->select('cart_stock.id,cart_stock.stock_name,cart_stock.stock,cart_stock.price,cart_stock.list_price,cart_stock.discount,cart_product.id as product_id,cart_product.cat_id,cart_product.description,cart_product.warranty');
        $this->db->from('cart_stock');
        $this->db->join('cart_product', 'cart_stock.product_id = cart_product.id');
        $this->db->where('cart_stock.id',$id);

        $parent = $this->db->get();

        $categories = $parent->result_array();

        $i=0;

        foreach($categories as $p_cat) {

            $categories[$i]['feature_name'] = $this->getProductWiseFeatureSub($p_cat['product_id']);

            $categories[$i]['option_name'] = $this->getProductWiseOptionSub($p_cat['id'],$p_cat['product_id']);

            $categories[$i]['highlights'] = $this->getProductIdWiseHighlightSub($p_cat['product_id']);

            $categories[$i]['image_name'] = $this->getAllImageSub($p_cat['id']);

            // $categories[$i]->rating_product = $this->getProductIdWiseRatingSub($p_cat->id);

            // $categories[$i]->rate = $this->getProductRategrpSub($p_cat->id,$user_id);

            // $categories[$i]->like_product = $this->getProductIdWiseLikeSub($p_cat->id,$user_id);

            // $categories[$i]->option_name = $this->getProductIdWiseListOptionSub($p_cat->id,$p_cat->product_id,$id);
            //  //$categories[$i]->option_name = $this->getProductIdWiseListOptionSub($p_cat->id);

            // $categories[$i]->selected_option_name = $this->getSelectedWiseListOptionSub($p_cat->id);

            $i++;
        }

        return $categories;

    }

    public function getProductWiseOptionSub($id='',$product_id='') {

        $this->db->select("options_type.opt_id,cart_stock_option.option_id,options.name");
        $this->db->from('cart_stock');
        $this->db->join('cart_stock_option', 'cart_stock.id = cart_stock_option.comb_id');
        $this->db->join('options_type', 'cart_stock_option.option_id = options_type.opt_var_id');
        $this->db->join('options', 'options_type.opt_id = options.option_id');
        $this->db->where('cart_stock.product_id',$product_id);
        $this->db->group_by('options_type.opt_id');

        $parent = $this->db->get();

        $categories = $parent->result_array();

        $i=0;

        foreach($categories as $p_cat) {

            $categories[$i]['option_varriant'] = $this->getOptionWiseVariantSub($p_cat['opt_id'],$product_id,$id);

            $i++;
        }
        
        return $categories;
    }

    public function getOptionWiseVariantSub($opt_id='',$product_id,$id)
    {
        $this->db->select('IF(cart_stock.id='.$id.',"1", 0) "status",cart_stock.id as stock_id,cart_stock.stock_name,options_type.opt_id,options_type.opt_var_id,options_type.type_name,options_type.color_name');
        $this->db->from('cart_product');
        $this->db->join('cart_stock', 'cart_product.id = cart_stock.product_id');
        $this->db->join('cart_stock_option', 'cart_stock.id = cart_stock_option.comb_id');
        $this->db->join('options_type', 'cart_stock_option.option_id = options_type.opt_var_id');
        $this->db->where('options_type.opt_id',$opt_id);
        $this->db->where('cart_stock.product_id',$product_id);
        $this->db->order_by('type_name','ASC');
        $this->db->group_by('options_type.opt_var_id');
        $query = $this->db->get();

        $categories=$query->result_array();

        return $categories;

    }

    // public function getProductWiseOptionSub($id='') {
   
    //     $this->db->select('options.option_id as id,cart_stock_option.option_id,options.name');
    //     $this->db->from('cart_stock_option');
    //     $this->db->join('options_type', 'cart_stock_option.option_id = options_type.opt_var_id');
    //     $this->db->join('options', 'options_type.opt_id = options.option_id');
    //     $this->db->where('cart_stock_option.comb_id',$id);
    //     $this->db->group_by('options.option_id');
    //     $parent = $this->db->get();

    //     $categories = $parent->result_array();

    //     $i=0;

    //     foreach($categories as $p_cat) {

    //         $categories[$i]['option_varriant'] = $this->getOptionWiseVariantSub($p_cat['id'],$id);

    //         $i++;
    //     }
        
    //     return $categories;
    // }



    //  public function getOptionWiseVariantSub($option_id='',$id='') {

    //    $this->db->select('options_type.opt_var_id,options_type.type_name,options_type.color_name');
    //     $this->db->from('cart_stock_option');
    //     $this->db->join('options_type', 'cart_stock_option.option_id = options_type.opt_var_id');
    //     $this->db->where('options_type.opt_id',$option_id);
    //     $this->db->where('cart_stock_option.comb_id',$id);

    //     $parent = $this->db->get();

    //     $categories=$parent->result_array();

    //      return $categories;

    // }

    public function getProductWiseFeatureSub($id='') {
   
        $this->db->select('cart_feature_group.group_name,cart_feature.id,cart_feature.name,cart_stock_feature.feature_id');
        $this->db->from('cart_stock_feature');
        $this->db->join('cart_feature_variant', 'cart_stock_feature.feature_id = cart_feature_variant.f_var_id');
        $this->db->join('cart_feature', 'cart_feature_variant.f_id = cart_feature.id');
        $this->db->join('cart_feature_group', 'cart_feature.f_grp_id = cart_feature_group.grp_id');
        $this->db->where('cart_stock_feature.product_id',$id);

        $parent = $this->db->get();

        $categories = $parent->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['feature_varriant'] = $this->getFeatureWiseVariantSub($p_cat['feature_id']);

            $i++;
        }
        
        return $categories;

    }

    public function getFeatureWiseVariantSub($id='') {

        $this->db->select('cart_feature_variant.variants_name');
        $this->db->from('cart_feature_variant');
        $this->db->where('cart_feature_variant.f_var_id',$id);
        $this->db->order_by('cart_feature_variant.variants_name','ASC');
        $query = $this->db->get();

        return $query->result_array();
          
    }


    public function getProductIdWiseHighlightSub($id='') {

        $this->db->select('cart_highlights.highlights');
        $this->db->from('cart_highlights');
        $this->db->where('cart_highlights.product_id',$id);
        $this->db->order_by('cart_highlights.id','desc');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getAllImageSub($id='') {

        $this->db->select('cart_product_image.image');
        $this->db->from('cart_product_image');
        $this->db->where('cart_product_image.stock_id',$id);

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $result = $query->result_array();

            return $result;

        }

        else{

            $result = 'no image';

            return $result;
        }


    }

    public function getProductFilterCategoryList($cat_id='',$min_price='',$max_price='',$st_name='')
    {

        $conditions = array();

        if(!empty($st_name)){

            $conditions[] = 'z.product_name  LIKE "%' . $st_name . '%"';
            $conditions[] = 'cart_category.cat_name  LIKE "%' . $st_name . '%"';
            $conditions[] = 'cart_stock.stock_name  LIKE "%' . $st_name . '%"';

            $sqlStatement = 'AND '. implode(' OR ', $conditions);
        }
        else{

            $sqlStatement = "";
        }

        if( !empty($cat_id) ) {

            $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

            $result = $query->result();

            $category= array();
            
            $f=0;

            foreach ($result as $rows) {

                $category[$f]=$rows->cat_id;

                $f++;
            }

            array_unshift($category,$cat_id);

            $comma_list = implode(",", $category);

            $cat_condition="AND z.cat_id IN($comma_list)";

        }
        else
        {
            $cat_condition="";
        }

        if( !empty($min_price) && !empty($max_price) )
        {

            $cond="AND cart_stock.list_price BETWEEN $min_price AND $max_price";
        }
        else
        {
            $cond=""; 
        }
      
        $parent = $this->db->query("SELECT z.cat_id,cart_category.display_name as cat_name
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        WHERE cart_stock.status=1 
        $cat_condition
        $cond
        $sqlStatement
        GROUP BY cart_category.cat_id
        ORDER BY cat_name ASC LIMIT 6");

        $res = $parent->result();

        return $res;
    }

        //filter list
    public function getProductFeatureList($cat_id='',$min_price='',$max_price='',$st_name='')
    {

        $conditions = array();

        if(!empty($st_name)){

            $conditions[] = 'z.product_name  LIKE "%' . $st_name . '%"';
            $conditions[] = 'cart_category.cat_name  LIKE "%' . $st_name . '%"';
            $conditions[] = 'cart_stock.stock_name  LIKE "%' . $st_name . '%"';

            $sqlStatement = 'AND '. implode(' OR ', $conditions);
        }
        else{

            $sqlStatement = "";
        }

        if( !empty($cat_id) ) {

            $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

            $result = $query->result();

            $category= array();
            
            $f=0;
            foreach ($result as $rows) {


               $category[$f]=$rows->cat_id;

               $f++;
            }

            array_unshift($category,$cat_id);

            $comma_list = implode(",", $category);

            $cat_condition="AND z.cat_id IN($comma_list)";

        }
        else
        {
            $cat_condition="";
        }

        if( !empty($min_price) && !empty($max_price) )
        {

            $cond="AND cart_stock.list_price BETWEEN $min_price AND $max_price";
        }
        else
        {
            $cond=""; 
        }
      
        $query = $this->db->query("SELECT cart_stock_feature.feature_id,cart_feature.id,cart_feature.display_name as name
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_stock_feature ON z.id=cart_stock_feature.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        JOIN cart_feature_variant ON cart_stock_feature.feature_id=cart_feature_variant.f_var_id
        JOIN cart_feature ON cart_feature_variant.f_id=cart_feature.id
        WHERE cart_stock.status=1 
        $cat_condition
        $cond
        $sqlStatement
        GROUP BY cart_feature.id
        ORDER BY name ASC");

        $categories = $query->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['feature_var'] = $this->getFilterFeatureVarSub($p_cat['id']);

            $i++;
        }
        
        return $categories; 

    }

    public function getFilterFeatureVarSub($id)
    {
        $parent = $this->db->query("SELECT cart_feature_variant.f_var_id,cart_feature_variant.variants_name
        FROM cart_stock_feature  
        JOIN cart_feature_variant ON cart_stock_feature.feature_id=cart_feature_variant.f_var_id
        WHERE cart_feature_variant.f_id = $id 
        GROUP BY cart_feature_variant.f_var_id
        ORDER BY cart_feature_variant.variants_name ASC");

        $categories = $parent->result_array();

        return $categories; 
    }

    public function getProductFilterPriceList($cat_id='',$min_price='',$max_price='',$search='') {

        if( !empty($cat_id) ) {

            $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

            $result = $query->result();

            $category= array();
            
            $f=0;
            foreach ($result as $rows) {


               $category[$f]=$rows->cat_id;

               $f++;
            }

            array_unshift($category,$cat_id);

            $comma_list = implode(",", $category);

            $cat_condition="AND z.cat_id IN($comma_list)";

        }
        else
        {
            $cat_condition="";
        }

        if( !empty($min_price) && !empty($max_price) )
        {

            $cond="AND cart_stock.list_price BETWEEN $min_price AND $max_price";
        }
        else
        {
            $cond=""; 
        }
   
        $parent = $this->db->query("SELECT MIN(cart_stock.list_price) AS SmallestPrice,MAX(cart_stock.list_price) AS LargestPrice
        FROM cart_product AS z
        INNER JOIN cart_stock ON z.id=cart_stock.product_id
        WHERE cart_stock.status=1 
        $cat_condition
        $cond");

        $res = $parent->result();

        return $res;
    }

    public function getSearchKeyword($search='') {

        $this->db->select('cart_stock.id,cart_stock.stock_name,cart_stock.price,cart_stock.list_price,cart_stock.stock,cart_stock.discount,cart_stock.status,z.id as product_id,z.cat_id,z.product_name,cart_category.cat_name');
        $this->db->from('cart_product as z');
        $this->db->join('cart_stock', 'z.id = cart_stock.product_id');
        $this->db->join('cart_category', 'z.cat_id = cart_category.cat_id');
        $this->db->where('cart_stock.status',1);
        
        if($search!='') {

        $this->db->where('cart_stock.status',1);
        $this->db->like('z.product_name',$search);
        $this->db->or_like('cart_stock.stock_name',$search);
        $this->db->or_like('cart_category.cat_name',$search);

            // if ($this->session->has_userdata('storeLoc')) {

            //     $store_name=$this->session->userdata('storeLoc');

            //     $this->db->where('z.reg_id',$store_name->id);   

            // } else {

            //     $this->db->where('z.reg_id',1);   
            // }

        }

        // if ($this->session->has_userdata('storeLoc')) {

        //     $store_name=$this->session->userdata('storeLoc');

        //     $this->db->where('z.reg_id',$store_name->id);   

        // } else {

        //     $this->db->where('z.reg_id',1);   
        // }

        $this->db->group_by('z.id');
        $query = $this->db->get();

        $categories = $query->result_array();

        return $categories;
    }

    public function getProductOptionList($cat_id='',$min_price='',$max_price='',$search='')
    {

        if( !empty($cat_id) ) {

            $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

            $result = $query->result();

            $category= array();
            
            $f=0;
            foreach ($result as $rows) {


               $category[$f]=$rows->cat_id;

               $f++;
            }

            array_unshift($category,$cat_id);

            $comma_list = implode(",", $category);

            $cat_condition="AND z.cat_id IN($comma_list)";

        }
        else
        {
            $cat_condition="";
        }

        if( !empty($min_price) && !empty($max_price) )
        {

            $cond="AND cart_stock.list_price BETWEEN $min_price AND $max_price";
        }
        else
        {
            $cond=""; 
        }
      
        $query = $this->db->query("SELECT options.option_id,options.name
        
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        JOIN cart_stock_option ON cart_stock.id=cart_stock_option.comb_id
        JOIN options_type ON cart_stock_option.option_id=options_type.opt_var_id
        JOIN options ON options_type.opt_id=options.option_id
        WHERE cart_stock.status=1 
        $cat_condition
        $cond
        GROUP BY options.option_id
        ORDER BY name ASC");

        $categories = $query->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['option_var'] = $this->getFilterOptionVarSub($p_cat['option_id']);

            $i++;
        }

        return $categories;  

    }

    public function getFilterOptionVarSub($id)
    {
        $parent = $this->db->query("SELECT cart_stock_option.comb_id,options_type.opt_var_id,options_type.type_name,options_type.color_name
        FROM cart_stock_option  
        JOIN options_type ON cart_stock_option.option_id=options_type.opt_var_id
        WHERE options_type.opt_id = $id 
        GROUP BY options_type.opt_var_id
        ORDER BY options_type.type_name ASC LIMIT 5");

        $categories = $parent->result_array();

        return $categories; 
    }
    
    public function getProductSimilar($cat_id='') {

        if(!empty($cat_id) ) {

            $query =$this->db->query("SELECT p6.parent_id as parent6_id, p5.parent_id as parent5_id, p4.parent_id as parent4_id, p3.parent_id as parent3_id, p2.parent_id as parent2_id, p1.parent_id as parent_id, p1.cat_id as cat_id, p1.cat_name from cart_category p1 left join cart_category p2 on p2.cat_id = p1.parent_id left join cart_category p3 on p3.cat_id= p2.parent_id left join cart_category p4 on p4.cat_id= p3.parent_id left join cart_category p5 on p5.cat_id= p4.parent_id left join cart_category p6 on p6.cat_id =p5.parent_id where $cat_id in (p1.parent_id, p2.parent_id, p3.parent_id, p4.parent_id, p5.parent_id, p6.parent_id) order by 1, 2, 3, 4, 5");

            $result = $query->result();

            $category= array();
        
            $f=0;

            foreach ($result as $row) {

                $category[$f]=$row->cat_id;

                $f++;
            }

            array_unshift($category,$cat_id);

            $comma_list = implode(",", $category);

            $cat_condition="AND cart_category.cat_id IN($comma_list)";
        }
        else
        {
            $cat_condition="";
        }

        $parent = $this->db->query("SELECT cart_stock.id,cart_stock.price,cart_stock.list_price,cart_stock.discount,cart_stock.stock,cart_stock.stock_name,cart_stock.url_slug,z.cat_id,cart_category.cat_name, z.description
        FROM cart_product AS z
        JOIN cart_stock ON z.id=cart_stock.product_id
        JOIN cart_category ON z.cat_id=cart_category.cat_id
        WHERE cart_stock.status=1 
        $cat_condition
        ORDER BY discount DESC LIMIT 10");

        $categories = $parent->result_array();

        $i=0;
        
        foreach($categories as $p_cat){

            $categories[$i]['image_name'] = $this->getSingleImageSub($p_cat['id']);

            $i++;
        }
        
        return $categories;    
    }
    
    public function putSubscriber($mail='') {

        $value= array('mail' => $mail,'created_at' => date("Y-m-d H:i:s"));


        $this->db->insert('subscribe', $value);

        return true;


    }
    
    public function putProductRecentlyView($user_id='',$stock_id='') {

        $data= array('user_id' => $user_id,'stock_id' => $stock_id);

        if(!array_key_exists('date', $data)){
            $data['viewdate'] = date("Y-m-d H:i:s");
        }

        $this->db->where('user_id',$user_id);
        $this->db->where('stock_id',$stock_id);
        $query = $this->db->get('cart_recently_view');

        if ($query->num_rows() >= 1){

            $this->db->where('user_id',$user_id);
            $this->db->where('stock_id',$stock_id);
            $this->db->update('cart_recently_view',$data);
        }
        else {

            $this->db->insert('cart_recently_view', $data);
        }

        return TRUE;

    }
    
    public function getStoreData($id='') {

        $this->db->select('store.id,store.map,store.location,store.address,store.phone,store.email,store.image,store.og_image,store.description');
        $this->db->from('store');
        if ($id != '')
        $this->db->where('store.id', $id);
        $query = $this->db->get();

        return $query->result();

    }
 

}