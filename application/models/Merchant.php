<?php
class Merchant extends CI_Model
{

     var $table = "merchants";  
     var $transaction_table = "transactions";  
    var $select_column = array("id","username","email","password","bio","profile_picture","physical_address","categories","status","is_super_merchant","created_at","updated_at"); 
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

    public function getDataByCategoryId($category_id = '') {
        $this->db->select('`merchants`.*, CONCAT("'.base_url().'", `merchants`.profile_picture) as profile_url,provinces.name as Region');
        if(!empty($category_id))
        {
            $this->db->where("find_in_set($category_id, categories)");
        }
        $this->db->join('provinces', 'provinces.id = merchants.province');
        $this->db->where('merchants`.status', 1);
        $query = $this->db->get('merchants');
        $result = $query->result_array();
        return $result;
    }

    public function getCategoryDataByBrandId($brand_id) {

           $this->db->select('categories'); 
           $this->db->from('merchants');  
           $this->db->join('categories', 'merchants.categories = categories.id');
            $this->db->where('merchants.id',$brand_id);
            $this->db->where('merchants.status',1);
           $query = $this->db->get();  
           $categories = $query->row_array(); 
           if(!empty($categories))
           {
             $cat = explode(',', $categories['categories']);

           }
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

           $this->db->select('products.*, CONCAT("'.base_url().'", `products`.product_image) as product_image,merchants.physical_address as physical_address,provinces.name as Region'); 
            
            $this->db->where('products.merchant_id',$brand_id);
            $this->db->where("find_in_set($category_id, products.categories)");
            $this->db->where('products.status' , '1');
            $this->db->where('merchants.status',1);
            $this->db->join('merchants', 'merchants.id = products.merchant_id');
            $this->db->join('provinces', 'provinces.id = merchants.province');
           $query = $this->db->get('products');
           $items = $query->result_array();
            if(!empty($items))
            {
                 return $items;
            }
            else
            {
                return array();
            }
    }

    public function brandsTopOffers($brand_id) {

            $this->db->select('`products`.*, CONCAT("'.base_url().'", `products`.product_image) as product_image,`merchants.physical_address` as physical_address,provinces.name as Region');
            $this->db->where('merchant_id',$brand_id);
            $this->db->where('products.is_featured' , '1');
            $this->db->where('merchants.status',1);
            $this->db->join('merchants', 'merchants.id = products.merchant_id');
            $this->db->join('provinces', 'provinces.id=merchants.province');
            $query = $this->db->get('products');
            $items = $query->result_array();
            if(!empty($items))
            {
                 return $items;
            }
            else
            {
                return array();
            } 
    }

    public function getOne($id) {
        $this->db->where('id', $id);
        $result = $this->db->get($this->table)->row();
        return $result;
    }

    public function searchProduct($search_text) {

            $this->db->select('`products`.*, CONCAT("'.base_url().'", `products`.product_image) as product_image');
            $this->db->like('product_name',$search_text);
            $query = $this->db->get('products');
            //print_r($this->db->last_query());exit();
            $items = $query->result_array();
            if(!empty($items))
            {
                 return $items;
            } 
            else
            {
                return array();
            }
    }

     public function searchBrandProduct($search_text,$brand_id) {

            $this->db->select('`products`.*, CONCAT("'.base_url().'", `products`.product_image) as product_image');
            $this->db->join('merchants', 'merchants.id=products.merchant_id');
            $this->db->where('products.merchant_id',$brand_id);
            $this->db->where('merchants.status',1);
            $this->db->like('product_name',$search_text);
            $query = $this->db->get('products');
            //print_r($this->db->last_query());exit();
            $items = $query->result_array();
            if(!empty($items))
            {
                 return $items;
            } 
             else
            {
                return array();
            }
    }

     public function ProductDetails($product_id,$brand_id) {

            $this->db->select('`products`.*, CONCAT("'.base_url().'", `products`.product_image) as product_image,`merchants.physical_address` as physical_address ,`merchants.username` as merchant_name , `merchants.province` as province,provinces.name as province_name');
            $this->db->where('merchant_id',$brand_id);
            $this->db->where('products.id',$product_id);
            $this->db->where('merchants.status',1);
            $this->db->join('merchants', 'merchants.id = products.merchant_id');
            $this->db->join('provinces', 'provinces.id = merchants.province');
            $query = $this->db->get('products');
            $items = $query->result_array();
            if(!empty($items))
            {
                 return $items;
            } 
             else
            {
                return array();
            }
    }

