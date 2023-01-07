<?php

Class Store_model extends MY_Model {

  public function __construct() {

    parent::__construct();
    $this->load->database();

  }

    var $table = 'store';

    var $column_order = array('location',null,null); //set column field database for datatable orderable

    var $column_search = array('location'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('id' => 'DESC');


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
    
    public function get_datatables_notification() {

        $this->get_datatables_query_notification();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }
    
      private function get_datatables_query_notification()
  {
        $this->db->from('notification');
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
    public function get_tocken() {
        $this->db->select('otp_table.fcm_token');
        $this->db->from('otp_table');
        //$this->db->where('user_id',65);
        $query = $this->db->get();
        $cat= $query->result_array();
       // print_r($cat);exit;
        $tock=array();
        foreach($cat as $ca)
        {
            //print_r($ca['fcm_token']);exit;
           $tock[]=$ca['fcm_token'];
        }
        
        return $tock;
        
        //print_r($tock);exit;
    }
    //json load view end //


  public function insertStoreData($value='') { 

    if ($this->db->insert($this->table, $value)) {

      $insert_id = $this->db->insert_id();
         
      return true;

      } else{

      return false;

    }

  }


  public function getStoreEdit($id='')
  {
      $this->db->from($this->table);

      if ($id != '')
      $this->db->where('id', $id);
      $query  = $this->db->get();

      return $query->result_array();
  }


    public function updateStoreData($id,$value)
    {
         
      $this->db->where('id',$id);
      $this->db->update($this->table,$value);

    }


    public function deleteStore($id)
    {

        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();

        foreach ($query->result() as  $row) {
           $name= $row->image;
           $og_image= $row->og_image;
          unlink("uploads/store/crop/" . $name);  
          unlink("uploads/store/" . $og_image);           
        }

       $this->db->where('id',$id);
       $this->db->delete($this->table);
    
    }
    
    
    public function storeNotification($value='') { 

    if ($this->db->insert('notification', $value)) {

      $insert_id = $this->db->insert_id();
         
      return true;

      } else{

      return false;

    }

  }
    

}