<?php
class admin_model extends CI_Model {

	function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function get_user($usr, $pwd)
     {
          $sql = "select * from users where email = '" . $usr . "' and password = '" .md5($pwd). "'";
          $query = $this->db->query($sql);
          return $query->row_array();

     }

	 //get the categories from categories
     function all_users($type)
     {
		  $this->db->select('*');
		  $this->db->where('type',$type);
          $query = $this->db->get('users');
          return $query->result_array();

     }
	 //get the categories from categories
     function all_patient($val)
     {

		 if($val=='0'){
		   	$sql = "select u.id,u.fname,u.lname,u.email,u.phoneno,u.created,u.address ,a.gender,a.id_card ,a.dob ,a.nationality ,a.country_code ,a.country_name  from users as u INNER JOIN patient_tbl as a ON a.user_id = u.id WHERE u.type ='patient'";
		   	$query = $this->db->query($sql);
		   return $query->result_array();
	     }else{
           return $this->db->query("select u.id,u.fname,u.lname,u.email,u.phoneno,u.created,u.address ,a.gender,a.id_card ,a.dob ,a.nationality ,a.country_code ,a.country_name  from users as u INNER JOIN patient_tbl as a ON a.user_id = u.id INNER JOIN authorized_doctors as ad on u.id = ad.user_id where u.type = 'patient' and ad.doc_id=".$val." GROUP BY u.id")->result_array();
		 }

     }

	 //get the subcategories from sub_category table with main cat id
     function get_single_user($id)
     {$this->db->select('*');
          $query = $this->db->get_where('users', array('id' => $id));
	       return $query->row_array();
     }


	//add category to categories table
	public function add_data($data,$table_name) {
	 $this->db->insert($table_name, $data);
	return $this->db->insert_id();
	}

	//edit category of categories table
	public function edit_data($id,$data,$table_name) {
     $this->db->where('id', $id);
	 if($this->db->update($table_name, $data)) return true;
	 else return false;
	}

	public function edit_user($id,$data,$table_name) {
     $this->db->where('user_id', $id);
	 if($this->db->update($table_name, $data)) return true;
	 else return false;
	}

	function change_status($id , $tbl_name)
     {
	     $sql = "select status from ".$tbl_name." WHERE id = $id";
          $query = $this->db->query($sql);
          $res = $query->row_array();
		  $status = $res['status'];
		  $status = (($status=='1')? '0' : '1');
        $data = array(
		'status' => $status,
		);
		 $this->db->where('id', $id);
		 $this->db->update($tbl_name, $data);
		 return $status;
     }


	function check_phoneno($phoneno){
		$this->db->where(array('phoneno'=>$phoneno));
		$query = $this->db->get('users');
		if($query->num_rows()==0){
			return "true";
		}
        else{
			return "false";
		}
	}

	function check_email($email){
		$this->db->where(array('email'=>$email));
		$query = $this->db->get('users');
		if($query->num_rows()==0){
			return "true";
		}
        else{
			return "false";
		}
	}

	function deletedata_from_tables($id, $table)
     {
		 $this->db->delete($table, array('id'=>$id));

     }

	function deletedata_from_tables1($id, $table)
     {
		 $this->db->delete($table, array('user_id'=>$id));

     }
	function deletedata_where_tables($where, $table)
     {
		 $this->db->delete($table, $where);

     }

	//get the data from tables
     function all_data_of_table($tablename)
     {
          $query = $this->db->get($tablename);
          return $query->result_array();

     }
	//get the data from tables
     function single_data_of_table($where,$tablename)
     {
		 $this->db->where($where);
          $query = $this->db->get($tablename);
          return $query->row_array();

     }
	//get the data from tables
     function get_datas_of_table($where,$tablename)
     {
		 $this->db->where($where);
          $query = $this->db->get($tablename);
          return $query->result_array();

     }