    public function monthlyPayment($id) {
        $sql = "SELECT SUM(`price`) AS grand FROM transactions WHERE MONTH(`created_at`)=MONTH( CURRENT_DATE ) AND `is_paid` = 0 AND merchant_id=".$id;
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            return $query->row('grand') ? $query->row('grand') : 0.00;    
        }
    }

    public function getTransactionsByMerchant($id) {
        $this->db->select('transactions.*, CONCAT(`users`.first_name, " ",  `users`.last_name) as user_fullname');
        $this->db->where('merchant_id', $id);
        $this->db->where('transactions.status !=', 'PENDING');
        $this->db->join('users', 'users.id = transactions.user_id');
        $query = $this->db->get('transactions');
        if($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function make_query_transactions($id)  
      {  
           $month = $this->input->post('month');
           $year = $this->input->post('year');
           $this->db->select('transactions.*, CONCAT(`users`.first_name, " ",  `users`.last_name) as user_fullname');  
           $this->db->where('merchant_id', $id);
            $this->db->where('MONTH(transactions.created_at)',$month);
            $this->db->where('YEAR(transactions.created_at)',$year);
            $this->db->where('transactions.is_paid',0);
            $this->db->where('transactions.status', 'COMPLETED');
            $this->db->join('users', 'users.id = transactions.user_id');
           $this->db->from($this->transaction_table);  
           if(isset($_POST["search"]["value"]))  
           {  
            $this->db->group_start();
                $this->db->like("transaction_id", $_POST["search"]["value"]);  
                $this->db->or_like("users.first_name", $_POST["search"]["value"]);  
                $this->db->or_like("transactions.full_name", $_POST["search"]["value"]);  
                $this->db->or_like("transactions.email", $_POST["search"]["value"]);  
                $this->db->or_like("transactions.phone_number", $_POST["search"]["value"]);  
                $this->db->group_end();
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
      function make_datatables_transactions($id){  
           $this->make_query_transactions($id);  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }
           $query = $this->db->get();
           return $query->result();  
      }  
      function get_filtered_data_transactions($id){  
           $this->make_query_transactions($id);  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data_transactions($id)  
      {  
            $month = $this->input->post('month');
            $year = $this->input->post('year');
           $this->db->select("transactions.*");
           $this->db->where('merchant_id', $id);
            $this->db->where('MONTH(transactions.created_at)',$month);
            $this->db->where('YEAR(transactions.created_at)',$year);
            $this->db->where('transactions.is_paid',0);
            $this->db->where('transactions.status','COMPLETED');
            $this->db->join('users', 'users.id = transactions.user_id');
           $this->db->from($this->transaction_table);
           $this->db->order_by('id', 'DESC');   
           $query = $this->db->get();  
           return $query->result();    
      }

      function totalTransactionByMonthYear($id, $month,$year)
      {
         $this->db->select('SUM(price) as total_amount');
         $this->db->where('MONTH(created_at)',$month);
         $this->db->where('YEAR(created_at)',$year);
         $this->db->where('is_paid',0);
         $this->db->where('merchant_id', $id);
         $this->db->where('status','COMPLETED');
         $this->db->from($this->transaction_table);
         $query = $this->db->get();  
           return $query->row();    

      }


       function MerchanttotalTransactionByMonthYear($id, $month,$year)
      {
         $this->db->select('SUM(price) as total_amount');
         $this->db->where('MONTH(created_at)',$month);
         $this->db->where('YEAR(created_at)',$year);
         $this->db->where('merchant_id', $id);
         $this->db->from($this->transaction_table);
         $query = $this->db->get();  
           return $query->row();    

      }


     function update_merchant_payment_details($data, $month = '', $year = '',$id = '') {
          $this->db->where('MONTH(created_at)',$month);
          $this->db->where('YEAR(created_at)',$year);
          $this->db->where('status','COMPLETED');
          $this->db->where('merchant_id', $id);
          $que = $this->db->update($this->transaction_table, $data);
          return $que;
    } 

    public function getNewUserTransactionsAvailable($phone)
    {
        $this->db->where('phone_number', $phone);
        $this->db->where('is_redeemed', 0);
        $this->db->where('status', 'COMPLETED');
        $query = $this->db->get($this->transaction_table);
        return $query->result();
    }
 
}
