<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
     if($this->session->userdata('admin'))
         {
             redirect('dashboard');
         }
		$this->load->view('login/index');	 

	}  

    public function check_login()
    {
       $data['error'] = '';
       $this->form_validation->set_rules('email', 'EMail', 'trim|required');
       $this->form_validation->set_rules('password', 'Password', 'trim|required');
       if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', 'Please follow validation rules!');
        redirect('Login', 'refresh');
    }
    else
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password'); 
        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
        $query=$this->db->get('admin');
        $get_user = $query->result();   

          if(!empty($get_user))
          {
              $newdata = array(
               'admin' => $get_user[0]->id, 
               'email' => $get_user[0]->email
           );

            $this->session->set_userdata($newdata);
          }
            

            $row = $query->num_rows();

            if($row)
            {
                redirect('/dashboard');
            }
            else
            {   
               $data['error'] = "1";
           }
           $this->load->view('login/index',$data);
       }
   }


   function logout()
   {
    $this->session->sess_destroy();
    redirect('/');
}	
}