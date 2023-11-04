<?php
date_default_timezone_set("Asia/Kolkata"); 
defined('BASEPATH') OR exit('No direct script access allowed');

class UserDetails extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->Model("UserDetailsModel");

	}

	public function register()
	{ 	
		if($this->session->userdata('id')){
			redirect('contact');
		}
		$data['title'] = 'Registertion-Skydash';
		$data['cities'] = $this->UserDetailsModel->CityLoad();
		$this->load->view('header',$data);
		$this->load->view('register',$data);
		$this->load->view('footer');
	}

	function getstate(){
		$postCity = $this->input->post('city_id');
		$result = $this->UserDetailsModel->StateLoad($postCity);
		echo json_encode($result);
	}


	public function register_process()
	{ 	
		 $insertdate = date('Y-m-d h:i:s');
		 $this->form_validation->set_rules('username', 'Name', 'trim|required');
		 $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
         $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
         $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|required');
         $this->form_validation->set_rules('password', 'Password', 'trim|required');
         $this->form_validation->set_rules('city', 'City', 'trim|required');

         if ($this->form_validation->run() == FALSE)
         {
         	$data['cities'] = $this->UserDetailsModel->CityLoad();
			$this->load->view('header');
			$this->load->view('register',$data);
			$this->load->view('footer');
         }
         else
         {
         	$param = array(
         	 'id' => $this->input->post('id'),
     		 'name' => $this->input->post('username'),
     		 'email' => $this->input->post('email'),
     		 'mobile' => $this->input->post('mobile'),
     		 'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
     		 'password' => $this->encryption->encrypt($this->input->post('password')),
     		 'address' => $this->input->post('address'),
     		 'city_id' => $this->input->post('city'),
     		 'state_id' => $this->input->post('state'),
     		 'country_id' => $this->input->post('country')
     		);
         	
         	$checkmail = checkEmail($param['email'],'user_details');
         	 if(empty($checkmail))
   			 {
         	 		$result = $this->UserDetailsModel->UserStore($param);
         	 		if($result)
         			{	
         				$userdata = array(
         	 				'user_id' => strrev(md5($result)),
         	 				'IsLogin' => true
         	 			);
         	 			$sww = $this->session->set_userdata($userdata);
         				$user_id = $this->session->userdata('user_id');
         	
         				$sesuser = $this->UserDetailsModel->GetSessionId();
         	
         					$otpdigit = 6;
            				$madeOtp = generateNumericOTP($otpdigit);
            				$madeExpire = timestampaddmin();
            				$otparray = array(
                				'otp' => $madeOtp,
                				'user_id' => $sesuser->id,
                				'expair_time' => $madeExpire   
            				);
            			$storeotp = $this->UserDetailsModel->storeotp($otparray);
            			$set = $this->session->set_userdata('otp_id_session',$storeotp);
         				$response = array('status' => "success",'massege' => "data added successfully" );
         			}
         			else
         			{
         				$response = array('status' => "error",'massege' => "failed to add data" );
         			}
         	 }
		    else
		    {
		    	$response = array('status' => "error",'massege' => "Email Already Exists" );
		    }
	
         	echo json_encode($response);
         }
	}

	 public function verifyotp()
	 {
	 	$response = array();
	 	$user_id = $this->input->post('user_id');
	 	
	 	$user_otp = $this->input->post('otp');
	 	$res = $this->UserDetailsModel->GetUserId();
	 	if($res)
	 	{
		 	$currentTime = timestamp();
	 	 	if($currentTime > $res->expair_time)
	 	 	{
	 	 		$response = array('status' => "error",'massege' => "Time Is  Expire" );
	 	 	}
	 	 	else if($user_otp != $res->otp)
	 	 	{
	 	 		$response = array('status' => "error",'massege' => "Invalid OTP" );			
	 	 	}
			else
			{
			 	$param['otp'] = $user_otp;
			 	$updOtp = $this->UserDetailsModel->updateotp($param,$res->user_id);
			 	if($updOtp)
			 	{
			 		$status['status'] = 1;
			 		$expair_time['expair_time'] = '0';
			 			$userstausupdate = $this->UserDetailsModel->UpdateUserStatus($status,$res->user_id);
			 			$userexpair_timeupdate = $this->UserDetailsModel->UpdateExpireTime($expair_time,$res->otp_id);
			 	}

			 	$this->session->unset_userdata('IsLogin');
	 			$this->session->unset_userdata('user_id');
			 	$response = array('status' => "success",'massege' => "Registration successfully" );
			}
	 	}
	 	else
	 	{
	 		$response = array('status' => "error",'massege' => "oops! something went wrong" );	
	 	}
	  	 echo json_encode($response);
	 }

	 public function otpresend()
	 {
	 	$response = array();
	 	$res = $this->UserDetailsModel->GetUserId();
	 	if(!empty($res))
	 	{
	 		$otpdigit = 6;
	 		$madeOtp = generateNumericOTP($otpdigit);
        	$madeExpire = timestampaddmin();
        	$otpidsession = $this->session->userdata('otp_id_session');
     	
	        $param1 = array(
	            'otp' => $madeOtp,
	            'expair_time' => $madeExpire,
	            'created_date' => date('Y-m-d H:i:s')
	        );
	        $wh=array(
	        	'expair_time !='=>'0',
	        	'otp_id'=>$otpidsession
	    	);
        	$time = UpdateRow('user_otp',$param1,$wh);
        	
        	if($time){
        		$result = $this->UserDetailsModel->GetUserId();
	        	if($madeExpire > $result->expair_time)
		 		{
		 			$response = array('status' => "error",'massege' => "Time Is Expaire" );
		 		}
		 		else if($madeOtp != $result->otp)
		 		{
		 			$response = array('status' => "error",'massege' => "Invalid OTP" );			
		 		}
	        	$response = array('status' => "success",'massege' => "otp send register ID" );
        	}
	        else
	        {
	        	$response = array('status' => "error",'massege' => "!Oop Something Is Wrong" );	
	        }
	 	}
	 	else
	 	{
	 		$response = array('status' => "error",'massege' => "oops! something went wrong" );	
	 	}
	 	
       echo json_encode($response);
	 }
	 
}
