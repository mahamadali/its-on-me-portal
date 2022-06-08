<?php
class Products_model extends CI_Model
{

     var $table = "products";  
    var $select_column = array("id","product_name","product_description", "product_price", "product_picture","shipping_returns","status","created_at","updated_at"); 
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
                $this->db->like("name", $_POST["search"]["value"]);  
                $this->db->or_like("price", $_POST["search"]["value"]);  
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

      function get_all_categories()  
      {  
           $this->db->select("*");  
           $this->db->from('categories');  
           $query = $this->db->get();  
           return $query->result();    
      } 


      function get_all_colors()  
      {  
           $this->db->select("*");  
           $this->db->from('colors');  
           $query = $this->db->get();  
           return $query->result();    
      } 

      function get_product_item_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get($this->table);
          return $query->row(); 
      } 
 
      function get_product_cat_data($id)  
      {  
          $this->db->where('id', $id);
          $query = $this->db->get('categories');
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

     function GetItemImageName($id)
{       
   
    $this->db->select('product_picture');
    $this->db->where('id', $id);
    $query = $this->db->get('products');
    return $query->row()->product_picture;
}

    function getCatName($id)
{       
   if (empty($id)) {
    return 'N/A';
   }
    $this->db->select('name');
    $this->db->where('id', $id);
    $query = $this->db->get('categories');
    return $query->row()->name;
}
   function getColorName($id)
{       
    if (empty($id)) {
    return 'N/A';
   }
    $this->db->select('color');
    $this->db->where('id', $id);
    $query = $this->db->get('colors');
    return $query->row()->color;
}

    public function update_product_detail($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update('products', $data);
          return $que;
    } 

    public function update_member_status($id,$data) {
          $this->db->where('id', $id);
          $que = $this->db->update('members', $data);
          return $que;
    } 

    public function get_all_sizes()  
      {  
           $this->db->select("*");  
           $this->db->from('sizes');  
           $query = $this->db->get();  
           return $query->result();    
      } 

      public function get_all_wood_finis_choices()  
      {  
           $this->db->select("*");  
           $this->db->from('wood_finish_choice');  
           $query = $this->db->get();  
           return $query->result();    
      } 

       public function get_all_format()  
      {  
           $this->db->select("*");  
           $this->db->from('product_format');  
           $query = $this->db->get();  
           return $query->result();    
      } 

      
      public function getProductSizes($id)
        {       
           if (empty($id)) {
            return 'N/A';
           }

           $this->db->select("name"); 
           $this->db->where('product_sizes.product_id', $id); 
           $this->db->from('product_sizes');  
           $this->db->join('sizes', 'product_sizes.size_id = sizes.id');
           $query = $this->db->get();  
           $result = $query->result(); 

           $product_size = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_size[] =  '<span class="badge badge-sm bg-gradient-success">'.$value->name.'</span>';
               }
           }


           if(!empty($product_size)){
                $result = implode(' ',$product_size);
            }else{
                $result = 'N/A';
            }

            return $result;
            
        }


        function getProductDisplaySolutionsColors($id)
        {       
           if (empty($id)) {
            return 'N/A';
           }

           $this->db->select("color"); 
           $this->db->where('product_mat_color_choices.product_id', $id); 
           $this->db->from('product_mat_color_choices');  
           $this->db->join('colors', 'product_mat_color_choices.mat_color_id = colors.id');
           $query = $this->db->get();  
           $result = $query->result(); 

           $product_color = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_color[] =  '<span class="badge badge-sm bg-gradient-success">'.$value->color.'</span>';
               }
           }


           if(!empty($product_color)){
                $result = implode(' ',$product_color);
            }else{
                $result = 'N/A';
            }

            return $result;
            
        }

         function getProductColors($id)
        {       
           if (empty($id)) {
            return 'N/A';
           }

           $this->db->select("color"); 
           $this->db->where('product_colors.product_id', $id); 
           $this->db->from('product_colors');  
           $this->db->join('colors', 'product_colors.color_id = colors.id');
           $query = $this->db->get();  
           $result = $query->result(); 

           $product_color = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_color[] =  '<span class="badge badge-sm bg-gradient-success">'.$value->color.'</span>';
               }
           }


           if(!empty($product_color)){
                $result = implode(' ',$product_color);
            }else{
                $result = 'N/A';
            }

            return $result;
            
        }

        

        function get_all_product_wood_finish_choices($id)
        {       
           $this->db->select("*"); 
           $this->db->where('product_wood_finish_choices.product_id', $id); 
           $this->db->from('product_wood_finish_choices');  
           $this->db->join('wood_finish_choice', 'product_wood_finish_choices.wood_finish_choice_id = wood_finish_choice.id');
           $query = $this->db->get();  
           $result = $query->result(); 
           

            $product_wood_finish_choices = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_wood_finish_choices[] =  $value->id;
               }
           }

           return $product_wood_finish_choices;
            
        }


          function get_all_product_mat_color_choices($id)
        {       
           $this->db->select("*"); 
           $this->db->where('product_mat_color_choices.product_id', $id); 
           $this->db->from('product_mat_color_choices');  
           $this->db->join('colors', 'product_mat_color_choices.mat_color_id = colors.id');
           $query = $this->db->get();  
           $result = $query->result(); 
           

            $product_suede_mat_colors = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_suede_mat_colors[] =  $value->id;
               }
           }

           return $product_suede_mat_colors;
            
        }

         function get_all_product_format($id)
        {       
           $this->db->select("*"); 
           $this->db->where('product_format_choice_store.product_id', $id); 
           $this->db->from('product_format_choice_store');  
           $this->db->join('product_format', 'product_format_choice_store.format_id = product_format.id');
           $query = $this->db->get();  
           $result = $query->result(); 
           

            $product_format = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_format[] =  $value->id;
               }
           }

           return $product_format;
            
        }

         function get_all_product_sizes($id)
        {       
           $this->db->select("*"); 
           $this->db->where('product_sizes.product_id', $id); 
           $this->db->from('product_sizes');  
           $this->db->join('sizes', 'product_sizes.size_id = sizes.id');
           $query = $this->db->get();  
           $result = $query->result(); 
           

            $product_size = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_size[] =  $value->id;
               }
           }

           return $product_size;
            
        }

        function get_all_product_colors($id)
        {       
           $this->db->select("*"); 
           $this->db->where('product_colors.product_id', $id); 
           $this->db->from('product_colors');  
           $this->db->join('colors', 'product_colors.color_id = colors.id');
           $query = $this->db->get();  
           $result = $query->result(); 
           

            $product_color = [];
           if(!empty($result)){
                foreach ($result as $key => $value) {
                    $product_color[] =  $value->id;
               }
           }

           return $product_color;
            
        }

        public function fetchOffers()
        {
            $this->db->select('`'.$this->table.'`.*, `'.$this->table.'`.status, CONCAT("'.base_url().'", `'.$this->table.'`.product_image) as product_image, CONCAT("'.base_url().'", `merchants`.profile_picture) as merchant_image, merchants.username as brand_name,merchants.is_super_merchant as Is Super Merchant, provinces.name');
            $this->db->join('merchants', 'merchants.id=products.merchant_id');
            $this->db->join('provinces', 'provinces.id=merchants.province');
            $this->db->where('`'.$this->table.'`.status', 1);
            $this->db->where('is_featured', 1);
            $query = $this->db->get($this->table);
            return $query->result_array();
        }

        public function giftIdeas()
        {
            $this->db->select('`'.$this->table.'`.*, `'.$this->table.'`.status, CONCAT("'.base_url().'", `'.$this->table.'`.product_image) as product_image, CONCAT("'.base_url().'", `merchants`.profile_picture) as merchant_image, merchants.username as brand_name,merchants.is_super_merchant as Is Super Merchant, provinces.name');
            $this->db->join('merchants', 'merchants.id=products.merchant_id');
            $this->db->join('provinces', 'provinces.id=merchants.province');
            $this->db->where('`'.$this->table.'`.status', 1);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(10);
            $query = $this->db->get($this->table);
            return $query->result_array();
        }

        public function searchByProvince($province)
        {
            if(empty($province)) { return []; }
            $this->db->select('`'.$this->table.'`.*, `'.$this->table.'`.status, CONCAT("'.base_url().'", `'.$this->table.'`.product_image) as product_image, CONCAT("'.base_url().'", `merchants`.profile_picture) as merchant_image, merchants.username as brand_name,merchants.is_super_merchant as Is Super Merchant, provinces.name');
            $this->db->join('merchants', 'merchants.id=products.merchant_id');
            $this->db->join('provinces', 'provinces.id=merchants.province');
            $this->db->where('`'.$this->table.'`.status', 1);
            $this->db->like('provinces.name', $province);
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get($this->table);
            return $query->result_array();
        }

        public function searchByName($name)
        {
            if(empty($name)) { return []; }
            $this->db->select('`'.$this->table.'`.*, `'.$this->table.'`.status, CONCAT("'.base_url().'", `'.$this->table.'`.product_image) as product_image, CONCAT("'.base_url().'", `merchants`.profile_picture) as merchant_image, merchants.username as brand_name,merchants.is_super_merchant as Is Super Merchant, provinces.name');
            $this->db->join('merchants', 'merchants.id=products.merchant_id');
            $this->db->join('categories', 'categories.id=merchants.categories');
            $this->db->join('provinces', 'provinces.id=merchants.province');
            $this->db->where('`'.$this->table.'`.status', 1);
            $this->db->group_start();
            $this->db->like('`'.$this->table.'`.product_name', $name);
            $this->db->or_like('merchants.username', $name);
            $this->db->or_like('categories.name', $name);
            $this->db->group_end();
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get($this->table);
            return $query->result_array();
        }

        public function searchByBrand($merchantName)
        {
            if(empty($merchantName)) { return []; }
            $this->db->select('`merchants`.*,CONCAT("'.base_url().'", `merchants`.profile_picture) as merchant_image,merchants.is_super_merchant as Is Super Merchant, provinces.name as province_name');
            $this->db->join('provinces', 'provinces.id=merchants.province');
            $this->db->like('merchants`.username', $merchantName);
            $this->db->order_by('merchants.id', 'DESC');
            $query = $this->db->get('merchants');
            return $query->result_array();
        }
     
    
}
