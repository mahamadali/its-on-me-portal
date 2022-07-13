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
         $this->load->model('Merchant', 'merchant');
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
        'merchant_id' => $input['merchant_id'],
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
        //$paymentData = $this->generatePaymentLink($data); 
    $data['payment_request'] = $this->generatePaymentLinkViaPaygate($data);
    $data['PAY_REQUEST_ID'] = explode('&', $data['payment_request'])[1];
    $data['PAY_REQUEST_ID'] = explode('=', $data['PAY_REQUEST_ID'])[1];
    // print_r($data['PAY_REQUEST_ID']);exit();
    $id = $this->user->insert_data_getid($data, 'transactions');

    if($id) {
        $this->response([
            'status' => 'success', 
            'message' => 'Transaction created successfully',
            'paymentRequestId' => $data['PAY_REQUEST_ID'],
            // 'paymentRequestId' => $paymentData->paymentRequestId,
            // 'url' => $paymentData->url
            'url' => base_url().'api/paygate-payment/'.$id
        ], REST_Controller::HTTP_OK);
    } else {
        $this->response(['status' => 'failed', 'message' => 'Transaction failed!'], REST_Controller::HTTP_OK);
    }
}

public function paygateSuccess_get($id)
{
    if(!empty($id))
    {
        $getOrdersData = $this->getOrdersData($id);

      /*  $this->data['getOrdersData'] = $getOrdersData;
        $this->data['page'] = "payment/index";*/
       $this->load->view('payment/index',array('getOrdersData' => $getOrdersData));   

        
    }
}

public function paygateNotify_post()
{
    if(!empty($_REQUEST['PAY_REQUEST_ID']) || !empty($_REQUEST['TRANSACTION_STATUS']))
    {
        $PAY_REQUEST_ID = $_REQUEST['PAY_REQUEST_ID'];
        $TRANSACTION_STATUS = $_REQUEST['TRANSACTION_STATUS'];
        $CHECKSUM = $_REQUEST['CHECKSUM'];

        if(!empty($PAY_REQUEST_ID))
        {
            $transaction = $this->getOrdersDataByPayID($PAY_REQUEST_ID);

            if($TRANSACTION_STATUS == 1)
            {
                 $data = array(
                    'status' => 'COMPLETED',
                );
            }
            else
            {
                $data = array(
                    'status' => 'CANCELLED',
                );
            }
            $checkUserExist = $this->user->check_user_exist_by_email($transaction['email']);

                if(!empty($checkUserExist))
                {
                  $this->email->from('info@itsonme.co.za', 'ITSONME');
                  $this->email->to($transaction['email']);
                  $this->email->subject('Transaction Gift Code - ITSONME');
                  $message = "Hey ".$transaction['full_name']." your order is on me. Your its on me CODE is ". $code ."";
                  $message .= "<p>Thanks,</p>";
                  $message .= "<p>ITSONME Team<br></p>";
                  $this->email->message($message);
                  $this->email->set_mailtype('html');
                  $this->email->set_newline("\r\n");
                  $this->email->send();

                  $getUserTokens = $this->user->getTokens($checkUserExist->id);
                  $senderName = $this->user->getUserById($transaction['user_id']);
                  $message = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me CODE is ". $code ."";
                        //$message = "Hey ".$transaction['full_name']." your order is on me. Your its on me CODE is ". $code ."";
                  $title = "Transaction gift code";
                  $link = '';
                  if(!empty($getUserTokens))
                  {
                     foreach ($getUserTokens as $key => $token) {
                       $this->user->sendNotificationUser($token['device_token'],$title,$message,$link);     
                   }
               }

               $user_notification_data = [
                'user_id' => $checkUserExist->id,
                'title' => $title,
                'message' => $message,
                'link' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $Smsmessage = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me CODE is ". $code ."";
            sendSMS($checkUserExist->phone, $Smsmessage);

            $this->user->insert_data_getid($user_notification_data, 'user_notifications');

            }
            else
            {
              $senderName = $this->user->getUserById($transaction['user_id']);
              $this->email->from('info@itsonme.co.za', 'ITSONME');
              $this->email->to($transaction['email']);
              $this->email->subject('Transaction Gift Code - ITSONME');
                         // $message = "Hey ".$transaction['full_name']." your order is on me. Download the “It’s on me” app to get code.";
              $message = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me. Download the “It’s on me” app to get code.";
              $message .= "<pThanks,</p>";
              $message .= "<p>ITSONME Team<br></p>";
              $this->email->message($message);
              $this->email->set_mailtype('html');
              $this->email->set_newline("\r\n");
              $this->email->send();
              $Smsmessage = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me. Download the “It’s on me” app to get code.";
              sendSMS($transaction['phone_number'], $Smsmessage);
            }


            $this->db->where('id', $transaction['id'])->update('transactions', $data);

            if($TRANSACTION_STATUS == 1)
            {
               // return $this->response(['status' => 'COMPLETED'], REST_Controller::HTTP_OK);
                $this->load->view('payment/success');   
            }
            else
            {
                //return $this->response(['status' => 'CANCELLED'], REST_Controller::HTTP_OK);   
                $this->load->view('payment/cancel');   
            }
        }

    }
}

 public function getOrdersData($id)
 {
     $this->db->select('transactions.*');
     $this->db->where('id' , $id);
     $response = $this->db->get('transactions')->row_array();
     return $response;
 }

 public function getOrdersDataByPayID($PAY_REQUEST_ID)
 {
     $this->db->select('transactions.*');
     $this->db->where('PAY_REQUEST_ID' , $PAY_REQUEST_ID);
     $response = $this->db->get('transactions')->row_array();
     return $response;
 }

 public function userInfo($id)
 {
     $this->db->select('email');
     $this->db->where('id' , $id);
     $response = $this->db->get('users')->row_array();
     return $response;
 }

public function generatePaymentLinkViaPaygate($data = '') {

   $encryptionKey = 'secret';
   $UserEmail = $this->userInfo($data['user_id']);
  
    $DateTime = new DateTime();

    $data = array(
        'PAYGATE_ID'        => 10011072130,
        'REFERENCE'         => 'pgtest_123456789',
        'AMOUNT'            => $data['price'] * 100,
        'CURRENCY'          => 'ZAR',
        'RETURN_URL'        => 'https://itsonme.co.za/its-on-me-portal/api/paygate-notify',
        'TRANSACTION_DATE'  => $DateTime->format('Y-m-d H:i:s'),
        'LOCALE'            => 'en-za',
        'COUNTRY'           => 'ZAF',
        'EMAIL'             => $UserEmail['email'],
    );


    $checksum = md5(implode('', $data) . $encryptionKey);

    $data['CHECKSUM'] = $checksum;

    $fieldsString = http_build_query($data);

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, 'https://secure.paygate.co.za/payweb3/initiate.trans');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $result;
}


