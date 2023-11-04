<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->Model("LoginModel");
		$this->load->library('form_validation');
		$this->load->Model("UserDetailsModel");
	}

	public function login()
	{ 	
		if($this->session->userdata('id')){
			redirect('contact');
		}
		$data['title'] = 'login-Skydash';
		$this->load->view('header',$data);
		$this->load->view('login');
		$this->load->view('footer');
	}


	public function user_otp()
	{ 	
		if(!$this->session->userdata('IsLogin')){
			redirect('login');
		}
		$data['title'] = 'Varify OTP-Skydash';
		$this->load->view('header',$data);
		$this->load->view('user_otp');
		$this->load->view('footer');
	}

	public function login_process()
	{
		$this->form_validation->set_rules('username', 'Email/Usernam', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		 if ($this->form_validation->run() == FALSE)
         {
         	$data['title'] = 'login-Skydash';
			$this->load->view('header',$data);
			$this->load->view('login');
			$this->load->view('footer');
         }
         else
         {
         	$username = $this->input->post('username');
     		$password = $this->input->post('password');
			$result = $this->LoginModel->UserLogin($username);
			print_r($result); die('fffff');
			if(!empty($result)){
				if($result->status == 1)
				{
					$decript = $this->encryption->decrypt($result->password);
					if($decript == $password)
		         	{
		         		$userdata = array(
		         			'id' => $result->id,
		         			'name' => $result->name,
		         			'logged_in' => true

		         		);
		         		$this->session->set_userdata($userdata);
		         		 $response['status'] = 'success';
		         		 $response['message'] = 'Login Successfully.';
		         	}
		         	else
		         	{
		         		//print_r('no');
		         		 $response['status'] = 'error';
		         		 $response['message'] = 'Invalid credentials ';
		         	}
				}
				else if($result->status == 2)
				{
					 $response['status'] = 'error';
	         		 $response['message'] = 'Your Block By Admin.';
				}
				
			}
			else{
					 $response['status'] = 'error';
	         		 $response['message'] = 'You are not verify user.';
			}
			
         	
         }
         echo json_encode($response);
	}

	

	public function forgetpass()
	{ 
		$data['title'] = 'ForgetPassword - skydash';
		$this->load->view('header',$data);
		$this->load->view('forgetpassword');
		$this->load->view('footer');
	}

	public function forgetpass_process()
	{
		$response = array();
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if ($this->form_validation->run() == FALSE)
         {
         	$this->forgetpass();
         }
	 	else
		{
			$email = $this->input->post('email');
	 		$result = $this->LoginModel->GetForgetPassLink($email);
	 		if(!empty($result))
	 		{
	 			$currentTime = time();
		 		if($result->expair_time > $currentTime)
		 		{
		 			$response["status"] = "error";
					$response["message"] = "You have sent link please use that link.";
		 		}
		 		else
		 		{
		 				
		 			$email = $this->session->set_userdata('email',$result->email);
					$response["status"] = "success";
		 		}
		 	}
		 	else
		 	{
		 		$response["status"] = "error";
				$response["message"] = "Email Is Not Register";
		 	}
		}
	 	echo json_encode($response);
	}


	public function urllink()
	{
		if(!$this->session->userdata('email'))
		{
			redirect('login');
		}
		$email = $this->session->userdata('email');
		$data['users'] = $this->LoginModel->GetForgetPassLink($email);
		$expair_time = time_url_link_expire_addmin();
		$currentTime = timestamp();
				
		$this->db->where('email',$email)->update('user_details',array('expair_time' => $expair_time));
	    $encryptid = encrypt($data['users']->id);
	    $encrypttime = encrypt($expair_time);
        $url = base_url().'passwordrecover?id='.$encryptid.'&time='.$encrypttime;
        $sessionurl1 =  $this->session->set_userdata('url',$url);
        
        $data['url'] = $url;
      	
		$data['title'] = 'Linkgenerate - skydash';
		$this->load->view('header',$data);
		$this->load->view('linkgenerate',$data);
		$this->load->view('footer');
	}

	public function passwordrecover()
	{

		$getid = $_GET['id'];
	   	$gettime =$_GET['time'];
	 	$strtoreplaceid = str_replace(" ","+",$getid);
	 	$strtoreplacetime = str_replace(" ","+",$gettime);
	 	$decryptid = decrypt($strtoreplaceid);
	 	$decrypttime = decrypt($strtoreplacetime);
		$data['users'] = $this->LoginModel->PasswordForget($decryptid);
	 	if($data['users']->expair_time == 0)
	 	{
	 		redirect('login');
	 	}

	 	$data['users'] = $this->LoginModel->PasswordForget($decryptid);
		$expair_time = time_url_link_expire_addmin();
		$encryptid = encrypt($decryptid);
	    $encrypttime = encrypt($expair_time);
	   	

	 	
	
		 if(($decryptid) && ($decrypttime))
		 {
		 	$data['userid'] = $getid;
			$data['title'] = 'ForgetPassword - skydash';
			$this->load->view('header',$data);
			$this->load->view('passwordrecover',$data);
			$this->load->view('footer');
		 }
		else
		{	
			show_404();
		}        
	}


	public function passwordrecover_process()
	{
		$response = array();
		$this->form_validation->set_rules('newpasswords', 'New Password', 'trim|required');
		if ($this->form_validation->run() == FALSE)
	    {
	     	$this->passwordrecover();
	    }
	    else
	    {
	    	$newpassword = $this->encryption->encrypt($this->input->post('newpasswords'));
	    	$userid = $this->input->post('userid');
	    	$strtoreplaceid = str_replace(" ","+",$userid);
	    	$decrypt_userid = decrypt($strtoreplaceid);
	    	$this->db->query("SELECT * FROM `user_details` WHERE `expair_time` !=0  AND `id` = '$decrypt_userid'")->row();
	    	$result1 = $this->LoginModel->PasswordForget($decrypt_userid);
	    	
	    	if($result1->expair_time != 0)
	    	{
	    		$currentTime = timestamp();
	    		if($currentTime > $result1->expair_time)
		     	{
			 	  	$response["status"] = "error";
					$response["message"] = "Link is expired";
		     	}
		     	else
		     	{
		     		$result = $this->LoginModel->RecoverPassword($newpassword,$decrypt_userid);
		     		$response["status"] = "success";
					$response["message"] = "Your Password Successfully Recover";
		     	}
	    	}
	    	else
	    	{
	    		$response["status"] = "error";
				$response["message"] = "Link is expired";
	    	}
	       	
	    }
	    echo json_encode($response);
	}

	public function logout()
	{
		 $this->session->unset_userdata('logged_in');
	 	 $this->session->unset_userdata('id');
    	 redirect('login');
	}

}
