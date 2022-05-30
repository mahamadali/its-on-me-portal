<?php
class UserNotifications extends CI_Model
{

    var $table = "user_notifications";
    var $select_column = array("id","user_id","title","message","link","created_at");
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function userNotification($userId) {
        $this->db->where('user_id', $userId);
        $query = $this->db->get('user_notifications');
        return $query->result();
    }
 
}
