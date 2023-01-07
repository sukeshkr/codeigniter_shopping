<?php

Class Product_model extends MY_model {

    

    public function __construct() {

        parent::__construct();
        $this->load->database();
        $this->session_data=$this->session->userdata('userDetails'); 
    }

    var $table = 'cart_product';

    var $column_order = array('product_name','stock',null); //set column field database for datatable orderable

    var $column_search = array('product_name','stock'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('id' => 'desc');


    private function get_datatables_query()
    {
        $this->db->select('cart_product.id,cart_product.product_name,cart_product.cat_id,cart_category.cat_name,cart_product.status');
        $this->db->from($this->table);
        $this->db->join('cart_category', 'cart_product.cat_id = cart_category.cat_id');
        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
        if($_POST['search']['value']) // if datatable send POST for search
        {
        if($i===0) // first loop
        {
        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
        $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
        }
        $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
        $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function get_datatables() {

        $this->get_datatables_query();

        if($_POST['length'] != -1)

        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result_array();
    }



    public function count_filtered() {

        $this->get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {

        $this->db->from($this->table);
        //$this->db->where('parent_id',0);
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {

        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    //json load view end //


    public function insertCartProduct($value,$highlights='') { 

        $this->db->insert('cart_product', $value);

        $insert_id = $this->db->insert_id();

        foreach($highlights as $highlight) {

            $value_highlight = array('product_id' => $insert_id,'highlights' => $highlight);

            $this->db->insert('cart_highlights', $value_highlight);
        }

        $affected_ids[] = $insert_id;

        return $affected_ids;

    }

    public function insertCartStock($value,$multi_image='',$product_id='') { 

        $product_id = explode(",",$product_id);

        foreach($product_id as $product_ids) {

            $value['product_id']  = $product_ids;

            $pro_value  = array('status' => 1);

            $this->db->insert('cart_stock', $value);

            $insert_id = $this->db->insert_id();
         
            foreach($multi_image as $multi_images) 
            {
              $value_image= array('stock_id' => $insert_id,'image' => $multi_images);

                $this->db->insert('cart_product_image', $value_image);
            }

            $this->db->update($this->table, $pro_value, array('id'=>$product_ids));

        }

        return true;
    }

    public function getShopWiseCategory($parent = 0, $spacing = '', $category_tree_array = '')
    {

        if (!is_array($category_tree_array))
            $category_tree_array = array();

        $this->db->from('cart_category');
        $this->db->where('parent_id', $parent);
        $this->db->order_by('cat_id','asc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {


            foreach($query->result_array() as $rowCategories){

            
                $category_tree_array[] = array("cat_id" => $rowCategories['cat_id'], "cat_name" => $spacing . $rowCategories['cat_name']);
                $category_tree_array = $this->getShopWiseCategory($rowCategories['cat_id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
            }
        }

        return $category_tree_array;
    }

  //   public function getShopWiseCategory($seller_id='',$parent = 0, $spacing = '', $category_tree_array = '')
  //   {

  //       if (!is_array($category_tree_array))
  //           $category_tree_array = array();

  //           $this->db->select('shop_type_category.cat_id,cart_category.cat_name,cart_category.display_name,cart_category.parent_id,cart_category.image,cart_category.cat_icon,shop_type_category.cat_parent,shop_type_category.shop_type');
  //           $this->db->from('register');
  //           $this->db->join('shop_type_category', 'register.bus_category = shop_type_category.shop_type');
  //           $this->db->join('cart_category', 'shop_type_category.cat_id = cart_category.cat_id');
  //           $this->db->where('shop_type_category.parent',$parent);
  //           $this->db->where('register.reg_id',$seller_id);
  //           $this->db->order_by('cart_category.cat_id','asc');
  //           $query = $this->db->get();



  //       if ($query->num_rows() > 0) {


  //         foreach($query->result_array() as $rowCategories){

            
  //               $category_tree_array[] = array("cat_id" => $rowCategories['cat_id'], "cat_name" => $spacing . $rowCategories['cat_name'],"display_name" => $rowCategories['display_name']);
  //               $category_tree_array = $this->getShopWiseCategory($seller_id='',$rowCategories['cat_id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
  //           }
  //       }

  //       return $category_tree_array;
  // }


  // public function getShopWiseCategory($seller_id="",$parent = 0, $spacing = '', $category_tree_array = '')
  // {

  //   if (!is_array($category_tree_array))
  //       $category_tree_array = array();

  //       $this->db->select('register.reg_id,shop_type_category.cat_id,cart_category.cat_name,cart_category.display_name,cart_category.parent_id,cart_category.image,cart_category.cat_icon,shop_type_category.cat_parent,shop_type_category.shop_type');
  //       $this->db->from('register');
  //       $this->db->join('shop_type_category', 'register.bus_category = shop_type_category.shop_type');
  //       $this->db->join('cart_category', 'shop_type_category.cat_id = cart_category.cat_id');
  //       $this->db->where('shop_type_category.cat_parent', $parent);
  //       $this->db->where('register.reg_id',$seller_id);
  //       $this->db->order_by('cart_category.cat_id','asc');

  //     $query = $this->db->get();



  //   if ($query->num_rows() > 0) {


  //     foreach($query->result_array() as $rowCategories){

        
  //           $category_tree_array[] = array("cat_id" => $rowCategories['cat_id'], "display_name" => $spacing . $rowCategories['display_name']);
  //           $category_tree_array = $this->getShopWiseCategory($rowCategories['reg_id'],$rowCategories['cat_id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
  //       }
  //   }
  //   return $category_tree_array;
  // }

    public function getFeatureProduct($id)
    {
        $this->db->select('cart_feature.id,cat_id,name,go_to_variant,cart_feature_group.grp_id,cart_feature_group.group_name');
        $this->db->from('cart_feature');
        $this->db->join('cart_features_category', 'cart_feature.id = cart_features_category.feature_id');
        $this->db->join('cart_feature_group', 'cart_feature.f_grp_id = cart_feature_group.grp_id');
        $this->db->where('cart_features_category.cat_id',$id);
        $this->db->order_by('cart_feature.id','desc');
        $query = $this->db->get();
      
        $categories=$query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->form="feature";

            $categories[$i]->sub = $this->getFeaturetSub($p_cat->id);

            $i++;
        }

        return $categories;

    }
    public function getFeaturetSub($id)
    {
        $this->db->select('cart_feature_variant.f_var_id as var_id,cart_feature_variant.variants_name as var_name');
        $this->db->from('cart_feature_variant');
        $this->db->where('cart_feature_variant.f_id',$id);
        $this->db->order_by('cart_feature_variant.variants_name','ASC');
        $query = $this->db->get();
      
        return $query->result();

    }

    public function getOptionProduct($id)
    {
        $this->db->select('options.option_id as id,cat_id,name,go_to_variant');
        $this->db->from('options');
        $this->db->join('cart_option_category', 'options.option_id = cart_option_category.opt_id');
        $this->db->where('cart_option_category.cat_id',$id);
        $this->db->order_by('options.option_id','desc');
        $query = $this->db->get();

        $categories=$query->result();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]->form="option";

            $categories[$i]->sub = $this->getOptionProductSub($p_cat->id);

            $i++;
        }

        return $categories;
    }

    public function getOptionProductSub($id)
    {
        $this->db->select('options_type.opt_var_id as var_id,options_type.type_name as var_name,color_name');
        $this->db->from('options_type');
        $this->db->where('options_type.opt_id',$id);
        $this->db->order_by('var_name','ASC');
        $query = $this->db->get();

        $categories=$query->result();

        return $categories;
    }

    public function getStockData($id='')
    {
        $this->db->from('cart_stock');

        if ($id != '')

        $this->db->where('product_id', $id);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        $categories=$query->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['image'] = $this->getStockDataImageSub($p_cat['id']);

            $i++;
        }

        return $categories;
    }

    public function getStockDataImageSub($id='') {
   
        $this->db->select("cart_product_image.image");
        $this->db->from('cart_product_image');
        $this->db->where('cart_product_image.stock_id',$id);
        $this->db->order_by('cart_product_image.id','ASC');
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {

            $image=$query->result_array()[0]['image'];

            return $image;
        }
        else{

            return "no image";

        }

    }

    public function getHighlights($id='')
    {
        $this->db->from("cart_highlights");
        $this->db->where('product_id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProductData($id='')
    {
        $this->db->from($this->table);
        if ($id != '')

        $this->db->where('id', $id);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateCartProduct($id='',$value='',$highlights='')
    {

        $update = $this->db->update($this->table, $value, array('id'=>$id));

        if($highlights) {

            $this->db->where('product_id',$id);
            $this->db->delete('cart_highlights');  
                
            foreach($highlights as $highlight)  {

                $value_category= array('product_id' => $id,'highlights' => $highlight);

                $this->db->insert('cart_highlights', $value_category);
            }

            // if(!empty($feature[0])) {

            //     foreach($feature as $features) {
                      
            //         $value_feature= array('product_id' => $product_id,'feature_id' => $features);

            //         $this->db->insert('cart_stock_feature', $value_feature);
            //     }
  
            // }

        }

    }



    public function deleteProduct($id)
    {
     
       $this->db->where('id',$id);
       $this->db->delete('cart_product');

       $this->db->where('product_id',$id);
       $this->db->delete('cart_highlights');

       $this->db->where('product_id',$id);
       $this->db->delete('cart_stock'); 

       $this->db->where('product_id',$id);
       $this->db->delete('cart_stock_feature');    

    }

    public function deleteSelectedStock($id)
    {
     
       $this->db->where('id',$id);
       $this->db->delete('cart_stock');  

    }

    public function deleteSpecificationsData($id) {
        
        $this->db->delete('cart_highlights', array('id' => $id));

    }

    public function deleteImage($id) {
        
        $this->db->delete('cart_product_image', array('id' => $id));

    }

    /////////////////////////////////////////////////////////

    public function getEditStockData($id='')
    {
        $this->db->select('cart_stock.id,cart_stock.product_id,cart_stock.stock_name,cart_stock.stock,cart_stock.price,cart_stock.list_price,cart_stock.discount');
        $this->db->from('cart_stock');

        if ($id != '')

        $this->db->where('id', $id);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        $categories=$query->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['image'] = $this->getAllStockImageSub($p_cat['id']);
            $categories[$i]['option'] = $this->getStockOptionSub($p_cat['id']);

            $i++;
        }

        return $categories;
    }

    public function getStockOptionSub($id)
    {
        $this->db->select('options_type.opt_var_id as var_id,options_type.type_name as var_name,color_name');
        $this->db->from('cart_stock_option');
        $this->db->join('options_type', 'cart_stock_option.option_id = options_type.opt_var_id');
        $this->db->where('cart_stock_option.comb_id',$id);
        $this->db->order_by('options_type.type_name','ASC');
        $query = $this->db->get();
      
        return $query->result();

    }

    public function getAllStockImageSub($id='') {
   
        $this->db->select("cart_product_image.id,cart_product_image.image");
        $this->db->from('cart_product_image');
        $this->db->where('cart_product_image.stock_id',$id);
        $this->db->order_by('cart_product_image.id','ASC');
        $query = $this->db->get();

        $result=$query->result_array();

        return $result;

    }

    public function updateStock($id,$product_id,$value,$multi_image) { 

        $this->db->where('id',$id);
        $this->db->update('cart_stock',$value);

        if(!empty($multi_image)) {
         
            foreach($multi_image as $multi_images) 
            {
                $value_image= array('stock_id' => $id,'image' => $multi_images);

                $this->db->insert('cart_product_image', $value_image);
            }

        }

        return $insert_id;

    }
    
    public function setProductStatus($id='',$status='') {

        $value = array('status' => $status);

        $this->db->where('id',$id);
        $this->db->update($this->table,$value);

        $this->db->where('product_id',$id);
        $this->db->update('cart_stock',$value);

    }

    public function getStore($id='') {

        $this->db->from("store");
        $query = $this->db->get();
        return $query->result_array();
    }
     
 


}

?>