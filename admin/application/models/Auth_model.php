<?php



class Auth_model extends MY_Model //extend MY_model from CI_model in core

{

	var $table = 'users';



	public function __construct() // Call the CI_Model constructor

	{

	    parent::__construct();

    }



	public function loginWithCredentials($email) //check email id and password are equal with DB email id and password.

	{

	    $this->db->select('*');

	    $this->db->from($this->table);

	    $this->db->where('email', $email);

	    $this->db->where('status',1);

	    $query = $this->db->get();

	    return $query->row();

	}



}