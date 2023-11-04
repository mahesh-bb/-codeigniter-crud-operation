<?php 
	function SelectAllRow($tablename)
	{
		$CI =& get_instance();
        $CI->db->from($tablename);
        $query = $CI->db->get();
        return $query;
	}

	function InsertRow($tablename,$inserdata)
	{
		$CI =& get_instance();
		return $CI->db->insert($tablename,$inserdata);
	}

	function UpdateRow($tablename,$param,$where)
	{
		$CI =& get_instance();
		$CI->db->where($where);
    	return $CI->db->update($tablename,$param);
	}

	function checkEmail($email,$tablename)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from($tablename);
        $CI->db->where('email', $email);
        $query = $CI->db->get();
        return $query->row();
    }

    function getRecordOnId($table, $where){
        $CI =& get_instance();
        // $CI->db->select("id,name");
        $CI->db->from($table);
        $CI->db->where($where);
        $query = $CI->db->get();
        return $query->row();
    }

    function CheckUser()
    {
  		$CI = & get_instance();  
  		$admin_id = $CI->session->userdata('admin_id');
  		$decriptid = decryptedtext($admin_id, publickey('adminsessionid'));
  		$result = $CI->db->select('*')->from('adminlogin')->where('admin_id ', $decriptid)->get()->row();
	  	if($result)
	  	{
	     	redirect(SKYDASH.'/dashboard');
	  	}
	  	return FALSE;
	}
	function IsLogin()
	{

		$CI = & get_instance();  
		$admin_id = $CI->session->userdata('admin_id');
		$decriptid = decryptedtext($admin_id, publickey('adminsessionid'));
		$result = $CI->db->select('*')->from('adminlogin')->where('admin_id ', $decriptid)->get()->row();
	  	if(!$result)
	  	{
	  		redirect(SKYDASH);
	  	}
	  	return FALSE;  
	}

	function get_record($select='*',$table='',$where='',$type='single')
	{
		$CI = & get_instance();  
	  	$CI->db->select($select);
	  	if($where!='')
	  	{
	  		$CI->db->where($where);
	  	}
		$query = $CI->db->get($table);
	    if($type=='single')
	    {
	        return $query->row_array();
	    }
	    else if($type=='multi')
	    {
	        return $query->result_array();
	    }	
	    else
		{
	        return $query->num_rows();
		}
	}

	function delete_record($table,$where)
	{
		$CI =& get_instance();  
		$CI->db->where($where);
	    $CI->db->delete($table);
	    if ($CI->db->affected_rows())
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}

   
?>