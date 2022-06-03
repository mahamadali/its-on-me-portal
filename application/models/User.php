<?php
class User extends CI_Model
{

     var $table = "users";  
    var $select_column = array("id","first_name","last_name", "email", "password","username","phone","province","status","created_at","updated_at"); 
     public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function make_query()  
      {  
           $this->db->select($this->select_column);  
           $this->db->from($this->table);  
           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->like("first_name", $_POST["search"]["value"]);  
                $this->db->or_like("email", $_POST["search"]["value"]);  
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'DESC');  
           }  
      }  
      function make_datatables(){  
           $this->make_query();  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      function get_filtered_data(){  
           $this->make_query();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);
           $this->db->order_by('id', 'DESC');   
           $query = $this->db->get();  
           return $query->result();    
      }

       function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
      }
    function delete_data($tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->delete($tablename)) {
            return true;
        } else {
            return false;
        }
    }

    function findByColumn($columnname, $value) {
        $this->db->where($columnname, $value);
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return $query->num_rows();
        }
    }

    function updateColumn($data, $id) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    function dashboard_statistics() {
        $response['total_users'] = count($this->get_all_data());
        $this->load->model('Merchant', 'merchant');
        $response['total_merchants'] = count($this->merchant->get_all_data());
        return $response;
    }

    function checkLogin($data) {
        // $this->updateColumn(['password' => md5('12345678')], 3);
        $this->db->where('email', $data['email']);
        $this->db->where('password', md5($data['password']));
        $query = $this->db->get('users');
        if($query->num_rows() > 0) {
            return $response = $query->row_array();
        } else {
            return false;
        }
    }

    public function saveDeviceToken($id, $token) {
        $this->db->where('user_id', $id);
        $this->db->where('device_token', $token);
        $query = $this->db->get('user_device_tokens');
        if($query->num_rows() == 0) {
            $data = ['user_id' => $id, 'device_token' => $token];
            $this->insert_data_getid($data, 'user_device_tokens');
        }
    }

    function get_user_profile_data($id)  
      {  
           $this->db->select("id,first_name,last_name,email,username,phone,dob,province");  
           $this->db->from($this->table);
            $this->db->where('id', $id);
           $query = $this->db->get();  
           return $query->row_array();    
      }

      function generateRandomString($length = 25) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

     function check_user_exist($id)  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);  
           $this->db->where('id', $id);
           $query = $this->db->get(); 
           return $query->num_rows();        
      }

      function getTokens($id)  
      {  
           $this->db->select("device_token");  
           $this->db->from('user_device_tokens');  
           $this->db->where('user_id', $id);
           $query = $this->db->get(); 
            return $query->result_array();      
      }

      public function sendNotificationUser($token, $title, $message, $link = '') {
        if(!empty($link)) {
            $json_data =array(
            "to" => $token,
            "notification" =>array(
              "title" => $title,
              "body" => $message,
              "icon" => "https://itsonme.co.za/its-on-me/admin/assets/img/IOM-logo.png",
              "click_action" => $link
            ),
           
          );    
        } else {
            $json_data =array(
            "to" => $token,
            "notification" =>array(
              "title" => $title,
              "body" => $message,
              "icon" => "https://itsonme.co.za/its-on-me/admin/assets/img/IOM-logo.png"
            ),
           
          );
        }
        

        $data = json_encode($json_data);
        
           
        $url = 'https://fcm.googleapis.com/fcm/send';
        $server_key = 'AAAAA_fuAbU:APA91bHt4xH7WnbyClLld-QvgWpYPnA5fz5bg_5uwneTP78v5iYWRrHbN4g97Vday7C_5izbtXycL_ZRn-535JymMhwVQh16Di9By5EyEx7t7F-s9JguiMaAECr4Tl01xdmfQ4PvDB6Q';
        
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
          );


            //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        
        curl_close($ch);

        return $result;
    }


    public function getTransactionsByMerchant($id) {
        $this->db->select('transactions.id as transaction_id,transactions.created_at as date_of_order,transactions.price as amount,merchants.username as brand_name, transactions.full_name as receiver_name');
        $this->db->where('merchant_id', $id);
        $this->db->where('transactions.status !=', 'PENDING');
        $this->db->join('merchants', 'merchants.id = transactions.merchant_id');
        $query = $this->db->get('transactions');
        if($query->num_rows() > 0) {
            return $query->result();
        }
        else
        {
             return [];
        }
    }

     public function getTransactionData($id,$transaction_id) {
        $this->db->select('*');
         $this->db->where('user_id', $id);
         $this->db->where('id', $transaction_id);
         $query = $this->db->get('transactions');
        if($query->num_rows() > 0) {
            return $query->row();
        }
        else
        {
             return [];
        }
    }

    public  function get_product_item_data($id)  
      {  
          $this->db->select('`products`.*, CONCAT("'.base_url().'", `products`.product_image) as product_image');
          $this->db->where('id', $id);
          $query = $this->db->get('products');
          return $query->row(); 
      } 
}
