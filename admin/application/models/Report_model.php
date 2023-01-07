<?php

Class Report_model extends MY_model {

    

    public function __construct() {

        parent::__construct();
        $this->load->database();
        $this->session_data=$this->session->userdata('userDetails');    

    }

   

    // var $column_order = array('id','id',null); //set column field database for datatable orderable

    // var $column_search = array('id','id'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    // var $order = array('id' => 'desc');



////////////////////////////////////////SALES//////////////////////////////////////////////////////


    private function get_datatables_query_sales()
    {
        $this->db->select('user_registration.user_name,SUM(cart_order_sub.sub_total * cart_order_sub.qty) AS total_amt,cart_order.date,cart_order_sub.status');
        $this->db->from('cart_order');
        $this->db->join('user_registration', 'cart_order.user_id = user_registration.id');
        $this->db->join('cart_order_sub', 'cart_order.id = cart_order_sub.order_id');
        $this->db->where('cart_order_sub.status',1);    
        $this->db->group_by('cart_order.id');
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


    public function get_datatables_sales() {

        $this->get_datatables_query_sales();

        if($_POST['length'] != -1)

        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result_array();
    }



    public function count_filtered_sales() {

        $this->get_datatables_query_sales();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_sales() {

        $this->db->from('cart_order');
        //$this->db->where('parent_id',0);
        return $this->db->count_all_results();
    }
    



    
    
    //**********************************************************//
    
////////////////////////////////////////STOCK//////////////////////////////////////////////////////


    private function get_datatables_query_stock()
    {
        $this->db->select('cart_product.product_name,cart_stock.stock_name,cart_stock.stock,cart_stock.price,cart_stock.list_price,cart_stock.discount');
        $this->db->from('cart_stock');
        $this->db->join('cart_product', 'cart_stock.product_id = cart_product.id');
        $this->db->where('cart_stock.status',1);
        $this->db->group_by('cart_stock.id');
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


    public function get_datatables_stock() {

        $this->get_datatables_query_stock();

        if($_POST['length'] != -1)

        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result_array();
    }



    public function count_filtered_stock() {

        $this->get_datatables_query_stock();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_stock() {

        $this->db->from('cart_stock');
        //$this->db->where('parent_id',0);
        return $this->db->count_all_results();
    }
        
    
    
    //**********************************************************//
    
////////////////////////////////////////ORDER STATUS//////////////////////////////////////////////////////    
    
    
    public function get_data_orderwise($status,$from,$to)
    {
        $date = new DateTime($to);
        $to=$date->modify('+1 day');
        $to=$date->format('Y-m-d');


        $this->db->select('user_registration.user_name,SUM(cart_order_sub.sub_total * cart_order_sub.qty) AS total_amt,cart_order.date,cart_order_sub.status');
        $this->db->from('cart_order');
        $this->db->join('user_registration', 'cart_order.user_id = user_registration.id');
        $this->db->join('cart_order_sub', 'cart_order.id = cart_order_sub.order_id');
        if(!empty($status)){
        $this->db->where('cart_order_sub.status',$status); 
        }
        if(!empty($from)){
        $this->db->where('cart_order.date >= ', $from); 
        }
        if(!empty($to)){
        $this->db->where('cart_order.date <', $to); 
        }
        $this->db->group_by('cart_order.id');
        $query = $this->db->get();
        return $query->result();
        
    }


   
    
    
  //**********************************************************//   
    
    
    
        public function getCategory() {

        $this->db->select('cat_id,cat_name');
        $this->db->from('cart_category');
        $query = $this->db->get();
        return $query->result();
    }
    
    
    
      public function get_data_categorywise($category)
    {

        $this->db->select('cart_product.product_name,cart_stock.stock_name,cart_stock.stock,cart_stock.price,cart_stock.list_price,cart_stock.discount');
        $this->db->from('cart_stock');
        $this->db->join('cart_product', 'cart_stock.product_id = cart_product.id');
        $this->db->join('cart_category', 'cart_product.cat_id = cart_category.cat_id');
        if(!empty($category)){
        $this->db->where('cart_category.cat_id',$category);
        }
        $this->db->group_by('cart_stock.id');
        $query = $this->db->get();
        return $query->result();
        
    }
  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    public function get_by_id($id) {

        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    //json load view end //


    public function getFeaturetSub($id)
    {
        $this->db->select('cart_feature_variant.f_var_id as var_id,cart_feature_variant.variants_name as var_name');
        $this->db->from('cart_feature_variant');
        $this->db->where('cart_feature_variant.f_id',$id);
        $this->db->order_by('cart_feature_variant.variants_name','ASC');
        $query = $this->db->get();
      
        return $query->result_array();

    }

    public function viewOrderData($id) {
        $this->db->select('cart_order.id,cart_order.payment_status,user_registration.prof_image,user_registration.user_name,SUM(cart_order_sub.sub_total * cart_order_sub.qty) AS total_amt,cart_order.date,cart_order_sub.status,user_delivery_address.name,
        user_delivery_address.address,user_delivery_address.land_mark,user_delivery_address.phone,user_delivery_address.alter_phone,user_delivery_address.latitude,user_delivery_address.longitude');
        $this->db->from($this->table);
        $this->db->join('user_delivery_address', 'cart_order.address_id = user_delivery_address.id');
        $this->db->join('cart_order_sub', 'cart_order.id = cart_order_sub.order_id');
        $this->db->join('user_registration', 'cart_order.user_id = user_registration.id');
        $this->db->where('cart_order.id',$id);
        $query = $this->db->get();

        $categories = $query->result_array();
        
        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['product'] = $this->getCartOrderStockListSub($p_cat['id']);

            $i++;
        }
        
        return $categories; 

    }

    public function getCartOrderStockListSub($order_id='')
    {
        $this->db->select('cart_order_sub.id,cart_stock.id as stock_id,cart_stock.stock_name,cart_stock.list_price, cart_order_sub.sub_total AS subtotal,cart_order_sub.qty,cart_order_sub.status,cart_product_image.image');
        $this->db->from('cart_order_sub');
        $this->db->join('cart_stock', 'cart_order_sub.stock_id = cart_stock.id');
        $this->db->join('cart_product_image', 'cart_stock.id = cart_product_image.stock_id');
        $this->db->group_by('cart_product_image.stock_id');
        $this->db->order_by('cart_order_sub.id','desc');
        $this->db->where('cart_order_sub.order_id',$order_id);

        $query = $this->db->get();

       return $query->result_array();
    }

        public function getUserBuslist($num)
    {
        $this->db->select('register_userlist.id,register_userlist.bus_id,register_userlist.role,register_userlist.phone,register.bus_name,register.crop_image as profile_image,register.cover_image,register_userlist.role,register_userlist.created');
        $this->db->from("register_userlist");
        $this->db->join('register', 'register_userlist.bus_id = register.reg_id');
        $this->db->where('register_userlist.phone',$num);
        //$this->db->where('register_userlist.role','owner');
        $this->db->where('register.status',1);
        $this->db->where('register_userlist.status',1);
        $query = $this->db->get();
        
        $categories = $query->result();

        $i=0;

        foreach($categories as $p_cat) {

            $bus_like = $this->getUserBusFollowCount($p_cat->bus_id);

            $categories[$i]->bus_like=$bus_like[0]['bus_like'];

            $i++;
        }
      
        return $categories;
    }

    public function getUserBusFollowCount($id='')
    {
        $this->db->select('COUNT(cart_seller_likes.seller_id) AS bus_like');
        $this->db->from('cart_seller_likes');
        $this->db->where('cart_seller_likes.seller_id',$id);
        $this->db->where('cart_seller_likes.like_status',1);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function setOrderStatus($id='',$status='') {

        $value = array('status' => $status);

        $this->db->where('id',$id);
        $this->db->update($this->table,$value);

        $this->db->where('order_id',$id);
        $this->db->update('cart_order_sub',$value);

    }
    
    public function delete($id='') {

        $this->db->where('id',$id);
        $this->db->delete($this->table);

        $this->db->where('order_id',$id);
        $this->db->delete('cart_order_sub');

    }

    

}