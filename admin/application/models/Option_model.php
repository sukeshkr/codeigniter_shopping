<?php
Class Option_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

    }

    var $table = 'options';

    var $colors  =  array('aqua'=>'00FFFF','black'=>'000000','blue'=>'0000FF','blueviolet'=>'8A2BE2','brown'=>'A52A2A',
        'chocolate'=>'D2691E','darkgray'=>'A9A9A9','darkgreen'=>'006400','darkviolet'=>'9400D3','gold'=>'FFD700',
        'gray'=>'808080','green'=>'008000','grey'=>'808080','indigo'=>'4B0082','ivory'=>'FFFFF0','khaki'=>'F0E68C',
        'lavender'=>'E6E6FA','lightblue'=>'ADD8E6','lightgreen'=>'90EE90','lightskyblue'=>'87CEFA','lime'=>'00FF00',
        'limegreen'=>'32CD32','linen'=>'FAF0E6','magenta'=>'FF00FF','maroon'=>'800000','navy'=>'000080',
        'orange'=>'FFA500','pink'=>'FFC0CB','plum'=>'DDA0DD','purple'=>'800080','red'=>'FF0000','royalblue'=>'4169E1',
        'seagreen'=>'2E8B57','silver'=>'C0C0C0','skyblue'=>'87CEEB','snow'=>'FFFAFA',
        'violet'=>'EE82EE','wheat'=>'F5DEB3','white'=>'FFFFFF','whitesmoke'=>'F5F5F5','yellow'=>'FFFF00');

    var $order = array('id' => 'desc');

    public function insertOptions($name,$value,$variants_name,$cat_name='') { 

        if ($this->db->insert($this->table, $value)) {

        	$insert_id = $this->db->insert_id();

                if(strtolower($name)=='color' || strtolower($name)=='colour') {

                    if($variants_name[0]) {

                    	foreach($variants_name as  $index => $color_name) {

                            $color_name = strtolower($color_name);

                            if (isset($this->colors[$color_name]))
                            {
                               $variant_color = '#' . $this->colors[$color_name];
                            }
                            else
                            {
                                $variant_color = $color_name;
                            }

                        $value_variants= array('opt_id' => $insert_id,'type_name' => $color_name,'color_code' => $variant_color);

                        $this->db->insert('options_type', $value_variants);
                        }
                    }

                }
                else
                {
                    if($variants_name[0]) {

                        foreach($variants_name as  $index => $variants) {

                            $value_variants= array('opt_id' => $insert_id,'type_name' => $variants);

                            $this->db->insert('options_type', $value_variants);
                        }
                    }

                }



            if($cat_name[0])
            {

                foreach($cat_name as  $index => $cat_names) 
                {
                  $value_variants= array('opt_id' => $insert_id,'cat_id' => $cat_names);

                    $this->db->insert('cart_option_category', $value_variants);
                }

            }

            return true;

        } else{

            return false;

        }

    }

	public function getOptions($id='')
	{
		$this->db->from($this->table);
		if ($id != '')
		$this->db->where('option_id', $id);
	    $this->db->order_by('option_id','desc');
		$query = $this->db->get();
		return $query->result_array();

	}

	public function getOptionsList($id)
	{
		$this->db->from('options_type');
		$this->db->where('opt_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function updateOptions($id='',$value='',$name='',$variants_name='',$cat_name='')
    {

        $this->db->trans_start();

        $this->db->where('option_id',$id);
        $this->db->update('options',$value);

        if(!empty($variants_name[0])) {

            if(strtolower($name)=='color' || strtolower($name)=='colour') {

                foreach($variants_name as  $index => $color_name) {

                    $color_name = strtolower($color_name);

                    if (isset($this->colors[$color_name])) {

                       $variant_color = '#' . $this->colors[$color_name];
                    }
                    else
                    {
                        $variant_color = $color_name;
                    }

                    $value_variants= array('opt_id' => $id,'type_name' => $color_name,'color_code' => $variant_color);


                $this->db->insert('options_type', $value_variants);
                }

            }
            else
            {

                foreach($variants_name as  $index => $variants) {

                    $value_variants= array('opt_id' => $id,'type_name' => $variants);

                    $this->db->insert('options_type', $value_variants);
                }
            }

        }

        if($cat_name[0]) {

            foreach($cat_name as  $index => $cat_names) 
            {
                $value_variants= array('opt_id' => $id,'cat_id' => $cat_names);

                $this->db->insert('cart_option_category', $value_variants);
            }

        }

        $this->db->trans_complete(); 
    }

	public function deleteOptions($id='')
	{
	    $this->db->trans_start();
		$this->db->where('option_id',$id);
	    $this->db->delete('options'); 

	    $this->db->where('opt_id',$id);
	    $this->db->delete('options_type'); 

        $this->db->where('opt_id',$id);
        $this->db->delete('cart_option_category'); 

        $this->db->trans_complete(); 
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
 //    {

 //        $this->db->from('cart_category');
 //        $this->db->order_by('cat_id','desc');
 //        $query = $this->db->get();
 //        return $query->result_array();
 //    }

    public function getOptionsCat($id='')
    {

        $this->db->from('cart_option_category');
        $this->db->join('cart_category', 'cart_option_category.cat_id = cart_category.cat_id');

        if ($id != '')
        $this->db->where('cart_option_category.opt_id', $id);
        $this->db->order_by('cart_option_category.id','desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function deleteOptioncatList($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('cart_option_category'); 
    }

    public function deleteOptionList($id)
    {
        $this->db->where('opt_var_id',$id);
        $this->db->delete('options_type'); 
    }


}