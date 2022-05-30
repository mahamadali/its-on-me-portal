<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	public $data; 

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('User', 'user');
        $this->load->helper(array('form', 'general'));
    }

    public function index()
    {      

       if(!$this->session->userdata('admin'))
       {
           redirect('/');
       }


       $this->data['page'] = "user/index";
       $this->load->view('structure',$this->data);  

   }

   public function create()
   {
      $this->data['provinces'] = provinces();
      $this->data['page'] = "user/create";   
      $this->load->view('structure',$this->data); 
  }
  public function store(){
      $UsersData = $this->input->post();
      $UsersData['password'] = md5($UsersData['password']);
      $checkUsernameAvailable = $this->user->findByColumn('username', $UsersData['username']);
      if($checkUsernameAvailable  > 0) {
        $this->session->set_flashdata('warning', 'Username already exist!');
        redirect('users/create');
      }
      $checkEmailAvailable = $this->user->findByColumn('email', $UsersData['email']);
      if($checkEmailAvailable  > 0) {
        $this->session->set_flashdata('warning', 'Email already exist!');
        redirect('users/create');
      }

      $User_id = $this->user->insert_data_getid($UsersData,'users');

      if (!empty($User_id)) {
          $this->session->set_flashdata('success', 'User created successfully!');

      }else{
        $this->session->set_flashdata('error', 'Something Wrong!');

    }
    
    redirect('users');
}

public function delete($id){


  $user_id = $this->user->delete_data('admin','id',$id);

  if(!empty($user_id)) {
      $this->session->set_flashdata('success', 'User deleted successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}

redirect('user');
}


public function get_users()
{
    $fetch_data = $this->user->make_datatables();  
    $data = array();  
    foreach($fetch_data as $row)  
    {  
        $sub_array = array();    
        $sub_array[] = $row->first_name;  
        $sub_array[] = $row->last_name;  
        $sub_array[] = $row->email;  
        $sub_array[] = $row->username;  
        $sub_array[] = $row->phone;  
        $sub_array[] = province($row->province)->name;
        $sub_array[] = '<strong>'.userStatus($row->status).'</strong>';
        $actionBtn = '';
        if($row->status == 0 || $row->status == 1) {
          $actionBtn = '
          <a href="'.base_url().'users/status-change/'.$row->id.'/2" class="btn btn-sm btn-danger">BAN</a>
          ';
        } else if($row->status == 2) {
          $actionBtn = '
          <a href="'.base_url().'users/status-change/'.$row->id.'/1" class="btn btn-sm btn-success">Active</a>';
        }
        $sub_array[] = $actionBtn;
        $data[] = $sub_array;  
    }  
    $output = array(  
        "draw"                    =>     intval($_POST["draw"]),  
        "recordsTotal"          =>      $this->user->get_all_data(),  
        "recordsFiltered"     =>     $this->user->get_filtered_data(),  
        "data"                    =>     $data  
    );  
    echo json_encode($output);  

}

public function statusChange($id, $status) {

  $data = array('status' => $status);
  $this->user->updateColumn($data, $id);
  $this->session->set_flashdata('success', 'Status updated successfully!');
  redirect('users');
}  

}