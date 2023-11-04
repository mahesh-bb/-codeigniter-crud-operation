<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->Model("HomeModel");
	}

	public function index()
	{ 	
		$data['title'] = 'Home-Skydash';
	
		$this->load->view('header',$data);
		$this->load->view('fronthome');
		$this->load->view('footer');
	}

}