public function generatePaymentLink($data) {

    $user = $this->user->get_user_profile_data($data['user_id']);
    $jsonData = '{ 
        "SiteCode": "ITS-ITS-005",
        "CountryCode": "ZA",
        "CurrencyCode": "ZAR",
        "Amount": '.$data["price"].',
        "TransactionReference": "'.$data["code"].'",
        "BankReference": "'.$data["code"].'",
        "Optional1": "'.$data["user_id"].'",
        "Customer": "'.$user["first_name"].'",
        "CancelUrl": "https://itsonme.co.za/its-on-me-portal/api/ozow-cancel",
        "ErrorUrl": "https://itsonme.co.za/its-on-me-portal/api/ozow-error",
        "SuccessUrl": "https://itsonme.co.za/its-on-me-portal/api/ozow-success",
        "NotifyUrl": "https://itsonme.co.za/its-on-me-portal/api/ozow-notify",
        "IsTest": "false"
    }';

    $jsonArray = json_decode($jsonData);

    $string = '';
    foreach ($jsonArray as $key => $value) {
        $string .= $value;
    }
    $string = $string."eK0FzPTejEqm5xR3SjBw94weStBHKMLv";
    $string = strtolower($string);
    $hashed = hash("sha512", $string);

    $jsonArray->HashCheck = $hashed;

    $jsonPostData = json_encode($jsonArray);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.ozow.com/PostPaymentRequest?ApiKey=UnuPoiNYDH0MYTdGiOuKZPlN2Ee9LBn8',
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
        'ApiKey: UnuPoiNYDH0MYTdGiOuKZPlN2Ee9LBn8'
    ),
  ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response);

    return $response;
}

