<?php
Class Feature_groups_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();

    }

    var $table = 'cart_feature_group';

    var $column_order = array('date','title',null); //set column field database for datatable orderable

    var $column_search = array('date','title'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    var $order = array('id' => 'desc');
  public function insertFeaturesGroup($value) { 


        if ($this->db->insert($this->table, $value)) {

        	  $insert_id = $this->db->insert_id();
      
            return true;

        } else{

            return false;

        }

    }

	public function getFeaturesGroup($id='')
	{
		$this->db->from($this->table);
		if ($id != '')
		$this->db->where('grp_id', $id);
	    $this->db->order_by('grp_id','desc');
		$query = $this->db->get();
		return $query->result_array();

	}

  	public function updateFeatureGroups($id,$value) {
      
      $this->db->where('grp_id',$id);
      $this->db->update($this->table,$value);

    }

  	public function deleteFeature($id='') {

      $this->db->where('grp_id',$id);
      $this->db->delete($this->table); 

  	}


}