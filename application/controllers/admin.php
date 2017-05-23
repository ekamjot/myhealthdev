<?php
class Admin extends CI_Controller {

	 public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->library('form_validation');
          //load the login model
          $this->load->model('admin_model');
          //print_r($this->session->all_userdata());

     }

      /*
	 * cretor:- Anjali Khurana
	 * function:- index
	 * description:- dashboard of admin
	 */
     function index()
	 {
		if($this->session->userdata('loginadmin'))
            {
		if($this->session->userdata('user_type')=='translator') {
			 redirect('admin/reports_info');
		 }
         $data['title']='Dashboard';
		 $data['file']='admin/index';
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }


	 }


	 /*
	 * creator:- Anjali Khurana
	 * function:- login
	 * description:- login page for admin
	 */

     public function login()
     {
		 if($this->session->userdata('loginadmin'))
            {
			  redirect("admin/index");
			}
		   $data['title']='Login';
		 $data['file']='admin/login';
          $username = $this->input->post("user_name");
          $password = $this->input->post("password");

          $this->form_validation->set_rules("user_name", "Username", "trim|required");
          $this->form_validation->set_rules("password", "Password", "trim|required");

	 if ($this->form_validation->run() == FALSE)
          {
                $this->load->view('template_s',$data);
          }
          else
          {
               if ($this->input->post('btn_login') == "Login")
               {

                    $usr_result = $this->admin_model->get_user($username, $password);
                    
                    if($usr_result['type'] != 'patient')
                    {	
	                    $count = count($usr_result);
	                    if ($count > 0)
	                    {

	                         $sessiondata = array(
	                              'username' => $usr_result['email'],
	                              'user_id' => $usr_result['id'],
	                              'user_type' => $usr_result['type'],
	                              'loginadmin' => TRUE
	                         );
	                         $this->session->set_userdata($sessiondata);
	                         redirect("admin/index");
	                    }
	                    else
	                    {
	                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
	                         redirect("admin/login");
	                    }
	                }
	                else
	                {
	                	$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">You are not authorized user.</div>');
	                	redirect('admin/login');
	                }    
               }
               else
               {
                   redirect('admin/login');
               }
         
          }
         
     }

      /*
	 * function:- logout
	 * description:- logout page for admin
	 */
     public function logout()
		{
			session_start();
		if(session_destroy())
		{
		$this->session->unset_userdata('loginadmin');
         $this->session->sess_destroy();
		redirect('admin/login');
		}
 	 }

 	  /*
	 * creator:- Anjali Khurana
	 * function:- category_list
	 * description:- get all categories from categories table in category list
	 */
 	 public function user_list()
     {

        if($this->session->userdata('loginadmin'))
        {
		 if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
		 if(!isset($_GET['type'])) {
			 redirect('admin/user_list?type=doctor');
		 }
		 if($_GET['type'] =='doctor' )	$data['title']='Doctor List';
         else if($_GET['type'] =='medical' )	$data['title']='Medical Center List';
         else if($_GET['type'] =='translator' )	$data['title']='Translator List';
		 $data['file']='admin/alluser';
		 $type = $_GET['type'];
		 $data['users']=$this->admin_model->all_users($type);
		 		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'users');

			if($_GET['type'] =='doctor' ){
				 $this->admin_model->deletedata_where_tables(array('doc_id'=>$id),'appointments');
			}elseif($_GET['type'] =='medical' ){
				 $this->admin_model->deletedata_where_tables(array('clinic_id'=>$id),'appointments');
			}
			if($_GET['type'] =='doctor' || $_GET['type'] =='medical'){
				 $this->admin_model->deletedata_where_tables(array('doc_id'=>$id),'authorized_doctors');
				 $this->admin_model->deletedata_where_tables(array('user_id'=>$id),'locations');
				 $this->admin_model->deletedata_where_tables(array('user_id'=>$id),'nonavailable_dates');
			}
			 redirect('admin/user_list?type='.$_GET['type']);
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

	  /*
	 * creator:- Anjali Khurana
	 * function:- add_category
	 * description:- add category in categories table
	 */
     public function add_user()
     {

        if($this->session->userdata('loginadmin'))
        {
		 if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Add User';
		 $data['file']='admin/adduser';
		 $data['services']=$this->admin_model->all_data_of_table('services');
		 $data['packages']=$this->admin_model->all_data_of_table('packages');
		 if(isset($_POST['submit'])){
			 $time = date("Y-m-d h:i:sa");
			 $type = $_GET['type'];
			$data = array(
			'fname' => $this->input->post('fname'),'lname' => $this->input->post('lname'),'email' => $this->input->post('email'),'phoneno' => $this->input->post('phoneno'),'introduction' => $this->input->post('introduction'),'education' => $this->input->post('education'),'clinic_name' => $this->input->post('clinic_name'),'clinic_type' => $this->input->post('clinic_type'),'fax' => $this->input->post('fax'),'password' => md5($this->input->post('password')),'created' => $time,'type'=>$type,'service_start_time' => $this->input->post('service_start_time'),'service_end_time' => $this->input->post('service_end_time'),'price' => $this->input->post('price')
		);
		if($_FILES['picture']['name'] != ''){
		       $config['upload_path']   =   './public/uploads/';
			   $config['allowed_types'] =   "gif|jpg|jpeg|png";
			   $this->load->library('upload',$config);
			   $this->upload->initialize($config);

			   if(!$this->upload->do_upload('picture')){
	               echo $this->upload->display_errors();
	               return false;
			   }
			   else
			   {
				   $finfo=$this->upload->data();
				   $data['picture'] = $finfo['file_name'];
			   }
		   }
		    $data = array_filter($data);
			$id = $this->admin_model->add_data($data,'users');
			if($id){
				$data_s = array('fname' => $this->input->post('fname_s'),'lname' => $this->input->post('lname_s'),'introduction' => $this->input->post('introduction_s'),'education' => $this->input->post('education_s'),'clinic_name' => $this->input->post('clinic_name_s'),'clinic_type' => $this->input->post('clinic_type_s'),'user_id'=>$id);

			    $data_t = array('fname' => $this->input->post('fname_t'),'lname' => $this->input->post('lname_t'),'introduction' => $this->input->post('introduction_t'),'education' => $this->input->post('education_t'),'clinic_name' => $this->input->post('clinic_name_t'),'clinic_type' => $this->input->post('clinic_type_t'),'user_id'=>$id);

			    $data_s = array_filter($data_s);
			    $this->admin_model->add_data($data_s,'users_simplified');
			    $data_t = array_filter($data_t);
			    $this->admin_model->add_data($data_t,'users_traditional');
			     $services = $this->input->post('services');
				if(!empty($services)){
					   foreach($services as $ser_id){
						 $data11 = array('service_id'=>$ser_id,'clinic_id'=>$id);
						 $this->admin_model->add_data($data11,'services_with_clinics');
					   }
				   }


				$address = $this->input->post('address');
				$address_s = $this->input->post('address_s');
				$address_t = $this->input->post('address_t');
				$district = $this->input->post('district');
				$district_s = $this->input->post('district_s');
				$district_t = $this->input->post('district_t');
				$lat = $this->input->post('lat');
				$long = $this->input->post('long');
				$addr = array('user_id'=>$id,'type'=> $type);
				if($address){
				   if(is_array($address)){
					   foreach($address as $key => $val){
						 $addr['address'] =  $val;
						 $addr['address_s'] =  $address_s[$key];
					    $addr['address_t'] =  $address_t[$key];
					    $addr['district'] =  $district[$key];
					    $addr['district_s'] =  $district_s[$key];
					    $addr['district_t'] =  $district_t[$key];
						 $addr['lat'] =  $lat[$key];
						 $addr['long'] =  $long[$key];
						 $this->admin_model->add_data($addr,'locations');
					   }
				   }else{
					    $addr['address'] =  $address;
					    $addr['address_s'] =  $address_s;
					    $addr['address_t'] =  $address_t;
					    $addr['district'] =  $district;
					    $addr['district_s'] =  $district_s;
					    $addr['district_t'] =  $district_t;
						$addr['lat'] =  $lat;
						$addr['long'] =  $long;
					   $this->admin_model->add_data($addr,'locations');
				   }
			   }
				   $this->load->library('email');
	               $config = array (
					  'mailtype' => 'html',
					  'charset'  => 'utf-8',
					  'priority' => '1'
					   );
				   $this->email->initialize($config);
				   $this->email->from('example@vooap.com', 'Myhealth');
				   $this->email->to($this->input->post('email'));
				   $this->email->subject('Welcome To Myhealth');
				   $message = "Hi ".$this->input->post('fname').$this->input->post('clinic_name');
				   $message .= "<p>Your Account for myhealth has been created. Please Check <a href='".base_url()."admin/'> here </a>
				    . <br>Your password is <strong>".$this->input->post('password')."</strong>";
				   $this->email->message($message);
				   $this->email->send();
			 }
			  $this->session->set_flashdata('success_msg', 'Successfully Added!');
			  redirect('admin/add_user?type='.$type);
		    }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }
	 /*
	  * creator:- Anjali Khurana
	 * function:- edit_category
	 * description:- add category in categories table
	 */
     public function edit_user()
     {

        if($this->session->userdata('loginadmin')) {
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Edit User';
		 $data['file']='admin/edituser';
		 $id = $_GET['id'];
		  $data['user']=$this->admin_model->get_single_user($id);
		  $data['user_s']=$this->admin_model->single_data_of_table(array('user_id'=>$id),'users_simplified');
		  $data['user_t']=$this->admin_model->single_data_of_table(array('user_id'=>$id),'users_traditional');
		  $type = $data['user']['type'];
		  $data['addr_info'] = $this->admin_model->get_datas_of_table(array('user_id'=>$id),'locations');
		  $data['services']=$this->admin_model->all_data_of_table('services');
		  $data['assigned_services'] = $this->admin_model->get_datas_of_table(array('clinic_id'=>$id),'services_with_clinics');
		 if(isset($_POST['submit'])){
			 $data = array(
			'fname' => $this->input->post('fname'),'lname' => $this->input->post('lname'),'phoneno' => $this->input->post('phoneno'),'introduction' => $this->input->post('introduction'),'education' => $this->input->post('education'),'clinic_name' => $this->input->post('clinic_name'),'clinic_type' => $this->input->post('clinic_type'),'fax' => $this->input->post('fax'),'service_start_time' => $this->input->post('service_start_time'),'service_end_time' => $this->input->post('service_end_time'),'price' => $this->input->post('price')
		);
		if($_FILES['picture']['name'] != ''){
		       $config['upload_path']   =   './public/uploads/';
			   $config['allowed_types'] =   "gif|jpg|jpeg|png";
			   $this->load->library('upload',$config);
			   $this->upload->initialize($config);

			   if(!$this->upload->do_upload('picture')){
	               echo $this->upload->display_errors();
	               return false;
			   }
			   else
			   {
				   $finfo=$this->upload->data();
				   $data['picture'] = $finfo['file_name'];
			   }
		   }
		    $data = array_filter($data);
		    $data_s = array('fname' => $this->input->post('fname_s'),'lname' => $this->input->post('lname_s'),'introduction' => $this->input->post('introduction_s'),'education' => $this->input->post('education_s'),'clinic_name' => $this->input->post('clinic_name_s'),'clinic_type' => $this->input->post('clinic_type_s'));
			$data_t = array('fname' => $this->input->post('fname_t'),'lname' => $this->input->post('lname_t'),'introduction' => $this->input->post('introduction_t'),'education' => $this->input->post('education_t'),'clinic_name' => $this->input->post('clinic_name_t'),'clinic_type' => $this->input->post('clinic_type_t'));
			$data_s = array_filter($data_s);
			$data_t = array_filter($data_t);
			 $this->admin_model->edit_data($id,$data,'users');
			 $this->admin_model->edit_user($id,$data_s,'users_simplified');
			 $this->admin_model->edit_user($id,$data_t,'users_traditional');
			// $this->admin_model->update_users_address($id,$type,$_POST['address'],$_POST['lat'],$_POST['long']);
			$this->admin_model->update_users_address($id,$type,$_POST['address'],$_POST['address_s'],$_POST['address_t'],$_POST['district'],$_POST['district_s'],$_POST['district_t'],$_POST['lat'],$_POST['long']);
			if(isset($_POST['services']))  $this->admin_model->update_serv_packages($id,$_POST['services']);
			  $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			  redirect('admin/edit_user?id='.$id);
		    }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }
     function delete_report_file(){
		  if($_POST['report_id']){
			 $id = $_POST['report_id'];
			 $this->admin_model->deletedata_from_tables($id,'reports');
			 $this->admin_model->deletedata_where_tables(array('report_id'=>$id),'translated_reports');
			 echo true;
		 }
	 }
     public function check_email()
		 {

		   $email = $this->input->get('email');
		  echo $this->admin_model->check_email($email);
	}
     public function check_phoneno()
		 {

		   $phoneno = $this->input->get('phoneno');
		  echo $this->admin_model->check_phoneno($phoneno);
	}

	 /*
	 * creator:- Anjali Khurana
	 * function:- category_list
	 * description:- get all categories from categories table in category list
	 */
 	 public function patient_list()
     {

        if($this->session->userdata('loginadmin'))
            {
         $data['title']='Patient List';
		 $data['file']='admin/allpatient';
		 if($this->session->userdata('user_type')=='admin') {
			 $data['users']=$this->admin_model->all_patient('0');
		 }else{
			 $data['users']=$this->admin_model->all_patient($this->session->userdata('user_id'));
		 }

		 $data['reports1']=$this->admin_model->get_datas_of_table(array('type'=>"A"),'reports_cat');
		 $data['medical']=$this->admin_model->get_datas_of_table(array('type'=>"M"),'reports_cat');
		 //$data['report_list']=$this->admin_model->report_list();
		 foreach($data['users'] as $user){
		  $report_list[] = $this->admin_model->getAllReports($user['id']);
	     }
	     $data['reports'] = @$report_list;
	     //print_r($report_list);die;
		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'users');
			 $this->admin_model->deletedata_from_tables1($id,'patient_tbl');
			 $this->admin_model->deletedata_from_tables1($id,'appointments');
			 $this->admin_model->deletedata_from_tables1($id,'authorized_doctors');
			 $this->admin_model->deletedata_from_tables1($id,'reports');
			 $this->admin_model->deletedata_from_tables1($id,'translated_reports');
			 $this->admin_model->deletedata_from_tables1($id,'translate_request');
			 redirect('admin/patient_list');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }
	 /*
	 * creator:- Anjali Khurana
	 * function:- view_patient
	 * description:- function used to view detail of patient
	 */
 	 public function view_patient()
     {

        if($this->session->userdata('loginadmin')){
         $data['title']='View Patient Detail';
		 $data['file']='admin/view_patients';
		 $id = $_GET['id'];
		 $o_id = $this->session->userdata('user_id');
		 if(($this->admin_model->check_docs_patients($id, $o_id)!=0) || ($this->admin_model->check_docs_patients1($id, $o_id)!=0) || ($this->session->userdata('user_type')=='admin')){
			 $data['patient']=$this->admin_model->getPatientDetails($id);
			 $this->load->view('template_admin',$data);
		 }else{
			  redirect('admin/patient_list');
		 }
	   }else{
		   redirect('admin/login');
	   }
     }

      /*
	 * creator:- Anjali Khurana
	 * function:- package_list
	 * description:- get all package from packages table in package list
	 */
 	 public function package_list()
     {

        if($this->session->userdata('loginadmin')) {
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Package List';
		 $data['file']='admin/allpackages';
		 $data['packages']=$this->admin_model->all_data_of_table('packages');
		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'packages');
			 redirect('admin/package_list');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

	  /*
	 * creator:- Anjali Khurana
	 * function:- add_package
	 * description:- add packages in packages table
	 */
    public function add_package()
     {

        if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Add Package';
		 $data['file']='admin/addpackage';
		 $data['services']=$this->admin_model->all_data_of_table('services');
		 if(isset($_POST['submit'])){
			 $time = date("Y-m-d h:i:sa");
			$data = array(
			'package_name' => $this->input->post('package_name'),'package_name_s' => $this->input->post('package_name_s'),'package_name_t' => $this->input->post('package_name_t'),'price' => $this->input->post('price'),'package_detail' => $this->input->post('package_detail'),'package_detail_s' => $this->input->post('package_detail_s'),'package_detail_t' => $this->input->post('package_detail_t'),'type' => $this->input->post('type'),'created' => $time
		  );
		  $id = $this->admin_model->add_data($data,'packages');
		  $services = $this->input->post('services');
			if(!empty($services)){
				   foreach($services as $ser_id){
					 $data11 = array('service_id'=>$ser_id,'package_id'=> $id);
					 $this->admin_model->add_data($data11,'service_with_pack');
				   }
			   }
			  $this->session->set_flashdata('success_msg', 'Successfully Added!');
			  redirect('admin/add_package');
		    }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

     /*
	 * creator:- Anjali Khurana
	 * function:- edit_package
	 * description:- edit packages in packages table
	 */
     public function edit_package()
     {

        if($this->session->userdata('loginadmin')){
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Edit Package';
		 $data['file']='admin/addpackage';
		 $data['services']=$this->admin_model->all_data_of_table('services');

		 $id = $_GET['id'];
		 $data['assigned_services'] = $this->admin_model->get_datas_of_table(array('package_id'=>$id),'service_with_pack');
		  $data['user']=$this->admin_model->single_data_of_table(array('id'=>$id),'packages');
		 if(isset($_POST['submit'])){
			 $data = array(
			'package_name' => $this->input->post('package_name'),'package_name_s' => $this->input->post('package_name_s'),'package_name_t' => $this->input->post('package_name_t'),'price' => $this->input->post('price'),'package_detail' => $this->input->post('package_detail'),'package_detail_s' => $this->input->post('package_detail_s'),'package_detail_t' => $this->input->post('package_detail_t'),'type' => $this->input->post('type'));
			 $this->admin_model->edit_data($id,$data,'packages');
			 $this->admin_model->update_pack_services($id,$_POST['services']);
			  $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			  redirect('admin/edit_package?id='.$id);
		    }
		    $this->load->view('template_admin',$data);
		 }
           else{
			   redirect('admin/login');
		   }
     }
     /*
	 * creator:- Anjali Khurana
	 * function:- check_dates
	 * description:- check date avalibilty
	 */
     public function check_dates()
     {

        if($this->session->userdata('loginadmin'))
            {
		if($this->session->userdata('user_type')=='translator') {
			 redirect('admin/index');
		 }
         $data['title']='Disable Dates';
		 $data['file']='admin/checkdates';
		 $user_id = $this->session->userdata('user_id');
		 $user_type= $this->session->userdata('user_type');
		 $tasks = array(); $tasks1 = array();
		 $taskse = $this->admin_model->check_appointments($user_type,$user_id);
		 $i = 0;
		 $appoin_detail = '';
		 //echo "<pre>"; print_r($taskse); die;
		 foreach($taskse as $task){
			   // print_r($task);
			  $appoin_detail = '';
					if(($task['package_id'] != '0') && ($task['services_id'] != '0')){
						if(!empty($task['package_id']))
						{
							$package=explode(',',$task['package_id']);
							//$appoin_detail.= '<strong>Packages</strong><br>';
							foreach($package as $pack)
							{
								$package_detail=$this->admin_model->package_detail($task['id'],$pack);

								if(!empty($package_detail)){
								   $appoin_detail.= '<strong>Package : </strong>'.$package_detail['package_name'].' : '.$package_detail['amount']."<br>";
							   }
							}

						}
						if(!empty($task['services_id']))
						{
							$services=explode(',',$task['services_id']);
							//$appoin_detail.= '<strong>Serivces</strong><br>';
							foreach($services as $ser)
							{
								$services_detail=$this->admin_model->service_detail($task['id'],$ser);

								if(!empty($package_detail)){
								  @$appoin_detail.= '<strong>Service : </strong>'.@$services_detail['service_name'].' : '.@$services_detail['amount']."<br>";
							   }
							}
						}
						$tasks[$i]['appointment_detail'] = $appoin_detail;
					}else{
						if($task['loc_id'] != 0)
						{
								$locations = $this->admin_model->single_data_of_table(array('id'=>$task['loc_id']),'locations');
								$payment = $this->admin_model->single_data_of_table(array('appointment_id'=>$task['id']),'payment');
                                 // print_r($payment);
								 // echo "location";
                                 // print_r($locations);
								$appoin_detail.= '<strong>Location</strong><br>';
								if(!empty($locations)){
								
								  $appoin_detail.= $locations['address'].' : '.$payment['amount']."<br>";
									
							   }
						}
						
						$tasks[$i]['appointment_detail'] =  $appoin_detail;
					}
					$tasks[$i]['start'] = $task['booking_date'].' '.$task['booking_s_time'];
					$tasks[$i]['end'] =  $task['booking_date'].' '.$task['booking_e_time'];
					if($user_type=='admin'){
					  $tasks[$i]['title'] = 'Appointment by '.$task['fname'].' '.$task['lname'].' with '.$task['doc_fname'].' '.$task['doc_lname'];
					  $tasks[$i]['title1'] = 'Appointment by <a href="'.base_url().'admin/view_patient?id='.$task['user_id'].'" target="_blank">'.$task['fname'].' '.$task['lname'].'</a> with <a href="'.base_url().'admin/edit_user?id='.$task['did'].'" target="_blank">'.$task['doc_fname'].' '.$task['doc_lname'].'</a>';
					 }else{
					  $tasks[$i]['title'] = 'Your Appointment with '.$task['fname'].' '.$task['lname'];
					  $tasks[$i]['title1'] = 'Your Appointment with <a href="'.base_url().'admin/view_patient?id='.$task['user_id'].'" target="_blank">'.$task['fname'].' '.$task['lname'].'</a>';
					 }

					$tasks[$i]['date'] =  $task['booking_date'];
					$tasks[$i]['time'] =  $task['booking_s_time'].' - '.$task['booking_e_time'];
					//$tasks[$i]['color'] =  '#99abea';
		++$i;
		}

		$data['tasks']=$tasks;
		 $taskso = $this->admin_model->others_non_available_dates($user_type,$user_id);
		 $j = 0;
		 foreach($taskso as $task){
			 		$tasks1[$j]['start'] = $task['nondate'];
					$tasks1[$j]['allDay'] =  true;
					$tasks1[$j]['title'] = 'Not Available '.$task['fname'].' '.$task['lname'].'('.$task['type'].')';
					$tasks1[$j]['date'] =  $task['nondate'];
					$tasks1[$j]['time'] =  'none';
					$tasks1[$j]['color'] =  '#99abea';
					$tasks1[$j]['id'] =  '0'.$task['id'];
		++$j;
		}
		 if($user_type=='admin'){
		  $data['tasks1'] = $tasks1;
	     }else{
		  $data['tasks1'] = array();
		 }
		 $data['dates'] = $this->admin_model->non_available_dates($user_type,$user_id );
		 $this->load->view('template_admin',$data);
		 }
           else{
			   redirect('admin/login');
		   }
     }

     function disabled_dates(){

		 $data = $_POST;
		 $data['user_id'] = $this->session->userdata('user_id');
		 $data['type'] = $this->session->userdata('user_type');
		 $check = $this->admin_model->check_available_dates($data['nondate'],$data['type'],$data['user_id']);
		 //echo $check;

		 if($check){
		    $this->admin_model->add_data($data,'nonavailable_dates');
		    echo true;
		}else{
			echo false;
		}
	 }
     function disabled_dates_remove(){

		 $data = $_POST;
		 $data['user_id'] = $this->session->userdata('user_id');
		 $data['type']= $this->session->userdata('user_type');
		 $this->admin_model->disabled_dates_remove($data['nondate'],$data['type'],$data['user_id']);
		 echo "The date has been deleted";
	 }


	 public function profile()
     {
    
        if($this->session->userdata('loginadmin')) {
         $data['title']='Profile';
		 $data['file']='admin/profile';
		$data['type'] = $this->session->userdata('user_type');
		 $id = $this->session->userdata('user_id');
		  $data['user']=$this->admin_model->get_single_user($id);
		  $data['addr_info'] = $this->admin_model->get_datas_of_table(array('user_id'=>$id),'locations');
		  if(isset($err)){
			  if($err==0){
		   $data['err']='Password not match';
			  }
			  elseif($err==1){
				  $data['err']='Password Update Succesfully';}
		  }
		  
		 if(isset($_POST['submit'])){
			 $data = array(
			'fname' => $this->input->post('fname'),'lname' => $this->input->post('lname'),'phoneno' => $this->input->post('phoneno'),'district' => $this->input->post('district'),'introduction' => $this->input->post('introduction'),'education' => $this->input->post('education'),'clinic_name' => $this->input->post('clinic_name'),'clinic_type' => $this->input->post('clinic_type'),'fax' => $this->input->post('fax'),'price' => $this->input->post('price'),'service_start_time' => $this->input->post('service_start_time'),'service_end_time' => $this->input->post('service_end_time')
		);
		if($_FILES['picture']['name'] != ''){
		       $config['upload_path']   =   './public/uploads/';
			   $config['allowed_types'] =   "gif|jpg|jpeg|png";
			   $this->load->library('upload',$config);
			   $this->upload->initialize($config);

			   if(!$this->upload->do_upload('picture')){
	               echo $this->upload->display_errors();
	               return false;
			   }
			   else
			   {
				   $finfo=$this->upload->data();
				   $data['picture'] = $finfo['file_name'];
			   }
		   }
			$data = array_filter($data);
			/*print_r($data);
			echo "Post_data";*/
			//print_r($_POST);
			
			 $type = $this->session->userdata('user_type');
			 $id = $this->session->userdata('user_id');
			 $this->admin_model->edit_data($id,$data,'users');
			 
			 if($type == 'doctor')
			 {	
				 $this->admin_model->update_users_address_for_doctor($id,$type,$_POST['address'],$_POST['lat'],$_POST['long']);
			 }
			 else
			 {	 
			  $this->admin_model->update_users_address($id,$type,$_POST['address'],$_POST['address_s'],$_POST['address_t'],$_POST['district'],$_POST['district_s'],$_POST['district_t'],$_POST['lat'],$_POST['long']);
			 }	
			  $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			 /* echo "success";
			  exit;*/
			  redirect('admin/profile?');
		    }
			$err="";
			if(isset($_POST['change'])){
				$id=$_POST['id'];
				$old=md5($_POST['oldpswd']);
					// print_r($_POST);
			// return;
		     $a3= $this->admin_model->get_userOldPswd($id,$old,'users');
			 if($a3>0){
			if(isset($_POST['password'])!==""){
			if($_POST['password']==$_POST['cpassword']){
			$pswd=md5($_POST['password']);
			
			$type=$_POST['type'];
			$data1 = array('password' => $pswd );
			  // print_r($data);
		 $this->admin_model->update_password($id,$data1,'users');
		 $err='<p style="color:green;">Password Update Succesfully</p>';
		
			  }
			  else { 
			   $err='<p style="color:red;">Password not match</p>';
			  }
			  }
		 else { 
			   $err='<p style="color:red;">Fill Password Blank</p>';
			  }
			   }
            else{  $err='<p style="color:red;">Old Passsword Incorrect</p>';}
		
		 
        }
		$data['err']=$err;
		
		 	$this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

	 public function other_options()
     {

        if($this->session->userdata('loginadmin')) {
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Edit Options';
		 $data['file']='admin/other_options';
		 $data['about_us']=$this->admin_model->single_data_of_table(array('id'=>1),'other_options');
		 $data['privacy_policy']=$this->admin_model->single_data_of_table(array('id'=>2),'other_options');
		 $data['contact_us']=$this->admin_model->single_data_of_table(array('id'=>3),'other_options');
		 $data['terms_use']=$this->admin_model->single_data_of_table(array('id'=>4),'other_options');
		 $data['adver_images']=$this->admin_model->get_other_images('adver','e');
		 $data['adver_images_s']=$this->admin_model->get_other_images('adver','s');
		 $data['adver_images_t']=$this->admin_model->get_other_images('adver','t');
		 $data['einfo_images']=$this->admin_model->get_other_images('einfo','e');
		 $data['einfo_images2']=$this->admin_model->get_other_images('einfo','s');
		 $data['einfo_images1']=$this->admin_model->get_other_images('einfo','t');
		 $data1 = array();
		 if($_POST){

			 if($_FILES){
		       $config['upload_path']   =   './public/uploads/others/';
			   $config['allowed_types'] =   "gif|jpg|jpeg|png";
			   $this->load->library('upload',$config);
			   $this->upload->initialize($config);
			   if(isset($_POST['adver_submit'])){
				   if(!$this->upload->do_upload('upload_adver')){
					   echo $this->upload->display_errors();
					   return false;
				   }
				   else
				   {
					   $finfo=$this->upload->data();
					   $data1 = array('featured'=>'yes','type'=>'adver');
					   $data1['file_path'] = $finfo['file_name'];
					   $data1['file_name'] = $finfo['raw_name'];
					   $data1['link'] = $_POST['link'];
					   $data1['lang'] = $_POST['language'];
					   $this->admin_model->add_data($data1,'other_options_images');
				   }
			   }elseif(isset($_POST['info_submit'])){
				   if(!$this->upload->do_upload('upload_einfo')){
					   echo $this->upload->display_errors();
					   return false;
				   }
				   else
				   {
					   $finfo=$this->upload->data();
					   $data1 = array('featured'=>'yes','type'=>'einfo');
					   $data1['file_path'] = $finfo['file_name'];
					   $data1['file_name'] = $finfo['raw_name'];
					   $data1['link'] = $_POST['link'];
					   $data1['lang'] = $_POST['language'];
					   $this->admin_model->add_data($data1,'other_options_images');
				   }
			   }
		   }


			 if(isset($_POST['about_submit'])){
				 $id = 1;
				 $data1 = array('content' => $this->input->post('about_us'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['pp_submit'])){
				 $id = 2;
				 $data1 = array('content' => $this->input->post('privacy_policy'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['contact_submit'])){
				 $id = 3;
				 $data1 = array('content' => $this->input->post('contact_us'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['term_submit'])){
				 $id = 4;
				 $data1 = array('content' => $this->input->post('terms_use'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['about_submit_s'])){
				 $id = 1;
				 $data1 = array('content_s' => $this->input->post('about_us'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['pp_submit_s'])){
				 $id = 2;
				 $data1 = array('content_s' => $this->input->post('privacy_policy'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['contact_submit_s'])){
				 $id = 3;
				 $data1 = array('content_s' => $this->input->post('contact_us'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['term_submit_s'])){
				 $id = 4;
				 $data1 = array('content_s' => $this->input->post('terms_use'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['about_submit_t'])){
				 $id = 1;
				 $data1 = array('content_t' => $this->input->post('about_us'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['pp_submit_t'])){
				 $id = 2;
				 $data1 = array('content_t' => $this->input->post('privacy_policy'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['contact_submit_t'])){
				 $id = 3;
				 $data1 = array('content_t' => $this->input->post('contact_us'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['term_submit_t'])){
				 $id = 4;
				 $data1 = array('content_t' => $this->input->post('terms_use'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
			 }
			 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'other_options_images');
		 }
			 $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			 redirect('admin/other_options');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

     function make_featured_images(){
		 $id = $_POST['id'];
		 $data = array('featured'=>$_POST['featured']);
		 echo $this->admin_model->edit_data($id,$data,'other_options_images');

	 }




	 /*
	 * creator:- Anjali Khurana
	 * function:- package_list
	 * description:- get all package from packages table in package list
	 */
 	 public function e_information_list()
     {

        if($this->session->userdata('loginadmin')) {
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
		 $type = $this->session->userdata('user_type');
		 $user_id = $this->session->userdata('user_id');
         $data['title']='E-information';
		 $data['file']='admin/e_information_list';
		 $data['einformation']=$this->admin_model->get_einformation($type,$user_id);
		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'einformation');
			 redirect('admin/e_information_list');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

     public function add_einformation()
     {

        if($this->session->userdata('loginadmin')){
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Add e-Information';
		 $data['file']='admin/add_einformation';
		 $user_id = $this->session->userdata('user_id');
		 $data['cats'] =  $this->admin_model->all_data_of_table('einfo_filters');
		 /******* CK editor ************/

		 $this->load->library('ckeditor');
		 $this->load->library('ckfinder');
		 $this->ckeditor->basePath = base_url().'public/ckeditor/';

		 $this->ckeditor->config['width'] = '930px';
		 $this->ckeditor->config['height'] = '300px';
		 $this->ckfinder->SetupCKEditor($this->ckeditor,'../public/ckfinder/');
		  /******* CK editor code ends ************/
		 if(isset($_POST['submit'])){
			 if(isset($_POST['featured'])){
				 $featured = 'yes';
			 }else{
				 $featured = 'no';
			 }
			 $time = date("Y-m-d h:i:sa");
			$data1 = array(
			'title' => $this->input->post('title'),'uploader_name' => $this->input->post('uploader_name'),'type' => $this->input->post('type'),'content' => $this->input->post('content1'),'featured' => $featured,'created' => $time,'user_id'=>$user_id
		);
			 $config['upload_path']   =   './public/uploads/others/';
			   $config['allowed_types'] =   "gif|jpg|jpeg|png";
			   $this->load->library('upload',$config);
			   $this->upload->initialize($config);
			 if($_FILES['picture']['name']!=''){
				   if(!$this->upload->do_upload('picture')){
					   echo $this->upload->display_errors();
					   return false;
				   }
				   else
				   {
					   $finfo=$this->upload->data();
					   $data1['image'] = $finfo['file_name'];
				   }
		   }
		   if($_FILES['e_image']['name']!=''){
				   if(!$this->upload->do_upload('e_image')){
					   echo $this->upload->display_errors();
					   return false;
				   }
				   else
				   {
					   $finfo1=$this->upload->data();
					   $data1['e_image'] = $finfo1['file_name'];
				   }
		   }

			          $id = $this->admin_model->add_data($data1,'einformation');
			           $data2 = array(); $data3 = array();
			           if($this->input->post('title2') || $this->input->post('content2')|| $this->input->post('uploader_name2')){
						   $data2['title'] =  $this->input->post('title2');
						   $data2['content'] =  $this->input->post('content2');
						   $data2['uploader_name'] =  $this->input->post('uploader_name2');
						   $data2['einfo_id'] = $id;
						   array_filter($data2);
						   $this->admin_model->add_data($data2,'einformation_simplified');
					   }
			           if($this->input->post('title3') || $this->input->post('content3')|| $this->input->post('uploader_name3')){
						   $data3['title'] =  $this->input->post('title3');
						   $data3['content'] =  $this->input->post('content3');
						   $data3['uploader_name'] =  $this->input->post('uploader_name3');
						   $data3['einfo_id'] = $id;
						   array_filter($data3);
						   $this->admin_model->add_data($data3,'einformation_traditional');
					   }
					   $this->session->set_flashdata('success_msg', 'Successfully Added!');
			  redirect('admin/add_einformation');
		    }
		    $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }
     public function edit_einformation()
     {

        if($this->session->userdata('loginadmin')){
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Edit e-Information';
		 $data['file']='admin/edit_einformation';
		 $data['cats'] =  $this->admin_model->all_data_of_table('einfo_filters');
		 $id = $_GET['id'];
		 $data['einfo']=$this->admin_model->single_data_of_table(array('id'=>$id),'einformation');
		 $data['einfo1']=$this->admin_model->single_data_of_table(array('einfo_id'=>$id),'einformation_simplified');
		 $data['einfo2']=$this->admin_model->single_data_of_table(array('einfo_id'=>$id),'einformation_traditional');
		 /******* CK editor ************/

		 $this->load->library('ckeditor');
		 $this->ckeditor->basePath = base_url().'public/ckeditor/';
		 $this->ckeditor->config['toolbar'] = array(
						array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
															);
		 $this->ckeditor->config['width'] = '930px';
		 $this->ckeditor->config['height'] = '300px';
		  /******* CK editor code ends ************/
		 if(isset($_POST['submit'])){
			 if(isset($_POST['featured'])){
				 $featured = 'yes';
			 }else{
				 $featured = 'no';
			 }
			$data1 = array(
			'title' => $this->input->post('title'),'uploader_name' => $this->input->post('uploader_name'),'type' => $this->input->post('type'),'content' => $this->input->post('content1'),'featured' => $featured
		);
			 $config['upload_path']   =   './public/uploads/others/';
			   $config['allowed_types'] =   "gif|jpg|jpeg|png";
			   $this->load->library('upload',$config);
			   $this->upload->initialize($config);
			 if($_FILES['picture']['name']!=''){

				   if(!$this->upload->do_upload('picture')){
					   echo $this->upload->display_errors();
					   return false;
				   }
				   else
				   {
					   $finfo=$this->upload->data();
					   $data1['image'] = $finfo['file_name'];
				   }
		   }
		   if($_FILES['e_image']['name']!=''){
				   if(!$this->upload->do_upload('e_image')){
					   echo $this->upload->display_errors();
					   return false;
				   }
				   else
				   {
					   $finfo1=$this->upload->data();
					   $data1['e_image'] = $finfo1['file_name'];
				   }
		   }
			           $this->admin_model->edit_data($id,$data1,'einformation');
			           $data2 = array(); $data3 = array();
			           if($this->input->post('title2') || $this->input->post('content2')|| $this->input->post('uploader_name2')){
						   $data2['title'] =  $this->input->post('title2');
						   $data2['content'] =  $this->input->post('content2');
						   $data2['uploader_name'] =  $this->input->post('uploader_name2');
						   array_filter($data2);
						   $this->admin_model->edit_data1($id,$data2,'einformation_simplified');
					   }
			           if($this->input->post('title3') || $this->input->post('content3')|| $this->input->post('uploader_name3')){
						   $data3['title'] =  $this->input->post('title3');
						   $data3['content'] =  $this->input->post('content3');
						   $data3['uploader_name'] =  $this->input->post('uploader_name3');
						   array_filter($data3);
						   $this->admin_model->edit_data1($id,$data3,'einformation_traditional');
					   }
					   $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			  redirect('admin/edit_einformation?id='.$id);
		    }
		    $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }



      public function einfo_cat()
     {

        if($this->session->userdata('loginadmin')) {
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Manage Report Category';
		 $data['file']='admin/einfo_cat';
		 $data['locations']=$this->admin_model->all_data_of_table('einfo_filters');
		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'einfo_filters');
			 redirect('admin/einfo_cat');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

     public function add_einfo_cat()
     {

        if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		    }
			$data1 = array(
			'cat_name' => $this->input->post('cat_name'),'cat_sim' => $this->input->post('cat_sim'),'cat_tra' => $this->input->post('cat_tra'));
			 $id = $this->admin_model->add_data($data1,'einfo_filters');
			 if( $id ){
			     $this->session->set_flashdata('success_msg', 'Successfully Added!');
			     redirect('admin/einfo_cat');
			 }else{
				  $this->session->set_flashdata('success_msg', 'Not  Added!');
			 }

           }
           else{
			   redirect('admin/login');
		   }
     }



      /*
	 * creator:- Anjali Khurana
	 * function:- package_list
	 * description:- get all package from packages table in package list
	 */
 	/* public function location_list()
     {

        if($this->session->userdata('loginadmin')) {
         $data['title']='Manage Location';
		 $data['file']='admin/location_list';
		 $data['locations']=$this->admin_model->all_data_of_table('locations');
		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'locations');
			 redirect('admin/location_list');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }*/

      public function add_report()
     {

        if($this->session->userdata('loginadmin')){
					// 	if($this->session->userdata('user_type')!='admin') {
					// 		redirect('admin/index');
		    	// }
			$data1 = array(
				'report_number' => $this->input->post('report_number'),
				'item' => $this->input->post('item'),
				'report_type' => $this->input->post('report_type'),
				'r_date' => date('Y-m-d'),
				'user_id' => $this->input->post('user_id'),
				'uploaded_by' => $this->session->userdata('user_id')
			);
			 if($_FILES['report_file']['name']!=''){
		       $config['upload_path']   =   './public/uploads/reports/';
			   $config['allowed_types'] =   "*";
			   $this->load->library('upload',$config);
			   $this->upload->initialize($config);
				   if(!$this->upload->do_upload('report_file')){
					    $this->upload->display_errors();

				   }
				   else
				   {
					   $finfo=$this->upload->data();
					   $data1['report_file'] = $finfo['file_name'];
				   }
		   }

			 $id = $this->admin_model->add_data($data1,'reports');
			 if( $id ){
			     $this->session->set_flashdata('success_msg', 'Successfully Added!');
			     redirect('admin/patient_list');
			 }else{
				  $this->session->set_flashdata('success_msg', 'Not  Added!');
			 }

          }
           else{
			   redirect('admin/login');
		   }
     }

     public function report_cat()
     {

        if($this->session->userdata('loginadmin')) {
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Manage Report Category';
		 $data['file']='admin/report_cat';
		 $data['locations']=$this->admin_model->all_data_of_table('reports_cat');
		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'reports_cat');
			 redirect('admin/report_cat');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

     public function add_report_cat()
     {

        if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		    }
			$data1 = array(
			'cat_name' => $this->input->post('cat_name'),'cat_sim' => $this->input->post('cat_sim'),'cat_tra' => $this->input->post('cat_tra'),'type' => $this->input->post('type'));
			 $id = $this->admin_model->add_data($data1,'reports_cat');
			 if( $id ){
			     $this->session->set_flashdata('success_msg', 'Successfully Added!');
			     redirect('admin/report_cat');
			 }else{
				  $this->session->set_flashdata('success_msg', 'Not  Added!');
			 }

           }
           else{
			   redirect('admin/login');
		   }
     }

     public function reports_info()
     {

        if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin' && $this->session->userdata('user_type')!='translator') {
			 redirect('admin/index');
		    }

		    $data['title']='Translate Report List';
		    $data['file']='admin/report_list';
		    $data['reports']=$this->admin_model->PaidReportsRequest();
		    $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }
      public function reports_info_ajax()
     {
		 if(@$_FILES){
		   $config['upload_path']   =   './public/uploads/reports/';
		   $config['allowed_types'] =   "*";
		   $this->load->library('upload',$config);
		   $this->upload->initialize($config);
			   if(!$this->upload->do_upload('report_file')){
					$this->upload->display_errors();
					echo "0";
			   }
			   else
			   {
				   $data = $_POST;
                      // print_r($_POST);exit;
				   $finfo=$this->upload->data();
				   $data['report_file'] = $finfo['file_name'];
				   $data['created'] = date('Y-m-d');
				   $data['translated_by'] = $this->session->userdata('user_id');
				   $payment_id = $_POST['payment_id'];
				   $id = $this->admin_model->add_data($data,'translated_reports');
				   $this->admin_model->edit_data($data['report_id'],array('translate'=>'Y'),'reports');
				   $this->admin_model->edit_data($payment_id,array('translate'=>'Y'),'payment');
				   echo "1";
			   }
		   }
	 }
	 public function change_price()
     {

        if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		    }

		    $data['title']='Change Price';
		    $data['file']='admin/change_price';
		     $data['price']=$this->admin_model->single_data_of_table(array('id'=>5),'other_options');
		     $data['cprice1']=$this->admin_model->single_data_of_table(array('id'=>7),'other_options');
		     $data['cprice2']=$this->admin_model->single_data_of_table(array('id'=>8),'other_options');
		     if(isset($_POST['submit'])){
				 $id = 5;
				 $data1 = array('content' => $this->input->post('price'));
				 $this->admin_model->edit_data($id,$data1,'other_options');
				 $this->admin_model->edit_data(7,array('content' => $this->input->post('cprice1')),'other_options');
				 $this->admin_model->edit_data(8,array('content' => $this->input->post('cprice2')),'other_options');
				 $this->session->set_flashdata('success_msg', 'Successfully Upldated!');
			     redirect('admin/change_price');
			 }
			 $this->load->view('template_admin',$data);


           }
           else{
			   redirect('admin/login');
		   }
     }
	 public function package_name()
	 {
		 if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		    }
			$data['title']='Package Name';
		    $data['file']='admin/package_name_list';

			$data['package_name']=$this->admin_model->package_name();
			$this->load->view('template_admin',$data);
		}else{
			   redirect('admin/login');
		}
	 }
	 public function edit_package_name()
	 {
		if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		    }
			$id = $_GET['id'];
			$data['title']='Package Name';
		    $data['file']='admin/edit_package';

			$data['package_detail']=$this->admin_model->edit_package_name($id);
			if(isset($_POST['submit'])){
				 $data1 = array('english_name' => $this->input->post('english_name'),'traditional_chinese_name' => $this->input->post('traditional_chinese_name'),'simplified_chinese_name' => $this->input->post('simplified_chinese_name'));
				 $this->admin_model->edit_package_name_detail($id,$data1,'package_name');
				 $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			     redirect('admin/package_name');
			 }
			$this->load->view('template_admin',$data);
		}else{
			   redirect('admin/login');
		}
	 }



	 /************************ Services **************************/


	  public function services()
     {

        if($this->session->userdata('loginadmin')) {
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $data['title']='Manage Services';
		 $data['file']='admin/services';
		 $data['locations']=$this->admin_model->all_data_of_table('services');
		 $data['service_cat']=$this->admin_model->all_data_of_table('service_cat');
		 if(isset($_POST['delete'])){
			 $id = $_POST['delete'];
			 $this->admin_model->deletedata_from_tables($id,'services');
			 redirect('admin/services');
		 }
		 if(isset($_POST['delete1'])){
			 $id = $_POST['delete1'];
			 $this->admin_model->deletedata_from_tables($id,'service_cat');
			 redirect('admin/services');
		 }
		 $this->load->view('template_admin',$data);

           }
           else{
			   redirect('admin/login');
		   }
     }

     public function add_services()
     {

        if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		    }
			$data1 = array(
			'service_name' => $this->input->post('service_name'),'service_name_s' => $this->input->post('service_name_s'),'service_name_t' => $this->input->post('service_name_t'),'price' => $this->input->post('price'),'cat_id' => $this->input->post('category'));
			 $id = $this->admin_model->add_data($data1,'services');
			 if( $id ){
			     $this->session->set_flashdata('success_msg', 'Successfully Added!');
			     redirect('admin/services');
			 }else{
				  $this->session->set_flashdata('success_msg', 'Not  Added!');
			 }

           }
           else{
			   redirect('admin/login');
		   }
     }

	  /*
	 * creator:- Anjali Khurana
	 * function:- edit_service
	 * description:- edit service in services table
	 */
     public function edit_service()
     {

        if($this->session->userdata('loginadmin')){
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $id = $_GET['id'];
         $data['title']='Edit Service';
         $data['type']='s';
		 $data['file']='admin/edit_services';
		 $data['service_cat']=$this->admin_model->all_data_of_table('service_cat');
		 $services = $this->admin_model->get_datas_of_table(array('id'=>$id),'services');
		 $data['services'] = $services[0];
		 if(isset($_POST['submit'])){
			 $data = array(
			'service_name' => $this->input->post('service_name'),'service_name_s' => $this->input->post('service_name_s'),'service_name_t' => $this->input->post('service_name_t'),'price' => $this->input->post('price'),'cat_id' => $this->input->post('category'));
			 $this->admin_model->edit_data($id,$data,'services');
			  $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			  redirect('admin/services');
		    }
		    $this->load->view('template_admin',$data);
		 }
           else{
			   redirect('admin/login');
		   }
     }


	  public function add_category()
     {

        if($this->session->userdata('loginadmin')){
			if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		    }
			$data1 = array(
			'cat_name' => $this->input->post('cat_name'),'cat_name_s' => $this->input->post('cat_name_s'),'cat_name_t' => $this->input->post('cat_name_t'));
			 $id = $this->admin_model->add_data($data1,'service_cat');
			 if( $id ){
			     $this->session->set_flashdata('success_msg', 'Successfully Added!');
			     redirect('admin/services');
			 }else{
				  $this->session->set_flashdata('success_msg', 'Not  Added!');
			 }

           }
           else{
			   redirect('admin/login');
		   }
     }


	 public function edit_category()
     {

        if($this->session->userdata('loginadmin')){
		if($this->session->userdata('user_type')!='admin') {
			 redirect('admin/index');
		 }
         $id = $_GET['id'];
         $data['type']='c';
         $data['title']='Edit Category';
		 $data['file']='admin/edit_services';
		 $data['service_cat']=$this->admin_model->all_data_of_table('service_cat');
		 $category = $this->admin_model->get_datas_of_table(array('id'=>$id),'service_cat');
		 $data['category'] = $category[0];
		 if(isset($_POST['submit'])){
			 $data = array('cat_name' => $this->input->post('cat_name'), 'cat_name_s' => $this->input->post('cat_name_s'), 'cat_name_t' => $this->input->post('cat_name_t'));
			 $this->admin_model->edit_data($id,$data,'service_cat');
			  $this->session->set_flashdata('success_msg', 'Successfully Updated!');
			  redirect('admin/services');
		    }
		    $this->load->view('template_admin',$data);
		  }
           else{
			   redirect('admin/login');
		   }
          }

     public function ForgotPassword()
         {
			
			 if($_POST['change']){
         $email = $this->input->post('email');      
         $findemail = $this->admin_model->ForgotPassword($email);  
         if($findemail){
			 // echo "yes";
			 // print_r($findemail);
			 
          $this->admin_model->sendpassword($findemail);        
           }
		   else{
          $this->session->set_flashdata('msg',' Email not found!');
         
      }
	   redirect('admin/login');
			 }
   } 
   public function Ressetpassword($resetlink)
         {
		
	 if(isset($resetlink)){
         	
         $fuser = $this->admin_model->dbResetpassword($resetlink); 
    	
  
				
         if($fuser){

			 $date = date('Y-m-d H:i:s');  
		 $dbdate=$fuser['link_date'];	
		 // $dbdate="2013-11-11 16:27:21";	
         
		 $timediff = strtotime($date) - strtotime($dbdate);
			if($timediff > 86400){ 
			
				 $this->session->set_flashdata('msg',' Link Expired');
				 $data['error']="<h1>Link Expired</h1>";
                 $this->load->view('admin/forgetpass',$data);
		  	
				}
				else
				{
				 $data['fuser']=$fuser;
				$this->load->view('admin/forgetpass',$data);
			}		
			  
           
           }
		   else{
         $this->session->set_flashdata('msg',' Invalid Link');
       redirect('admin/login');
		  		
      } 
			 } 
   }

	  public function resetpass()
     {
		
	if($_POST['change'])
	  { 
	   if($_POST['new_pass']==$_POST['c_pass'])
	      {
		   $pswd=md5($_POST['new_pass']);
		   $id=$_POST['id'];
		
		   $data = array(
	      'password' => $pswd,
	      );
	     $this->admin_model->update_password($id,$data,'users');
		 $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Password Changed.</div>');
		redirect('admin/login');
	      }
	    }
	}
	 public function changepass()
     {
		 // echo"<pre>";print_r($_POST);echo"</pre>";  
		 // return;
		 if($_POST['change']){ if($_POST['password']==$_POST['cpassword']){
		   $pswd=md5($_POST['password']);
		   $id=$_POST['id'];
		   $type=$_POST['type'];
		  $data = array(
	   'password' => $pswd,
	   );
	  $this->admin_model->update_password($id,$data,'users');
	   }}
	}

    public function appointments_list()
          {
			  if($this->session->userdata('user_type')=="doctor"){
				  echo "dr";
			  }
			   $data['reports']=$this->admin_model->check_appointments('doctor',2);
			
		 $this->load->view('admin/appointments_list',$data);
		  }
	public function test()
          {
				  // $data=$this->admin_model->dbget_user();
				  $data=$this->admin_model->check_appointments('doctor',2);
				  // $data=$this->admin_model->createNewField();
				// your first date coming from a mysql database (date fields) 
			/* 	$dateA = '2013-11-12 23:10:30'; $dateB = '2013-11-11 16:27:21'; 
				echo  $date = date('Y-m-d H:i:s');$timediff = strtotime($dateA) - strtotime($dateB);
           echo $timediff;if($timediff > 86400){ 
				echo 'more than 24 hours';}else
				{echo 'less than 24 hours';
			}// return $result;
					 */echo"<pre>";print_r($data);echo"</pre>";
		}
}
