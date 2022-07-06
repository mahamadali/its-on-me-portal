<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrandsController extends CI_Controller {

	public $data;

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Brands_model');
        $this->load->helper('form');
    }

    public function index()
    {      
       if(!$this->session->userdata('admin'))
       {
           redirect('/');
       }

       $this->data['page'] = "brands/index";
       $this->data['AllBrands'] = $this->Brands_model->get_all_data();
       $this->load->view('structure',$this->data);	 

   }

   public  function add()
   {
    $this->data['page'] = "brands/add";
    $this->load->view('structure',$this->data);  
}

public function store()
{

  $brandData['name'] = $this->input->post('name');
  $brandData['created_at'] = date('Y-m-d H:i:s');
  if(!empty($_FILES['logo']['name'])){ 
    $filename = time()."_".str_replace(' ','_',$_FILES['logo']['name']);
    $_FILES['file']['name']     = $filename; 
    $_FILES['file']['type']     = $_FILES['logo']['type']; 
    $_FILES['file']['tmp_name'] = $_FILES['logo']['tmp_name']; 
    $_FILES['file']['error']     = $_FILES['logo']['error']; 
    $_FILES['file']['size']     = $_FILES['logo']['size']; 

    $uploadPath = 'assets/brand_logos/'; 
    $config['upload_path'] = $uploadPath; 
    $config['allowed_types'] = '*'; 
    $this->load->library('upload', $config); 
    $this->upload->initialize($config); 
    if($this->upload->do_upload('file')){ 
      $fileData = $this->upload->data(); 
      $uploadData = "assets/brand_logos/".$filename; 
    }else{  
      $errorUploadType .= $_FILES['file']['name'].' | ';  
    }
  }
  $brandData['logo'] = $uploadData;
  $brand_id = $this->Brands_model->insert_data_getid($brandData,'brands');

  if (!empty($brand_id)) {
      $this->session->set_flashdata('success', 'Brand Added successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}   

redirect('brands');
}

public function delete($id)
{
    $getImage = $this->advertise->getBannerImage($id);
    if(!empty($getImage))
    {
      @unlink('assets/brand_logos/'.basename($getImage));
    }
  $brand_id = $this->Brands_model->delete_data('brands','id',$id);

  if(!empty($brand_id)) {
    $this->session->set_flashdata('success', 'Brand deleted successfully!');

}else{
    $this->session->set_flashdata('error', 'Something Wrong!');
}
redirect('brands');
}

public function edit($id)
{
   $this->data['brandData'] = $this->Brands_model->get_brand_data($id);
   $this->data['page'] = "brands/edit";
   $this->load->view('structure',$this->data);  
}

public function update()
{
    $brandData['name'] = $this->input->post('name');
    $brand_id = $this->input->post('brand_id');
    if(!empty($_FILES['logo']['name'])){ 
    $getImage = $this->Brands_model->getBrandImage($edit_advt_id);
    if(!empty($getImage))
    {
      @unlink('assets/brand_logos/'.basename($getImage));
    }
    $filename = time()."_".str_replace(' ','_',$_FILES['logo']['name']);
    $_FILES['file']['name']     = $filename; 
    $_FILES['file']['type']     = $_FILES['logo']['type']; 
    $_FILES['file']['tmp_name'] = $_FILES['logo']['tmp_name']; 
    $_FILES['file']['error']     = $_FILES['logo']['error']; 
    $_FILES['file']['size']     = $_FILES['logo']['size']; 

    $uploadPath = 'assets/brand_logos/'; 
    $config['upload_path'] = $uploadPath; 
    $config['allowed_types'] = '*'; 
    $this->load->library('upload', $config); 
    $this->upload->initialize($config); 
    if($this->upload->do_upload('file')){ 
      $fileData = $this->upload->data(); 
      $uploadData = "assets/brand_logos/".$filename; 
    }else{  
      $errorUploadType .= $_FILES['file']['name'].' | ';  
    }

    $brandData['logo'] = $uploadData;
  }
     unset($brandData['brand_id']);

          $edit_brand_id = $this->Brands_model->update_brand_detail($brand_id,$brandData);

    if (!empty($edit_brand_id)) {
      $this->session->set_flashdata('success', 'Brand Updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}   
    redirect('brands');
}


}