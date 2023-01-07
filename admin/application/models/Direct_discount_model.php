<?php

Class Direct_discount_model extends MY_model {

    

    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    var $table = 'direct_discount';

    var $column_order = array('caption'); //set column field database for datatable orderable

    var $column_search = array('caption'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('id' => 'desc');

    private function get_datatables_query() {

        $this->db->from($this->table);

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



    public function get_datatables(){

        $this->get_datatables_query();

        if($_POST['length'] != -1)

        $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    public function count_filtered(){

        $this->get_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all(){

        $this->db->from($this->table);

        return $this->db->count_all_results();

    }

    public function getProductData($id='')
    {
        $this->db->select('id,stock_name');
        $this->db->from('cart_stock');
              if ($id != '')

        $this->db->where('id', $id);
       $this->db->where('status', 1);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getOfferData($id='')
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
  
    public function getTotalProductPrice($id='') {

        $query = $this->db->query("SELECT id,list_price FROM cart_stock  WHERE id IN (".$id.") ");

        return $query->result_array();

    }

    public function insertDirectDiscount($value,$stock_name='') { 

        $this->db->insert($this->table, $value);

        $insert_id = $this->db->insert_id();

        // if($stock_name[0]) {

        //     foreach($stock_name as  $index => $stock_ids) {

        //         $value= array('deal_id' => $insert_id,'stock_id' => $stock_ids);

        //         $this->db->insert('direct_discount_products', $value);
        //     }
        // }
    }

    public function updateDirectDiscount($id='',$value='') {

        $this->db->where('id', $id); 
        $this->db->update($this->table, $value);


    }
    
    public function updateStock($id='',$value='') {

        $this->db->where('id', $id); 
        $this->db->update('cart_stock', $value);


    }

    public function deleteDirect($id)
    {
       $this->db->where('id',$id);
        $this->db->delete($this->table);
    }

    public function viewDirectData($id) {

        $this->db->select('direct_discount_products.id,cart_stock.stock_name,cart_product_image.image');
        $this->db->from('table');
        $this->db->join('direct_discount_products', 'table.id = direct_discount_products.deal_id');
        $this->db->join('cart_stock', 'direct_discount_products.stock_id = cart_stock.id');
        $this->db->join('cart_product_image', 'cart_stock.id = cart_product_image.stock_id');
        $this->db->where('table.id',$id);
        $this->db->group_by('cart_product_image.stock_id');
        $query = $this->db->get();

        $categories = $query->result_array();
        
       
        return $categories; 

    }



}