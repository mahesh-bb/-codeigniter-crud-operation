<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function UserLogin($username)
	{	
		$statuscode = $this->db->group_start()->where('name',$username)->or_where('email',$username)->group_end()->get('user_details')->row();
		if(!empty($statuscode))
		{
			if($statuscode->status == 1)
			{
				$this->db->group_start();
				$this->db->where('name',$username); 
		        $this->db->or_where('email',$username);  
		        $this->db->group_end();
		        $this->db->where('status',$statuscode->status); 
		     	$query = $this->db->get('user_details');
		     	if($query)
		     	{
		     		return $query->row();
		     	}
		     	else
		     	{
		     		return false;
		     	}
			}
			else if($statuscode->status == 2)
			{
				//print_r('two'); die();
				$this->db->group_start();
				$this->db->where('name',$username); 
		        $this->db->or_where('email',$username);  
		        $this->db->group_end();
		        $this->db->where('status',$statuscode->status); 
		     	$query = $this->db->get('user_details');
		     	if($query)
		     	{
		     		return $query->row();
		     	}
		     	else
		     	{
		     		return false;
		     	}
			}
		}
		else
		{
			return false;
		}
		
		
		 	 
	}

	public function PasswordForget($user_id)
	{
		$sql =  $this->db->where('id',$user_id)->get('user_details');
		if($sql)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
	public function GetForgetPassLink($email)
	{
		$sql = $this->db->where('email',$email)->get('user_details');
		if($sql)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}

	public function RecoverPassword($newpassword,$userid)
	{
		$update = $this->db->where('id',$userid)->update('user_details',array('password' => $newpassword));
		if($update)
		{
			$this->db->where('id',$userid)->update('user_details',array('expair_time' => 0));
			return true;
		}
		else
		{
			return false;
		}	
	}


}
