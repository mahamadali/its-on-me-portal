<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public $data; 

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Products_model');
        $this->load->model('Merchant', 'merchant');
        $this->load->helper('form');
    }

    public function index()
    {      
     if(!$this->session->userdata('admin'))
     {
         redirect('/');
     }

     $this->data['page'] = "products/index";
     $this->data['AllProducts'] = $this->Products_model->get_all_data();
     $this->load->view('structure',$this->data);	 

 }

 public  function add_product_items()
 {
    $this->data['AllCategories'] = $this->Products_model->get_all_categories();
    $this->data['AllColors'] = $this->Products_model->get_all_colors();
    $this->data['AllSizes'] = $this->Products_model->get_all_sizes();
    $this->data['AllWoodFinishChoices'] = $this->Products_model->get_all_wood_finis_choices();
    $this->data['AllProductFormat'] = $this->Products_model->get_all_format();
    $this->data['page'] = "products/add";
    $this->load->view('structure',$this->data);  
}

public function store_product_items()
{
  $productData = $this->input->post();
  
  $productData['created_at'] = date('Y-m-d H:i:s');
  $productData['product_description'] = $this->input->post('product_description');
  $productData['shipping_returns'] = $this->input->post('shipping_returns');
  $productData['is_eligible_for_coupon_code'] = !empty($this->input->post('is_eligible_for_coupon_code')) ? '1' : '0';
  $data = array(); 
  $errorUploadType = $statusMsg = ''; 

  /* If files are selected to upload */

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
        // print_r($config);
        // print_r($this->upload->do_upload('file'));
        // print_r($this->upload->display_errors());
        // print_r($this->upload->data());
        // exit;
        /* Upload file to server */ 
        if($this->upload->do_upload('file')){ 
            /* Uploaded file data */ 
            $fileData = $this->upload->data(); 
            $uploadData[] = "assets/product_images/".$fileData['file_name']; 
        }else{  
            $errorUploadType .= $_FILES['file']['name'].' | ';  
        } 
    } 


    if(!empty($uploadData)){ 
        $productData['product_picture'] = implode(',', $uploadData);
        $sizes = [];
        if(!empty($this->input->post('has_size'))){

            $sizes = $productData['sizes'];
            unset($productData['has_size']);
            unset($productData['sizes']);
        }

        $colors = [];
        if(!empty($this->input->post('colors'))){

            $colors = $productData['colors'];
            unset($productData['colors']);
        }

        $wood_finish_choices = [];
        if(!empty($this->input->post('wood_finish_choice_id'))){

            $wood_finish_choices = $productData['wood_finish_choice_id'];
            unset($productData['wood_finish_choice_id']);
        }

        $suede_mat_color = [];
        if(!empty($this->input->post('suede_mat_color_id'))){

            $suede_mat_color = $productData['suede_mat_color_id'];
            unset($productData['suede_mat_color_id']);
        }

         $pro_format = [];
        if(!empty($this->input->post('pro_format_id'))){
            $pro_format = $productData['pro_format_id'];
            unset($productData['pro_format_id']);
        }

        if(!empty($this->input->post('wood_finish_choice_id')))
        {
            $productData['has_wood_finish_choice'] = $this->input->post('has_wood_finish_choice');
        }
        if(!empty($this->input->post('suede_mat_color_id')))
        {
            $productData['has_suede_mat_color'] = $this->input->post('has_suede_mat_color');
        }
        if(!empty($this->input->post('pro_format_id')))
        {
            $productData['has_format'] = $this->input->post('has_format');
        }

      

        $product_id = $this->Products_model->insert_data_getid($productData,'online_store_products');


        if(!empty($sizes)){

            foreach ($sizes as $key => $value) {
                $product_size = [];

                $product_size['product_id'] = $product_id;
                $product_size['size_id'] = $value;

                $this->Products_model->insert_data_getid($product_size,'product_sizes');
            }
        }

        if(!empty($colors)){

            foreach ($colors as $key => $value) {
                $product_colors = [];

                $product_colors['product_id'] = $product_id;
                $product_colors['color_id'] = $value;

                $this->Products_model->insert_data_getid($product_colors,'product_colors');
            }
        }


         if(!empty($wood_finish_choices)){

            foreach ($wood_finish_choices as $key => $value) {
                $product_wood_finish_choices = [];

                $product_wood_finish_choices['product_id'] = $product_id;
                $product_wood_finish_choices['wood_finish_choice_id'] = $value;

                $this->Products_model->insert_data_getid($product_wood_finish_choices,'product_wood_finish_choices');
            }
        }

         if(!empty($suede_mat_color)){

            foreach ($suede_mat_color as $key => $value) {
                $product_suede_mat_color = [];

                $product_suede_mat_color['product_id'] = $product_id;
                $product_suede_mat_color['mat_color_id'] = $value;

                $this->Products_model->insert_data_getid($product_suede_mat_color,'product_mat_color_choices');
            }
        }

        if(!empty($pro_format)){

            foreach ($pro_format as $key => $value) {
                $product_pro_format = [];

                $product_pro_format['product_id'] = $product_id;
                $product_pro_format['format_id'] = $value;

                $this->Products_model->insert_data_getid($product_pro_format,'product_format_choice_store');
            }
        }


        if (!empty($product_id)) {
          $this->session->set_flashdata('success', 'Product Item Added successfully!');

      }else{
        $this->session->set_flashdata('error', 'Something Wrong!');

    }   

}else{ 
    $this->session->set_flashdata('error', 'Sorry, there was an error uploading your file.');     
} 
}
else
{
    $this->session->set_flashdata('error', 'Please Upload Valid File!');
}


