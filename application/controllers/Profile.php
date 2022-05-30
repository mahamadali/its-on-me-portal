<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public $data;

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Profile_model');
        $this->load->helper('form');
    }

    public function index()
    {      
       if(!$this->session->userdata('admin'))
       {
           redirect('/');
       }

       $this->data['page'] = "profile/index";
       $this->load->view('structure',$this->data);	 

   }

   public function changepassword()
   {
      
      $Old_pass = $this->input->post('old_password');
      $New_pass = $this->input->post('new_password');
      $conf_pass = $this->input->post('confirm_password');
      $current_pass = $this->Profile_model->get_password($_SESSION['email']);
      if($current_pass != md5($this->input->post('old_password')))
      {
          $this->session->set_flashdata('warning', 'Please Enter Correct Old Password');
          redirect('profile/manageprofile');
      }
       if($New_pass != $conf_pass)
      {
          $this->session->set_flashdata('warning', 'New Password and confirm password Must be Same');
          redirect('profile/manageprofile');
      }
      $id = $_SESSION['admin'];   
      $data['password'] = md5($New_pass);
      $updated_id = $this->Profile_model->update_password($id,$data);
      if(!empty($updated_id))
      {
         $this->session->set_flashdata('success', 'System Password Updated successfully!');
      }
      else
      {
         $this->session->set_flashdata('warning', 'Something went wrong');
      }
      redirect('profile/manageprofile');
   }

}