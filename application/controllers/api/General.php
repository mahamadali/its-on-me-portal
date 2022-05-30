<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class General extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->helper('general');
       $this->load->model('User', 'user');
       $this->load->library('email');
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function banners_get()
    {
        $this->db->select('banners.*, CONCAT("'.base_url().'", `banners`.banner_path) as banner_url');
        $response = $this->db->get('banners')->result_array();
        $this->response(['status' => 'success', 'data' => $response], REST_Controller::HTTP_OK);
    }
}