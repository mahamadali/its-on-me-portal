<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public $data;

	public function __construct(){
        parent::__construct();
       	$this->data['header'] = $this->load->view('header',$this->data,true);
        $this->data['footer'] = $this->load->view('footer',$this->data,true);
        $this->load->model('Dashboard_model');
        $this->load->model('User', 'user');
        $this->load->helper('form');
        $this->load->helper('general');
      }

	public function index()
	{
         if(!$this->session->userdata('admin'))
         {
             redirect('/');
         }
        $this->data['dashboard'] = $this->user->dashboard_statistics();
        $this->data['page'] = "dashboard/index";
		$this->load->view('structure',$this->data);	 

	}	
}