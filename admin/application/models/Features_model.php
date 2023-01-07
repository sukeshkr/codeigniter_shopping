<?php
Class Features_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

    }

    var $table = 'cart_feature';

    var $column_order = array('date','title',null); //set column field database for datatable orderable

    var $column_search = array('date','title'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('id' => 'desc');

    private function get_datatables_query()
    {
        $this->db->select('cart_feature.id,cart_feature.name,cart_feature_group.group_name,cart_feature.display_name');
        $this->db->from($this->table);
        $this->db->join('cart_feature_group', 'cart_feature.f_grp_id = cart_feature_group.grp_id');
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
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {

        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    //json load view end //

    public function insertFeatures($value='',$variants_name='',$cat_name='') { 

        if ($this->db->insert($this->table, $value)) {

        	$insert_id = $this->db->insert_id();

            if($variants_name[0]) {

            	foreach($variants_name as  $index => $variants) {

                    $value_variants= array('f_id' => $insert_id,'variants_name' => $variants);

                    $this->db->insert('cart_feature_variant', $value_variants);
                }
            }

            if($cat_name[0]) {

                foreach($cat_name as $cat_names) {

                    $value_cat= array('feature_id' => $insert_id,'cat_id' => $cat_names);

                    $this->db->insert('cart_features_category', $value_cat);
                }

            }

            return true;

        } else{

            return false;

        }

    }

    public function getCategory($parent = 0, $spacing = '', $category_tree_array = '')
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
                $category_tree_array = $this->getCategory($rowCategories['cat_id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
            }
        }

        return $category_tree_array;
    }

    // public function getCategory()
    // {

    //    $this->db->from('cart_category');
    //     $this->db->order_by('cat_id','desc');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function getSelectedCat($id='')
    {

        $this->db->from('cart_features_category');
        $this->db->join('cart_category', 'cart_features_category.cat_id = cart_category.cat_id');
         if ($id != '')
        $this->db->where('cart_features_category.feature_id', $id);
        $this->db->order_by('cart_features_category.c_f_id','desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function getFeat()
    {
        $this->db->from($this->table);
        $this->db->join('cart_feature_group', 'cart_feature.f_grp_id = cart_feature_group.grp_id');
        $this->db->order_by('cart_feature.id','desc');
        $query = $this->db->get();
        return $query->result_array();

    }


	public function getFeatures($id='')
	{
		$this->db->from($this->table);
		if ($id != '')
		$this->db->where('id', $id);
	    $this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result_array();

	}

    public function getFeatureVariants($id='')
    {
        $this->db->from('cart_feature_variant');
        if ($id != '')
        $this->db->where('f_id', $id);
        $this->db->order_by('f_var_id','desc');
        $query = $this->db->get();
        return $query->result_array();

    }

	public function getFeatureGroup()
	{
		$this->db->from('cart_feature_group');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function updateFeature($id,$value,$variants_name='',$cat_name='')
    {
    
        $this->db->where('id',$id);
        $this->db->update($this->table,$value);

        if(!empty($variants_name[0])) {

            foreach($variants_name as  $index => $variants) 
            {
                $value_variants= array('f_id' => $id,'variants_name' => $variants);

                $this->db->insert('cart_feature_variant', $value_variants);
            }
        }

        if(isset($cat_name)) {

            foreach($cat_name as  $index => $cat_names) 
            {
                $value_variants= array('feature_id' => $id,'cat_id' => $cat_names);

                $this->db->insert('cart_features_category', $value_variants);
            }

        }

    }


	public function deleteFeature($id='')
	{
		   
        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->delete($this->table); 

        $this->db->where('f_id',$id);
        $this->db->delete('cart_feature_variant'); 

        $this->db->where('feature_id',$id);
        $this->db->delete('cart_features_category'); 

        $this->db->trans_complete();
 
	}

    public function deleteFeatureCat($id)
    {
           $this->db->where('c_f_id',$id);
           $this->db->delete('cart_features_category'); 
    }

    public function deleteFeaturesList($id)
    {
           $this->db->where('f_var_id',$id);
           $this->db->delete('cart_feature_variant'); 
    }
	

}