redirect('products');
}

public function delete_product_item($id)
{

  $item_photo = $this->Products_model->GetItemImageName($id);
  @unlink('assets/product_images/'.basename($item_photo));
  $item_id = $this->Products_model->delete_data('online_store_products','id',$id);
  

  if(!empty($item_id)) {
    $this->Products_model->delete_data('product_sizes','product_id',$id);
    $this->Products_model->delete_data('product_colors','product_id',$id);
    $this->session->set_flashdata('success', 'Product Itme deleted successfully!');

}else{
    $this->session->set_flashdata('error', 'Something Wrong!');
}
redirect('products');
}

public function approve_feature_item($id)
{
    $data = ['is_featured' => 1];
    $this->Products_model->update_product_detail($id, $data);
    $this->session->set_flashdata('success', 'Product approved as featured successfully!');
    redirect('products');
}

public function edit_product_item($id)
{
    $this->data['AllCategories'] = $this->Products_model->get_all_categories();
    $this->data['AllColors'] = $this->Products_model->get_all_colors(); 
    $this->data['AllSizes'] = $this->Products_model->get_all_sizes();
    $this->data['AllWoodFinishChoices'] = $this->Products_model->get_all_wood_finis_choices();
    $this->data['AllProductFormat'] = $this->Products_model->get_all_format();
    $this->data['AllProductSizes'] = $this->Products_model->get_all_product_sizes($id);
    $this->data['AllProductColors'] = $this->Products_model->get_all_product_colors($id);

    $this->data['AllProductWoodFinishChoices'] = $this->Products_model->get_all_product_wood_finish_choices($id);
    $this->data['AllProductSuedeMatColors'] = $this->Products_model->get_all_product_mat_color_choices($id);
    $this->data['AllProductFormatChoices'] = $this->Products_model->get_all_product_format($id);


    $this->data['product_data'] = $this->Products_model->get_product_item_data($id);
    $this->data['page'] = "products/edit";
    $this->load->view('structure',$this->data);  
}

