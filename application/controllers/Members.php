<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

	public $data;

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Members_model');
        $this->load->helper('general');
    }

    public function index()
    {      
       if(!$this->session->userdata('admin'))
       {
           redirect('/');
       }

       if($this->input->post('member_access_password'))
       {

       	 $mem_pass = $this->input->post('member_access_password');
	   	  $current_mem_pass = $this->Members_model->get_mem_password($_SESSION['email']);

	   	  if(md5($mem_pass) != $current_mem_pass)
	   	  {
	   	  	$this->session->set_flashdata('warning', 'Please Enter Correct Member Access Password');
	          redirect('members');
	   	  }
	   	 
	       $this->data['isset'] = 1;
	       $this->data['AllMembers'] = $this->Members_model->get_all_data();
       }

       $this->data['page'] = "members/index";
       $this->load->view('structure',$this->data);	 

   }

   public function view($id)
   {
       $this->data['MemberInfo'] = $this->Members_model->getMemberInfo($id);
       $this->data['page'] = "members/view";
       $this->load->view('structure',$this->data);    
   }


   public function corporate_members()
   {
      $this->data['page'] = "members/add_corporate_members";
       $this->load->view('structure',$this->data);   
   }

   public function store()
   {
      
      $Memberdata['created_at'] = date('Y-m-d H:i:s');
      $Memberdata['first_name'] = $this->input->post('member_first_name');
      $Memberdata['email'] = $this->input->post('member_email');
      $Memberdata['is_corporate'] = 1;
      $Memberdata['password'] = general::encrypt($this->input->post('member_password'));
     

      $product_id = $this->Members_model->insert_data_getid($Memberdata,'members');

      if (!empty($product_id)) {
          $this->session->set_flashdata('success', 'Corporate Member Added successfully!');

      }else{
        $this->session->set_flashdata('error', 'Something Wrong!');

    }   
    redirect('members');
   }

}