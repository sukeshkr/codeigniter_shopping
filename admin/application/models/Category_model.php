<?php

Class Category_model extends MY_Model {

  public function __construct() {

    parent::__construct();
    $this->load->database();

  }

    var $table = 'cart_category';

    var $column_order = array('cat_name',null,null); //set column field database for datatable orderable

    var $column_search = array('cat_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable

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


    // public function get_datatables() {

    //     $this->get_datatables_query();
    //     if($_POST['length'] != -1)
    //     $this->db->limit($_POST['length'], $_POST['start']);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

  public function get_datatables($parent = 0, $spacing = '', $category_tree_array = '')
  {

     $this->get_datatables_query();

     if($_POST['length'] != -1)

    if (!is_array($category_tree_array))
        $category_tree_array = array();

      $this->db->limit($_POST['length'], $_POST['start']);
      $this->db->where('parent_id', $parent);
      //$this->db->limit($limit, $offset);
      $this->db->order_by('cat_id','asc');
      $query = $this->db->get();



  if ($query->num_rows() > 0) {


  foreach($query->result_array() as $rowCategories){

        
            $category_tree_array[] = array("cat_id" => $rowCategories['cat_id'], "cat_name" => $spacing . $rowCategories['cat_name'],"image" => $rowCategories['image'],"parent_id" => $rowCategories['parent_id']);
            $category_tree_array = $this->get_datatables($rowCategories['cat_id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
        }
    }
    return $category_tree_array;
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






















    ///////////////////////////////////////////////////////

  public function insertCategoryData($value='') { 

    if ($this->db->insert($this->table, $value)) {

       $insert_id = $this->db->insert_id();
         
        return true;

        } else{

            return false;

    }

  }

  public function getCartCat($parent = 0, $spacing = '', $category_tree_array = '')
  {

    if (!is_array($category_tree_array))
        $category_tree_array = array();

      $this->db->from($this->table);

      $this->db->where('parent_id', $parent);
      $this->db->order_by('cat_id','asc');
      $query = $this->db->get();



    if ($query->num_rows() > 0) {


      foreach($query->result_array() as $rowCategories){

        
            $category_tree_array[] = array("cat_id" => $rowCategories['cat_id'], "cat_name" => $spacing . $rowCategories['cat_name']);
            $category_tree_array = $this->getCartCat($rowCategories['cat_id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
        }
    }
    return $category_tree_array;
  }

  public function getCartParentEdit($id='')
  {
      $this->db->from($this->table);

      if ($id != '')
      $this->db->where('cat_id', $id);
      $this->db->order_by('cat_id','desc');
      $query  = $this->db->get();

      return $query->result_array();
  }

  public function fetch_data($limit=null,$offset=NULL) {
  $this->db->limit($limit, $offset);
  $this->db->order_by('id', "desc");
  $query = $this->db->get("gallery");
  if ($query->num_rows() > 0) {
  foreach ($query->result_array() as $row) {
  $data[] = $row;
  }
  return $data;
  }
  return false;
 }
public function record_count() {
  return $this->db->count_all($this->table);
 }

  public function getCartParent($parent = 0, $spacing = '', $category_tree_array = '')
  {

    if (!is_array($category_tree_array))
        $category_tree_array = array();

       $this->db->select('cat_id,cat_name,display_name,cat_icon,parent_id');

      $this->db->from($this->table);

      $this->db->where('parent_id', $parent);
      //$this->db->limit($limit, $offset);
      $this->db->order_by('cat_id','desc');
      $query = $this->db->get();



if ($query->num_rows() > 0) {


  foreach($query->result_array() as $rowCategories){

        
            $category_tree_array[] = array("cat_id" => $rowCategories['cat_id'], "cat_name" => $spacing . $rowCategories['cat_name'],"display_name" => $rowCategories['display_name'],"cat_icon" => $rowCategories['cat_icon'],"parent_id" => $rowCategories['parent_id']);
            $category_tree_array = $this->getCartParent($rowCategories['cat_id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
        }
    }
    return $category_tree_array;
  }


  public function getMainCategories($id='')
  {
        $this->db->from('category');
        if ($id != '')
        $this->db->where('id', $id);
        $this->db->order_by('category_name','asc');
        $query = $this->db->get();
        return $query->result_array();
  }

  public function getSelectedCategories($id='')
  {
        $this->db->select('shop_type_category.id,shop_type_category.cat_id,shop_type_category.shop_type,category.category_name');
        $this->db->from('shop_type_category');
        $this->db->join('category', 'shop_type_category.shop_type = category.id');
        $this->db->where('shop_type_category.cat_id', $id);
        $query = $this->db->get();
        return $query->result_array();
  }

  

   // public function getCartParent()
   //  {
   //      $this->db->from($this->table);
   //      $this->db->where('parent_id', 0);
   //      $this->db->order_by('cat_id','desc');
   //      $parent  = $this->db->get();


   //       $categories = $parent->result();
   //      $i=0;
   //      foreach($categories as $p_cat){

   //          $categories[$i]->sub = $this->sub_categories($p_cat->cat_id);
   //          $i++;
   //      }

   //      return $categories;



   //     // return $query->result_array();
   //  }

    public function sub_categories($id){

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('parent_id', $id);

        $child = $this->db->get();
        $categories = $child->result();
        $i=0;
        foreach($categories as $p_cat){

            $categories[$i]->sub = $this->sub_categories($p_cat->cat_id);
            $i++;
        }
        return $categories;       
    }

    public function updateCategory($id,$value)
    {
         
      $this->db->where('cat_id',$id);
      $this->db->update($this->table,$value);

    }


    public function deleteProduct($id)
    {

        $this->db->from($this->table);
        $this->db->where('cat_id',$id);
        $query = $this->db->get();

        foreach ($query->result() as  $row) {
           $name= $row->image;
          unlink("uploads/category/crop/" . $name);           
        }

       $this->db->where('cat_id',$id);
       $this->db->delete($this->table);
    
    }

}