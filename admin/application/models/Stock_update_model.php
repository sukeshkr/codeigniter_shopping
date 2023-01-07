<?php

Class Stock_update_model extends MY_model {

    

    public function __construct() {

        parent::__construct();
        $this->load->database();
        $this->session_data=$this->session->userdata('userDetails'); 
    }

    var $table = 'cart_product';

    var $column_order = array('cart_category.cat_name'); //set column field database for datatable orderable

    var $column_search = array('cart_category.cat_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('id' => 'desc');


    private function get_datatables_query()
    {
        $this->db->select('cart_stock.id,cart_stock.stock_name,cart_product.cat_id,cart_stock.price,cart_stock.list_price,cart_stock.stock,cart_category.cat_name,cart_stock.status');
        $this->db->from($this->table);
        $this->db->join('cart_stock', 'cart_product.id = cart_stock.product_id');
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

        $categories=$query->result_array();

        $i=0;

        foreach($categories as $p_cat){

            $categories[$i]['image'] = $this->getImageDataSub($p_cat['id']);

            $i++;
        }

        return $categories;

    }

    public function getImageDataSub($id='') {
   
        $this->db->select("cart_product_image.id,cart_product_image.image");
        $this->db->from('cart_product_image');
        $this->db->where('cart_product_image.stock_id',$id);
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


    public function UpdatePriceSet($value='',$id='')
    {

      $data= array('price' => $value);

      $this->db->where('id',$id);
      $this->db->update('cart_stock', $data);

        
    }

    public function UpdateListPriceSet($value='',$id='')
    {

      $data= array('list_price' => $value);

      $this->db->where('id',$id);
      $this->db->update('cart_stock', $data);

        
    }


    public function UpdateStockSet($value='',$id='')
    {
      $data= array('stock' => $value);

      $this->db->where('id',$id);
      $this->db->update('cart_stock', $data);
    }

    public function insertCartStock($id='',$multi_image='') { 
         
        foreach($multi_image as $multi_images) 
        {
            $value_image= array('stock_id' => $id,'image' => $multi_images);

            $this->db->insert('cart_product_image', $value_image);
        }

        $data = array('status' => 1);

        $this->db->where('id',$id);
        $this->db->update('cart_stock', $data);

        return false;
    }


}

?>