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

        // Generate Payment Link
        $paymentData = $this->generatePaymentLink($data); 

        $id = $this->user->insert_data_getid($data, 'transactions');

        $checkUserExist = $this->user->check_user_exist($input['user_id']);
        if($checkUserExist == 1)
        {

              $this->email->from('info@itsonme.co.za', 'ITSONME');
              $this->email->to($input['email']);
              $this->email->subject('Transaction Gift Code - ITSONME');
              $message = "Hey ".$input['full_name']." your order is on me. Your its on me CODE is ". $code ."";
              $message .= "<p>Thanks,</p>";
              $message .= "<p>ITSONME Team<br></p>";
              $this->email->message($message);
              $this->email->set_mailtype('html');
              $this->email->set_newline("\r\n");
              $this->email->send();
         
             $getUserTokens = $this->user->getTokens($input['user_id']);
            if(!empty($getUserTokens))
            {
               $message = "Hey ".$input['full_name']." your order is on me. Your its on me CODE is ". $code ."";
               $title = "Transaction gift code";
               $link = '';
               foreach ($getUserTokens as $key => $token) {
                     $this->user->sendNotificationUser($token['device_token'],$title,$message,$link);
                     $user_notification_data = [
                    'user_id' => $input['user_id'],
                    'title' => $title,
                    'message' => $message,
                    'link' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                   ];
                   $this->user->insert_data_getid($user_notification_data, 'user_notifications');
                  }   
            }

        }
        else
        {
              $this->email->from('info@itsonme.co.za', 'ITSONME');
              $this->email->to($input['email']);
              $this->email->subject('Transaction Gift Code - ITSONME');
              $message = "Hey ".$input['full_name']." your order is on me. Download app to get code";
              $message .= "<p>Thanks,</p>";
              $message .= "<p>ITSONME Team<br></p>";
              $this->email->message($message);
              $this->email->set_mailtype('html');
              $this->email->set_newline("\r\n");
              $this->email->send();
        }

        

         
        if($id) {
            $this->response([
                'status' => 'success', 
                'message' => 'Transaction created successfully',
                'paymentRequestId' => $paymentData->paymentRequestId,
                'url' => $paymentData->url
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Transaction failed!'], REST_Controller::HTTP_OK);
        }
    }

    public function generatePaymentLink($data) {

        $user = $this->user->get_user_profile_data($data['user_id']);
        $jsonData = '{ 
            "SiteCode": "TSTSTE0001", 
            "CountryCode": "ZA",
            "CurrencyCode": "ZAR",
            "Amount": '.$data["price"].',
            "TransactionReference": "'.$data["code"].'",
            "BankReference": "'.$data["code"].'",
            "Optional1": "'.$data["user_id"].'",
            "Customer": "'.$user["first_name"].'",
            "CancelUrl": "https://itsonme.co.za/its-on-me-portal/ozow-cancel",
            "ErrorUrl": "https://itsonme.co.za/its-on-me-portal/ozow-error",
            "SuccessUrl": "https://itsonme.co.za/its-on-me-portal/ozow-success",
            "NotifyUrl": "https://itsonme.co.za/its-on-me-portal/ozow-notify",
            "IsTest": "true"
        }';

        $jsonArray = json_decode($jsonData);

        $string = '';
        foreach ($jsonArray as $key => $value) {
            $string .= $value;
        }
        $string = $string."215114531AFF7134A94C88CEEA48E";
        $string = strtolower($string);
        $hashed = hash("sha512", $string);

        $jsonArray->HashCheck = $hashed;

        $jsonPostData = json_encode($jsonArray);
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.ozow.com/PostPaymentRequest?ApiKey=EB5758F2C3B4DF3FF4F2669D5FF5B',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $jsonPostData,
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json',
            'ApiKey: EB5758F2C3B4DF3FF4F2669D5FF5B'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);

        return $response;
    }
}