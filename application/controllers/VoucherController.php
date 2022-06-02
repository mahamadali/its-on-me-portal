<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VoucherController extends CI_Controller {

	public $data; 

	public function __construct(){
    parent::__construct();
    $this->data['header'] = $this->load->view('header',$this->data,true);
    $this->data['footer'] = $this->load->view('footer',$this->data,true);
    $this->load->model('Voucher_model', 'voucher');
    $this->load->helper(array('form', 'general'));
  }

  public function index()
  {      
   
    if(!$this->session->userdata('admin'))
   {
     redirect('/');
   }


   $this->data['AllVouchers'] = $this->voucher->get_all_data();
   $this->data['page'] = "voucher/index";
   $this->load->view('structure',$this->data);  

 }

public function add()
{
  $this->data['page'] = "voucher/add";
  $this->load->view('structure',$this->data); 
}

public function store()
{
  $VoucherData = $this->input->post();
  if(!empty($_FILES['voucher_photo']['name'])){ 
    $filename = time()."_".str_replace(' ','_',$_FILES['voucher_photo']['name']);
    $_FILES['file']['name']     = $filename; 
    $_FILES['file']['type']     = $_FILES['voucher_photo']['type']; 
    $_FILES['file']['tmp_name'] = $_FILES['voucher_photo']['tmp_name']; 
    $_FILES['file']['error']     = $_FILES['voucher_photo']['error']; 
    $_FILES['file']['size']     = $_FILES['voucher_photo']['size']; 

    $uploadPath = 'assets/voucher_photos/'; 
    $config['upload_path'] = $uploadPath; 
    $config['allowed_types'] = '*'; 
    $this->load->library('upload', $config); 
    $this->upload->initialize($config); 
    if($this->upload->do_upload('file')){ 
      $fileData = $this->upload->data(); 
      $uploadData = "assets/voucher_photos/".$filename; 
    }else{  
      $errorUploadType .= $_FILES['file']['name'].' | ';  
    }
  }

  $VoucherData['voucher_photo'] = $uploadData;
 $Voucher_id = $this->voucher->insert_data_getid($VoucherData,'vouchers');

 if (!empty($Voucher_id)) {
  $this->session->set_flashdata('success', 'Voucher created successfully!');

}else{
  $this->session->set_flashdata('error', 'Something Wrong!');

}

redirect('vouchers');
}

public function delete($id){

  $getImage = $this->voucher->getVoucherImage($id);
    if(!empty($getImage))
    {
      @unlink('assets/voucher_photos/'.basename($getImage));
    }
  $delete_voucher = $this->voucher->delete_data('vouchers','id',$id);
  if(!empty($delete_voucher)) {
    $this->session->set_flashdata('success', 'Voucher deleted successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('vouchers');
}

 public function edit($id)
{
  $this->data['voucher_data'] = $this->voucher->get_voucher_data($id);
  $this->data['page'] = "voucher/edit";
  $this->load->view('structure',$this->data);  
}

 public function update()
{
  $UpdateVoucherData = $this->input->post();
  $edit_voucer_id = $this->input->post('edit_voucer_id');
   if(!empty($_FILES['voucher_photo']['name'])){ 
    $getImage = $this->voucher->getVoucherImage($edit_voucer_id);
    if(!empty($getImage))
    {
      @unlink('assets/voucher_photos/'.basename($getImage));
    }
    $filename = time()."_".str_replace(' ','_',$_FILES['voucher_photo']['name']);
    $_FILES['file']['name']     = $filename; 
    $_FILES['file']['type']     = $_FILES['voucher_photo']['type']; 
    $_FILES['file']['tmp_name'] = $_FILES['voucher_photo']['tmp_name']; 
    $_FILES['file']['error']     = $_FILES['voucher_photo']['error']; 
    $_FILES['file']['size']     = $_FILES['voucher_photo']['size']; 

    $uploadPath = 'assets/voucher_photos/'; 
    $config['upload_path'] = $uploadPath; 
    $config['allowed_types'] = '*'; 
    $this->load->library('upload', $config); 
    $this->upload->initialize($config); 
    if($this->upload->do_upload('file')){ 
      $fileData = $this->upload->data(); 
      $uploadData = "assets/voucher_photos/".$filename; 
    }else{  
      $errorUploadType .= $_FILES['file']['name'].' | ';  
    }

    $UpdateVoucherData['voucher_photo'] = $uploadData;
  }

    unset($UpdateVoucherData['edit_voucer_id']);
  $voucher_id = $this->voucher->update_voucher_detail($edit_voucer_id,$UpdateVoucherData);
  if (!empty($voucher_id)) {
    $this->session->set_flashdata('success', 'Voucher updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('vouchers');
}

 


}