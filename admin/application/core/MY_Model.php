<?php


class MY_Model extends CI_Model {



    public $dataArr = array();



    public function __construct() {

        parent::__construct();

       // $this->load->library('custom');

    }



    public function saveData($table) {

        $this->db->insert($table, $this->dataArr);

        //print_r($this->db->insert_id()); exit;

        return $this->db->insert_id();



    }



    public function updateData($table, $id) {

        $this->db->where('id', $id);

        $this->db->update($table, $this->dataArr);

    }



    public function deleteData($table, $id) {

        $this->dataArr = array('status' => DATABASE_STATUS_DISABLE);

        $this->db->where('id', $id);

       

        $this->db->update($table, $this->dataArr);

       

               

    }



    public function setGalleryValues($postId, $url, $isVideo) {

        $this->dataArr = array(

            'post_id' => $postId,

            'url' => $url,

            'is_video' => $isVideo

        );

        return $this;

    }



    public function getRowCreatedUser($table, $id) {

        $query = $this->db->get_where($table, array('id' => $id));

        return $query->row();

    }



}

