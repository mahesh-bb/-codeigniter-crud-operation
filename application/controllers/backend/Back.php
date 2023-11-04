<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Back extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->Model('backend/BackApiModel');
	}

	public function index()
	{ 
		$cookie = array(
			'email' => $this->input->cookie('email'),
			'password' => $this->input->cookie('password'),
			'rememberme' => $this->input->cookie('rememberme')
		);

		$config['sess_cookie_name'] = $cookie['email'];
		
		$data['cookies'] = $cookie;
		$data['title'] = 'Login';
		$this->load->view('backend/login',$data);
	}
	public function loads($page='',$data=[])
	{
		$path='backend/inc/';
		$this->load->view($path.'header',$data);
		$this->load->view($path.'sidebar');
		$this->load->view('backend/'.$page,$data);
		$this->load->view($path.'footer');
	}
	public function dashboard()
	{
		IsLogin();
		$data['title'] = 'Dashboard';
		$data['page']='backend/dashboard';
		$this->loads('dashboard',$data);
	}

	public function manageuser()
	{
		//print_r('hello'); die();
		IsLogin();

		$data['title'] = 'Userlist';

		//$data['userstatus'] = $this->BackApiModel->GetUserStatus();
		//print_r($data['userstatus']->status); die();
		$data['page']='backend/manageuser';
		$this->loads('manageuser',$data);
	}
}
