<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdvertisingController extends CI_Controller {

	public $data; 

	public function __construct(){
    parent::__construct();
    $this->data['header'] = $this->load->view('header',$this->data,true);
    $this->data['footer'] = $this->load->view('footer',$this->data,true);
    $this->load->model('Advertising_model', 'advertise');
    $this->load->helper(array('form', 'general'));
  }

  public function index()
  {      

   if(!$this->session->userdata('admin'))
   {
     redirect('/');
   }


   $this->data['AllAdvertisement'] = $this->advertise->get_all_data();
   $this->data['page'] = "advertise/index";
   $this->load->view('structure',$this->data);  

 }

public function add()
{
  $this->data['page'] = "advertise/add";
  $this->load->view('structure',$this->data); 
}

public function store()
{
 $AdvertisementData = $this->input->post();
  if(!empty($_FILES['banner_path']['name'])){ 
    $filename = time()."_".str_replace(' ','_',$_FILES['banner_path']['name']);
    $_FILES['file']['name']     = $filename; 
    $_FILES['file']['type']     = $_FILES['banner_path']['type']; 
    $_FILES['file']['tmp_name'] = $_FILES['banner_path']['tmp_name']; 
    $_FILES['file']['error']     = $_FILES['banner_path']['error']; 
    $_FILES['file']['size']     = $_FILES['banner_path']['size']; 

    $uploadPath = 'assets/banner_images/'; 
    $config['upload_path'] = $uploadPath; 
    $config['allowed_types'] = '*'; 
    $this->load->library('upload', $config); 
    $this->upload->initialize($config); 
    if($this->upload->do_upload('file')){ 
      $fileData = $this->upload->data(); 
      $uploadData = "assets/banner_images/".$filename; 
    }else{  
      $errorUploadType .= $_FILES['file']['name'].' | ';  
    }
  }


  $AdvertisementData['banner_path'] = $uploadData;
 $Advertisement_id = $this->advertise->insert_data_getid($AdvertisementData,'banners');

 if (!empty($Advertisement_id)) {
  $this->session->set_flashdata('success', 'Banner created successfully!');

}else{
  $this->session->set_flashdata('error', 'Something Wrong!');

}

redirect('advertising');

}

public function delete($id){

  $getImage = $this->advertise->getBannerImage($id);
    if(!empty($getImage))
    {
      @unlink('assets/banner_images/'.basename($getImage));
    }
  $delete_advertise_id = $this->advertise->delete_data('banners','id',$id);
  if(!empty($delete_advertise_id)) {
    $this->session->set_flashdata('success', 'Banner deleted successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('advertising');
}

 public function edit($id)
{
  $this->data['banner_data'] = $this->advertise->get_banner_data($id);
  $this->data['page'] = "advertise/edit";
  $this->load->view('structure',$this->data);  
}

 public function update()
{
  $UpdateAdvertisementData = $this->input->post();
  $edit_advt_id = $this->input->post('edit_advt_id');
   if(!empty($_FILES['banner_path']['name'])){ 
    $getImage = $this->advertise->getBannerImage($edit_advt_id);
    if(!empty($getImage))
    {
      @unlink('assets/banner_images/'.basename($getImage));
    }
    $filename = time()."_".str_replace(' ','_',$_FILES['banner_path']['name']);
    $_FILES['file']['name']     = $filename; 
    $_FILES['file']['type']     = $_FILES['banner_path']['type']; 
    $_FILES['file']['tmp_name'] = $_FILES['banner_path']['tmp_name']; 
    $_FILES['file']['error']     = $_FILES['banner_path']['error']; 
    $_FILES['file']['size']     = $_FILES['banner_path']['size']; 

    $uploadPath = 'assets/banner_images/'; 
    $config['upload_path'] = $uploadPath; 
    $config['allowed_types'] = '*'; 
    $this->load->library('upload', $config); 
    $this->upload->initialize($config); 
    if($this->upload->do_upload('file')){ 
      $fileData = $this->upload->data(); 
      $uploadData = "assets/banner_images/".$filename; 
    }else{  
      $errorUploadType .= $_FILES['file']['name'].' | ';  
    }

    $UpdateAdvertisementData['banner_path'] = $uploadData;
  }

    unset($UpdateAdvertisementData['edit_advt_id']);
  $advertise_id = $this->advertise->update_advertisement_detail($edit_advt_id,$UpdateAdvertisementData);
  if (!empty($advertise_id)) {
    $this->session->set_flashdata('success', 'Banner updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('advertising');
}

  public function statusChange($id, $status) {

  $data = array('status' => $status);
  $this->advertise->updateColumn($data, $id);
  $this->session->set_flashdata('success', 'Status updated successfully!');
  redirect('advertising');
} 
}