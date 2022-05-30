<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PushNotificationController extends CI_Controller {

	public $data; 

	public function __construct(){
    parent::__construct();
    $this->data['header'] = $this->load->view('header',$this->data,true);
    $this->data['footer'] = $this->load->view('footer',$this->data,true);
    $this->load->model('PushNotification', 'push_notification');
    $this->load->helper(array('form', 'general'));
  }

  public function index()
  {      

   if(!$this->session->userdata('admin'))
   {
     redirect('/');
   }


   $this->data['push_notifications'] = $this->push_notification->get_all_data();
   $this->data['page'] = "push-notifications/index";
   $this->load->view('structure',$this->data);  

 }

 public function ajax_list() {
  $fetch_data = $this->push_notification->make_datatables();  
  $data = array();  
  foreach($fetch_data as $row)  
  {  
    $sub_array = array();    
    $sub_array[] = $row->id;  
    $sub_array[] = $row->title;  
    $sub_array[] = $row->message;    
    $sub_array[] = $this->push_notification->getProvincesByIds($row->province);
    $sub_array[] = $row->created_at;
    $data[] = $sub_array;  
  }  
  $output = array(  
    "draw"                    =>     intval($_POST["draw"]),  
    "recordsTotal"          =>      $this->push_notification->get_all_data(),  
    "recordsFiltered"     =>     $this->push_notification->get_filtered_data(),  
    "data"                    =>     $data  
  );
  echo json_encode($output);  
 }

public function create()
{
  $this->data['provinces'] = provinces();
  $this->data['page'] = "push-notifications/create";
  $this->load->view('structure',$this->data); 
}

public function store()
{
 $data = $this->input->post();
 $this->push_notification->send($data);
 $this->session->set_flashdata('success', 'Notification created successfully!');
 redirect('push-notifications');

}
}