<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->Model('profilemodel');
		$this->load->Model('UserDetailsModel');
		$this->load->library('form_validation'); 
		if(!$this->session->userdata('id')){
		 	redirect('login');
		 }
	}

	public function myprofile()
	{
		//$userId = $this->session->userdata('id');
		//print_r($this->session->userdata('id')); die();

		$data = array();
		$data['title'] = 'Profile - skydash';
		$data['user'] = $this->profilemodel->GetProfile();
		if(!empty($data['user']))
		{
			//print_r($data['user']); die();
			$data['cities'] = $this->UserDetailsModel->CityLoad();
			$this->load->view('header',$data);
			$this->load->view('edituser',$data);
			$this->load->view('footer');
		}
		else
		{
			$this->session->unset_userdata('id');
			redirect('login');
		}
		
		
	}


	public function changepassword()
	{

		$this->form_validation->set_rules('oldpassword', 'Current Password:', 'trim|required');
		$this->form_validation->set_rules('newpassword', 'New Password:', 'trim|required');
		if ($this->form_validation->run() == FALSE)
         {
    		$this->load->view('header');
			$this->load->view('profile');
			$this->load->view('footer');
	     }
	     else
	     {
        	$param = array(
				'oldpassword' => $this->input->post('oldpassword'),
				'newpassword' => $this->input->post('newpassword')
			);
		 	$result = $this->profilemodel->PasswordChange($param);

        	if(!empty($result)){

        		$response['status'] = 'success';
        		$response['message'] = 'Password Is successfullt Change';
        		$this->session->unset_userdata('logged_in');
	 	 		$this->session->unset_userdata('id');
        	}else{
        		$response['status'] = 'error';
        		$response['message'] = 'Old Password Is Invalid ';
        	}

         }
		echo json_encode($response);
	}
	public function StateGet()
	{
		$postCity = $this->input->post('city_id');
		$result = $this->UserDetailsModel->StateLoad($postCity);
		echo json_encode($result);
	}

	public function passwordupdate()
	{		
	 	$data['title'] = 'MyProfile - skydash';
	 	$this->load->view('header',$data);
	 	$this->load->view('changepassword');
	 	$this->load->view('footer');
	}

	public function userupdate()
	{ 	
		$response = array();
		$userid = $this->session->userdata('id');
		$this->form_validation->set_rules('mobile', 'Mobile Mo', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
       

         if ($this->form_validation->run() == FALSE)
         {
         	$data['title'] = 'Profile - skydash';
         	$data['user'] = $this->profilemodel->GetProfile();
         	$data['cities'] = $this->UserDetailsModel->CityLoad();
			$this->load->view('header',$data);
			$this->load->view('edituser',$data);
			$this->load->view('footer');
          }
          else
          {
          	$param = array(
     		 'mobile' => $this->input->post('mobile'),
     		 'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
     		 'address' => $this->input->post('address'),
     		 'city_id' => $this->input->post('city'),
     		 'state_id' => $this->input->post('state'),
     		 'country_id' => $this->input->post('country')
         	);

         	$result = $this->profilemodel->UpdateUser($param,$userid);

         	if(!empty($result)){
        		$response['status'] = 'success';
        		$response['message'] = 'Successfully Update';
        	}else{
        		$response['status'] = 'error';
        		$response['message'] = 'Failed to Update';
        	}
         }
         echo json_encode($response);
	}
}