<?php

Class Home_category_model extends MY_Model {

    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    var $table = 'cart_category';

    var $column_order = array('cat_name','display_name',null,null); //set column field database for datatable orderable

    var $column_search = array('cat_name','display_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('cat_id' => 'asc');


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
        $this->db->where('cat_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    //json load view end //

    public function putCartTopData($status='',$id='')
    {

      $value_cat= array('top_category_status' => $status);

      $this->db->where('cat_id',$id);
      $this->db->update($this->table, $value_cat);
        
    }

    public function getTopSetCategory()
    {
        $this->db->select('cart_category.cat_id,cart_category.cat_name,cart_category.display_name');
        $this->db->from('cart_category');
        $this->db->where('cart_category.top_category_status',1);
        $this->db->order_by('cart_category.cart_page_order','asc');
        $query = $this->db->get();
      
        $categories=$query->result_array();

        return $categories;

    }

    public function update($cat_id='')
    {

      for($i=0; $i<count($cat_id); $i++)
      {
          $query = $this->db->query("
          UPDATE cart_category 
          SET cart_page_order = '".$i."' 
          WHERE cat_id = '".$cat_id[$i]."'");
      }

    }

}