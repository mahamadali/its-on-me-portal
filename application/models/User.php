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
}
