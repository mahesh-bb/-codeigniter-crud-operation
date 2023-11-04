<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserDetailsModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function CityLoad()
	{ 	
		return SelectAllRow('cities')->result_array();
	}

	// public function GetUserDetails()
	// {
		
	// }

	public function GetSessionId()
	{
		$user_id = $this->session->userdata('user_id'); 
		return $this->db->query("SELECT * FROM `user_details` WHERE REVERSE(md5(`id`))='$user_id'")->row();
	}

	public function GetUserId(){
		$ses = $this->GetSessionId();
		return $this->db->query("SELECT * FROM `user_otp` WHERE `expair_time` !=0  AND `user_id` = $ses->id")->row();
	}

	public function storeotp($otparray)
	{
		$insert = InsertRow("user_otp",$otparray);
		return  $this->db->insert_id();
	}


	public function StateLoad($CityId)
	{ 	

		$getcity = getRecordOnId('cities', ['city_id' => $CityId]);
		if($getcity)
		{
			$getstate = getRecordOnId('states', ['state_id' => $getcity->state_id]);
			if($getstate)
			{
				$getcountry = getRecordOnId('countries', ['country_id' => $getstate->country_id]);
			}
		}
		return $resultvalue = array(
			'city_id' => $getcity->city_id,
			'city' => $getcity->city,
			'state_id' => $getstate->state_id,
			'state' => $getstate->state,
			'country_id' => $getcountry->country_id,
			'country' => $getcountry->country
			);

	}

	public function UserStore($param)
	{ 	
		$insert = InsertRow("user_details",$param);
		return  $this->db->insert_id();
	}

	public function updateotp($param,$UserId){

		$result = UpdateRow('user_otp',$param,['user_id' => $UserId]);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function UpdateUserStatus($param,$UserId)
	{ 	
		UpdateRow('user_details',$param,['id' => $UserId]);
	}

	public function UpdateExpireTime($param,$otp_id)
	{ 	
		UpdateRow('user_otp',$param,['otp_id' => $otp_id]);
	}

	public function UserRemove($UserId){
		$this->db->where('id', $UserId)->delete('user_details');
		return true;
	}

}
