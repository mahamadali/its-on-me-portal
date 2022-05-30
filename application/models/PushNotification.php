<?php
class PushNotification extends CI_Model
{

     var $table = "push_notifications";  
    var $select_column = array("id","title","message","province","created_at"); 
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
                $this->db->like("title", $_POST["search"]["value"]);  
                $this->db->or_like("message", $_POST["search"]["value"]);  
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

    function findByColumnId($columnname, $value,$id) {
        $this->db->where($columnname, $value);
        $this->db->where('id !=', $id);
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

    public function getOne($id) {
        $this->db->where('id', $id);
        $result = $this->db->get($this->table)->row();
        return $result;
    }

    public function send($data) {
        if(in_array('All', $data['province'])) {
            $this->sendToAllUsers($data);
        } else {
            $this->sendToProvices($data);
        }
    }

    public function sendToAllUsers($data) {
        $this->db->where('status', 1);
        $query = $this->db->get('users');
        if($query->num_rows() > 0) {
            $result = $query->result();
            $this->sendNotifications($data, $result);
        }
    }

    public function sendToProvices($data) {
        $this->db->join('provinces', 'provinces.id=users.province');
        $this->db->where('status', 1);
        $this->db->where_in('users.province', $data['province']);
        $query = $this->db->get('users');

        if($query->num_rows() > 0) {
            $result = $query->result();
            $this->sendNotifications($data, $result);
        }
    }

    public function sendNotifications($data, $result) {
        foreach ($result as $key => $user) {
            $tokens = $this->userTokens($user);
            $notificationSent = 0;
            if(!empty($tokens)) {
                foreach($tokens as $token) {
                    $response = $this->sendNotification($token->device_token, $data['title'], $data['message'], $data['link']);
                    $response = json_decode($response);
                    if($response->success) {
                        $notificationSent = 1;
                    }
                }
            }
            if($notificationSent == 1) {
                $user_notification_data = [
                    'user_id' => $user->id,
                    'title' => $data['title'],
                    'message' => $data['message'],
                    'link' => $data['link'],
                    'photo' => $data['photo'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->insert_data_getid($user_notification_data, 'user_notifications');
            }
        }
        $data['province'] = in_array('All', $data['province']) ? 0 : implode(",", $data['province']);
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->insert_data_getid($data, $this->table);
    }

    public function userTokens($user) {
        $this->db->where('user_id', $user->id);
        $query = $this->db->get('user_device_tokens');
        if($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function sendNotification($token, $title, $message, $link) {
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

    public function getProvincesByIds($ids) {
        $provinceName = [];
        if(!empty($ids)) {
            $ids = explode(',', $ids);
            foreach($ids as $id) {
                $provinceName[] = $this->db->where('id', $id)->get('provinces')->row()->name;
            }
            return implode(',', $provinceName);
        } else {
            return 'All Provinces';
        }
    }
 
}
