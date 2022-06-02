<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MerchantDashboardController extends CI_Controller {

	public $data;

	public function __construct(){
        parent::__construct();
       	$this->data['header'] = $this->load->view('merchant_header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Merchant_Dashboard_model');
        $this->load->model('Merchant', 'merchant');
        $this->load->model('User', 'user');
        $this->load->helper('form');
        $this->load->helper('general');
      }

	public function index()
	{
         if(!$this->session->userdata('merchant'))
         {
             redirect('merchant/login');
         }
        $this->data['total_items'] = $this->Merchant_Dashboard_model->get_all_product_count();
        $this->data['page'] = "dashboard/merchant_index";
		$this->load->view('structure',$this->data);	 

	}	

	public function profile()
	{
    $this->data['provinces'] = provinces();
		$loggedIn = !empty($_SESSION['merchant']) ? $_SESSION['merchant'] : '';
		$this->data['merchant_data'] = $this->merchant->get_merchant_data($loggedIn);
  		$this->data['categories'] = categories();
		$this->data['page'] = "merchant/merchant_profile";
		$this->load->view('structure',$this->data);	 
	}

	public function profileupdate()
{

  $MerchantsData = $this->input->post();
  $merchant_edit_id = $this->input->post('merchant_edit_id');
  $MerchantsData['password'] = md5($MerchantsData['password']);
  $MerchantsData['categories'] = implode(',',$MerchantsData['categories']);
  $MerchantsData['updated_at'] = date('Y-m-d H:i:s');

  if(!empty($_FILES['profile_picture']['name'])){ 
    $getImage = merchantProfile($merchant_edit_id);
    @unlink('assets/merchant_profile/'.basename($getImage));
    $filename = time()."_".str_replace(' ','_',$_FILES['profile_picture']['name']);
    $_FILES['file']['name']     = $filename; 
    $_FILES['file']['type']     = $_FILES['profile_picture']['type']; 
    $_FILES['file']['tmp_name'] = $_FILES['profile_picture']['tmp_name']; 
    $_FILES['file']['error']     = $_FILES['profile_picture']['error']; 
    $_FILES['file']['size']     = $_FILES['profile_picture']['size']; 

    $uploadPath = 'assets/merchant_profile/'; 
    $config['upload_path'] = $uploadPath; 
    $config['allowed_types'] = '*'; 
    $this->load->library('upload', $config); 
    $this->upload->initialize($config); 
    if($this->upload->do_upload('file')){ 
      $fileData = $this->upload->data(); 
      $uploadData = "assets/merchant_profile/".$filename; 
    }else{  
      $errorUploadType .= $_FILES['file']['name'].' | ';  
    }
  }

  if(!empty($uploadData))
  {
    $MerchantsData['profile_picture'] = $uploadData;
  }

  $checkUsernameAvailable = $this->merchant->findByColumnId('username', $MerchantsData['username'],$merchant_edit_id);
  if($checkUsernameAvailable  > 0) {
    $this->session->set_flashdata('warning', 'Username already exist!');
    redirect('merchants/edit/'.$merchant_edit_id);
  }
  $checkEmailAvailable = $this->merchant->findByColumnId('email', $MerchantsData['email'],$merchant_edit_id);
  if($checkEmailAvailable  > 0) {
    $this->session->set_flashdata('warning', 'Email already exist!');
    redirect('merchants/edit/'.$merchant_edit_id);
  }

  

  unset($MerchantsData['merchant_edit_id']);
      //$Merchant_id = $this->merchant->insert_data_getid($MerchantsData,'merchants');
  $Merchant_id = $this->merchant->update_merchant_detail($merchant_edit_id,$MerchantsData);
  if (!empty($Merchant_id)) {
    $this->session->set_flashdata('success', 'Merchant updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('merchant/profile');
}

	 public function list_banks($id)
	{
	 $this->data['merchant_bank_list'] = $this->merchant->get_merchant_bank_list($id);
	 $this->data['merchant_id'] = $id;
	 $this->data['page'] = "merchantdata/list_banks";
	 $this->load->view('structure',$this->data);  
	}

	public function add_bank($id)
	{
	  $this->data['merchant_id'] = $id;
	  $this->data['page'] = "merchantdata/add_bank";
	  $this->load->view('structure',$this->data); 
	}

	public function store_bank()
	{
	 $MerchantbankData = $this->input->post();
	 $MerchantbankData['created_at'] = date('Y-m-d H:i:s');
	 $Merchant_id = $this->merchant->insert_data_getid($MerchantbankData,'merchant_banks');

	 if (!empty($Merchant_id)) {
	  $this->session->set_flashdata('success', 'Bank created successfully!');

	}else{
	  $this->session->set_flashdata('error', 'Something Wrong!');

	}

	redirect('merchant/list-bank/'.$MerchantbankData['merchant_id']);

	}

	public function delete_bank($id,$merchant_id){

  $delete_bank_id = $this->merchant->delete_data('merchant_banks','id',$id);

  if(!empty($delete_bank_id)) {
    $this->session->set_flashdata('success', 'Bank deleted successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('merchant/list-bank/'.$merchant_id);
}

public function edit_bank($id,$merchant_id)
{
  $this->data['merchant_bank_data'] = $this->merchant->get_merchant_bank_data($id);
  $this->data['page'] = "merchantdata/edit_bank";
  $this->load->view('structure',$this->data);  
}


public function update_bank()
{
  $UpdatedMerchantbankData = $this->input->post();
 
  $edit_bank_id = $this->input->post('edit_bank_id');
  $UpdatedMerchantbankData['created_at'] = date('Y-m-d H:i:s');
    unset($UpdatedMerchantbankData['edit_bank_id']);
  $Merchant_id = $this->merchant->update_merchant_bank_detail($edit_bank_id,$UpdatedMerchantbankData);
  if (!empty($Merchant_id)) {
    $this->session->set_flashdata('success', 'Bank data updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('merchant/list-bank/'.$UpdatedMerchantbankData['merchant_id']);
}

  public function transactions()
  {   
     $id = $this->session->userdata('merchant');
     $this->data['merchant_id'] = $id;
      $this->data['merchant'] = $this->merchant->getOne($id);
      $total = '';
      $month = $this->input->post('transaction_month') ?? date('m');
      $year = $this->input->post('transaction_year') ?? date('Y');
      $this->data['month'] = $month;
      $this->data['year'] = $year;
      if(!empty($month) && !empty($year))
      {
         $getTotalTransaction = $this->merchant->MerchanttotalTransactionByMonthYear($id, $month,$year);
         if(!empty($getTotalTransaction->total_amount))
         {
            $total = $getTotalTransaction->total_amount;

         }
         else
         {
             $total = 0.00;
         }
         
      }
      
      $this->data['total_amount'] = $total;
      $this->data['page'] = "merchant/merchant_transaction";
      $this->data['footer'] = $this->load->view('footer',$this->data,true);
      $this->load->view('structure',$this->data);
  }

}