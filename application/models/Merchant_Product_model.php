<?php
class Merchant_Product_model extends CI_Model
{

     var $table = "products";  
    var $select_column = array("id","merchant_id","category","product_name","product_price","product_description","status","created_at","updated_at"); 
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
                $this->db->like("product_name", $_POST["search"]["value"]);  
                $this->db->or_like("product_price", $_POST["search"]["value"]);  
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
      function get_all_data($id)  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);
           $this->db->where('merchant_id', $id);
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

     function get_product_cat_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get('categories');
          return $query->result(); 
      } 

       function getCatName($id)
{       
   if (empty($id)) {
    return 'N/A';
   }
    $this->db->select('name');
    $this->db->where('id', $id);
    $query = $this->db->get('categories');
    return $query->result_array();
}

     function getMerchantName($id)
{       
   if (empty($id)) {
    return 'N/A';
   }
    $this->db->select('username');
    $this->db->where('id', $id);
    $query = $this->db->get('merchants');
    return $query->row()->username;
}

function get_product_item_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get($this->table);
          return $query->row(); 
      } 
 function update_product_detail($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update($this->table, $data);
          return $que;
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

     function update_merchant_detail($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update($this->table, $data);
          return $que;
    } 

     function get_merchant_bank_list($id)  
      {  
          $this->db->where('merchant_id', $id);
          $query = $this->db->get('merchant_banks');
          return $query->result_array(); 
      } 

      function get_merchant_bank_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get('merchant_banks');
          return $query->row(); 
      } 

       function update_merchant_bank_detail($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update('merchant_banks', $data);
          return $que;
    } 

      function delete_merchant_bank($tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->delete($tablename)) {
            return true;
        } else {
            return false;
        }
    }
 
}
