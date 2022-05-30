<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Notification extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->helper('general');
       $this->load->model('UserNotifications', 'user_notifications');
       $this->load->library('email');
    }

    /**
     * Get All categories Data from this method.
     *
     * @return Response
    */
    public function userNotifications_post()
    {
        $input = $this->input->post();
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        $notifications = $this->user_notifications->userNotification($input['user_id']);
        $this->response(['status' => 'success', 'data' => $notifications], REST_Controller::HTTP_OK);
    }

    public function userNotificationDetails_post()
    {
        $input = $this->input->post();
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['notification_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Notification ID'], REST_Controller::HTTP_OK);
        }
        $notifications = $this->user_notifications->userNotificationDetails($input['user_id'],$input['notification_id']);
        $this->response(['status' => 'success', 'data' => $notifications], REST_Controller::HTTP_OK);
    }
}