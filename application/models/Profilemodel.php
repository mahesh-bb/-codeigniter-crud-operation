<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profilemodel extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
	}

	public function UpdateUser($param,$userid)
	{
		$userupdate =  UpdateRow('user_details',$param,['id' => $userid]);
		if($userupdate)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function PasswordChange($param)
	{
		$userId = $this->session->userdata('id');
		$sql = getRecordOnId('user_details', ['id' => $userId]);
		$password_decript = $this->encryption->decrypt($sql->password);
		if($param['oldpassword'] == $password_decript){
			$newpassword = array('password' => $this->encryption->encrypt($param['newpassword']));
			$result = UpdateRow('user_details',$newpassword,['id' => $UserId]);
			return true;
		}else{
			return false;
		}
	}

	public function GetProfile()
	{
		$userId = $this->session->userdata('id');
		//print_r($userId); die();
		$usersql = getRecordOnId('user_details', ['id' => $userId]);
		//echo $this->db->last_query(); die;
		// print_r($usersql); die();
		if(!empty($usersql))
		{
			$citiessql = getRecordOnId('cities', ['city_id' => $usersql->city_id]);
			$usersql->city = $citiessql->city;
			$statessql = getRecordOnId('states', ['state_id' => $citiessql->state_id]);
	 		$usersql->state = $statessql->state;
			$countriessql = getRecordOnId('countries', ['country_id' =>$statessql->country_id]);
			$usersql->country =  $countriessql->country;
			return $usersql;
		}
		else
		{
		 	return false;
		}
	}
}
