<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	function __construct(){
		parent::__construct();
		// if(!$this->session->userdata('id')){
		// 	redirect('login');
		// }
		
	}

	public function contact()
	{ 	
		$data['title'] = 'contact-Skydash';
		$this->load->view('header',$data);
		$this->load->view('contact');
		$this->load->view('footer');
	}	
}
