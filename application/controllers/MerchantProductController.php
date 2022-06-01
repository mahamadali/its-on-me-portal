<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MerchantProductController extends CI_Controller {

	public $data; 

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('merchant_header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Merchant_Product_model', 'merchant_product');
        $this->load->model('Merchant', 'merchant');
        $this->load->model('Voucher_model', 'voucher');
        $this->load->helper('form');
        $this->load->helper('general');
    }

    public function index()
    {      
       if(!$this->session->userdata('merchant'))
       {
           redirect('merchant/login');
       }

       $this->data['page'] = "products/index";
       $this->data['AllProducts'] = $this->merchant_product->get_all_data();
       $this->load->view('structure',$this->data);	 

   }

   public  function add_product_items()
   {
    $this->data['categories'] = categories();
    $this->data['page'] = "products/add";
    $this->load->view('structure',$this->data);  
}

public function store_product_items()
{

  $MerchantProductdata['created_at'] = date('Y-m-d H:i:s');
  $MerchantProductdata['merchant_id'] = $_SESSION['merchant'];
  $MerchantProductdata['product_name'] = $this->input->post('product_name');
  $MerchantProductdata['product_price'] = $this->input->post('product_price');
  $MerchantProductdata['apply_featured'] = $this->input->post('apply_featured');
  $MerchantProductdata['product_description'] = $this->input->post('product_description');
  $MerchantProductdata['categories'] = implode(',',$this->input->post('categories'));
  
  if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
    $filesCount = count($_FILES['files']['name']); 
    for($i = 0; $i < $filesCount; $i++){ 
        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
         $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 

        /* File upload configuration */
        $uploadPath = 'assets/product_images/'; 
        $config['upload_path'] = $uploadPath; 
        // $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|JPG|JPEG|PNG|GIF'; 
        $config['allowed_types'] = '*'; 
        // $config['max_size']    = '1000000';
        //  $config['max_width'] = '1024'; 
        //  $config['max_height'] = '768'; 

        /* Load and initialize upload library */
        $this->load->library('upload', $config); 
        $this->upload->initialize($config); 
        /* Upload file to server */ 
        if($this->upload->do_upload('file')){ 
            /* Uploaded file data */ 
            $fileData = $this->upload->data(); 
            $uploadData[] = "assets/product_images/".$fileData['file_name']; 
        } 
    }

    $MerchantProductdata['product_image'] = implode(",", $uploadData);
    }

  $product_id = $this->merchant_product->insert_data_getid($MerchantProductdata,'products');

  if (!empty($product_id)) {
      $this->session->set_flashdata('success', 'Product Added successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}   
redirect('merchant/products');
}

    public function delete_product_item($id)
    {

      $item_id = $this->merchant_product->delete_data('products','id',$id);
      

      if(!empty($item_id)) {
        $this->session->set_flashdata('success', 'Product Item deleted successfully!');

    }else{
        $this->session->set_flashdata('error', 'Something Wrong!');
    }
    redirect('merchant/products');
    }


    public function edit_product_item($id)
{
    $this->data['categories'] = categories();
    $this->data['product_data'] = $this->merchant_product->get_product_item_data($id);
    $this->data['page'] = "products/edit";
    $this->load->view('structure',$this->data);  
}

 public function update_product_item()
 {

    $product_id = $this->input->post('product_id');    
    $productData['updated_at'] = date('Y-m-d H:i:s');
    $productData['product_name'] = $this->input->post('product_name');
    $productData['product_price'] = $this->input->post('product_price');
    $productData['apply_featured'] = $this->input->post('apply_featured');
    $productData['product_description'] = $this->input->post('product_description');
    $productData['categories'] = implode(',',$this->input->post('categories'));
   
    unset($productData['product_id']);

    if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
    $filesCount = count($_FILES['files']['name']); 
    for($i = 0; $i < $filesCount; $i++){ 
        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
         $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 

        /* File upload configuration */
        $uploadPath = 'assets/product_images/'; 
        $config['upload_path'] = $uploadPath; 
        // $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|JPG|JPEG|PNG|GIF'; 
        $config['allowed_types'] = '*'; 
        // $config['max_size']    = '1000000';
        //  $config['max_width'] = '1024'; 
        //  $config['max_height'] = '768'; 

        /* Load and initialize upload library */
        $this->load->library('upload', $config); 
        $this->upload->initialize($config); 
        /* Upload file to server */ 
        if($this->upload->do_upload('file')){ 
            /* Uploaded file data */ 
            $fileData = $this->upload->data(); 
            $uploadData[] = "assets/product_images/".$fileData['file_name']; 
        } 
    }

    $productData['product_image'] = implode(",", $uploadData);
    }

   

    $edit_pro_id = $this->merchant_product->update_product_detail($product_id,$productData);

    if (!empty($edit_pro_id)) {
        $this->session->set_flashdata('success', 'Product Data updated successfully!');
     
    }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}  
    redirect('merchant/products');

 }

 public function reedem_voucher()
 {
    $this->data['page'] = "merchant/reedem_index";
    $this->load->view('structure',$this->data); 
 }

 public function check_reedem_voucher()
 {
    $VoucherCode = $this->input->post('voucher_code');
    $CheckVoucherCode = $this->voucher->checkVoucherCode($VoucherCode);
     if(!empty($CheckVoucherCode))
     {
          if($CheckVoucherCode->is_redeemed == 0)
          {
             $GetProductItems = $this->voucher->getProductsByCode($VoucherCode);
             $this->data['user_id'] =  $CheckVoucherCode->id ;
             $this->data['GetProductItems'] = json_decode($GetProductItems);
             $this->data['page'] = "merchant/reedem_index";
              $this->load->view('structure',$this->data); 
          }
          else
          {
             $this->session->set_flashdata('warning', 'Voucher Code Already Used');
             redirect('merchant/reedem');
          }
     }
     else
     {
       $this->session->set_flashdata('warning', 'Invalid Voucher Code!');
       redirect('merchant/reedem');
     }

     
 }

 public function update_reedem_code($id)
 {
       $Voucherdata = array('is_redeemed'=> 1);
       $update_voucher_id = $this->voucher->update_voucher_reedem($id,$Voucherdata);

    if (!empty($update_voucher_id)) {
        $this->session->set_flashdata('success', 'Voucher reedem successfully!');
     
    }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}  
    redirect('merchant/reedem');
 }

}