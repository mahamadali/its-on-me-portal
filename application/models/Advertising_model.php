<?php
class Advertising_model extends CI_Model
{

     var $table = "banners";  
    var $select_column = array("id","banner_path","banner_link","status"); 
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
                $this->db->like("banner_path", $_POST["search"]["value"]);  
                $this->db->or_like("banner_link", $_POST["search"]["value"]);  
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

      function getBannerImage($id)  
      {  
           $this->db->select("banner_path");  
           $this->db->from($this->table);
           $this->db->where('id', $id);
           $query = $this->db->get();  

           return $query->row()->banner_path;    
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

    function dashboard_statistics() {
        $response['total_users'] = count($this->get_all_data());
        return $response;
    }


    function get_merchant_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get($this->table);
          return $query->row(); 
      } 

     function update_advertisement_detail($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update($this->table, $data);
          return $que;
    } 


      function get_banner_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get($this->table);
          return $query->row(); 
      } 

     
 
}
