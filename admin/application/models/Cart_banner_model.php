<?php

Class Cart_banner_model extends MY_model {

    

    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    var $table = 'cart_banner';

    var $column_order = array('date','banner_name',null); //set column field database for datatable orderable

    var $column_search = array('date','banner_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('id' => 'desc');


  private function get_datatables_query()
  {
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


    public function get_datatables() {

        $this->get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function count_filtered() {

        $this->get_datatables_query();
        //$this->db->where('parent_id',0);
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

    public function insertForBanner($value) { 

        if ($this->db->insert($this->table, $value)) {

            return true;

        } else{

            return false;

        }

    }

    public function getBanner($id='')
    {
        $this->db->from($this->table);
        if ($id != '')
        $this->db->where('id', $id);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateBanner($id,$value)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table,$value);

        //unlink("uploads/banner/" .$image);
    }

    public function setPriorityValue($id,$value)
    {

        $this->db->where('priority', $value);

        $query = $this->db->get($this->table);

        $count_row = $query->num_rows();

        if ($count_row > 0) {
          
            return FALSE; // here I change TRUE to false.
            
        } else {

            $data = array('priority' => $value );
            $this->db->where('id',$id);
            $this->db->update($this->table,$data);
            return TRUE; // And here false to TRUE
        }

    }
   

    public function deleteBanner($id,$name='')
    {
       $this->db->where('id',$id);
       $this->db->delete($this->table);  
       //unlink("uploads/banner/" . $name);
    }

       public function getBannerCategoryValue($id='')
    {
        $this->db->select('cart_category.cat_id as id,cart_category.cat_name as name');
        $this->db->from('cart_category');
        if ($id != '')
        $this->db->where('cat_id', $id);
        $this->db->order_by('cat_id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBannerProductValue($id='')
    {
        $this->db->select('cart_stock.id,cart_stock.stock_name as name');
        $this->db->from('cart_stock');
        if ($id != '')
        $this->db->where('id', $id);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBannerSellerValue($id='')
    {
        $this->db->select('register.reg_id as id,register.bus_name as name');
        $this->db->from('register');
        if ($id != '')
        $this->db->where('reg_id', $id);
        $this->db->order_by('reg_id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }


}