<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InquiryController extends CI_Controller {

	public $data; 

	public function __construct(){
    parent::__construct();
    $this->data['header'] = $this->load->view('header',$this->data,true);
    $this->data['footer'] = $this->load->view('footer',$this->data,true);
    $this->load->model('Inquiry_model', 'inquiry');
    $this->load->helper(array('form', 'general'));
  }

  public function index()
  {      
   
    if(!$this->session->userdata('admin'))
   {
     redirect('/');
   }


   $this->data['AllInquries'] = $this->inquiry->get_all_data();
   $this->data['page'] = "inquiry/index";
   $this->load->view('structure',$this->data);  

 }

public function add()
{
  $this->data['page'] = "admin/add";
  $this->load->view('structure',$this->data); 
}

public function store()
{
  $AdminData = $this->input->post();
  $checkEmailAvailable = $this->admin->findByColumn('email', $AdminData['email']);
  if($checkEmailAvailable  > 0) {
    $this->session->set_flashdata('warning', 'Admin already exist!');
    redirect('admin-list/add');
  }

  $AdminData['email'] = $AdminData['email'];
  $AdminData['password'] = md5($AdminData['password']);
  $new_admin_id = $this->admin->insert_data_getid($AdminData,'admin');

 if (!empty($new_admin_id)) {
  $this->session->set_flashdata('success', 'Admin created successfully!');

}else{
  $this->session->set_flashdata('error', 'Something Wrong!');

}

redirect('admin-list');

}

public function delete($id){

  
  $delete_admin = $this->admin->delete_data('admin','id',$id);
  if(!empty($delete_admin)) {
    $this->session->set_flashdata('success', 'Admin deleted successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('admin-list');
}

 public function edit($id)
{
  $this->data['admin_data'] = $this->admin->get_admin_data($id);
  $this->data['page'] = "admin/edit";
  $this->load->view('structure',$this->data);  
}

 public function update()
{
  $AdminData = $this->input->post();
  $UpdateAdminData['email'] = $AdminData['email'];
  if(!empty($AdminData['password']))
  {
     $UpdateAdminData['password'] = md5($AdminData['password']);
  }

  $edit_admin_id = $this->input->post('edit_admin_id');
    unset($UpdateAdminData['edit_admin_id']);
  $admin_id = $this->admin->update_admin_detail($edit_admin_id,$UpdateAdminData);
  if (!empty($admin_id)) {
    $this->session->set_flashdata('success', 'Admin updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('admin-list');
}


  public function info()
  {
     if(empty($this->input->post('inquiry_id')))
    {
        $this->session->set_flashdata('error', 'Something Wrong!');
        redirect('inquiries');
    }
    $id = $this->input->post('inquiry_id');
    $InquiryData = $this->inquiry->get_inquiry_data($id);
    if(!empty($InquiryData))
    {
       echo json_encode(['status' => '200' ,'data' => $InquiryData]);   
   }
   else
   {
       echo json_encode(['status' => '404' ,'msg' => 'Something Wrong !']);
   }
  }

}