public function update_product_item()
{    
    $product_id = $this->input->post('product_id');    
    $productData['updated_at'] = date('Y-m-d H:i:s');
    $productData['product_name'] = $this->input->post('product_name');
    $productData['product_price'] = $this->input->post('product_price');
    $productData['product_description'] = $this->input->post('product_description');
    $productData['shipping_returns'] = $this->input->post('shipping_returns');
    $productData['cat_id'] = $this->input->post('cat_id');
    $productData['status'] = $this->input->post('status');
    $productData['is_eligible_for_coupon_code'] = !empty($this->input->post('is_eligible_for_coupon_code')) ? '1' : '0';
     if(!empty($this->input->post('wood_finish_choice_id')))
        {
            $productData['has_wood_finish_choice'] = $this->input->post('has_wood_finish_choice');
        }
        if(!empty($this->input->post('suede_mat_color_id')))
        {
            $productData['has_suede_mat_color'] = $this->input->post('has_suede_mat_color');
        }
        if(!empty($this->input->post('pro_format_id')))
        {
            $productData['has_format'] = $this->input->post('has_format');
        }
    $data = array(); 
    $errorUploadType = $statusMsg = ''; 

    /* If files are selected to upload */
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
            $config['allowed_types'] = '*';  
            /* $config['max_size']    = '100'; */
            /* $config['max_width'] = '1024'; */
            /* $config['max_height'] = '768'; */

            /* Load and initialize upload library */
            $this->load->library('upload', $config); 
            $this->upload->initialize($config); 

            /* Upload file to server */ 
            if($this->upload->do_upload('file')){ 
                /* Uploaded file data */ 
                $item_photos = $this->Products_model->GetItemImageName($product_id);
                foreach (explode(',', $item_photos) as $key => $value) {
                    @unlink('assets/product_images/'.basename($value));     
                }
                $fileData = $this->upload->data(); 
                $uploadData[] = "assets/product_images/".$fileData['file_name']; 
            }else{  
                $errorUploadType .= $_FILES['file']['name'].' | ';  
            } 
        } 


    }
    else
    {
        $this->session->set_flashdata('error', 'Please Upload Valid File!');
    }


    if(!empty($uploadData))
    {
         $productData['product_picture'] = implode(',', $uploadData);
    }

    unset($productData['product_id']);

    $sizes = [];
    if(!empty($this->input->post('has_size'))){

        $sizes = $this->input->post('sizes');
        unset($productData['has_size']);
        unset($productData['sizes']);
    }


    $colors = [];
    if(!empty($this->input->post('colors'))){

        $colors = $this->input->post('colors');
        unset($productData['colors']);
    }

    $wood_finish_choices = [];
    if(!empty($this->input->post('wood_finish_choice_id'))){

        $wood_finish_choices = $this->input->post('wood_finish_choice_id');
        unset($productData['wood_finish_choice_id']);
    }

     $suede_mat_color = [];
    if(!empty($this->input->post('suede_mat_color_id'))){

        $suede_mat_color = $this->input->post('suede_mat_color_id');
        unset($productData['suede_mat_color_id']);
    }

    $pro_format = [];
    if(!empty($this->input->post('pro_format_id'))){

        $pro_format = $this->input->post('pro_format_id');
        unset($productData['pro_format_id']);
    }

    $edit_pro_id = $this->Products_model->update_product_detail($product_id,$productData);

    if (!empty($edit_pro_id)) {
      $item_id = $this->Products_model->delete_data('product_sizes','product_id',$product_id);

      if(!empty($sizes)){

        foreach ($sizes as $key => $value) {
            $product_size = [];

            $product_size['product_id'] = $product_id;
            $product_size['size_id'] = $value;

            $this->Products_model->insert_data_getid($product_size,'product_sizes');
        }
    }

    $color_item_id = $this->Products_model->delete_data('product_colors','product_id',$product_id);

    if(!empty($colors)){

        foreach ($colors as $key => $value) {
            $product_colors = [];
            $product_colors['product_id'] = $product_id;
            $product_colors['color_id'] = $value;

            $this->Products_model->insert_data_getid($product_colors,'product_colors');
        }
    }

     $wood_finish_choice_id = $this->Products_model->delete_data('product_wood_finish_choices','product_id',$product_id);

    if(!empty($wood_finish_choices)){

        foreach ($wood_finish_choices as $key => $value) {
            $product_wood_finish_choices = [];
            $product_wood_finish_choices['product_id'] = $product_id;
            $product_wood_finish_choices['wood_finish_choice_id'] = $value;

            $this->Products_model->insert_data_getid($product_wood_finish_choices,'product_wood_finish_choices');
        }
    }

     $suede_mat_color_id = $this->Products_model->delete_data('product_mat_color_choices','product_id',$product_id);

    if(!empty($suede_mat_color)){

        foreach ($suede_mat_color as $key => $value) {
            $product_suede_mat_color = [];
            $product_suede_mat_color['product_id'] = $product_id;
            $product_suede_mat_color['mat_color_id'] = $value;

            $this->Products_model->insert_data_getid($product_suede_mat_color,'product_mat_color_choices');
        }
    }

      $pro_format_id = $this->Products_model->delete_data('product_format_choice_store','product_id',$product_id);

    if(!empty($pro_format)){

        foreach ($pro_format as $key => $value) {
            $product_pro_format = [];
            $product_pro_format['product_id'] = $product_id;
            $product_pro_format['format_id'] = $value;

            $this->Products_model->insert_data_getid($product_pro_format,'product_format_choice_store');
        }
    }

    $this->session->set_flashdata('success', 'Product Data updated successfully!');

}else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}  


redirect('products');
}


public function update_member_status()
{

    if(empty($this->input->post('status')) && empty($this->input->post('member_id')))
    {
        $this->session->set_flashdata('error', 'Something Wrong!');
        redirect('members');
    }

    $status_val['can_do_gua_listing'] = $this->input->post('status');
    $member_id = $this->input->post('member_id');

    $updated_id = $this->Products_model->update_member_status($member_id,$status_val);

    if(!empty($updated_id))
    {
       echo json_encode(['status' => '200' ,'msg' => 'Status Updated successfully']);   
   }
   else
   {
       echo json_encode(['status' => '404' ,'msg' => 'Something Wrong !']);
   }
}

}