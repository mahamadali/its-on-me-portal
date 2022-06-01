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

    public function userTransaction_post()
    {
         $input = $this->input->post();
         if(!isset($input['user_id'])) {
          return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
         }
         $code = $this->user->generateRandomString(6);
         $data = [
            'user_id' => $input['user_id'],
            'full_name' => $input['full_name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'date_to_send' => $input['date_to_send'],
            'payment_method' => $input['payment_method'],
            'message_attached' => $input['message_attached'],
            'menu_items' => $input['menu_items'],
            'price' => $input['price'],
            'quantity' => $input['quantity'],
            'code' => $code,
        ];
        $id = $this->user->insert_data_getid($data, 'transactions');

        $checkUserExist = $this->user->check_user_exist($input['user_id']);
        if($checkUserExist == 1)
        {

              $this->email->from('info@itsonme.co.za', 'ITSONME');
              $this->email->to($input['email']);
              $this->email->subject('Verification Code - ITSONME');
              $message = "Hey ".$input['full_name']." your order is on me. Your its on me CODE is ". $code ."";
              $message .= "<p>Thanks,</p>";
              $message .= "<p>ITSONME Team<br></p>";
              $this->email->message($message);
              $this->email->set_mailtype('html');
              $this->email->set_newline("\r\n");
              $this->email->send();
        }
        else
        {
              $this->email->from('info@itsonme.co.za', 'ITSONME');
              $this->email->to($input['email']);
              $this->email->subject('Verification Code - ITSONME');
              $message = "Hey ".$input['full_name']." your order is on me. Download app to get code";
              $message .= "<p>Thanks,</p>";
              $message .= "<p>ITSONME Team<br></p>";
              $this->email->message($message);
              $this->email->set_mailtype('html');
              $this->email->set_newline("\r\n");
              $this->email->send();
        } 

        if($id) {
            $this->response(['status' => 'success', 'message' => 'Transaction created successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Incorrect login credentials!'], REST_Controller::HTTP_OK);
        }
    }
}