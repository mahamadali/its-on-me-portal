<?php
class Merchant extends CI_Model
{

     var $table = "merchants";  
    var $select_column = array("id","username","email","password","bio","profile_picture","physical_address","categories","status","created_at","updated_at"); 
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
                $this->db->like("username", $_POST["search"]["value"]);  
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

    public function getDataByCategoryId($category_id) {
        $this->db->select('`'.$this->table.'`.*, CONCAT("'.base_url().'", `'.$this->table.'`.profile_picture) as profile_url');
        $this->db->where("find_in_set($category_id, categories)");
        $query = $this->db->get($this->table);
        $result = $query->result_array();
        return $result;
    }

    public function getCategoryDataByBrandId($brand_id) {

           $this->db->select('categories'); 
           $this->db->from('merchants');  
           $this->db->join('categories', 'merchants.categories = categories.id');
            $this->db->where('merchants.id',$brand_id);
           $query = $this->db->get();  
           $categories = $query->row_array(); 
           $cat = explode(',', $categories['categories']);
           if(!empty($cat))
           {
                $this->db->select('categories.id,categories.name');
                $this->db->from('categories');                
                $this->db->where_in('categories.id',$cat);
                 $query =$this->db->get();
           
           }
                if ($query->num_rows()) {
                    return $query->result_array();
                } else {
                    return 0;
                }    
            
     
         
    }

    public function fetchBrandsByCat($brand_id,$category_id) {

           $this->db->select('*'); 
            
            $this->db->where('products.merchant_id',$brand_id);
            $this->db->where("find_in_set($category_id, products.categories)");
            $this->db->where('products.status' , '1');
           $query = $this->db->get('products');
           $items = $query->result_array();
            if(!empty($items))
            {
                 return $items;
            } 
    }

    public function brandsTopOffers($brand_id) {

            $this->db->select('*'); 
            $this->db->where('merchant_id',$brand_id);
            $this->db->where('is_featured' , '1');
            $query = $this->db->get('products');
            $items = $query->result_array();
            if(!empty($items))
            {
                 return $items;
            } 
    }

    public function getOne($id) {
        $this->db->where('id', $id);
        $result = $this->db->get($this->table)->row();
        return $result;
    }
 
}
