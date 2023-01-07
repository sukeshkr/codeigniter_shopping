<?php

ob_start();

defined('BASEPATH') OR exit('No direct script access allowed');

//login page

class MY_Controller extends CI_Controller {



public function __construct() {

    parent::__construct();

    $this->load->helper(array('form', 'url'));

    $this->load->library('form_validation');

    $this->load->helper('security');

    $this->load->library('session');

    ini_set('display_errors', 'on');

 }



}



class MY_Auth_Controller extends MY_Controller {

 private $template = 'common/template';

    private $data = array();

    public $userAdminDetails = '';

    private $module = '';

    private $urlAction = '';

    public $urlId = '';

    public $table = '';





public function __construct() {

    parent::__construct();

    $this->load->model('MY_model');

    $this->load->library('upload');

    $this->load->library('image_lib');

    $this->load->library('pagination');

    header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");

    header("Cache-Control: no-store, no-cache, must-revalidate");

    $this->userAdminDetails = $this->session->userdata('userAdminDetails');

  

      //  $this->load->library('custom');

        $this->module = $this->uri->segment(1);

        $this->urlAction = $this->uri->segment(2);

        $this->urlId = $this->uri->segment(3);

        $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');





 }



   public function loadView($contentPage, $data = array()) {

        $this->data['contentPage'] = $contentPage;

        $this->data['module'] = $this->module;

        $this->data['userAdminDetails'] = $this->userAdminDetails;

        $this->data = array_merge($this->data, $data);

        $this->load->view($this->template, $this->data);

    }



   public function update() {

        $id = ($this->urlId != '') ? $this->urlId : $this->input->post('id');

        $row = $this->MY_model->getRowCreatedUser($this->table, $id);

        if (!$row) {

            $this->session->set_flashdata('error', TRUE);

            $this->session->set_flashdata('msg', 'Data is not available');

            redirect($this->module);

        }

        if ($row->user_id != $this->userAdminDetails->id) {

            $this->session->set_flashdata('error', TRUE);

            $this->session->set_flashdata('msg', 'Data belongs to other user');

            redirect($this->module);

        }

    }



    public function destroy() {

        $this->update();

    }

    





public function is_logged_in() {

    $user = $this->session->userdata('userAdminDetails');

    return $user;

 }



}