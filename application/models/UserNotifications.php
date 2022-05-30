<?php
class UserNotifications extends CI_Model
{

    var $table = "user_notifications";
    var $select_column = array("id","user_id","title","message","link","photo","created_at");
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function userNotification($userId) {
        $this->db->select('`'.$this->table.'`.*, CONCAT("'.base_url().'", `'.$this->table.'`.photo) as photo');
        $this->db->where('user_id', $userId);
        $query = $this->db->get('user_notifications');
        return $query->result();
    }

    public function userNotificationDetails($userId,$notificationId) {
        $this->db->select('`'.$this->table.'`.*, CONCAT("'.base_url().'", `'.$this->table.'`.photo) as photo');
        $this->db->where('user_id', $userId);
        $this->db->where('id', $notificationId);
        $query = $this->db->get('user_notifications');
        return $query->result();
    }
 
}
