<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MerchantController extends CI_Controller {

	public $data; 

	public function __construct(){
    parent::__construct();
    $this->data['header'] = $this->load->view('header',$this->data,true);
    $this->data['footer'] = $this->load->view('footer',$this->data,true);
    $this->load->model('Merchant', 'merchant');
    $this->load->helper(array('form', 'general'));
  }

  public function index()
  {      

   if(!$this->session->userdata('admin'))
   {
     redirect('/');
   }


   $this->data['page'] = "merchant/index";
   $this->load->view('structure',$this->data);  

 }

 public function create()
 {
  $this->data['provinces'] = provinces();
  $this->data['categories'] = categories();
  $this->data['page'] = "merchant/create";   
  $this->load->view('structure',$this->data); 
}
public function store(){
  $MerchantsData = $this->input->post();
  $MerchantsData['password'] = md5($MerchantsData['password']);
  $MerchantsData['categories'] = implode(',',$MerchantsData['categories']);
  $MerchantsData['created_at'] = date('Y-m-d H:i:s');

  if(!empty($_FILES['profile_picture']['name'])){ 
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


  $MerchantsData['profile_picture'] = $uploadData;
  $checkUsernameAvailable = $this->merchant->findByColumn('username', $MerchantsData['username']);
  if($checkUsernameAvailable  > 0) {
    $this->session->set_flashdata('warning', 'Username already exist!');
    redirect('merchants/create');
  }
  $checkEmailAvailable = $this->merchant->findByColumn('email', $MerchantsData['email']);
  if($checkEmailAvailable  > 0) {
    $this->session->set_flashdata('warning', 'Email already exist!');
    redirect('merchants/create');
  }

  $Merchant_id = $this->merchant->insert_data_getid($MerchantsData,'merchants');

  if (!empty($Merchant_id)) {
    $this->session->set_flashdata('success', 'Merchant created successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('merchants');
}

public function delete($id){

  $getImage = merchantProfile($id);
  @unlink('assets/merchant_profile/'.basename($getImage));
  $merchant_id = $this->merchant->delete_data('merchants','id',$id);
  $MerchantbankDelete = $this->merchant->delete_merchant_bank('merchant_banks','merchant_id',$id);
  if(!empty($merchant_id)) {
    $this->session->set_flashdata('success', 'Merchant deleted successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('merchants');
}


public function get_merchants()
{
  $fetch_data = $this->merchant->make_datatables();  
  $data = array();  
  foreach($fetch_data as $row)  
  {  
    $sub_array = array();    
    $sub_array[] = '<img src='.$row->profile_picture.' style="height:50px;width:50px">';  
    $sub_array[] = $row->username;  
    $sub_array[] = $row->email;    
    $sub_array[] = "R".$this->merchant->monthlyPayment($row->id);
    if($row->status == 0) {
      $sub_array[] = 'Suspend';
    } else if($row->status == 1) {
     $sub_array[] = 'Active</a>';
   }
   $actionBtn = '';
   if($row->status == 0) {
    $actionBtn = '
    <a href="'.base_url().'merchants/status-change/'.$row->id.'/1" class="btn btn-sm btn-success">Active</a>
    <a href="'.base_url().'merchants/edit/'.$row->id.'" class="btn btn-sm btn-info">Edit</a>
    <a href="'.base_url().'merchants/delete/'.$row->id.'" class="btn btn-sm btn-danger">Delete</a>
    <a href="'.base_url().'merchants/list-bank/'.$row->id.'" class="btn btn-sm btn-warning"><i class="fa fa-plus"></i> Bank</a>
    <a href="'.base_url().'merchants/transactions/'.$row->id.'" class="btn btn-sm btn-primary"><i class="fa fa-money"></i> Transactions</a>
    <a href="'.base_url().'merchants/payment/'.$row->id.'" class="btn btn-sm btn-info"><i class="fa fa-money"></i>Pay</a>
    ';
  } else if($row->status == 1) {
    $actionBtn = '
    <a href="'.base_url().'merchants/status-change/'.$row->id.'/0" class="btn btn-sm btn-danger">Suspend</a>
    <a href="'.base_url().'merchants/edit/'.$row->id.'" class="btn btn-sm btn-info">Edit</a>
    <a href="'.base_url().'merchants/delete/'.$row->id.'" class="btn btn-sm btn-danger">Delete</a>
    <a href="'.base_url().'merchants/list-bank/'.$row->id.'" class="btn btn-sm btn-warning"><i class="fa fa-plus"></i> Bank</a>
    <a href="'.base_url().'merchants/transactions/'.$row->id.'" class="btn btn-sm btn-primary"><i class="fa fa-money"></i> Transactions</a>
    <a href="'.base_url().'merchants/payment/'.$row->id.'" class="btn btn-sm btn-info"><i class="fa fa-money"></i>Pay</a>
    ';
  }
  $sub_array[] = $actionBtn;
  $data[] = $sub_array;  
}  
$output = array(  
  "draw"                    =>     intval($_POST["draw"]),  
  "recordsTotal"          =>      $this->merchant->get_all_data(),  
  "recordsFiltered"     =>     $this->merchant->get_filtered_data(),  
  "data"                    =>     $data  
);  
echo json_encode($output);  

}

public function statusChange($id, $status) {

  $data = array('status' => $status);
  $this->merchant->updateColumn($data, $id);
  $this->session->set_flashdata('success', 'Status updated successfully!');
  redirect('merchants');
}  


public function edit($id)
{
  $this->data['provinces'] = provinces();
  $this->data['merchant_data'] = $this->merchant->get_merchant_data($id);
  $this->data['categories'] = categories();
   // print_r($this->data['merchant_data']->profile_picture);exit();
  $this->data['page'] = "merchant/edit";
  $this->load->view('structure',$this->data);  
}

public function update()
{

      //echo "<pre>";print_r($MerchantsData);exit();
  $MerchantsData = $this->input->post();
      //$updated_id = $this->input->post('merchant_edit_id');
  $merchant_edit_id = $this->input->post('merchant_edit_id');
  if(!empty($MerchantsData['password'])) {
    $MerchantsData['password'] = md5($MerchantsData['password']);  
  }
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

  redirect('merchants');

}


public function banks($id)
{
 $this->data['merchant_bank_list'] = $this->merchant->get_merchant_bank_list($id);
 $this->data['merchant_id'] = $id;
 $this->data['page'] = "merchant/list_banks";
 $this->load->view('structure',$this->data);  
}

public function add_bank($id)
{
  $this->data['merchant_id'] = $id;
  $this->data['page'] = "merchant/add_bank";
  $this->load->view('structure',$this->data); 
}

public function store_bank()
{
 $MerchantbankData = $this->input->post();
 $MerchantbankData['created_at'] = date('Y-m-d H:i:s');
 $Merchant_id = $this->merchant->insert_data_getid($MerchantbankData,'merchant_banks');

 if (!empty($Merchant_id)) {
  $this->session->set_flashdata('success', 'Merchant Bank created successfully!');

}else{
  $this->session->set_flashdata('error', 'Something Wrong!');

}

redirect('merchants/list-bank/'.$MerchantbankData['merchant_id']);

}

public function delete_bank($id,$merchant_id){

  $delete_bank_id = $this->merchant->delete_data('merchant_banks','id',$id);

  if(!empty($delete_bank_id)) {
    $this->session->set_flashdata('success', 'Merchant Bank deleted successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('merchants/list-bank/'.$merchant_id);
}

 public function edit_bank($id,$merchant_id)
{
  $this->data['merchant_bank_data'] = $this->merchant->get_merchant_bank_data($id);
  $this->data['page'] = "merchant/edit_bank";
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
    $this->session->set_flashdata('success', 'Merchant Bank updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

  }

  redirect('merchants/list-bank/'.$UpdatedMerchantbankData['merchant_id']);
}

   /*After Merchant Login Functions*/


   public function merchant_login()
   {

      $this->load->view('merchant/merchant_login');
   }

   public function check_login()
    {

       $data['error'] = '';
       $this->form_validation->set_rules('email', 'EMail', 'trim|required');
       $this->form_validation->set_rules('password', 'Password', 'trim|required');
       if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', 'Please follow validation rules!');
        redirect('merchant/login', 'refresh');
    }
    else
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password'); 
        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
        $query=$this->db->get('merchants');
        $get_user = $query->result();   

          if(!empty($get_user))
          {
              $merchantdata = array(
               'merchant' => $get_user[0]->id, 
               'email' => $get_user[0]->email
           );

            $this->session->set_userdata($merchantdata);
          }
            

            $row = $query->num_rows();

            if($row)
            {
                redirect('merchant/dashboard');
            }
            else
            {   
               $data['error'] = "1";
           }
           $this->load->view('merchant/merchant_login',$data);
       }
   }

   function logout()
   {
    $this->session->sess_destroy();
    redirect('merchant/login');
} 

   /*After Merchant Login Functions*/

   public function transactions($id) {
      $this->data['merchant_id'] = $id;
      $this->data['merchant'] = $this->merchant->getOne($id);
      $total = '';
      $month = $this->input->post('transaction_month') ?? date('m');
      $year = $this->input->post('transaction_year') ?? date('Y');
      $this->data['month'] = $month;
      $this->data['year'] = $year;
      if(!empty($month) && !empty($year))
      {
         $getTotalTransaction = $this->merchant->totalTransactionByMonthYear($id, $month,$year);
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
      $this->data['page'] = "merchant/transactions";
      $this->data['footer'] = $this->load->view('footer',$this->data,true);
      $this->load->view('structure',$this->data);
   }

   public function get_transactions($id) {
      
      $fetch_data = $this->merchant->make_datatables_transactions($id);  
      $data = array();  
      foreach($fetch_data as $row)  
      {  
        $sub_array = array();    
        $sub_array[] = $row->id;  
        $sub_array[] = $row->user_fullname;  
        $sub_array[] = $row->full_name;    
        $sub_array[] = $row->email;    
        $sub_array[] = $row->phone_number;    
        $sub_array[] = "R".$row->price;
        $sub_array[] = $row->date_to_send;
        $sub_array[] = $row->created_at;
        $sub_array[] = $row->status;
        
        $data[] = $sub_array;  
    }  
    $output = array(  
      "draw"                    =>     intval($_POST["draw"]),  
      "recordsTotal"          =>      $this->merchant->get_all_data_transactions($id),  
      "recordsFiltered"     =>     $this->merchant->get_filtered_data_transactions($id),  
      "data"                    =>     $data  
    );  
    echo json_encode($output);  
   }


   public function payment($id)
   {  
      $this->data['merchant'] = $this->merchant->getOne($id);
      $total = '';
      $month = $this->input->post('transaction_month') ?? date('m');
      $year = $this->input->post('transaction_year') ?? date('Y');
      $this->data['month'] = $month;
      $this->data['year'] = $year;
      if(!empty($month) && !empty($year))
      {
         $getTotalTransaction = $this->merchant->totalTransactionByMonthYear($id, $month,$year);
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
      $this->data['page'] = "merchant/transaction_payment";
      $this->load->view('structure',$this->data);  
   }

   public function paymentSuccess($id)
   {
      $pay_month = $this->input->post('payment_month');
      $pay_year = $this->input->post('payment_year');
      $PaymentData = array('is_paid' => 1);
      $total = '';
      if(!empty($pay_month) && !empty($pay_year))
      {
         $getTotalTransaction = $this->merchant->totalTransactionByMonthYear($id, $pay_month,$pay_year);
         if(!empty($getTotalTransaction->total_amount))
         {
            $total = $getTotalTransaction->total_amount;

         }
         else
         {
             $total = 0.00;
         }
         
      }

      $member_payment_data = array(
          'merchant_id' => $id,
          'pay_month' =>  $pay_month,
          'pay_year' =>  $pay_year,
          'amount' =>  $total,
      );
       $merchant_payment_log_id = $this->merchant->insert_data_getid($member_payment_data,'merchant_payment_logs');

      $updatePaymentData = $this->merchant->update_merchant_payment_details($PaymentData,$pay_month,$pay_year,$id);
      if (!empty($updatePaymentData)) {
        $this->session->set_flashdata('success', 'Payment successfully!');

      }else{
        $this->session->set_flashdata('error', 'Something Wrong!');

      }

      redirect('merchants');
   }

}