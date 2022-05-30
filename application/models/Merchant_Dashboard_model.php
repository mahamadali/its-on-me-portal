<?php
class Merchant_Dashboard_model extends CI_Model
{

     public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_product_count()  
      {  
           $this->db->select("*");  
           $this->db->from('products');  
           $query = $this->db->get(); 
           return $query->num_rows();    
      }


      public function get_all_cat_count()  
      {  
           $this->db->select("*");  
           $this->db->from('product_categories');  
           $query = $this->db->get(); 
           return $query->num_rows();    
      }
      public function get_all_color_count()  
      {  
           $this->db->select("*");  
           $this->db->from('colors');  
           $query = $this->db->get(); 
           return $query->num_rows();    
      }

      public function get_all_public_member_collections()  
      {  
           $this->db->select("*");  
           $this->db->from('member_collections');  
           $this->db->where('is_private',0);
           $query = $this->db->get(); 
           return $query->num_rows();    
      }
      public function get_all_private_member_collections()  
      {  
           $this->db->select("*");  
           $this->db->from('member_collections');  
           $this->db->where('is_private',1);
           $query = $this->db->get(); 
           return $query->num_rows();    
      }

       public function get_all_collections_comments()  
      {  
           $this->db->select("*");  
           $this->db->from('collections_comments');  
           $this->db->where('is_deleted',0);
           $query = $this->db->get(); 
           return $query->num_rows();    
      }

      public function get_all_collections_likes()  
      {  
           $this->db->select("*");  
           $this->db->from('collections_likes');  
           $query = $this->db->get(); 
           return $query->num_rows();    
      }

      public function get_all_foundership_purchases()  
      {  
           $this->db->select("*");  
           $this->db->from('members'); 
           $this->db->where('has_purchased_fm_package',1);
           $this->db->where('is_founder_member',1); 
           $query = $this->db->get(); 
           return $query->num_rows();    
      }

      
      public function get_all_founder_members()  
      {  
           $this->db->select("*");  
           $this->db->from('members'); 
           $this->db->where('has_early_access_to_fm_package',1);
           $this->db->where('is_founder_member',1); 
           $query = $this->db->get(); 
           return $query->num_rows();    
      }

      public function get_Member_chart_detail($from_date,$to_date){
          $this->db->select("*");  
          $this->db->from('members'); 
          // $this->db->where('created_at', 0);    
          $query = $this->db->get(); 
          return $query->num_rows();       
      }


      public function getPreRegisterMemberCount($start, $end)
      {

          $where = " AND
                    DATE(created_at) >= '".$start."' AND 
                    DATE(created_at) <= '".$end."'";

          $sql = "select year(created_at) as year_count,month(created_at) as month,day(created_at) as day,count(*) as total_count
                    from members
                    WHERE is_preregister_user = 1 
                    ".$where."
                    group by year(created_at),month(created_at),day(created_at)
                    order by year(created_at),month(created_at),day(created_at)"; 

         
          $result = $this->db->query($sql)->result_array();

          $data = [];

          $startTime = strtotime( $start );
          $endTime = strtotime( $end );

          // Loop between timestamps, 24 hours at a time
          for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $date = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
            $day = date( 'd', $i );
            if($month_stats = $this->dayDataAvailable($day, $result)) {
                  $data[$date] = (int) $month_stats['total_count'];  
               } else {
                    $data[$date] = 0;     
               }
          }
          return $data;
      }

      public function getMembersCount($start, $end)
      {

          $where = "AND DATE(created_at) >= '".$start."' AND 
                    DATE(created_at) <= '".$end."'";

          $sql = "select year(created_at) as year_count,month(created_at) as month,day(created_at) as day,count(*) as total_count
                    from members WHERE is_preregister_user = 0 
                    ".$where."
                    group by year(created_at),month(created_at),day(created_at)
                    order by year(created_at),month(created_at),day(created_at)"; 

         
          $result = $this->db->query($sql)->result_array();

          $data = [];

          $startTime = strtotime( $start );
          $endTime = strtotime( $end );

          // Loop between timestamps, 24 hours at a time
          for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $date = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
            $day = date( 'd', $i );
            if($month_stats = $this->dayDataAvailable($day, $result)) {
                  $data[$date] = (int) $month_stats['total_count'];  
               } else {
                    $data[$date] = 0;     
               }
          }
          return $data;
      }



      public function getMemberCollectionsCount($start, $end)
      {

          $where = " AND
                    DATE(created_at) >= '".$start."' AND 
                    DATE(created_at) <= '".$end."'";

          $sql = "select year(created_at) as year_count,month(created_at) as month,day(created_at) as day,count(*) as total_count
                    from member_collections
                    WHERE 1 = 1 
                    ".$where."
                    group by year(created_at),month(created_at),day(created_at)
                    order by year(created_at),month(created_at),day(created_at)"; 

         
          $result = $this->db->query($sql)->result_array();

          $data = [];

          $startTime = strtotime( $start );
          $endTime = strtotime( $end );

          // Loop between timestamps, 24 hours at a time
          for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $date = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
            $day = date( 'd', $i );
            if($month_stats = $this->dayDataAvailable($day, $result)) {
                  $data[$date] = (int) $month_stats['total_count'];  
               } else {
                    $data[$date] = 0;     
               }
          }
          return $data;
      }

      public function dayDataAvailable($day, $result) {
          if(!empty($result)) {
               foreach($result as $month_stats) {
                    if($month_stats['day'] == ($day)) {
                         return $month_stats;
                    }
               }
          } else {
               return false;
          }
      }

       public function getSiteVisitors($start = '', $end = '')  
      {  
           $this->db->select("*");  
           $this->db->from('site_visitors');
          // echo $start . " ".$end;exit();
           if(!empty($start) || !empty($end))
           {
              $this->db->where('date(created_at) >=',$start); 
              $this->db->where('date(created_at) <=',$end); 
           } 
           $query = $this->db->get(); 
           return $query->result();    
      }

      public function getMemberInfo($memberId)
      {
            $this->db->select("*");  
           $this->db->from('members'); 
           $this->db->where('id',$memberId); 
           $query = $this->db->get(); 
           return $query->row();
      }

       public function get_all_preregister_members()  
      {  
           $this->db->select("*");  
           $this->db->from('members'); 
           $this->db->where('is_preregister_user',1); 
           $query = $this->db->get(); 
           return $query->num_rows();    
      }
       public function get_all_active_members()  
      {  
           $this->db->select("*");  
           $this->db->from('members');
           $this->db->where('is_preregister_user',0); 
           $query = $this->db->get(); 
           return $query->num_rows();    
      }

}