public function ozowSuccess_get()
{
    $input = $this->input->get(); 
    $code = $input['TransactionReference'];
    $transaction = $this->db->where('code', $code)->get('transactions')->row_array();

    $data = array(
        'sitecode' => $input['SiteCode'],
        'transaction_id' => $input['TransactionId'],
        'status' => 'COMPLETED'
    );

    $checkUserExist = $this->user->check_user_exist_by_email($transaction['email']);

    if(!empty($checkUserExist))
    {
      $this->email->from('info@itsonme.co.za', 'ITSONME');
      $this->email->to($transaction['email']);
      $this->email->subject('Transaction Gift Code - ITSONME');
      $message = "Hey ".$transaction['full_name']." your order is on me. Your its on me CODE is ". $code ."";
      $message .= "<p>Thanks,</p>";
      $message .= "<p>ITSONME Team<br></p>";
      $this->email->message($message);
      $this->email->set_mailtype('html');
      $this->email->set_newline("\r\n");
      $this->email->send();

      $getUserTokens = $this->user->getTokens($checkUserExist->id);
      $senderName = $this->user->getUserById($transaction['user_id']);
      $message = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me CODE is ". $code ."";
            //$message = "Hey ".$transaction['full_name']." your order is on me. Your its on me CODE is ". $code ."";
      $title = "Transaction gift code";
      $link = '';
      if(!empty($getUserTokens))
      {
         foreach ($getUserTokens as $key => $token) {
           $this->user->sendNotificationUser($token['device_token'],$title,$message,$link);     
       }
   }

   $user_notification_data = [
    'user_id' => $checkUserExist->id,
    'title' => $title,
    'message' => $message,
    'link' => '',
    'created_at' => date('Y-m-d H:i:s'),
];

$Smsmessage = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me CODE is ". $code ."";
sendSMS($checkUserExist->phone, $Smsmessage);

$this->user->insert_data_getid($user_notification_data, 'user_notifications');

}
else
{
  $senderName = $this->user->getUserById($transaction['user_id']);
  $this->email->from('info@itsonme.co.za', 'ITSONME');
  $this->email->to($transaction['email']);
  $this->email->subject('Transaction Gift Code - ITSONME');
             // $message = "Hey ".$transaction['full_name']." your order is on me. Download the “It’s on me” app to get code.";
  $message = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me. Download the “It’s on me” app to get code.";
  $message .= "<pThanks,</p>";
  $message .= "<p>ITSONME Team<br></p>";
  $this->email->message($message);
  $this->email->set_mailtype('html');
  $this->email->set_newline("\r\n");
  $this->email->send();
  $Smsmessage = "Hey ".$transaction['full_name']." you've received a gift from ".$senderName.", Your its on me. Download the “It’s on me” app to get code.";
  sendSMS($transaction['phone_number'], $Smsmessage);
}

$this->db->where('id', $transaction['id'])->update('transactions', $data);

return $this->response(['status' => 'success', 'data' => $data], REST_Controller::HTTP_OK);

}

public function ozowCancel_get()
{
    $input = $this->input->get(); 
    $code = $input['TransactionReference'];
    $transaction = $this->db->where('code', $code)->get('transactions')->row_array();

    $data = array(
        'sitecode' => $input['SiteCode'],
        'transaction_id' => $input['TransactionId'],
        'status' => 'CANCELLED'
    );
    $this->db->where('id', $transaction['id'])->update('transactions', $data);

    return $this->response(['status' => 'success', 'data' => $data], REST_Controller::HTTP_OK);
}

public function ozowError_get()
{
    $input = $this->input->get(); 
    $code = $input['TransactionReference'];
    $transaction = $this->db->where('code', $code)->get('transactions')->row_array();

    $data = array(
        'sitecode' => $input['SiteCode'],
        'transaction_id' => $input['TransactionId'],
        'status' => 'ERROR'
    );
    $this->db->where('id', $transaction['id'])->update('transactions', $data);

    return $this->response(['status' => 'success', 'data' => $data], REST_Controller::HTTP_OK);
}

public function ozowNotify_post()
{
    $input = $this->input->post(); 
    $code = $input['TransactionReference'];
    $transaction = $this->db->where('code', $code)->get('transactions')->row_array();

    $data = array(
        'sitecode' => $input['SiteCode'],
        'transaction_id' => $input['TransactionId'],
        'status' => $input['Status']
    );
    $this->db->where('id', $transaction['id'])->update('transactions', $data);

    return $this->response(['status' => 'success', 'data' => $data], REST_Controller::HTTP_OK);
}

