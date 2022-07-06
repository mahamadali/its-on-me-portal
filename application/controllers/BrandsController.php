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