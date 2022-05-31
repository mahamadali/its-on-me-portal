<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductCategories extends CI_Controller {

	public $data;

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Product_categories_model');
        $this->load->helper('form');
    }

    public function index()
    {      
       if(!$this->session->userdata('admin'))
       {
           redirect('/');
       }

       $this->data['page'] = "product_categories/index";
       $this->data['AllCategories'] = $this->Product_categories_model->get_all_data();
       $this->load->view('structure',$this->data);	 

   }

   public  function add_cat()
   {
    $this->data['page'] = "product_categories/add";
    $this->load->view('structure',$this->data);  
}

public function store_cat()
{

  $catData['name'] = $this->input->post('name');
  $catData['created_at'] = date('Y-m-d H:i:s');
  $product_id = $this->Product_categories_model->insert_data_getid($catData,'categories');

  if (!empty($product_id)) {
      $this->session->set_flashdata('success', 'Category Added successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}   

redirect('product-categories');
}

public function delete_cat($id)
{
  $cat_id = $this->Product_categories_model->delete_data('categories','id',$id);

  if(!empty($cat_id)) {
    $this->session->set_flashdata('success', 'Category deleted successfully!');

}else{
    $this->session->set_flashdata('error', 'Something Wrong!');
}
redirect('product-categories');
}

public function edit_cat($id)
{
   $this->data['cat_data'] = $this->Product_categories_model->get_category_data($id);
   $this->data['page'] = "product_categories/edit";
   $this->load->view('structure',$this->data);  
}

public function update_cat()
{
    $catData['name'] = $this->input->post('name');
    $cat_id = $this->input->post('cat_id');
    $catData['updated_at'] = date('Y-m-d H:i:s');
     unset($catData['cat_id']);

          $edit_cat_id = $this->Product_categories_model->update_cat_detail($cat_id,$catData);

    if (!empty($edit_cat_id)) {
      $this->session->set_flashdata('success', 'Category Updated successfully!');

  }else{
    $this->session->set_flashdata('error', 'Something Wrong!');

}   
    redirect('product-categories');
}


}