public function userTransactions_post()
{
    $input = $this->input->post(); 
    if(!isset($input['user_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
  }
  $getUserTransactions = $this->user->getTransactionsByMerchant($input['user_id']);
  return $this->response(['status' => 'success', 'data' => $getUserTransactions], REST_Controller::HTTP_OK);
}

public function userTransactionDetails_post()
{
    $input = $this->input->post(); 
    if(!isset($input['user_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
  }
  if(!isset($input['transaction_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing Transaction ID'], REST_Controller::HTTP_OK);
  }
  $getUserTransactions = $this->user->getTransactionData($input['user_id'],$input['transaction_id']);
  if(!empty($getUserTransactions->menu_items))
  {
    $new_data = json_decode($getUserTransactions->menu_items);
    $getUserproduct = [] ;
    foreach ($new_data as $key => $value) {
        $productDetail = $this->user->get_product_item_data($value->product_id);
        $merchant_details = $this->merchant->getOne($productDetail->merchant_id);
        $getUserproduct[$key]['product_id'] = $productDetail->id;
        $getUserproduct[$key]['product_name'] = $productDetail->product_name;
        $getUserproduct[$key]['merchant_name'] = $merchant_details->username ?? '';
        $getUserproduct[$key]['product_price'] = $value->price;
        $getUserproduct[$key]['product_image'] = $productDetail->product_image;
        $getUserproduct[$key]['product_description'] = $productDetail->product_description;
        $getUserproduct[$key]['product_Qty'] = $value->qty;
        $getUserproduct[$key]['total'] = $value->qty*$value->price;
    }
    $getUserTransactions->product_detail = $getUserproduct;
}

return $this->response(['status' => 'success', 'data' => $getUserTransactions], REST_Controller::HTTP_OK);
}

public function orderSuccessTransactionDetails_post()
{
    $input = $this->input->post(); 
    if(!isset($input['user_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
  }
  if(!isset($input['transaction_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing Transaction ID'], REST_Controller::HTTP_OK);
  }
  $getUserSuccessTransactions = $this->user->getSuccessTransactionData($input['user_id'],$input['transaction_id']);
  if(!empty($getUserSuccessTransactions->menu_items))
  {
    $new_data = json_decode($getUserSuccessTransactions->menu_items);
    $getUserproduct = [] ;
    foreach ($new_data as $key => $value) {
        $productDetail = $this->user->get_product_item_data($value->product_id);
        print_r($productDetail);exit();
        $merchant_details = $this->merchant->getOne($productDetail->merchant_id);
        $getUserproduct[$key]['product_id'] = $productDetail->id;
        $getUserproduct[$key]['product_name'] = $productDetail->product_name;
        $getUserproduct[$key]['merchant_name'] = $merchant_details->username ?? '';
        $getUserproduct[$key]['product_price'] = $value->price;
        $getUserproduct[$key]['product_image'] = $productDetail->product_image;
        $getUserproduct[$key]['product_description'] = $productDetail->product_description;
        $getUserproduct[$key]['product_Qty'] = $value->qty;
        $getUserproduct[$key]['total'] = $value->qty*$value->price;
    }
    $getUserSuccessTransactions->product_detail = $getUserproduct;
}

return $this->response(['status' => 'success', 'data' => $getUserSuccessTransactions], REST_Controller::HTTP_OK);
}

public function userGiftHistory_post()
{
    $input = $this->input->post(); 
    if(!isset($input['user_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
  }

  $UserEmail = $this->user->getUserEmail($input['user_id']);
  if(!empty($UserEmail))
  {
    $GetUserGiftHistory = $this->user->getUserGiftHistory($UserEmail);
}
else
{
    $GetUserGiftHistory = [];  
}
return $this->response(['status' => 'success', 'data' => $GetUserGiftHistory], REST_Controller::HTTP_OK);

}

public function getMerchantsByProvince_post()
{
    $input = $this->input->post(); 

    if(!isset($input['brand_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing Brand ID'], REST_Controller::HTTP_OK);
  }

    $province = !empty($input['province_id']) ? $input['province_id']  : '';

  $MerchantByProvince = $this->user->getMerchantByProvince($province , $input['brand_id']);
   
return $this->response(['status' => 'success', 'data' => $MerchantByProvince], REST_Controller::HTTP_OK);

}

public function getBrandsByProvince_post()
{
    $input = $this->input->post(); 

    if(!isset($input['province_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Missing Province ID'], REST_Controller::HTTP_OK);
    }

    $province = !empty($input['province_id']) ? $input['province_id']  : '';
    $search_text = !empty($input['search_text']) ? $input['search_text']  : '';

  $MerchantByProvince = $this->user->getBrandsByProvince($province, $search_text);
   
return $this->response(['status' => 'success', 'data' => $MerchantByProvince], REST_Controller::HTTP_OK);

}

public function checkPaymentStatus_post()
{
    $input = $this->input->post(); 

    if(!isset($input['payment_request_id'])) {
      return $this->response(['status' => 'failed', 'message' => 'Payment Request ID Missing'], REST_Controller::HTTP_OK);
  }

    $payment_request_id = !empty($input['payment_request_id']) ? $input['payment_request_id']  : '';

    $checkUserExist = $this->user->check_payment_status($payment_request_id);
    if(empty($checkUserExist))
    {
        return $this->response(['status' => 'failed', 'data' => 'Invalid Payment Request ID'], REST_Controller::HTTP_OK);
    }
    else
    {
        $PaymentStatus = $this->user->getPaymentStatus($payment_request_id);
        return $this->response(['status' => 'success', 'id' => $PaymentStatus->id, 'Payment_status' => $PaymentStatus->status], REST_Controller::HTTP_OK);
    }
  

}

}