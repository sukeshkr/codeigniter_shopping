<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Auth_Controller  //extend MY_Auth_Controller from CI_controller in core
{ 

  public function __construct() {

    parent::__construct();
    $this->load->model('User_model', 'model');
    $this->load->library('bcrypt');

    if (!$this->is_logged_in()) 
    {
      redirect('login');
    }
  }

  public function index() {

    $data['profile']=$this->model->getProfile();
    $this->load->view('user/view',$data);
  }

  public function create() {

    $this->form_validation->set_rules('username', 'User name', 'trim|required|xss_clean');
    $this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
    $this->form_validation->set_rules('email','Email','required|callback_exists_email');
    $this->form_validation->set_rules('password','Password','trim|required|xss_clean');

    if($this->form_validation->run() == FALSE) 
    {
      $this->load->view('user/add');
    } 
    else 
    {
      $username = $this->input->post('username');
      $role = $this->input->post('role');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $hash = $this->bcrypt->hash_password($password);

      $value = array('username'=> $username,'role'=>$role,'email' => $email,'password' => $hash);
   
      $data['result'] = $this->model->insertUser($value);
      $this->session->set_flashdata('add', 'Added Successfully');
      redirect('User');

    }
  }

  public function edit() {

    $id = $this->uri->segment(3);
    $data['profile']=$this->model->getProfile($id);
    $this->load->view('user/edit', $data);     
  }

  public function update() {

    $this->form_validation->set_rules('username', 'User name', 'trim|required|xss_clean');
    $this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
    $this->form_validation->set_rules('email','Email','required|xss_clean');
    $this->form_validation->set_rules('password','Password','trim|required|xss_clean');

    if($this->form_validation->run() == FALSE) 
    {
      $id = $this->uri->segment(3);
      $data['profile']=$this->model->getProfile($id);
      $this->load->view('user/edit', $data);
    } 
    else 
    {
      $id = $this->input->post('id');

      $username = $this->input->post('username');
      $role = $this->input->post('role');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $hash = $this->bcrypt->hash_password($password);

      $value = array('username'=> $username,'role'=>$role,'email' => $email,'password' => $hash);
   
      $data['result'] = $this->model->updateUser($value,$id);
      $this->session->set_flashdata('add', 'Added Successfully');
      redirect('User');

    }
  }

  public function changepassword() {

    $this->load->view('user/change_password');
  }

  //update password function
  public function updatepassword()  {

    $currentPassword = $this->input->post('currentPassword');
    $newPassword = $this->input->post('newPassword');
    $hash = $this->bcrypt->hash_password($newPassword);
    $confirmPassword = $this->input->post('confirmPassword');
    $this->form_validation->set_rules('currentPassword', 'Current Password', 'trim|required|callback_currentPasswordCheck');
    $this->form_validation->set_rules('newPassword', 'New Password', 'required|trim');
    $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|trim|matches[newPassword]');
    if ($this->form_validation->run() == FALSE) 
    {
      $this->changepassword();
    } 
    else {

      $this->model->changePasswordDet($hash, $this->userAdminDetails->id);
      $this->session->set_flashdata('changepwd', 'Password Changed Successfully !');
      redirect('User/changePassword');
    }

  }
  //password check either correct or not from callback_currentPasswordCheck
  public function currentPasswordCheck($currentPassword) {

    if (!$this->bcrypt->check_password($currentPassword, $this->userAdminDetails->password) )
    {
      $this->form_validation->set_message('currentPasswordCheck', 'The current password field is wrong');

      return false;

    } else {

        return true;

    }

  }
  #uniqueness of username
  function exists_email($str) {

    $value=$this->model->key_exists($str);

    if ($value)
    {
      return TRUE;
    }
    else
    {
      $this->form_validation->set_message('exists_email', 'Email already exists!... Please choose another one');
      return FALSE;
    }
  }

  //delete with modal popup
  public function delete()  {

    $this->load->view('user/delete');
    if (isset($_POST['delete'])) 
    {
      $id = $this->input->post('id');
      $this->model->delete($id);
      $this->session->set_flashdata('delete', 'Deleted Successfully');
      redirect('User');
    }
  }

  public function user_profile()  {

    $this->load->view('user/profile');
  }

   //update password function
  public function update_profile() {
       
    $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
    $this->form_validation->set_rules('location', 'Location', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim');

    if ($this->form_validation->run() == FALSE) {

      $this->user_profile();

    } else {

      $phone = $this->input->post('phone');
      $location = $this->input->post('location');
      $email = $this->input->post('email');
      $facebook = $this->input->post('facebook');
      $value = array('phone' => $phone , 'location' => $location,'gmail' => $email,'facebook' => $facebook);
      $this->model->updateProfileDet($value,$this->userAdminDetails->id);
      $this->session->set_flashdata('update', 'Profile Changed Successfully !');

      redirect('User/user_profile');

    }

  }

} 

?>