     //get the data from tables
     function non_available_dates($type,$user_id)
     {
		 $this->db->where(array('type'=>$type));
		 $this->db->where(array('user_id'=>$user_id));
          $query = $this->db->get('nonavailable_dates');
          return $query->result_array();

     }
     function check_available_dates($nondate, $type,$user_id)
     {
		 $this->db->where(array('type'=>$type,'nondate' => $nondate,'user_id' => $user_id));
          $query = $this->db->get('nonavailable_dates')->result_array();
          //echo "dsa  ".count($query)."  dasdas";
          	/*echo $this->db->last_query();
          	print_r($query);*/
        	if(count($query) == 0){
				return true;
			}
        	else{
				return false;
			}

     }
     function others_non_available_dates($type,$user_id)
     {
		$query=$this->db->query("SELECT n.*,u.fname,u.lname FROM nonavailable_dates as n INNER JOIN users as u ON u.id=n.user_id AND (u.type='admin' OR u.type='doctor')  WHERE n.user_id!='$user_id' AND n.type!='$type'
		UNION ALL
		SELECT n.*,u.clinic_name as fname,u.clinic_type as lname FROM nonavailable_dates as n INNER JOIN users as u ON u.id=n.user_id AND u.type='medical'  WHERE n.user_id!='$user_id' AND n.type!='$type'
		")->result_array();
        return $query;

     }
     function disabled_dates_remove($nondate, $type,$user_id)
     {
		 $this->db->delete('nonavailable_dates', array('nondate'=>$nondate,'user_id'=>$user_id));

     }

     function check_appointments($type,$user_id){
		 if($type=='admin'){
		   $sql = "select a.id,a.clinic_id as did ,a.user_id,a.loc_id,a.booking_date,a.package_id,a.services_id, a.booking_s_time, a.booking_e_time , u.fname , u.lname , u1.clinic_name as doc_fname, u1.clinic_type as doc_lname from appointments as a INNER JOIN users as u on a.user_id = u.id INNER JOIN users as u1 on a.clinic_id = u1.id  where a.clinic_id!='0' and a.paid ='y'
		   UNION ALL
		   select a.id,a.doc_id as did ,a.user_id,a.loc_id,a.booking_date,a.package_id,a.services_id, a.booking_s_time, a.booking_e_time , u.fname , u.lname , u1.fname as doc_fname, u1.lname as doc_lname from appointments as a INNER JOIN users as u on a.user_id = u.id INNER JOIN users as u1 on a.doc_id = u1.id  where a.doc_id!='0'  and a.paid ='y'";
		 }elseif($type=='medical'){
		   $sql = "select a.id,a.clinic_id as did ,a.user_id,a.loc_id,a.booking_date, a.package_id,a.services_id,a.booking_s_time, a.booking_e_time , u.fname , u.lname , u1.clinic_name as doc_fname, u1.clinic_type as doc_lname from appointments as a INNER JOIN users as u on a.user_id = u.id INNER JOIN users as u1 on a.clinic_id = u1.id  where a.paid ='y' and a.clinic_id=".$user_id;
		 }else{
		   $sql = "select a.id,a.doc_id as did , a.user_id,a.loc_id,a.booking_date, a.package_id,a.services_id,a.booking_s_time, a.booking_e_time , u.fname , u.lname , u1.fname as doc_fname, u1.lname as doc_lname from appointments as a INNER JOIN users as u on a.user_id = u.id INNER JOIN users as u1 on a.doc_id = u1.id where a.paid ='y' and a.doc_id=".$user_id;
		 }
          $query = $this->db->query($sql);
          return $query->result_array();
	 }

     function get_einformation($type,$user_id){
		 //if($type == 'admin'){
		   $sql = "select a.*  from einformation as a";
	    /* }else{
			$sql = "select a.* , u.fname , u.lname from einformation as a INNER JOIN users as u on a.user_id = u.id where user_id=".$user_id;
		 }*/
         $query = $this->db->query($sql);
         return $query->result_array();
	 }

	 //get the data from tables
     function get_other_images($type,$lang)
     {
		 $this->db->where(array('type'=>$type,'lang'=>$lang));
          $query = $this->db->get('other_options_images');
          return $query->result_array();

     }


     //edit category of categories table
	public function edit_data1($id,$data,$table_name) {
		 $this->db->where('einfo_id', $id);
		 if($this->db->update($table_name, $data)) return true;
		 else return false;
	}

	function assigned_users1($user_id){
		 $sql1 = "select * from locations where user_id=".$user_id;
			  $query1 = $this->db->query($sql1);
			  return $query1->result_array();
	}
	 function update_users_address($user_id,$type,$address,$address_s,$address_t,$district,$district_s,$district_t,$lat,$long){

	      $w_choice = $this->assigned_users1($user_id);
		  $count1 = count($address);
          $count2 = count($w_choice);
          if($count1 > $count2){

			   for($i=0;$i<$count1;$i++){
			   if(array_key_exists($i,$w_choice)){

				   if($address[$i] != ''){
					   $data11 = array('address'=>$address[$i],'address_s'=>$address_s[$i],'address_t'=>$address_t[$i],'district'=>$district[$i],'district_s'=>$district_s[$i],'district_t'=>$district_t[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                     $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('locations', $data11);
				   }
                  }else{
					  if($address[$i] != ''){
				    $data11 = array('address'=>$address[$i],'address_s'=>$address_s[$i],'address_t'=>$address_t[$i],'district'=>$district[$i],'district_s'=>$district_s[$i],'district_t'=>$district_t[$i],'lat'=>$lat[$i],'long'=>$long[$i],'user_id'=>$user_id,'type'=>$type);
                    $this->db->insert('locations', $data11);
					}
				  }
			   }
		  }
		  elseif($count1 < $count2){
		  for($i=0;$i<$count2;$i++){
				  if(array_key_exists($i,$address)){
				   if($address[$i] != ''){
					$data11 = array('address'=>$address[$i],'address_s'=>$address_s[$i],'address_t'=>$address_t[$i],'district'=>$district[$i],'district_s'=>$district_s[$i],'district_t'=>$district_t[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                $this->db->update('locations', $data11);
				   }
                  }else{
                     $this->db->delete('locations', array('id' => $w_choice[$i]['id']));
				  }
			   }
		  }
		  else{
		      for($i=0;$i<$count2;$i++){
				 if(array_key_exists($i,$address)){

				   if($address[$i] != ''){
					   $data11 = array('address'=>$address[$i],'address_s'=>$address_s[$i],'address_t'=>$address_t[$i],'district'=>$district[$i],'district_s'=>$district_s[$i],'district_t'=>$district_t[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('locations', $data11);
				   }
                  }
			   }
		  }
	}


	//In Doctor panel edit profile there is no t_address and r_address feilds added api as per the post values from form
	function update_users_address_for_doctor($user_id,$type,$address,$lat,$long)
	{
		$w_choice = $this->assigned_users1($user_id);
		  $count1 = count($address);
          $count2 = count($w_choice);
          if($count1 > $count2){

			   for($i=0;$i<$count1;$i++){
			   if(array_key_exists($i,$w_choice)){

				   if($address[$i] != ''){
					   $data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                     $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('locations', $data11);
				   }
                  }else{
					  if($address[$i] != ''){
				    $data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i],'user_id'=>$user_id);
                    $this->db->insert('locations', $data11);
					}
				  }
			   }
		  }
		  elseif($count1 < $count2){
		  for($i=0;$i<$count2;$i++){
				  if(array_key_exists($i,$address)){
				   if($address[$i] != ''){
					$data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                $this->db->update('locations', $data11);
				   }
                  }else{
                     $this->db->delete('locations', array('id' => $w_choice[$i]['id']));
				  }
			   }
		  }
		  else{
		      for($i=0;$i<$count2;$i++){
				 if(array_key_exists($i,$address)){

				   if($address[$i] != ''){
					   $data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('locations', $data11);
				   }
                  }
			   }
		  }
	}


	function update_pack_services($package_id,$services){

	      $w_choice = $this->get_datas_of_table(array('package_id'=>$package_id),'service_with_pack');
		  $count1 = count($services);
          $count2 = count($w_choice);
          if($count1 > $count2){

			   for($i=0;$i<$count1;$i++){
			   if(array_key_exists($i,$w_choice)){
				   if($services[$i] != ''){
					   $data11 = array('service_id'=>$services[$i]);
                     $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('service_with_pack', $data11);
				   }
                  }else{
					  if($services[$i] != ''){
				    $data11 = array('service_id'=>$services[$i],'package_id'=>$package_id);

                    $this->db->insert('service_with_pack', $data11);
					}
				  }
			   }
		  }
		  elseif($count1 < $count2){
		  for($i=0;$i<$count2;$i++){
				  if(array_key_exists($i,$services)){
				   if($services[$i] != ''){
					//   echo $w_choice[$i]['id'];
					   $data11 = array('service_id'=>$services[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('service_with_pack', $data11);
				   }
                  }else{
                     $this->db->delete('service_with_pack', array('id' => $w_choice[$i]['id']));
				  }
			   }
		  }
		  else{
		      for($i=0;$i<$count2;$i++){
				 if(array_key_exists($i,$services)){

				   if($services[$i] != ''){
					   $data11 = array('service_id'=>$services[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('service_with_pack', $data11);
				   }
                  }
			   }
		  }
	}


	function update_serv_packages($clinic_id,$services){

	      $w_choice = $this->get_datas_of_table(array('clinic_id'=>$clinic_id),'services_with_clinics');
		  $count1 = count($services);
          $count2 = count($w_choice);
          if($count1 > $count2){

			   for($i=0;$i<$count1;$i++){
			   if(array_key_exists($i,$w_choice)){
				   if($services[$i] != ''){
					   $data11 = array('service_id'=>$services[$i]);
                     $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('services_with_clinics', $data11);
				   }
                  }else{
					  if($services[$i] != ''){
				    $data11 = array('service_id'=>$services[$i],'clinic_id'=>$clinic_id);

                    $this->db->insert('services_with_clinics', $data11);
					}
				  }
			   }
		  }
		  elseif($count1 < $count2){
		  for($i=0;$i<$count2;$i++){
				  if(array_key_exists($i,$services)){
				   if($services[$i] != ''){
					//   echo $w_choice[$i]['id'];
					   $data11 = array('service_id'=>$services[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('services_with_clinics', $data11);
				   }
                  }else{
                     $this->db->delete('services_with_clinics', array('id' => $w_choice[$i]['id']));
				  }
			   }
		  }
		  else{
		      for($i=0;$i<$count2;$i++){
				 if(array_key_exists($i,$services)){

				   if($services[$i] != ''){
					   $data11 = array('service_id'=>$services[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('services_with_clinics', $data11);
				   }
                  }
			   }
		  }
	}


	/*function update_users_address($user_id,$type,$address,$lat,$long){

	      $w_choice = $this->assigned_users1($user_id);
		  $count1 = count($address);
          $count2 = count($w_choice);
          if($count1 > $count2){

			   for($i=0;$i<$count1;$i++){
			   if(array_key_exists($i,$w_choice)){

				   if($address[$i] != ''){
					   $data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                     $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('locations', $data11);
				   }
                  }else{
					  if($address[$i] != ''){
				    $data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i],'user_id'=>$user_id,'type'=>$type);
                    $this->db->insert('locations', $data11);
					}
				  }
			   }
		  }
		  elseif($count1 < $count2){
		  for($i=0;$i<$count2;$i++){
				  if(array_key_exists($i,$address)){
				   if($address[$i] != ''){
					$data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                $this->db->update('locations', $data11);
				   }
                  }else{
                     $this->db->delete('locations', array('id' => $w_choice[$i]['id']));
				  }
			   }
		  }
		  else{
		      for($i=0;$i<$count2;$i++){
				 if(array_key_exists($i,$address)){

				   if($address[$i] != ''){
					   $data11 = array('address'=>$address[$i],'lat'=>$lat[$i],'long'=>$long[$i]);
                    $this->db->where('id', $w_choice[$i]['id']);
	                 $this->db->update('locations', $data11);
				   }
                  }
			   }
		  }
	}
	*/

	 function getAllReports($user_id)
     {

		$result=array();
		$upload_path=base_url()."public/uploads/reports/";
		return $this->db->query("SELECT r.id as report_id,r.report_number,r.r_date as report_date,rc.cat_name,r.item,CONCAT('$upload_path', r.report_file ) as report_file,u.fname,u.lname,u.clinic_name FROM reports as r INNER JOIN reports_cat as rc ON rc.id=r.report_type INNER JOIN users as u on r.uploaded_by = u.id WHERE r.user_id=".$user_id)->result_array();
	 }

	 function PaidReportsRequest()
     {
		$result=array();
		$upload_path=base_url()."public/uploads/reports/";
		return $this->db->query("SELECT p.*,u.fname,u.lname,r.report_number,CONCAT('$upload_path', r.report_file ) as report_file FROM payment as p INNER JOIN users as u ON u.id=p.user_id inner join reports as r on r.id = p.report_id and u.id=r.user_id")->result_array();
	 }


	function getPatientDetails($id){
		$sql = "select u.fname,u.lname,u.email,u.phoneno,u.created,u.address ,a.gender,a.id_card ,a.dob ,a.nationality ,a.country_code ,a.country_name  from users as u INNER JOIN patient_tbl as a ON a.user_id = u.id WHERE u.id =".$id;
          $query = $this->db->query($sql);
	    return $query->row_array();

	}

	function check_docs_patients($patient_id , $o_id){
	   return $this->db->query("select * FROM authorized_doctors where doc_id=".$o_id. " and user_id =" .$patient_id)->num_rows();
	}
	function check_docs_patients1($patient_id , $o_id){
	   return $this->db->query("select * FROM appointments where doc_id=".$o_id. " and user_id =" .$patient_id)->num_rows();
	}

	public function package_name()
	{
		$result=$this->db->query("SELECT * FROM package_name ORDER BY id DESC")->result_array();
		return $result;
	}
	public function edit_package_name($id)
	 {
		 $result=$this->db->query("SELECT * FROM package_name WHERE id='$id'")->row_array();
		 return $result;
	 }
	 public function edit_package_name_detail($id,$data1,$table_name)
	 {
		 $this->db->where('id', $id);
		 if($this->db->update($table_name, $data1)) return true;
		 else return false;
	 }
	 public function package_detail($appointment_id,$package_id)
	 {
		 $result=$this->db->query("SELECT p.amount,pac.package_name FROM payment as p INNER JOIN packages as pac ON p.package_id=pac.id WHERE p.appointment_id='$appointment_id' AND p.package_id='$package_id'")->row_array();
		 return $result;
	 }
	 public function service_detail($appointment_id,$service_id)
	 {
		 $result=$this->db->query("SELECT p.amount,s.service_name FROM payment as p INNER JOIN services as s ON p.service_id=s.id WHERE p.appointment_id='$appointment_id' AND p.service_id='$service_id'")->row_array();
		 return $result;
	 }
	  public function location_detail($appointment_id,$service_id)
	 {
		 $result=$this->db->query("SELECT p.amount,s.service_name FROM payment as p INNER JOIN services as s ON p.service_id=s.id WHERE p.appointment_id='$appointment_id' AND p.service_id='$service_id'")->row_array();
		 return $result;
	 }
	 /*---------ekamjot code------------*/
	   function dbget_user()
     {
          $sql = "select * from users where email='mary@gmail.com'";
          $query = $this->db->query($sql);
          return $query->row_array();
          // $data = array('password' => md5('admin@gmail.com'));
        // /*  $this->db->where('id', 1);*/
          // $this->db->where('email', 'admin@gmail.com');
          // $this->db->update('users', $data);
	 }   
	 function get_userOldPswd($id,$old,$table_name)
     {
          $sql = "select * from users where id=".$id." AND password='".$old."' ";
          $query = $this->db->query($sql);
         $query->row_array();
			  return $rowcount = $query->num_rows();
        
        /*  $this->db->where('id', 1);*/
        
	 } 
	  function createNewField()
     {
          // $sql = "ALTER TABLE users ADD forget_date VARCHAR( 255 ) after forget_link";
          $sql = "ALTER TABLE users ADD `link_date`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER  forget_link";
		  // ALTER TABLE `content` ADD `link_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`;
          $query = $this->db->query($sql);
         $query->row_array();
			  // return $rowcount = $query->num_rows();
        
        /*  $this->db->where('id', 1);*/
        
	 } 
	 public function update_password($id,$data,$table_name)
	 {
		 $this->db->where('id', $id);
		 if($this->db->update($table_name, $data)) return true;
		 else return false;
	}
	//funtion to get email of user to send password
	public function ForgotPassword($email)
	{
        $this->db->select('email');
        $this->db->from('users'); 
        $this->db->where('email', $email); 
        $query=$this->db->get();
        return $query->row_array();
	}
	
	public function sendpassword($data)
	{
        $email = $data['email'];
        $query1=$this->db->query("SELECT *  from users where email = '".$email."' ");
        $row=$query1->result_array();
	// print_r($row);
        if ($query1->num_rows()>0)
      
		{
       $passwordplain = "";
    
       $passwordplain2  = rand(9999999,9999999999999999999999);
	   // $reseturl='http://playtripapp.com'.base_url().'admin/Ressetpassword/'. $passwordplain2.'';
	   $reseturl='http://playtripapp.com/wordpress/myhealthdev/admin/Ressetpassword/'. $passwordplain2.'';
	  
	  $Uid= $row[0]['id'];
       $newpass['forget_link'] =$passwordplain2;
        $newpass['forget_date'] = date('y-m-d');
	   $this->db->where('id', $Uid);
       $this->db->update('users', $newpass); 
	   $this->load->library('email');
	               $config = array (
					  'mailtype' => 'html',
					  'charset'  => 'utf-8',
					  'priority' => '1'
					   );
				   $this->email->initialize($config);
				   $this->email->from('example@vooap.com', 'Myhealth');
				   // $this->email->to($email);
				   $this->email->to("testplanet317@gmail.com");
				  
				   $this->email->subject('Welcome To Myhealth');
				   $mail_message='Dear ,'. "\r\n";
         $mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b>Password</b> is '.$reseturl.''."\r\n";
        $mail_message.='<br>Please Update your password.';
        $mail_message.='<br>Thanks & Regards';
        $mail_message.='<br>Your company name'; 
		$this->email->message($mail_message);
			
	   
      
		if (!$this->email->send()) {
			 $this->session->set_flashdata('msg','Failed to send password, please try again!');
		} 
		else {
		   $this->session->set_flashdata('msg','Link  Send To Your Email. Please Check Your Mail');
		}
		  redirect('admin/login');        
		}
		else
		{  
		 $this->session->set_flashdata('msg','Email not found try again!');
		 redirect(base_url().'admin/login');
		}
   }
   public function dbResetpassword($link)
	{
		
        $this->db->select('*');
        $this->db->from('users'); 
        $this->db->where('forget_link', $link); 
        $query=$this->db->get();
        return $query->row_array();
	}  
	public function dbappointments_list($link)
	{
		
        $this->db->select('*');
        $this->db->from('users'); 
        $this->db->where('forget_link', $link); 
        $query=$this->db->get();
        return $query->row_array();
	}
	
}
