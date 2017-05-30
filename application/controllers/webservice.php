<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Webservice extends CI_Controller
{

   function __construct()
  {
     parent::__construct();
  	 $this->load->model('webservice_model');
		  $this->load->model('admin_model');
  	 $this->load->library('encrypt','email');
     ini_set("error_reporting", 1);
     }

	public function index()
	{  set_time_limit(0);
	  $this->load->view('view');
	  $this->load->helper('url');
	}
	 /*
	 * function:- login
	 * description:- In this function check telephone number and password when user try to login
	 */
    function login(){
		$baseurl=base_url();
		$device_id=$this->input->post('device_id');
		$device_type=$this->input->post('device_type');
		$phoneno=$this->input->post('phoneno');
		$code=$this->input->post('country_code');
		$pass=md5($this->input->post('password'));
		$data=array(
		'phoneno'=>$phoneno,
		'password'=>$pass,
		);
		$flag = $this->webservice_model->checkphoneno($phoneno,$code,0);
		if($flag === 1){
			$result_array = array('status'=>'false','message'=>'Please check your phone number');
			echo  json_encode($result_array);
		}
	    else if($this->webservice_model->checkpass($pass,$phoneno,$code)){
			$result_array = array('status'=>'false','message'=>'Please check your password');
			echo  json_encode($result_array);
		}
	    else{
			$result=$this->webservice_model->login($data);
			$result1=$this->webservice_model->get_data_with_type('user_id',$result['id'],'patient_tbl','gender,id_card,dob,nationality');
			$result= array_merge($result,$result1[0]);
			if($result!='0'){
				if($result['status']==1){
					$this->webservice_model->upd_dri($result['id'],$device_id,$device_type);
					$result_array = array('status'=>'true','message'=>'Login succesfully','userid'=>$result['id'],'users'=>$result);
					echo  json_encode($result_array );
				}else{
					$result_array = array('status'=>'false','message'=>'Please verify your email.');
				echo  json_encode($result_array);
				}

			}
			else {
				$result_array = array('status'=>'false','message'=>'Please check your Phone number and password.');
				echo  json_encode($result_array);
			}
		}
    }

  public function newLogin(){
    	$baseurl=base_url();
      $data['identity_card']=$this->input->post('identity_card');
      $data['password']=md5($this->input->post('password'));
      $flag = $this->webservice_model->newLogin($data);
			if(!empty($flag)){
				$result_array = array('status'=>'true','message'=>'Login succesfully','result'=>$flag);
				echo  json_encode($result_array );
			}else{
				$result_array = array('status'=>'false','message'=>'Please enter valid credentials.');
				echo  json_encode($result_array);
			}


  }
     /*
	 * function:- register
	 * description:- this function using for register the patient data
	 */
	 function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

	public function register()
		 {
		   $password = trim($this->input->post('password'));
		   if(!empty($password) && $password != ''){
			$password = md5(trim($password));
		   }
		   else{
			$password = '';
		   }
		   $code=$this->input->post('country_code');
		   $email=$this->input->post('email');
		   $data = array(
		   'fname'    => htmlspecialchars($this->input->post('fname')),
		   'lname'    => htmlspecialchars($this->input->post('lname')),
		   'email'    => htmlspecialchars($email),
		  	'district'=>'asd',
		   'password' => $password,'address' => $this->input->post('address'), 'type' => 'patient','phoneno' => $this->input->post('phoneno'), 'device_id'=> htmlspecialchars($this->input->post('device_id')),'created'    => date("Y-m-d H:i:s")
		  );
		  $flag = $this->webservice_model->checkphoneno($this->input->post('phoneno'),$code,0); // check phone or register or not
		  $check_email = $this->webservice_model->check_email($email); // check email registered or not
		  if($check_email ==1 || $email == ''){
			  if($flag === 1){

				  $results = $this->webservice_model->addDatatoTable($data,'users'); // add 2nd parameter for table name

				  if(!empty($results)){

					   $name=$this->input->post('fname'). " ".$this->input->post('lname');
					   $data1 = array('user_id'=>$results,'gender'=>$this->input->post('gender'),'id_card'=>$this->input->post('id_card'),'dob'=>$this->input->post('dob'),'nationality'=>$this->input->post('nationality'),'country_code'=>$this->input->post('country_code'),'country_name'=>$this->input->post('country_name'));

					   $this->webservice_model->addDatatoTable($data1,'patient_tbl'); // add 2nd parameter for table name

					   $result=$this->webservice_model->get_data_with_type('id',$results,'users','lname,fname,email,address'); // clear parameter if you will check using model
					   $result1=$this->webservice_model->get_data_with_type('user_id',$results,'patient_tbl','gender,id_card,dob,nationality'); // clear parameter if you will check using model

					   $result = array_merge($result[0],$result1[0]);
					   echo json_encode(array('status' => true,'message' => 'Registration Successfully','user_id' => $results,'users'=>$result));
						$message = "<p>Dear <strong>Admin</strong>,&nbsp;</p>
						<p>You have a new patient registered.&nbsp;</p>
						<p><strong>Patient Details</strong></p>
						<p>Name &nbsp; &nbsp;<strong>".$name."</strong></p>
						<p>Email&nbsp; &nbsp;&nbsp;<strong>".$email."</strong></p>
						<p>&nbsp;</p>
						<p><strong>Regards,</strong>&nbsp;<br />
						Customer Support<br/>
						";

						$mail_array['subject'] = 'Myhealth new patient';
						$mail_array['message'] = $message;
						//email($arr['email'],'vishnu@infiny.in',$mail_array);
            			//$config=array();
						$config['mailtype'] = 'html';
						$config['protocol'] = "smtp";
						$config['smtp_host'] = SMTP_HOST;
						$config['smtp_port'] = SMTP_PORT;
						$config['smtp_user'] = SMTP_USER;
						$config['smtp_pass'] = SMTP_PASSWORD;
						$config['charset'] = "utf-8";
						$config['mailtype'] = "html";
            			$config['newline'] = "\r\n";

						$this->email->initialize($config);
						$this->email->set_newline("\r\n");
						$this->email->set_crlf( "\r\n" );
						$this->email->from('sankalp.m@gmail.com');
						$this->email->to($email);
						$this->email->subject($mail_array['subject']);
						$this->email->message($mail_array['message']);
						$this->email->send();
				  }
				  else{
					echo json_encode(array('status' => false,'message' => 'Failed to Registered!'));
				  }
			 }else{
					echo json_encode(array('status' => false,'message' => 'Phone number already exist'));
			 }
		 }else{
					echo json_encode(array('status' => false,'message' => 'Email already exists'));
			 }

	}
     /*
	 * function:- edit_profile
	 * description:- this function using for edit the patient data
	 */

	public function edit_profile()
		 {
           $user_id = $this->input->post('userID');
		   $data = array(
		   'fname'    => htmlspecialchars($this->input->post('fname')),
		   'lname'    => htmlspecialchars($this->input->post('lname')),
       'address' => $this->input->post('address'),
       'phoneno'=> $this->input->post('phoneno'),

       'email'=> $this->input->post('email'),

		  );
		     $data = array_filter($data);
		     if(!empty($data)){
			  $results = $this->webservice_model->update_data(array('id'=>$user_id),$data,'users'); // add 2nd parameter for table name
		    }
		    $data1 = array('gender'=>$this->input->post('gender'),'id_card'=>$this->input->post('id_card'),'dob'=>$this->input->post('dob'),'nationality'=>$this->input->post('nationality'),'country_name'=>$this->input->post('country_name'),'country_code'=>$this->input->post('country_code'));
		    $data1 = array_filter($data1);
		   if(!empty($data1)){
				$results1 = $this->webservice_model->update_data(array('user_id'=>$user_id),$data1,'patient_tbl'); // add 2nd parameter for table name
		   }
		  if($results1 || $results){
			echo json_encode(array('status' => true,'message' => 'Profile updated successfully','user_id' => $user_id));
		  }else{
			echo json_encode(array('status' => false,'message' => 'Profile update failed'));
		  }

	}

    /*** confirm unique code for change phone number ****/


     public function change_phneNo()
		 {
		   $userID = trim($this->input->post('userID'));
		   $phoneno = $this->input->post('phoneno');
		   $country_code = $this->input->post('country_code');
           $flag = $this->webservice_model->checkphoneno($phoneno,$country_code,$userID);
		   if($flag == 1){
					/************************** APIIIII  ********************/
					 for ($i = 0; $i<4; $i++)
					{
						$rand_no .= mt_rand(0,9);
					}
				   $results = $this->webservice_model->update_rand_no($userID, $rand_no);
					$curl_post_data = array('email' => 'shennong@ctrlf.hk','password' => 'SM@l7es7');
					$service_url = 'http://portal.ctrlf.hk/api/auth/log_in';
					$decoded = $this->hit_apiii($service_url,$curl_post_data,array());
					if ($decoded->meta->message != 'Success') {
						die('error occured: ' . $decoded->meta->message);
					};
					$access_token = $decoded->data->access_token;
					$service_url2 = 'http://portal.ctrlf.hk/api/sms/send_message';
					 $curl_post_data1 = array('phone_numbers' => $code.'-'.$data,'message' => 'Your Unique Number For forget Password '.$rand_no);
					$decoded2 = $this->hit_apiii($service_url2,$curl_post_data1,array('X-USER-TOKEN: ' . $access_token));
					$service_url1 = 'http://portal.ctrlf.hk/api/auth/log_out';
					$decoded1 = $this->hit_apiii($service_url1,array(),array('X-USER-TOKEN: ' . $access_token));
					if ($decoded2->meta->message != 'Success') {

						echo json_encode(array('status' => false,'message' => $decoded2->meta->message,'unique_code'=>$rand_no));

					}else if($results == 1 && $decoded2->meta->message == 'Success'){

						echo json_encode(array('status' => true,'message' => 'Success','unique_number' => $rand_no));

					}else{

						echo json_encode(array('status' => false,'message' => 'Failed!'));

					}
				  /************************** APIIIII  ********************/
		   }else{
				echo json_encode(array('status' => false,'message' => 'Phone Number Already Exist','user_id' => $user_id));
		   }
	}
    /*** confirm unique code for change phone number ****/


     public function confirm_change_phneNo()
		 {
		   $userID = trim($this->input->post('userID'));
		   $unique_code = trim($this->input->post('unique_code'));
		   $phoneno = $this->input->post('phoneno');
		   $country_code = $this->input->post('country_code');
		  $results = $this->webservice_model->check_phone_ran_number($userID , $unique_code);
		  if($results != 0){
			if($this->webservice_model->update_new_phnumber($userID,array('phoneno'=>$phoneno,'country_code'=>$country_code))){
		        echo json_encode(array('status' => true,'message' => 'Phone Number Update successsfully!', 'user_id'=>$results));
			}else{
				echo json_encode(array('status' => false,'message' => 'Problem in server'));
			}
		  }
		  else{
			echo json_encode(array('status' => false,'message' => 'Unique Number is not Correct'));
		  }

	}
/*function add_client_report,delete_report_image,add_new_report_image,edit_client_report,getAllUserClientReports
  description:- this function is to add reports by patients
	created by : sankalp mehta  3rd march
*/




public function delete_report_image(){
  $image_id = $this->input->post('image_id');
  if(!empty($image_id)){
    foreach ($image_id as $key => $value) {
      	$images_array=$this->db->get_where('client_uploaded_reports_images',array('id' => $value))->row_array();
        if(!empty($images_array))
      	{
      		$this->db->delete('client_uploaded_reports_images',array('id'=>$value));
      		unlink(FCPATH.'public/uploads/user_reports/'.$images_array['image_name']);

      	}

    }
		echo json_encode(array('status' => true,'message' => 'client reports image deleted successsfully'));
  }else{
			echo json_encode(array('status' => false,'message' => 'client report image not found'));
  }

}
// public function delete_report_image()
// {
// 	$image_id = $this->input->post('image_id');
// 	$images_array=$this->db->get_where('client_uploaded_reports_images',array('id' => $image_id))->row_array();
// 	if(!empty($images_array))
// 	{
// 		$this->db->delete('client_uploaded_reports_images',array('id'=>$image_id));
// 		unlink(FCPATH.'public/uploads/user_reports/'.$images_array['image_name']);
// 		echo json_encode(array('status' => true,'message' => 'client reports image deleted successsfully'));
// 		exit;
// 	}
// 	echo json_encode(array('status' => false,'message' => 'client report image not found'));
// }

public function add_new_report_image()
{
	set_time_limit(0);
	$id = $this->input->post('id');
	$images=$this->input->post('images');
	$order=$this->input->post('order');
	$data=array();
	if(!empty($images)){

		foreach ($images as $key => $value) {

			$imageExtesion=$this->getMIMETYPE($value);
			$data['report_id']=$id;
			$data['order']=$order;
			$data['image_name'] = $this->generateRandomString(10).'.'.$imageExtesion;
			$data['upload_type']='image';
			$url=FCPATH.'public/uploads/user_reports/'.$data['image_name'];
			file_put_contents($url,base64_decode($value));
			//echo $url;
		  $data['id']=$this->admin_model->add_data($data,'client_uploaded_reports_images');
			//print_r($data);exit;
		}
		echo json_encode(array('status' => true,'message' => 'client reports image uploaded successsfully','result' => $data));
		exit;
	}
	$pdfs=$this->input->post('pdfs');
	$pdfNames=$this->input->post('pdfNames');
	if(!empty($pdfs)){
		$i=0;
		foreach ($pdfs as $key => $value) {
				$imageExtesion=$this->getMIMETYPE($value);
			//	print_r($imageExtesion);exit;
			$data['report_id']=$id;
			$data['order']=$order;
			$random=$this->generateRandomString(10).'.'.$imageExtesion;
			$data['image_name'] = $id."|".$pdfNames[$i]."|".$random;
			//$data['image_name'] = $this->generateRandomString(10).'.'.$imageExtesion;
			$data['upload_type']='pdf';
			$i++;
			$url=FCPATH.'public/uploads/user_reports/'.$data['image_name'];
			file_put_contents($url,base64_decode($value));
			$data['id']=$this->admin_model->add_data($data,'client_uploaded_reports_images');
			//print_r($data);exit;
		}
		echo json_encode(array('status' => true,'message' => 'client reports image uploaded successsfully','result' => $data));
		exit;
	}
	echo json_encode(array('status' => false,'message' => 'Something went wrong'));
}

public function edit_client_report()
{
	$id = $this->input->post('id');
	$data1 = array(
		'description'=>$this->input->post('description'),
		'title'=>$this->input->post('title'),
		'uploaded_by' => $this->input->post('user_id'),
		'date' => $this->input->post('date')
	);
//  print_r(FCPATH);exit;
	if($this->db->update('client_uploaded_reports',$data1,array('id' => $id)))
	{
		echo json_encode(array('status' => true,'message' => 'client reports edited successsfully'));
	}
	else
	{
		echo json_encode(array('status' => false,'message' =>'Something went wrong'));
	}
}



public function add_client_report(){


	if(empty($this->input->post('user_id'))){

	}
	$data1 = array(
		'description'=>$this->input->post('description'),
		'title'=>$this->input->post('title'),
		'uploaded_by' => $this->input->post('user_id'),
		'date' =>$this->input->post('date')
	);


	$id=$this->admin_model->add_data($data1,'client_uploaded_reports');
	$images=$this->input->post('images');
  $pdfNames=$this->input->post('pdfNames');
	$image_order=$this->input->post('image_order');
	$pdf_order=$this->input->post('pdf_order');
  /*image order and pdf order arrays are created because it has the sequence in which  file was uploaded.
   eg: if we upload in the sequence image 1 den a pdf ,0th position of image_order will have 0 and 0th position
	 of pdf_order will have 1 .This has been created because the upload functionlaity is done by base64 conversion  */

	if(!empty($images)){
		foreach ($images as $key => $value) {

			$imageExtesion=$this->getMIMETYPE($value);

			$data['report_id']=$id;
			$data['order']=$image_order[$key];
			$data['image_name'] = $this->generateRandomString(10).'.'.$imageExtesion;
			$data['upload_type']='image';
			$url=FCPATH.'public/uploads/user_reports/'.$data['image_name'];
		//	print_r($url);exit;

			file_put_contents($url,base64_decode($value));
			//echo $url;
		  $this->admin_model->add_data($data,'client_uploaded_reports_images');
		}
	}
	$pdfs=$this->input->post('pdfs');
	if(!empty($pdfs)){
		$i=0;
		foreach ($pdfs as $key => $value) {

				$imageExtesion=$this->getMIMETYPE($value);
			//	print_r($imageExtesion);exit;
			$data['report_id']=$id;
			$random=$this->generateRandomString(10).'.'.$imageExtesion;
			$data['order']=$pdf_order[$key];
			$data['image_name'] = $id."|".$pdfNames[$key]."|".$random;
			$data['upload_type']='pdf';
			$url=FCPATH.'public/uploads/user_reports/'.$data['image_name'];
			//print_r($value);exit;
			file_put_contents($url,base64_decode($value));
			$i++;
			$this->admin_model->add_data($data,'client_uploaded_reports_images');
		}
	}
	echo json_encode(array('status' => true,'message' => 'client reports uploaded successsfully'));
}

public function getAllUserClientReports()
{
	$user_id = $this->input->post('user_id');
	$result=array();
	$this->db->select('*,date as report_date');
	$this->db->order_by('client_uploaded_reports.date_created', 'ASC');
	$getAllClientReports=$this->db->get_where('client_uploaded_reports',array('uploaded_by'=>$user_id))->result_array();
	if(!empty($getAllClientReports))
	{
		foreach ($getAllClientReports as $key => $value) {
			$temp=array();
			$temp=$value;
			$this->db->order_by('client_uploaded_reports_images.order', 'ASC');
			$temp['image_array']=$this->db->get_where('client_uploaded_reports_images',array('report_id'=>$value['id']))->result_array();
			/*$temp['pdf_array']=$this->db->get_where('client_uploaded_reports_images',array('report_id'=>$value['id'],'upload_type'=>'pdf'))->result_array();*/
			array_push($result,$temp);
		}
		echo json_encode(array('status' => true,'message' => 'client reports recived successsfully','result'=>$result));
	}
	else
	{
		echo json_encode(array('status' => false,'message' => 'client reports are empty','result'=>$result));
	}
}
/*
* description:- get all client uploaded reports
* function : get_all_reports_client
*/
function getMIMETYPE($base64string){

	$finfo = new finfo(FILEINFO_MIME);
	$type_encoded= $finfo->buffer(base64_decode($base64string)) . "\n";
	//echo $type_encoded;
	$pos  = strpos($type_encoded, ';');
$type = explode('/', substr($type_encoded, 0, $pos))[1];
return $type;
	//exit;
}
function get_all_reports_client(){

}


    /*
	 * function:- get_user_profile
	 * description:- this function using For get user profile
	 */

	function get_user_profile()
     {
		 $user_id = $this->input->post('user_id');
		 $result=$this->webservice_model->get_data_with_type('id',$user_id,'users','lname,fname,email,address,phoneno'); // clear parameter if you will check using model
         $result1=$this->webservice_model->get_data_with_type('user_id',$user_id,'patient_tbl','country_code,gender,id_card,dob,nationality'); // clear parameter if you will check using model

			       $results = array_merge($result[0],$result1[0]);
		  if(!empty($results)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$results));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }

     /*
	 * function:- forgot
	 * description:- this function using for to generate a unique number for change password
	 */

    public function hit_apiii($service_url,$curl_post_data,$header)
		 {
			$curl = curl_init($service_url);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			$curl_response = curl_exec($curl);
			if ($curl_response === false) {
				$info = curl_getinfo($curl);
				curl_close($curl);
				die('error occured during curl exec. Additioanl info: ' . var_export($info));
			}
			curl_close($curl);
			return json_decode($curl_response);
		 }

    public function forgot()
		 {
			 $data = trim($this->input->post('phoneno'));
			 $code = trim($this->input->post('country_code'));
		   for ($i = 0; $i<4; $i++)
			{
				$a .= mt_rand(0,9);
			}

		  $results = $this->webservice_model->update_forgot($data,$code, $a);
			$curl_post_data = array('email' => 'shennong@ctrlf.hk','password' => 'SM@l7es7');
			$service_url = 'http://portal.ctrlf.hk/api/auth/log_in';
            $decoded = $this->hit_apiii($service_url,$curl_post_data,array());
			if ($decoded->meta->message != 'Success') {
				die('error occured: ' . $decoded->meta->message);
			};
			$access_token = $decoded->data->access_token;
            $service_url2 = 'http://portal.ctrlf.hk/api/sms/send_message';
             $curl_post_data1 = array('phone_numbers' => $code.'-'.$data,'message' => 'Your Unique Number For forget Password '.$a);
            $decoded2 = $this->hit_apiii($service_url2,$curl_post_data1,array('X-USER-TOKEN: ' . $access_token));
            $service_url1 = 'http://portal.ctrlf.hk/api/auth/log_out';
            $decoded1 = $this->hit_apiii($service_url1,array(),array('X-USER-TOKEN: ' . $access_token));
            if ($decoded2->meta->message != 'Success') {

				echo json_encode(array('status' => false,'message' => $decoded2->meta->message,'unique_code'=>$a));

			}else if($results == 1 && $decoded2->meta->message == 'Success'){

		        echo json_encode(array('status' => true,'message' => 'Success','unique_number' => $a));

		    }else{

			    echo json_encode(array('status' => false,'message' => 'Failed!'));

		    }

	}
	   /*
	 * function:- forgot
	 * description:- this function using for to generate a unique number for change password Using Email
	 */

	public function forgotNew()
		 {
			 $data = trim($this->input->post('email'));
		   for ($i = 0; $i<4; $i++)
			{
				$a .= mt_rand(0,9);
			}
 

		  $results = $this->webservice_model->update_forgotNew($data, $a);
		    if(isset($results['id'])){
				$this->load->library('email');
	               $config = array (
					  'mailtype' => 'html',
					  'charset'  => 'utf-8',
					  'priority' => '1'
					   );
				   $this->email->initialize($config);
				   $this->email->from('example@vooap.com', 'Myhealth');
				   // $this->email->to($data);
				   $this->email->to("ekamjot317@gmail.com");
				  
				   $this->email->subject('Welcome To Myhealth');
				   $mail_message='Dear ,'. "\r\n";
         $mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b> Your Code is</b> is '.$a.''."\r\n";
        $mail_message.='<br>Please Update your password.';
        $mail_message.='<br>Thanks & Regards';
        $mail_message.='<br>Myhealth'; 
		$this->email->message($mail_message);
			
	   
      
		if (!$this->email->send()) {
			 $this->session->set_flashdata('msg','Failed to send password, please try again!');
			 echo json_encode(array('status' => false,'Failed to send password, please try again!'));
		} 
		else {
			 echo json_encode(array('status' => true,'message' => 'Code   Send To Your Email. Please Check Your Mail'));
		   //$this->session->set_flashdata('msg','Code   Send To Your Email. Please Check Your Mail');
		}
		 // redirect('admin/login');        
		}
		else {
				echo json_encode(array('status' => false,'message' => 'Invaild Email '));
			
		}
		
			$curl_post_data = array('email' => 'shennong@ctrlf.hk','password' => 'SM@l7es7');
			$service_url = 'http://portal.ctrlf.hk/api/auth/log_in';
            $decoded = $this->hit_apiii($service_url,$curl_post_data,array());
			
			if ($decoded->meta->message != 'Success') {
				die('error occured: ' . $decoded->meta->message); 
			};
			$access_token = $decoded->data->access_token;
            $service_url2 = 'http://portal.ctrlf.hk/api/sms/send_message';
            $curl_post_data1 = array('phone_numbers' => $results['country_code'].'-'.$results['phoneno'],'message' => 'Your Unique Number For forget Password '.$a);
            $decoded2 = $this->hit_apiii($service_url2,$curl_post_data1,array('X-USER-TOKEN: ' . $access_token));
            $service_url1 = 'http://portal.ctrlf.hk/api/auth/log_out';
            $decoded1 = $this->hit_apiii($service_url1,array(),array('X-USER-TOKEN: ' . $access_token));
			
            if ($decoded2->meta->message != 'Success') {

				echo json_encode(array('status' => false,'message' => $decoded2->meta->message,'unique_code'=>$a));

			}else if($results['status'] == 1 && $decoded2->meta->message == 'Success'){

		        echo json_encode(array('status' => true,'message' => 'Success','unique_number' => $a));

		    }else{

			    echo json_encode(array('status' => false,'message' => 'Failed!'));

		    }

	}


	/*
	 * function:- new_password
	 * description:- this function using for to create new password using unique_number
	 */

    public function new_password()
		 {
		   $password = trim($this->input->post('password'));
		   $phoneno = trim($this->input->post('phoneno'));
		   $code = trim($this->input->post('country_code'));
		   $random_number = trim($this->input->post('random_number'));
		  $results = $this->webservice_model->check_random_number($phoneno,$code , $random_number);
		  if($results != 0){
			if($this->webservice_model->update_new_password($results,$password)){
		        echo json_encode(array('status' => true,'message' => 'password update successsfully!', 'user_id'=>$results));
			}else{
				echo json_encode(array('status' => false,'message' => 'Problem in server'));
			}
		  }
		  else{
			echo json_encode(array('status' => false,'message' => 'Unique Number is not Correct'));
		  }

	}
    /*
	 * function:- new_passwordNew
	 * description:- this function using for to create new password using unique_number using Email 
	 */

    public function new_passwordNew()
		 {
		   $password = trim($this->input->post('password'));
		   $email = trim($this->input->post('email'));
		   $random_number = trim($this->input->post('random_number'));
		  $results = $this->webservice_model->check_random_numberNew($email,$random_number);
		
		  if($results != 0){
			if($this->webservice_model->update_new_password($results,$password)){
		        echo json_encode(array('status' => true,'message' => 'password update successsfully!', 'user_id'=>$results));
			}else{
				echo json_encode(array('status' => false,'message' => 'Problem in server'));
			}
		  }
		  else{
			echo json_encode(array('status' => false,'message' => 'Unique Number is not Correct'));
		  }

	}

	/*
	 * function:- get_appointment_button
	 * description:- this function using gor get packages
	 */

	function get_appointment_button()
     {
		 //$type = $this->input->post('type');
		 $results = $this->webservice_model->get_all_data('package_name');
		 $i = 0;
		 foreach($results as $res){
			 if($res['id']==1) $results[$i]['type'] = 'doctor';
			 else $results[$i]['type'] = 'medical';
			 ++$i;
		 }
		  if(!empty($results)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$results));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
	/*
	 * function:- get_packages
	 * description:- this function using gor get packages
	 */

	function get_packages()
     {
		 //$type = $this->input->post('type');
		 $results = $this->webservice_model->get_packages();
		 $i = 0;
			 foreach($results as $res){
			   $results[$i]['services'] = $this->webservice_model->get_services($res['id']);
			   ++$i;
			 }
		  if(!empty($results)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$results));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
	/*
	 * function:- get_packages
	 * description:- this function using gor get packages
	 */

	function get_services()
     {
		 //$type = $this->input->post('type');
		 $results = $this->webservice_model->get_all_services();
		  if(!empty($results)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$results));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }

     /*
	 * function:- get_locations
	 * description:- this function using for get locations
	 */

	function get_locations()
     {
		  $lang = $this->input->post('type');
		  $services_id = $this->input->post('services_id');
			$output = $this->webservice_model->get_all_clinics_using_services($lang,$services_id );
		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
     /*
	 * function:- get_doctors_location
	 * description:- this function using for get doctor locations
	 */

	function get_doctors_location()
     {
		 $doc_id = $this->input->post('doc_id');
		 $lang = $this->input->post('type');

		  if($lang=='S'){
			$clinic_name = $this->webservice_model->get_single_data(array('user_id'=>$doc_id),'users_simplified',"clinic_name");
			$output = $this->webservice_model->get_data_with_type('user_id',$doc_id,'locations',"(CASE WHEN address_s = '' THEN address ELSE address_s END)  as address,(CASE WHEN district_s = '' THEN district ELSE district_s END) as district,user_id as doc_id ,id as loc_id");

		 }elseif($lang=='T'){
			$clinic_name = $this->webservice_model->get_single_data(array('user_id'=>$doc_id),'users_traditional',"clinic_name");
			$output  = $this->webservice_model->get_data_with_type('user_id',$doc_id,'locations',"(CASE WHEN address_t = '' THEN address ELSE address_t END)  as address,(CASE WHEN district_t = '' THEN district ELSE district_t END) as district,user_id as doc_id ,id as loc_id");
		 } else{
			$clinic_name = $this->webservice_model->get_single_data(array('id'=>$doc_id),'users',"clinic_name");
			$output = $this->webservice_model->get_data_with_type('user_id',$doc_id,'locations','address,district,user_id as doc_id, ,id as loc_id');
	     }
	     //print_r($clinic_name);die;
          if($clinic_name == ''){
			  $clinic_name = $this->webservice_model->get_single_data(array('id'=>$doc_id),'users',"clinic_name");
		  }

		  if(!empty($output)){
			  $i = 0;
			  foreach($output as $op){
				  $output[$i]['clinic_name'] = $clinic_name['clinic_name'];
				  ++$i;
			  }
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }

     /*
	 * function:- new_password
	 * description:- this function using for get disabled dates which is disabled by doctor/admin
	 */

	function get_disabled_dates()
     {
		 $loc_id = $this->input->post('loc_id');
		 $type = $this->input->post('type');
		 $results = $this->webservice_model->get_nonavailable_date_by_loc($loc_id,$type);
		 /*foreach($results as $res){
			 $resg[] = $res['nondate'];
			 $resg[] = $res['nondate'];
		 }*/
		  if(!empty($results)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$results));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }


	/*
	 * function:- time_slots
	 * description:- this function get all available time slots for patient which is not booked
	 */

	function time_slots()
     {

		 $location_id = $this->input->post('location_id');
		 $booking_date = $this->input->post('booking_date');
		 $type = $this->input->post('type');
		 $results = $this->webservice_model->get_time_slots($location_id, $booking_date,$type);
		// print_r($results);die;
		 $starttime = $results[0]['service_start_time'];  // your start time
			$endtime = $results[0]['service_end_time'];  // End time
			$duration = '60';  // split by 30 mins

			$array_of_time = array ();
			$start_time    = strtotime ($starttime); //change to strtotime
			$end_time      = strtotime ($endtime); //change to strtotime

			$add_mins  = $duration * 60;
			$i =0;
			while ($start_time <= $end_time) // loop between time
			{
			   $array_of_time[$i]['start_time'] = date ("H:i", $start_time);
			   $start_time += $add_mins; // to check endtie=me
			   $array_of_time[$i]['end_time'] = date ("H:i", $start_time);
			    ++$i;
			}
		   array_pop($array_of_time);
		  $i = 0;
		  foreach($results as $r){
			  $newres[$i]['start_time'] = date ("H:i",strtotime ($r['booking_s_time']));
			  $newres[$i]['end_time'] = date ("H:i",strtotime ($r['booking_e_time']));
			 ++$i;
		  }

		 $final = array();
		 foreach($array_of_time AS $key => $item) {
			$final[$item['start_time'] . $item['end_time']] = $item;
		 }

		 foreach($newres AS  $key => $item) {
			unset($final[$item['start_time'] . $item['end_time']]);
		 }
		 $j = 0;
         foreach($final as $new){
			 $final1[$j]['start_time'] = $new['start_time'];
			 $final1[$j]['end_time'] = $new['end_time'];
			 ++$j;
		 }
		 $time_slot = $final1;
		 if($booking_date == date('Y-m-d')){
			 $time_slot = array();
			 foreach($final1 as $key =>$r){
				 if($r['start_time'] >= date ("H:i")){;
					 $time_slot[] = $final1[$key];
				 }
			 }
		 }
		// print_r($time_slot);
		 //print_r($final1);die;
		  if(!empty($time_slot)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$time_slot,'booking_date'=>$booking_date));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }

     /*
	 * function:- set_appointment
	 * description:- function used for set apointment
	 */


     function set_appointment()
     {
		 $package_id = $this->input->post('package_id');
		 $service_id = $this->input->post('services_id');

		 $data1 = array('user_id'=>$this->input->post('user_id'),'doc_id'=>$this->input->post('doc_id'),'loc_id'=>$this->input->post('loc_id'),'clinic_id'=>$this->input->post('clinic_id'),'booking_date'=>$this->input->post('booking_date'),'booking_s_time'=>$this->input->post('booking_s_time'),'booking_e_time'=>$this->input->post('booking_e_time'),'package_id'=>$this->input->post('package_id'),'services_id'=>$this->input->post('services_id'),'paid'=>'n');
		 $resg = $this->webservice_model->addDatatoTable($data1,'appointments');
		 $data2 = array('user_id'=>$this->input->post('user_id'),'created'=>date('Y-m-d'),'appointment_id'=>$resg,'type'=>'a');
		 if($this->input->post('clinic_id')!=0){
			 if($package_id){
			   $package_id = explode(",",$package_id);
			   foreach($package_id as $p_id){
					$data2['package_id'] = $p_id;
					$data2['service_id'] = 0;
					$price = $this->webservice_model->get_single_data(array('id'=>$p_id),'packages','price');
					$data2['price'] = $price['price'];
					$this->webservice_model->addDatatoTable($data2,'translate_request');
				}
			 }
			 if($service_id){
			   $service_id=explode(",",$service_id);
			   foreach($service_id as $s_id){
					$data2['service_id'] = $s_id;
					 $data2['package_id'] = 0;
					$price = $this->webservice_model->get_single_data(array('id'=>$s_id),'services','price');
					$data2['price'] = $price['price'];
					$this->webservice_model->addDatatoTable($data2,'translate_request');
				}
			 }
         }else{
			 $price = $this->webservice_model->get_single_data(array('id'=>$this->input->post('doc_id')),'users','price');
			 $data2['price'] = $price['price'];
			 $this->webservice_model->addDatatoTable($data2,'translate_request');
		 }
		  if($this->input->post('cons_fee') == 'P'){
			  $fee = $this->webservice_model->get_single_data(array('id'=>8),'other_options','content');
			  //$fee = $price['content'];
			  $data2['price'] = $fee['content'];
			 $this->webservice_model->addDatatoTable($data2,'translate_request');
		 }elseif($this->input->post('cons_fee') == 'D'){
			  $fee = $this->webservice_model->get_single_data(array('id'=>7),'other_options','content');
			 // $fee = $price['content'];
			  $data2['price'] =$fee['content'];
			 $this->webservice_model->addDatatoTable($data2,'translate_request');
		 }else{
			 $fee = '0';
		 }


		  if($resg != 0){
		     echo json_encode(array('status' => true,'message' => 'Selected services are now in shopping cart', 'data'=>$resg));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
     /*
	 * function:- get_appointments
	 * description:- function used for get apointment
	 */


     function get_appointments()
     {
	     $user_id = $this->input->post('user_id');
		 $output = $this->webservice_model->get_appointments($user_id);

		  if(!empty($output['doctors']) || !empty($output['packages'])){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }

    /*
	 * function:- get_all_doctors
	 * description:- get all doctor listings
	 */


     function get_all_doctors()
     {
		 $lang = $this->input->post('type');
		 if($lang=='S'){
			 $output = $this->webservice_model->get_all_clinics_other('D','users_simplified');
			 $i = 0;
			 foreach($output as $res){
				 $output[$i]['locations'] = $this->webservice_model->get_data_with_type('user_id',$res['id'],'locations',"id as address_id,(CASE WHEN address_s = '' THEN address ELSE address_s END)  as address,(CASE WHEN district_s = '' THEN district ELSE district_s END) as district");
				 ++$i;
			 }
		 }elseif($lang=='T'){
			 $output = $this->webservice_model->get_all_clinics('D','users_traditional');
			 $i = 0;
			 foreach($output as $res){
				 $output[$i]['locations'] = $this->webservice_model->get_data_with_type('user_id',$res['id'],'locations',"id as address_id,(CASE WHEN address_t = '' THEN address ELSE address_t END)  as address,(CASE WHEN district_t = '' THEN district ELSE district_t END) as district");
				 ++$i;
			 }
		 } else{
			 $output = $this->webservice_model->get_all_clinics('D');
			 $i = 0;
			 foreach($output as $res){
				 $output[$i]['locations'] = $this->webservice_model->get_data_with_type('user_id',$res['id'],'locations','id as address_id,address,district');
				 ++$i;
			 }
	     }

		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }


     /*
	 * function:- get_all_clinics
	 * description:- get all clinics
	 */

     function get_all_clinics()
     {
		 $lang = $this->input->post('type');
		  if($lang=='S'){
			$output = $this->webservice_model->get_all_clinics_other('M','users_simplified');

		 }elseif($lang=='T'){
			$output = $this->webservice_model->get_all_clinics_other('M','users_traditional');
		 } else{
			$output = $this->webservice_model->get_all_clinics('M');
	     }

		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }


     /*
	 * function:- set_authorized_doctors
	 * description:- this function used to set authorized doctors
	 */

     function set_authorized_doctors()
     {
		 $data1 = array('user_id'=>$this->input->post('user_id'),'doc_id'=>$this->input->post('doc_id'));

		 $data = $this->webservice_model->get_data_with_type1($data1,'authorized_doctors','*');
		 if(empty($data)){
			 $resg = $this->webservice_model->addDatatoTable($data1,'authorized_doctors');
			  if($resg != 0){
				 echo json_encode(array('status' => true,'message' => 'Added in your authorized doctor list', 'data'=>$resg));
			  }
			  else{
				 echo json_encode(array('status' => false,'message' => 'Failed to add in your authorized doctor list'));
			  }
		  }else{
			  echo json_encode(array('status' => false,'message' => 'Already Added!!!'));
		  }
     }

    /*
	 * function:- set_authorized_doctors
	 * description:- this function used to set authorized doctors
	 */


     function get_all_authorized_doctors()
     {
		 $user_id = $this->input->post('user_id');
		 $output = $this->webservice_model->get_all_authorized_doctors($user_id);

		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }



     /*
	 * function:- del_authorized_doctor
	 * description:- this function using to delete authorized doctor
	 */


     function del_authorized_doctor()
     {
		 $id = $this->input->post('id');
		 $output = $this->webservice_model->delete_data($id,'authorized_doctors');

		  if($output == 1){
		     echo json_encode(array('status' => true,'message' => 'Deleted!!'));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Not Deleted server Problem!!'));
		  }

     }


     /*
	 * function:- get_all_einfo
	 * description:- get all einfo
	 */

     function get_all_einfo()
     {
		 $type = $this->input->post('type');
		 if($type=='S'){
			 $output = $this->webservice_model->get_einformation1('einformation_simplified');
		 }else if($type=='T'){
			 $output = $this->webservice_model->get_einformation1('einformation_traditional');
		 }else{
			 $output = $this->webservice_model->get_einformation();
		 }


		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }

      /*
	 * function:- getEinfoFilters
	 * description:- Get info cate name
	 */

     function getEinfoFilters()
     {
		$output = $this->webservice_model->getEinfoFilters();
		if(!empty($output)){
			 echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		}else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		}

     }
     /*
	 * function:- get_other_content
	 * description:- get all content
	 */

     function get_other_content()
     {
		 $type = $this->input->post('type');
		 if($this->input->post('language') == 'T'){
			 $output = $this->webservice_model->get_data_with_type('type',$type,'other_options',"(CASE WHEN content_t = '' THEN content ELSE content_t END) as content");
			 $content  = $output[0]['content'];
		 }else if($this->input->post('language') == 'S'){
			 $output = $this->webservice_model->get_data_with_type('type',$type,'other_options',"(CASE WHEN content_s = '' THEN content ELSE content_s END) as content");
			  $content  = $output[0]['content'];
		 }else{
			 $output = $this->webservice_model->get_data_with_type('type',$type,'other_options','content');
			  $content  = $output[0]['content'];
		 }

		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$content));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
     /*
	 * function:- get_other_content
	 * description:- get all content
	 */

     function get_adver_images()
     {
		$upload_path=base_url()."public/uploads/others/";
		$lang = $this->input->post('language');
		//(adver = advertise banner, einfo = einformation banner
		  $output['adver'] = $this->webservice_model->get_data_with_type1(array('featured'=>'yes','lang'=>strtolower($lang),'type'=>'adver'),'other_options_images',"CONCAT('".$upload_path."', file_path ) as image,link");
		  if(empty($output['adver'])){
			  $output['adver'] = $this->webservice_model->get_data_with_type1(array('featured'=>'no','lang'=>strtolower($lang),'type'=>'adver'),'other_options_images',"CONCAT('".$upload_path."', file_path ) as image,link");
		  }
		  if(empty($output['adver'])){
			  $output['adver'] = $this->webservice_model->get_data_with_type1(array('lang'=>strtolower('E'),'type'=>'adver'),'other_options_images',"CONCAT('".$upload_path."', file_path ) as image,link");
		  }
		  $output['einfo'] = $this->webservice_model->get_data_with_type1(array('featured'=>'yes','lang'=>strtolower($lang),'type'=>'einfo'),'other_options_images',"CONCAT('".$upload_path."', file_path ) as image,link");
		  if(empty($output['einfo'])){
			  $output['einfo'] = $this->webservice_model->get_data_with_type1(array('featured'=>'no','lang'=>strtolower($lang),'type'=>'einfo'),'other_options_images',"CONCAT('".$upload_path."', file_path ) as image,link");
		  }
		  if(empty($output['einfo'])){
			  $output['einfo'] = $this->webservice_model->get_data_with_type1(array('lang'=>strtolower('E'),'type'=>'einfo'),'other_options_images',"CONCAT('".$upload_path."', file_path ) as image,link");
		  }

		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }

     /*
	 * function:- searchDoctorMedical
	 * description:- search doctor and medical by name
	 */

     function searchDoctorMedical()
     {
		$upload_path=base_url()."public/uploads/others/";
		$data=array(
			'name'=>$this->input->post('name'),'type'=>$this->input->post('type')
		);
		$output = $this->webservice_model->searchDoctorMedical($data);
		if(!empty($output)){
			 echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		}else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		}

     }
	 /*
	 * function:- getReports
	 * description:- Get Analysis & Medical Scan Report
	 */

     function getReports()
     {
		$output = $this->webservice_model->getReports();
		if(!empty($output)){
			 echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		}else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		}

     }
	  /*
	 * function:- getAllReports
	 * description:- Get All Reports(Translated OR Non-Translated)
	 */

     function getAllReports()
     {
		 $data=array(
			'user_id'=>$this->input->post('user_id'),'cat_id'=>$this->input->post('cat_id'),'ios_cat_id'=>$this->input->post('ios_cat_id'),'ios_multi'=>$this->input->post('ios_multi')
		 );
		$output = $this->webservice_model->getAllReports($data);
		//print_r($output);die;
		if(!empty($output)){
			 echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		}else{
			 echo json_encode(array('status' => false,'message' => 'No report found'));
		}
     }
	   /*
	 * function:- getAllReports
	 * description:- Get All Reports(Translated OR Non-Translated)
	 */

     function requestTranslate()
     {
		 $data=array(
			'user_id'=>$this->input->post('user_id'),
			'report_id'=>$this->input->post('report_id'),
			'language'=>$this->input->post('language')
		 );
		$output = $this->webservice_model->requestTranslate($data);
		if(!empty($output)){
			 echo json_encode(array('status' => true,'message' => 'Request Sent For Translation!!'));
		}else{
			 echo json_encode(array('status' => false,'message' => 'Failed!!'));
		}
     }
	   /*
	 * function:- shoping_list
	 * description:- get shoping_list
	 */

     function shoping_list()
     {
			$user_id = $this->input->post('user_id');

		$output = $this->webservice_model->shoping_list($user_id);
		if(!empty($output)){
			 echo json_encode(array('status' => true,'data'=>$output,'message' => 'Shopping Request List'));
		}else{
			 echo json_encode(array('status' => false,'message' => 'Failed!!'));
		}
     }
      /*
	 * function:- add_payment_status
	 * description:- this function used to add payment detail
	 */

     function add_payment_status()
     {
		 /*$report_id = $this->input->post('report_id');
		 $service_id = $this->input->post('service_id');
		 $package_id = $this->input->post('package_id');
		 $appointment_id = $this->input->post('appointment_id');
		 $reports= explode(",",$report_id );
		 $services= explode(",",$service_id );
		 $packages= explode(",",$package_id );
		 data1 = array('user_id'=>$this->input->post('user_id'),'transaction_id'=>$this->input->post('transaction_id'),'amount'=>$this->input->post('amount'),'create_time'=>$this->input->post('create_time'),'status'=>$this->input->post('status'));
		 if($report_id != 0){
			 for($i=0;$i<count($reports);$i++)
			 {
				 $data1['report_id'] = $reports[$i];
				 $data1['service_id'] = 0;
				 $data1['package_id'] = 0;
				 $data1['appointment_id'] = 0;
				 $resg = $this->webservice_model->addDatatoTable($data1,'payment');
				  $this->webservice_model->update_data( array('id'=>$reports[$i]),array('translate'=>'Y'),'reports');
				  $this->webservice_model->delete_trans_request($this->input->post('user_id'),$reports[$i]);
			 }
	     }
	     if($service_id != 0){
			 for($i=0;$i<count($services);$i++)
			 {
				 $data1['report_id'] = 0;
				  $data1['service_id'] = $services[$i];
				 $data1['package_id'] = 0;
				 $data1['appointment_id'] = $appointment_id;
				 $resg = $this->webservice_model->addDatatoTable($data1,'payment');
				  $this->webservice_model->update_data( array('id'=>$appointment_id),array('paid'=>'y'),'appointments');
				  $this->webservice_model->delete_trans_request($this->input->post('user_id'),$reports[$i]);
			 }
		 }
		 if($package_id != 0){
			 for($i=0;$i<count($packages);$i++)
			 {
				 $data1['report_id'] = 0;
				  $data1['service_id'] = 0;
				 $data1['package_id'] = $packages[$i];
				 $data1['appointment_id'] = $appointment_id;
				 $resg = $this->webservice_model->addDatatoTable($data1,'payment');
				  $this->webservice_model->update_data( array('id'=>$appointment_id),array('paid'=>'y'),'appointments');
				  $this->webservice_model->delete_trans_request($this->input->post('user_id'),$reports[$i]);
			 }
		 }*/
		 $request_id = $this->input->post('request_id');
		 $requests = explode(",",$request_id );
		 $data1 = array('user_id'=>$this->input->post('user_id'),'transaction_id'=>$this->input->post('transaction_id'),'create_time'=>$this->input->post('create_time'),'status'=>$this->input->post('status'));
		  for($i=0;$i<count($requests);$i++)
			 {
				 $data = $this->webservice_model->get_single_data(array('id'=>$requests[$i]),'translate_request',"*");
				 //print_r($data);
				 $data1['report_id'] = $data['report_id'];
				 $data1['service_id'] = $data['service_id'];
				 $data1['package_id'] = $data['package_id'];
				$appointment_id = $data1['appointment_id'] = $data['appointment_id'];
				 $data1['amount'] = $data['price'];
				 $resg = $this->webservice_model->addDatatoTable($data1,'payment');
				 if($data1['report_id'] != 0){
				  $this->webservice_model->update_data( array('id'=>$reports[$i]),array('translate'=>'Y'),'reports');
			     }else{
					 $mydata = $this->webservice_model->get_single_data(array('id'=>$appointment_id),'appointments',"clinic_id,doc_id,	booking_date, booking_s_time,booking_e_time");
					 if($mydata['clinic_id'] != 0){
						 $user_id = $mydata['clinic_id'];
					 }else{
						 $user_id = $mydata['doc_id'];
					 }
					 $userdata = $this->webservice_model->get_single_data(array('id'=>$user_id),'users',"fname,lname,email, clinic_name");
					 $currentuserdata = $this->webservice_model->get_single_data(array('id'=>$this->input->post('user_id')),'users',"fname,lname,email");
					// print_r($userdata);die;
					 $this->webservice_model->update_data( array('id'=>$appointment_id),array('paid'=>'y'),'appointments');

					 $this->load->library('email');
	                 $config = array (
					  'mailtype' => 'html',
					  'charset'  => 'utf-8',
					  'priority' => '1'
					   );
				   $this->email->initialize($config);
				   $this->email->from('example@vooap.com', 'Myhealth');
				   $this->email->to($userdata['email']);
				   $this->email->subject('Myhealth Appointment');
				   $message = "Hi ".$userdata['fname'].$userdata['clinic_name'].",";
				   $message .= "<p>Your Appointment has been fixed with <strong>".$currentuserdata['fname']." ".$currentuserdata['lname']."</strong> on ".$mydata['booking_date']." at ".$mydata['booking_s_time']." to ".$mydata['booking_e_time']." . <br> <br> Thanks And Regards,<br> Myhealth Admin";
				   $this->email->message($message);
				   $this->email->send();
				   $this->email->clear(TRUE);
				   $this->email->from('example@vooap.com', 'Myhealth');
				   $this->email->to($currentuserdata['email']);
				   $this->email->subject('Myhealth Appointment');
				   $message = "Hi ".$currentuserdata['fname'].$currentuserdata['clinic_name'].",";
				   $message .= "<p>Your Appointment has been fixed with <strong>".$userdata['fname']." ".$userdata['lname']."</strong> on ".$mydata['booking_date']." at ".$mydata['booking_s_time']." to ".$mydata['booking_e_time']." . <br> <br> Thanks And Regards, <br> Myhealth Admin";
				   $this->email->message($message);
				   $this->email->send();


				 }
				  $this->webservice_model->delete_trans_request($this->input->post('user_id'),$requests[$i]);
			 }
		  if($resg != 0){

		     echo json_encode(array('status' => true,'message' => 'Added Successfully!!', 'data'=>$resg));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Not Added!!'));
		  }
     }
      /*
	 * function:- delete_translated_request
	 * description:- this function used to delete translated request
	 */

     function delete_translated_request()
     {
		$id = $this->input->post('request_id');
		$pac_id1  = explode(',',$id);

		 foreach ($pac_id1 as $key => $ii) {
			 $this->webservice_model->delete_appointment($ii);
			 $output = $this->webservice_model->delete_data($ii,'translate_request');
		}



		  if($output == 1){
		     echo json_encode(array('status' => true,'message' => 'Deleted!!'));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Not Deleted server Problem!!'));
		  }
     }


     /*
	 * function:- get_all_einfo
	 * description:- get all einfo
	 */

     function get_doc_medical()
     {
		 $type = $this->input->post('type');
			 $output = $this->webservice_model->get_doc_medical($type);
		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
     /*
	 * function:- get_all_einfo
	 * description:- get all einfo
	 */

     function get_transaction_record()
     {
		 $user_id = $this->input->post('user_id');
			 $output = $this->webservice_model->get_transaction_record($user_id);
		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
     /*
	 * function:- get_consultation_price
	 * description:- get consultation price einfo
	 */

     function get_consultation_price()
     {
		$cpriced = $this->webservice_model->get_data_with_type('type','cpriced','other_options',"content as price,'Doctor' as type");
		$cpriced  = $cpriced;
		$cpricep = $this->webservice_model->get_data_with_type('type','cpricep','other_options',"content as price,'Phone' as type");
		$cpricep  = $cpricep;
		$output = array_merge($cpriced,$cpricep);
		  if(!empty($output)){
		     echo json_encode(array('status' => true,'message' => 'Results Found!!', 'data'=>$output));
		  }
		  else{
			 echo json_encode(array('status' => false,'message' => 'Result not found'));
		  }

     }
/*last closing bracket*/
	 /*
	 * function:- verifyEmail
	 * description:- this is to confirm the user email
	 */
	 function verifyEmail($id)
     {
		$user = $this->webservice_model->verifyEmail($id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Your email has been successfully verified. </div>');
        $this->load->view('admin/verifyEmail');


     }
}

/* End of file webservice.php */
/* Location: ./application/controllers/webservice.php */
