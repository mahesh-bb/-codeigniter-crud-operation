<?php
date_default_timezone_set("Asia/Kolkata");
defined('BASEPATH') OR exit('No direct script access allowed');

class BackApiModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function AdminLogin($email,$password)
	{
		$query =  $this->db->where('email',$email)->where('password',$password)->get('adminlogin');
		if($query)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function last_login_datetime($email,$encrpassword)
	{
		$t=time();
		$datatime = date('Y-m-d H:i:s',$t);
		$sql = UpdateRow('adminlogin',['updated_date' => $datatime],['email' => $email,'password' => $encrpassword]);
		if($sql)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function UserFetchList($param)
	 {		
	 	if($_SERVER['REQUEST_METHOD']=='POST')
	 	{
	 		$usetstatus = $param['userstatus'];
	 		$ps['daterange'] = explode("to",$param['daterange']);

	 	
	 	 
	 	$time = date('H:i:s');
	 	$FromDate = date('Y-m-d',strtotime($ps['daterange'][0]));
		$Todate = date('Y-m-d',strtotime($ps['daterange'][1]));
	
		
		if($usetstatus == 'all')
		{
			// $sql = $this->db->query('select * from `user_details` where date(`inserted_date`) between "'.$FromDate.'" and "'.$Todate.'" order by `inserted_date` desc');
			// $sql = $this->db->query("SELECT `user`.*, `citi`.* FROM `user_details` `user` INNER JOIN `cities` `citi` ON `user`.`city_id` = `citi`.`city_id` WHERE date(`user`.`inserted_date`) >= '".$FromDate."' AND date(`user`.`inserted_date`) <= '".$Todate."' ORDER BY `user`.`inserted_date` DESC");
			
			$this->db->select('user.*, citi.*')->join('cities citi','user.city_id = citi.city_id','inner');
			$this->db->where('date(user.inserted_date) >=',$FromDate);//start date
			$this->db->where('date(user.inserted_date) <=',$Todate);//end date
			$this->db->order_by('user.inserted_date','desc');
			$sql = $this->db->get('user_details user');
		
			if($sql)
			{
				return $sql->result();
			}
			else
			{
				return false;
			}
		}
		else
		{	$this->db->select('user.*, citi.*')->join('cities citi','user.city_id = citi.city_id','inner');
			$this->db->where('status',$param['userstatus']);
			$this->db->where('date(user.inserted_date) >=',$FromDate);//start date
			$this->db->where('date(user.inserted_date) <=',$Todate);//end date
			$this->db->order_by('user.inserted_date','desc');
			$sql = $this->db->get('user_details user');
			
			if($sql)
			{
				return $sql->result();
			}
			else
			{
				return false;
			}
		}
	 	}
	 	
	}

	public function bckupduser($param)
	{
    	$fetchid = array_pop($param); 
    	$where = array('id' => $fetchid); 
    	$userupdate = UpdateRow('user_details',$param,$where);
    	if($userupdate)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
	}

	public function bckpassupd($param)
	{
		
		$decadminpass = decryptedtext($param['adminpassword'],publickey('adminpassword'));
		$adminsessid = $this->session->userdata('admin_id');
		$adminid = $encrpadminid = decryptedtext($adminsessid,publickey('adminsessionid'));
		$whereid = array('admin_id' => $adminid);
		$GetRecord = get_record($select='*',$table='adminlogin',$where=$whereid,$type='single');
		$decdbadminpass = decryptedtext($GetRecord['password'],publickey('adminpassword'));
		
		if($decadminpass == $decdbadminpass)
		{
			$userpass = array('password' => $param['userpassword']);
			$fetchid = array_pop($param); 
    		$user_id = array('id' => $fetchid); 
    		return $this->db->where($user_id)->update('user_details',$userpass);
		}
		else
		{
			return false;
		}
	}

	public function UsersStatus($statususer,$userid)
	{
		$status = array('status' => $statususer);
		$sql =  UpdateRow('user_details',$status,['id' => $userid]); 
		if($sql)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
	}

	public function EditUserMailExits($email,$id = 0)
	{
		$q  = $this->db->select('email')->from('user_details')->where(['email' => $email]);
		if($id > 0)
		{
			$q = $q->where(['id !=' => $id]);
		}
		return $q->get()->row();

	}

	public function Modaledit($userid)
	{

		$GetRecord = $this->db->where('id',$userid)->get('user_details');
		if($GetRecord)
    	{
    		return $GetRecord->row();
    	}
    	else
    	{
    		return false;
    	}
	}

	public function import_excel($data)
	{
		$result = $this->db->insert('user_impot_excel',$data);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public function DeleteUser($userid)
	{
		$sql = delete_record("user_details",array('id' => $userid));
		$sql1 = delete_record("user_otp",array('user_id' => $userid));
		if($sql && $sql1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		
	

}
