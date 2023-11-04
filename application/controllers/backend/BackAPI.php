<?php
// namespace PhpOffice\PhpSpreadsheet\Spreadsheet;
// namespace PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//https://mpdf.github.io/installation-setup/installation-v7-x.html
date_default_timezone_set("Asia/Kolkata");
require_once 'vendor/autoload.php';
defined('BASEPATH') OR exit('No direct script access allowed');


class BackAPI extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->Model('backend/BackApiModel');
		$this->load->library("excel");
		//$this->load->library("m_pdf");
	}

	public function admin_login()
	{
		$response = array();
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$rememberme = $this->input->post('rememberme');
		
		$encrpassword = encrypttext($password,publickey('adminpassword'));
		if($encrpassword)
		{
			$result = $this->BackApiModel->AdminLogin($email,$encrpassword);
			if($result)
			{
				if(($this->input->post('rememberme')) == 1)
				{


					//$cookiepass = $this->input->set_cookie('password',$password,$newDate1);
					//$cookiemail = $this->input->set_cookie('email',$email,$newDate1);
					//$rememberme = $this->input->set_cookie('rememberme',$rememberme,$newDate1);

					$cookiepass = setcookie("password",$password,time() + (10 * 365 * 24 * 60 * 60));
					$cookiemail = setcookie("email",$email,time() + (10 * 365 * 24 * 60 * 60));
					$rememberme = setcookie("rememberme",$rememberme,time() + (10 * 365 * 24 * 60 * 60));
				}
				else
				{
					delete_cookie("email");
					delete_cookie("password");
					delete_cookie("rememberme");
				}
				$encrpadminid = encrypttext($result->admin_id,publickey('adminsessionid'));
				$this->session->set_userdata('admin_id',$encrpadminid);		
				$this->BackApiModel->last_login_datetime($email,$encrpassword);
				$response['status'] = 'success';
				$response['message'] = 'Login Successfully.';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'Invalid credentials.';
			}
		}
		else
		{
			$response['status'] = 'error';
		}
		
		echo json_encode($response);
	}

	public function showuserlist()
	{
		
		 $response = array();
		 $param = array(
		 	'userstatus' => $this->input->post('userstatus'),
		 	'daterange' => $this->input->post('daterange')
		);

		 
		$result = $this->BackApiModel->UserFetchList($param);
			


		if(!empty($result))
		{
			$output = "";
			foreach($result as $tvalue)
			 {

			 	$row = array();
			 	$row['name'] = $tvalue->name;
			 	$row['email'] = $tvalue->email;
			 	$row['mobile'] = $tvalue->mobile;
			 	$row['dob'] = date('d-m-Y', strtotime($tvalue->dob));
			 	$row['city'] = $tvalue->city;
			 	$row['status'] = $tvalue->status;
			 	$row['id'] = $tvalue->id;
 				$data[] = $row;
			 }

			$output = array("data" => $data);
 			echo json_encode($output);
		}
		else
		{
			$row = array();
			$data = $row;
			$output = array("data" => $data);
			echo json_encode($output);
		}
	}

	public function excelexport()
	{

		$response = array();
		 $param = array(
		 	'userstatus' => $this->input->post('userstatus'),
		 	'daterange' => $this->input->post('daterange'),
		);
		$result = $this->BackApiModel->UserFetchList($param);

		if(!empty($result))
		{
			$filename = 'users.csv';
			
  			$object = new PHPExcel();
  			
	        $object->setActiveSheetIndex(0);
	         
	        $table_columns = array("Name", "Email", "Mobile", "DOB", "City", "Status");
	          $column = 0;
			foreach($table_columns as $field)
			{
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			}
  			$excel_row = 2; 
	    	$object->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(12);
	    	$object->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(25);
	    	$object->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(12);
	    	$object->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(12);
	    	$object->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(12);
	        foreach ($result as $row)
	        {
	        	if($row->status == 1){
	        		$userstatus = 'Active';
	        	}elseif($row->status == 2){
	        		$userstatus = 'Block';
	        	}elseif($row->status == 0){
	        		$userstatus = 'Deactive';
	        	}
	        	$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->name);
			   	$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->email);
			   	$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->mobile);
			   	$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->dob);
			   	$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->city);
			   	$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $userstatus);
			   	$excel_row++;
        	} 
          	$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
          	ob_start();
			$object_writer->save("php://output");
			$xlsData = ob_get_contents();
			ob_end_clean();

			$response =  array( 'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData));

			
		}
		else
		{
				$response['status'] = 'error';
		 		$response['message'] = 'Data is not available.';
		 		
		}
		echo json_encode($response);
	}

	public function importexcel()
	{

		//
		
		
			if(isset($_FILES["import"]["name"]))
			{
				$response = array();
				$path = $_FILES["import"]["tmp_name"];
		   		$object = PHPExcel_IOFactory::load($path);
		   		/*----------------------------------------------------*/
		   			foreach($object->getWorksheetIterator() as $worksheet)
		   			{
		    			$highestRow = $worksheet->getHighestRow();
		    			$highestColumn = $worksheet->getHighestColumn();
		    			for($row=2; $row<=$highestRow; $row++)
		    			{
		     				$name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
		     				$email = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
		     				$mobile = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
		     				$dob = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
		     				$city = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
		     				$status = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
		     				$data[] = array(
		      					'name'  => $name,
		      					'email'   => $email,
		      					'mobile'    => $mobile,
		      					'dob'  => $dob,
		      					'city'   => $city,
		      					'status'   => $status == 'Active' ? 1 : 0
		     				);
		    			}
		   			}
		   			//
		   			$emails = [];
		   			foreach($data as $key=>$value)
		   			{
		   				$query =  $this->db->where('email',$value['email'])->get('user_impot_excel');
		   				if($query->num_rows() > 0){
		   					$row = $query->row();
		   					// if(empty($row->email))
			   				// {
			   				// 	$result = $this->BackApiModel->import_excel($value);
			   				// 	if($result)
					   		// 	{
					   		// 		$response['status'] = 'success';
			       //        			$response['message'] = 'Imported Ecxel File Successfully.';
					   		// 	}
					   		// 	else
			       //     			{ 
			       //     				//echo 'Imported Not.';
			       //          		$response['status'] = 'error';
			       //        			$response['message'] = 'Excel Not Imported.';
			       //      		}
			   				// }
			   				// else
			   				// {
			   					//$emails[] = 'updated email'.$value['email'];
			   					$result1 = $this->db->where('email',$value['email'])->update('user_impot_excel',$value);
	   							if($result1)
	   							{
	   								$response['status'] = 'success';
	              					$response['message'] = 'Imported Ecxel File Successfully';
	   							}	
	   							else
			           			{ 
			           				$response['status'] = 'error';
			              			$response['message'] = 'Excel Not Imported.';
			            		}	
			   				// }	
		   				}
		   				else
		   				{
		   					//$emails[] = 'first time'.$value['email'];
	   						$result = $this->BackApiModel->import_excel($value);
		   					if($result)
				   			{
				   				//echo 'Imported Ecxel File Successful	ly.';
				   				$response['status'] = 'success';
		              			$response['message'] = 'Imported Ecxel File Successfully.';
				   			}
				   			else
		           			{ 
		           				//echo 'Imported Not.';
		                		$response['status'] = 'error';
		              			$response['message'] = 'Imported Not.';
		            		}
		   				}
		   			}
		   	}
		   	else
		   	{
		   		//echo 'somathing is wrong';
		   		$response['status'] = 'error';
	            $response['message'] = 'somathing is wrong	';
		   	}
		echo json_encode($response);      
	}

	public function generatepdf()
	{
		$response = array();
		$response = array();
		$param = array(
		 	'userstatus' => $this->input->post('userstatus'),
		 	'daterange' => $this->input->post('daterange'),
		);
		$result = $this->BackApiModel->UserFetchList($param);
		if(!empty($result))
		{

			$mpdf = new Mpdf\Mpdf([
'mode'=>'utf-8',
'format' => 'A4'
]);
			//$mpdf->simpleTables = true;
			$html = '';
			// $html = '<p>User Details</p>';
			// $html .= '<table class="pdftable" border="1" >';
			// $html .= '<thead>';
   //          $html .= '<tr>';
   //          $html .= '<th>Sr No.</th>';
   //          $html .= '<th>Name</th>';
   //          $html .= '<th>Email</th>';
   //          $html .= '<th>Mobile</th>';
   //          $html .= '<th>DOB</th>';
   //          $html .= '<th>City</th>';
   //          $html .= '<th>Status</th>';
   //          $html .= '</tr>';
   //          $i = 1;
   //          foreach($result as $row)
   //          {
   //          	print_r($row); 
   //          	if($row->status == 1)
   //          	{
   //          		$status = 'Active';
   //          	}
   //          	else if($row->status == 0)
   //          	{
   //          		$status = 'Deactive';
   //          	}
   //          	else
   //          	{
   //          		$status = 'Block';
   //          	 }
   //          	$html .= '<tr>';
   //          	$html .= '<td class="srno">'.$i++.'</td>';
   //          	$html .= '<td class="rows">'.$row->name.'</td>';
   //          	$html .= '<td class="txtcolor rows">'.$row->email.'</td>';
   //          	$html .= '<td class="rows">'.$row->mobile.'</td>';
   //          	$html .= '<td class="rows">'.$row->dob.'</td>';
   //          	$html .= '<td class="rows">'.$row->city.'</td>';
   //          	$html .= '<td class="rows">'.$row->status.'</td>';
   //          	$html .= '</tr>';
   //          }
   //          $html .= '</thead>';
			// $html .= '</table>';
			//$stylesheet = file_get_contents(base_url().'assets/backend/css/pdftable.css');
			//$mpdf->SetTitle('User details');
			//$mpdf->WriteHTML($stylesheet);

			$html = '<h1 class="pdftitle">User Details</h1>';
			$html .= '<table id="example" class="display" border="1" style="width:100%">
			        	<thead>
			            	<tr>
			            		<th>Sr No.</th>
			                	<th>Name</th>
			                	<th>Email</th>
			                	<th>Mobile</th>
			                	<th>DOB</th>
			                	<th>City</th>
			                	<th>Status</th>
			            	</tr>
			        	</thead>
			        <tbody>';
			       //  ini_set('memory_limit', '1500000M');
 //ini_set("pcre.backtrack_limit", "30000000"); //Perl Compatible Regular Expressions
			        $no = 10000;
			        for($i=1;$i<=$no;$i++)
			        {
			        	//$j++; 
			        	$html .= '<tr>
			        				<td class="srno">'.$i.'</td>
			        				<td class="rows">abc</td>
			        				<td class="txtcolor rows">abc@gmail.com</td>
			        				<td class="rows">9904266728</td>
			        				<td class="rows">15-02-1990</td>
			        				<td class="cityw rows">Surat</td>
			        				<td class="rows">Active</td>
			        				</tr>
			        				';


			        }
			        // $i= 1;
			        // foreach($result as $row)
			       	// {
			       	// 	if($row->status == 1)
           //  	{
           //  		$status = 'Active';
           //  	}
           //  	else if($row->status == 0)
           //  	{
           //  		$status = 'Deactive';
           //  	}
           //  	else
           //  	{
           //  		$status = 'Block';
           //  	 }
			       	// 	$html .= '<tr>';
		         //    	$html .= '<td class="srno">'.$i++.'</td>';
		         //    	$html .= '<td class="rows">'.$row->name.'</td>';
		         //    	$html .= '<td class="txtcolor rows">'.$row->email.'</td>';
		         //    	$html .= '<td class="rows">'.$row->mobile.'</td>';
		         //    	$html .= '<td class="rows">'.$row->dob.'</td>';
		         //    	$html .= '<td class="rows">'.$row->city.'</td>';
		         //    	$html .= '<td class="rows">'.$status.'</td>';
		         //    	$html .= '</tr>';
			       	// }
        	$html .= '</tbody>
        
    </table>';
    $long_html = strlen($html);
	$long_int  = intval($long_html/$no);


	
    $chunks = explode("chunk", $html);
    $stylesheet = file_get_contents(base_url().'assets/backend/css/pdftable.css');
			//$mpdf->SetTitle('User details');
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html,2);
			//$mpdf->output();
			ob_start();
			$mpdf->output();
			$result = ob_get_contents();
			ob_end_clean();

			$response =  array( 'op' => 'ok',
        'file' => "data:application/pdf;base64,".base64_encode($result));

		}
		else
		{
			$response['status'] = 'error';
		 	$response['message'] = 'Data is not available.';
		 		
		}
		echo json_encode($response);
	}

	public function backuseredit()
	{
		$response = array();
		$param = array(
			'name' => $this->input->post('uname'),
			'email' => $this->input->post('uemail'),
			'mobile' => $this->input->post('umobile'),
			'dob' => date('Y-m-d',strtotime($this->input->post('udob'))),
			'id' => $this->input->post('hidename')
		);

		$MailChack =  $this->BackApiModel->EditUserMailExits($param['email'],$param['id']);

		if(empty($MailChack))
		{
			
			$result = $this->BackApiModel->bckupduser($param);
			if(!empty($result))
			{
				$response['status'] = 'success';
				$response['message'] = 'Successfully User Record Update.';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'User Record Not Updated.';
			}
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'User Email Already Exists.';
		}
		echo json_encode($response);
	}

	public function backpassupd()
	{
		$response = array();
		$param = array(
			'adminpassword' => encrypttext($this->input->post('admin_password'),publickey('adminpassword')),
			'userpassword' => $this->encryption->encrypt($this->input->post('user_password')),
			'id' => $this->input->post('hidename')
		);
		$result = $this->BackApiModel->bckpassupd($param);
		if(!empty($result))
		{
			$response['status'] = 'success';
			$response['message'] = 'Successfully User Password Update';
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'In Invalid Admin Password';
		}
		echo json_encode($response);
	}

	public function userstatus()
	{	$response = array();
		$statususer = $this->input->post('statususer');
		$userid = $this->input->post('userid');
		
		if($statususer == 0)
		{
			$result = $this->BackApiModel->UsersStatus($statususer,$userid);
			if(!empty($result))
			{
				// $response['status'] = 'success';
				// $response['message'] = 'User Status Active.';
				$response['status'] = 'success';
				$response['message'] = 'User Deactive Successfully.';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'User Not Deactive.';
			}
		}
		else if($statususer == 1)
		{
			$result = $this->BackApiModel->UsersStatus($statususer,$userid);
			if(!empty($result))
			{
				$response['status'] = 'success';
				$response['message'] = 'User Active Successfully.';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'User Not Active.';
			}
		}
		else
		{
			$result = $this->BackApiModel->UsersStatus($statususer,$userid);
			if(!empty($result))
			{
				$response['status'] = 'success';
				$response['message'] = 'User Block Successfully.';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'User not Block.';
			}
		}
		
		echo json_encode($response);

	}

	public function editmodal()
	{
		$response = array();
		$userid = $this->input->post('userid');
		$result = $this->BackApiModel->Modaledit($userid);
		if(!empty($result))
		{
			$row = array(
				'name' => $result->name,
				'email' => $result->email,
				'mobile' => $result->mobile,
				'dob' => date('d-m-Y',strtotime($result->dob)),
				'id' => $result->id
			);
			 echo json_encode($row);
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'oops! something went wrong ';

			echo json_encode($response);
		}
	}

	public function edituserpassword()
	{
		$response = array();
		$userid = $this->input->post('userid');
		$result = $this->BackApiModel->Modaledit($userid);
		if(!empty($result))
		{
			$row = array('id' => $result->id);
			echo json_encode($row);
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'oops! something went wrong ';
			echo json_encode($response);
			
		}
		
	}

	public function userdelete()
	{
		$response = array();
		$userid = $this->input->post('userid');
		$result = $this->BackApiModel->DeleteUser($userid);
		if(!empty($result))
		{
			$response['status'] = 'success';
			$response['message'] = 'User Successfully Delete.';
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'User Not Delete.';
		}
		echo json_encode($response);
	}

	public function logout()
	{
	 	$this->session->unset_userdata('admin_id');
		redirect(SKYDASH);
	}
}
