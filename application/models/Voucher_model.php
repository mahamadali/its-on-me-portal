<?php
class Voucher_model extends CI_Model
{

     var $table = "vouchers";  
    var $select_column = array("id","voucher_name","voucher_price","voucher_description","voucher_photo","status"); 
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
                $this->db->like("voucher_name", $_POST["search"]["value"]);  
                $this->db->or_like("voucher_price", $_POST["search"]["value"]);  
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

      function getVoucherImage($id)  
      {  
           $this->db->select("voucher_photo");  
           $this->db->from($this->table);
           $this->db->where('id', $id);
           $query = $this->db->get();  

           return $query->row()->voucher_photo;    
      }
        
        function getUsername($id)  
      {  
           $this->db->select("first_name,last_name");  
           $this->db->from('users');
           $this->db->where('id', $id);
           $query = $this->db->get();  
           return $query->row();    
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


    function get_merchant_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get($this->table);
          return $query->row(); 
      } 

     function update_voucher_detail($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update($this->table, $data);
          return $que;
    } 


      function get_voucher_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get($this->table);
          return $query->row(); 
      } 

      function checkVoucherCode($code)  
      {  
          $this->db->where('code', $code);
          $query = $this->db->get('transactions');
          if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return $query->num_rows();
        } 
      } 

       function getProductsByCode($code)  
      {  
          $this->db->select('menu_items');
          $this->db->where('code', $code);
          $query = $this->db->get('transactions');
          return $query->row()->menu_items; 
      } 

         function getProName($id)
        {       
        
           if (empty($id)) {
            return 'N/A';
           }
            $this->db->select('product_name');
            $this->db->where('id', $id);
            $query = $this->db->get('products');
            return $query->row();
        }
        
        function update_voucher_reedem($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update('transactions', $data);
          return $que;
    } 
 
}
