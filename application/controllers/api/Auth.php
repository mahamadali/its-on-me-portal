<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Auth extends REST_Controller {
    
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
       $this->load->model('Merchant', 'merchant');
       $this->load->library('email');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function province_get()
    {
        $response = $this->db->get('provinces')->result_array();
        $this->response(['status' => 'success', 'data' => $response], REST_Controller::HTTP_OK);
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function login_post()
    {
        $input = $this->input->post();
        if(!isset($input['device_token'])) {
            return $this->response(['status' => 'failed', 'message' => 'Device Token Missing!'], REST_Controller::HTTP_OK);
        }
        $response = $this->user->checkLogin($input);

        if($response) {
            $this->user->saveDeviceToken($response['id'], $input['device_token']);
            $this->response(['status' => 'success', 'data' => $response], REST_Controller::HTTP_OK);    
        } else {
            $this->response(['status' => 'failed', 'message' => 'Incorrect login credentials!'], REST_Controller::HTTP_OK);
        }
        
    }

    public function register_post()
    {
        $input = $this->input->post();

        if($input['password'] != $input['confirmPassword']) {
            return $this->response(['status' => 'failed', 'message' => 'Password and Confirm password must be same!'], REST_Controller::HTTP_OK);
        }

        $emailCount = $this->user->findByColumn('email', $input['email']);
        
        if(!empty($emailCount)) {
            return $this->response(['status' => 'failed', 'message' => 'Email already exist'], REST_Controller::HTTP_OK);
        }

        $data = [
            'first_name' => $input['firstname'],
            'last_name' => $input['surname'],
            'dob' => $input['dob'],
            'phone' => $input['phoneNumber'],
            'email' => $input['email'],
            'password' => md5($input['password']),
            'province' => $input['province']
        ];
        
        $id = $this->user->insert_data_getid($data, 'users');
       
        if($id) {

            $getUserTransactions = $this->merchant->getNewUserTransactionsAvailable($input['phoneNumber']);

            if(!empty($getUserTransactions)) {
                $getUserTokens = $this->user->getTokens($id);
                foreach($getUserTransactions as $transaction) {
                    $senderName = $this->user->getUserById($transaction->user_id);
                   $message = "Hey ".$input['firstname']." ".$input['surname']." you've received a gift from ".$senderName.", Your “It’s on me” CODE is ". $transaction->code ."";

                    echo "<pre>"; print_r($message);exit();
                   // $message = "Hey ".$input['firstname']." ".$input['surname'].", Your order is on me. Your “It’s on me” CODE is ". $transaction->code ."";

                    $title = "Transaction gift code";
                    $link = '';
                    if(!empty($getUserTokens))
                    {
                       foreach ($getUserTokens as $key => $token) {
                             $this->user->sendNotificationUser($token['device_token'],$title,$message,$link);     
                        }
                    }
                    $user_notification_data = [
                    'user_id' => $id,
                    'title' => $title,
                    'message' => $message,
                    'link' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                   ];

                   $this->user->insert_data_getid($user_notification_data, 'user_notifications');
                   $Smsmessage = "Hey ".$input['firstname']." ".$input['surname']." you've received a gift from ".$senderName.", Your “It’s on me” CODE is ". $transaction->code ."";
                   sendSMS($input['phoneNumber'], $Smsmessage);
                }
            }


            $this->response(['status' => 'success', 'message' => 'Account created successfully', 'user_id' => $id], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Incorrect login credentials!'], REST_Controller::HTTP_OK);
        }
        
    }

    public function forgotPassword_post()
    {
        $input = $this->input->post();

        $emailCount = $this->user->findByColumn('email', $input['email']);
        
        if(empty($emailCount)) {
            return $this->response(['status' => 'failed', 'message' => 'Email does not exist'], REST_Controller::HTTP_OK);
        }

        $id = $emailCount->id;

        $code = rand(111111, 999999);
        $data = [
            'verification_code' => $code,
        ];
        
        $this->user->updateColumn($data, $id);

        $this->email->from('info@itsonme.co.za', 'ITSONME');
        $this->email->to($emailCount->email);
         
        $this->email->subject('Verification Code - ITSONME');
        $message = "Hello ".$emailCount->first_name.",";
        $message .= "<br>";
        $message .= "<p>Your forgot password request has been received. You can use below reset code in APP</p>";
        $message .= "<p>Verification code: ". $code ."</p>";
        $message .= "<br>";
        $message .= "<p>Thanks,</p>";
        $message .= "<p>ITSONME Team<br></p>";
        $this->email->message($message);
        $this->email->set_mailtype('html');
        $this->email->set_newline("\r\n");
        $this->email->send();

        if($id) {
            $this->response(['status' => 'success', 'message' => 'verification code sent to email', 'user_id' => $id, 'code' => $code, 'email' => $emailCount->email], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Something went wrong!'], REST_Controller::HTTP_OK);
        }
        
    }

    public function verifyEmailCode_post()
    {
        $input = $this->input->post();

        $emailCount = $this->user->findByColumn('email', $input['email']);
        
        if(empty($emailCount)) {
            return $this->response(['status' => 'failed', 'message' => 'Email does not exist'], REST_Controller::HTTP_OK);
        }

        if($input['code'] == $emailCount->verification_code) {
            $this->response(['status' => 'success', 'message' => 'Code correct', 'user_id' => $emailCount->id], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Incorrect Code'], REST_Controller::HTTP_OK);
        }
        
    }

    public function resetPassword_post()
    {
        $input = $this->input->post();

        if(strlen($input['password']) < 6) {
            return $this->response(['status' => 'failed', 'message' => 'Password must be greater than 6 characters'], REST_Controller::HTTP_OK);
        }

        if($input['password'] != $input['confirmPassword']) {
            return $this->response(['status' => 'failed', 'message' => 'Password and Confirm password must be same!'], REST_Controller::HTTP_OK);
        }

        $data = [
            'password' => md5($input['password']),
        ];
        
        if($this->user->updateColumn($data, $input['user_id'])) {
            $this->response(['status' => 'success', 'message' => 'Password changed successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Something went wrong'], REST_Controller::HTTP_OK);
        }
        
    }


    public function editProfile_post()
    {
        $input = $this->input->post();
      
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['firstname']) || empty($input['firstname'])) {
            return $this->response(['status' => 'failed', 'message' => 'Missing FirstName'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['surname']) || empty($input['surname'])) {
            return $this->response(['status' => 'failed', 'message' => 'Missing Surname'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['phoneNumber']) || empty($input['phoneNumber'])) {
            return $this->response(['status' => 'failed', 'message' => 'Missing phoneNumber'], REST_Controller::HTTP_OK);
        }
        $data = [
            'first_name' => $input['firstname'],
            'last_name' => $input['surname'],
            'phone' => $input['phoneNumber'],
        ];
        
         if($this->user->updateColumn($data, $input['user_id'])) {
            $this->response(['status' => 'success', 'message' => 'Profile Info Updated successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Something went wrong'], REST_Controller::HTTP_OK);
        }
    }

    public function userProfileInfo_post()
    {
        $input = $this->input->post();
      
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        $ProfileData = $this->user->get_user_profile_data($input['user_id']);

            $this->response(['status' => 'success', 'data' => $ProfileData], REST_Controller::HTTP_OK);
    
    }

     public function userInquiries_post()
    {
        $input = $this->input->post();
      
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        $Inquiries = [
            'user_id' => $input['user_id'],
            'full_name' => $input['full_name'],
            'email' => $input['email'],
            'subject' => $input['subject'],
            'message' => $input['message'],
        ];
        $id = $this->user->insert_data_getid($Inquiries, 'inquiries');
        if($id) {
            $this->response(['status' => 'success', 'message' => 'Inquiry submitted successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Incorrect login credentials!'], REST_Controller::HTTP_OK);
        }
    }

    public function deleteUser_post()
    {
         $input = $this->input->post();
         if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
         $checkUserExist = $this->user->check_user_exist($input['user_id']);
          if(empty($checkUserExist)) {
         return $this->response(['status' => 'failed', 'message' => 'Invalid User ID'], REST_Controller::HTTP_OK);
        }
          $this->user->delete_data('inquiries','user_id',$input['user_id']);
          $this->user->delete_data('transactions','user_id',$input['user_id']);
          $this->user->delete_data('user_device_tokens','user_id',$input['user_id']);
          $this->user->delete_data('user_notifications','user_id',$input['user_id']);
          $deleted_id = $this->user->delete_data('users','id',$input['user_id']);
         if($deleted_id) {
            $this->response(['status' => 'success', 'message' => 'User Deleted successfully' ,'user_id' => $input['user_id']], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => 'failed', 'message' => 'Something Went wrong!'], REST_Controller::HTTP_OK);
        }
    }
    	
}