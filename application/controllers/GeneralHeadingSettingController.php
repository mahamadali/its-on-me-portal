<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralHeadingSettingController extends CI_Controller {

	public $data;

	public function __construct(){
        parent::__construct();
        $this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Services_model');
        $this->load->helper('form');
    }

    public function index()
    {      

       if(!$this->session->userdata('admin'))
       {
           redirect('/');
       }

       $this->data['page'] = "services/general_heading_setting";
       $this->data['InsuranceHeadingText'] = $this->Services_model->get_heading_text();
       $this->load->view('structure',$this->data);	 

   }

   public function update_heading()
   {
            $insurance_heading_id = $this->input->post('insurance_heading_id');
            $HeadingServiceData['insurance_heading'] = $this->input->post('insurance_heading');
            $HeadingServiceData['authentication_heading'] = $this->input->post('authentication_heading');
            $HeadingServiceData['storage_heading'] = $this->input->post('storage_heading');
            $HeadingServiceData['custom_display_heading'] = $this->input->post('custom_display_heading');
            $HeadingServiceData['photo_match_heading'] = $this->input->post('photo_match_heading');
            $HeadingServiceData['exclusive_listing_heading'] = $this->input->post('exclusive_listing_heading');
            $HeadingServiceData['ebay_listing_heading'] = $this->input->post('ebay_listing_heading');
            $HeadingServiceData['other_listing_heading'] = $this->input->post('other_listing_heading');
            $HeadingServiceData['my_collection_heading'] = $this->input->post('my_collection_heading');
            $HeadingServiceData['all_collection_heading'] = $this->input->post('all_collection_heading');
            $HeadingServiceData['collection_showcase_heading'] = $this->input->post('collection_showcase_heading');
            if(!empty($insurance_heading_id))
            {
                  $update_id = $this->Services_model->update_heading_detail($insurance_heading_id,$HeadingServiceData,'general_heading_setting');

                  if (!empty($update_id)) {
                    $this->session->set_flashdata('success', 'Heading data Updated successfully!');

                  }else{
                      $this->session->set_flashdata('error', 'Something Wrong!');

                  }     
            }
            else
            {
              $HeadingServiceData['insurance_heading'] = $this->input->post('insurance_heading');
              $HeadingServiceData['authentication_heading'] = $this->input->post('authentication_heading');
              $HeadingServiceData['storage_heading'] = $this->input->post('storage_heading');
              $HeadingServiceData['custom_display_heading'] = $this->input->post('custom_display_heading');
              $HeadingServiceData['photo_match_heading'] = $this->input->post('photo_match_heading');
              $HeadingServiceData['exclusive_listing_heading'] = $this->input->post('exclusive_listing_heading');
              $HeadingServiceData['ebay_listing_heading'] = $this->input->post('ebay_listing_heading');
            $HeadingServiceData['other_listing_heading'] = $this->input->post('other_listing_heading');
            $HeadingServiceData['my_collection_heading'] = $this->input->post('my_collection_heading');
            $HeadingServiceData['all_collection_heading'] = $this->input->post('all_collection_heading');
            $HeadingServiceData['collection_showcase_heading'] = $this->input->post('collection_showcase_heading');
               $insurance_id = $this->Services_model->insert_data_getid($HeadingServiceData,'general_heading_setting');

                  if (!empty($insurance_id)) {
                    $this->session->set_flashdata('success', 'Heading data Updated successfully!');

                }else{
                  $this->session->set_flashdata('error', 'Something Wrong!');

              }   
            }

           
redirect('general_heading_setting');
   }


// Service Main Title 


    public function services_title()
    {      

       if(!$this->session->userdata('admin'))
       {
           redirect('/');
       }

       $this->data['page'] = "services/services_title";
       $this->data['ServicesTitleData'] = $this->Services_model->get_services_title();
       $this->load->view('structure',$this->data);   

   }

   public function update_services_title()
   {
      $id = $this->input->post('update_title_id');
      $text = $this->input->post('service_title_text');
      $is_hide = $this->input->post('is_hide');

      if(!empty($id) || !empty($text) || !empty($is_hide))
      {
         $HeadingServiceData['service_title'] = $text;
         $HeadingServiceData['is_hide'] = !empty($is_hide) ? 1 : 0;
         $update_id = $this->Services_model->update_heading_title($id,$HeadingServiceData,'game_used_services');
      }

      if (!empty($update_id)) {
                    $this->session->set_flashdata('success', 'Heading data Updated successfully!');

                }else{
                  $this->session->set_flashdata('error', 'Something Wrong!');

              }

    redirect('services_title');
   }

}

?>