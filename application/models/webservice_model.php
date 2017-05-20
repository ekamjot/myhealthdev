 <?php

class Webservice_model extends CI_Model
{
	function checkphoneno($tel_no,$code,$user_id){
		if($user_id==0){
		 $sql = "select u.id from users as u INNER JOIN patient_tbl as a ON a.user_id = u.id WHERE u.phoneno ='".$tel_no."' and a.country_code = '".$code."'";
	    }else{
		 $sql = "select u.id from users as u INNER JOIN patient_tbl as a ON a.user_id = u.id WHERE u.phoneno ='".$tel_no."' and a.country_code = '".$code."' and u.id !=".$user_id;
	     }
          $query = $this->db->query($sql);
		$res=$query->row_array();
		if($query->num_rows()==0){
			return 1;
		}
        else{
			return $res;
		}
	}
		//for checkpassword in user

	function checkpass($pass,$phoneno,$code){
		$sql = "select u.id from users as u INNER JOIN patient_tbl as a ON a.user_id = u.id WHERE u.phoneno ='".$phoneno."' and a.country_code = '".$code."' and u.password='".$pass."' and u.type='patient'";
          $query = $this->db->query($sql);
	    $res=$query->row_array();
		if($query->num_rows()==0){
			return 1;
		}
		else{
			return 0;
		}
	}

	function check_email($email){
		$this->db->where(array('email'=>$email));
		$query = $this->db->get('users');
		if($query->num_rows()==0){
			return true;
		}
        else{
			return false;
		}
	}


		//for login in user

	function login($data) {
		$this->db->select('id,lname,fname,email,address,status');
		$this->db->where(array('phoneno'=>@$data['phoneno'],'password'=>@$data['password'],'type'=>'patient'));
		$query = $this->db->get('users');
		$res=$query->row_array();
		if($query->num_rows()>0){
			return $res;
		}else{
			return 0;
		}
	}
	function newLogin($data){

		return $this->db->query("SELECT * FROM `users` JOIN patient_tbl on users.id = patient_tbl.user_id  WHERE  patient_tbl.id_card='".$data['identity_card']."'and users.password='".$data['password']."'")->row_array();
		// print_r($sql);
		// echo $this->db->last_query();exit;
	}


	//for update device type and device id in user
	function upd_dri($id,$device_id,$device_type){
		$this->db->where('id',$id);
		$this->db->update('users',array('device_id'=>$device_id,'device_type'=>$device_type));
	}


	function get_packages()
     {
		return $this->db->query("Select id,package_name,price,package_detail,CASE WHEN package_name_s = '' THEN package_name ELSE package_name_s END AS package_name_s ,CASE WHEN package_name_t = '' THEN package_name ELSE package_name_t END AS package_name_t,CASE WHEN package_detail_s = '' THEN package_detail ELSE package_detail_s END AS package_detail_s  ,CASE WHEN package_detail_t = '' THEN package_detail ELSE package_detail_t END AS package_detail_t from packages")->result_array();

     }


     function get_services($package_id)
     {
		return $this->db->query("Select s.id, s.service_name,  s.price,CASE WHEN  s.service_name_s = '' THEN  s.service_name ELSE  s.service_name_s END AS  service_name_s ,CASE WHEN  s.service_name_t = '' THEN  s.service_name ELSE  s.service_name_t END AS  service_name_t from services as s INNER JOIN service_with_pack as p ON s.id = p.service_id WHERE p.package_id = ".$package_id)->result_array();

     }

     function get_all_services()
     {
		$rr = $this->db->query("Select s.id, s.cat_name, CASE WHEN  s.cat_name_s = '' THEN  s.cat_name ELSE  s.cat_name_s END AS  cat_name_s ,CASE WHEN  s.cat_name_t = '' THEN  s.cat_name ELSE  s.cat_name_t END AS  cat_name_t from service_cat as s ")->result_array();
		$i = 0;
		foreach($rr as $r){
		   $rr[$i]['services'] =  $this->db->query("Select s.id, s.service_name,  s.price,CASE WHEN  s.service_name_s = '' THEN  s.service_name ELSE  s.service_name_s END AS  service_name_s ,CASE WHEN  s.service_name_t = '' THEN  s.service_name ELSE  s.service_name_t END AS  service_name_t from services as s WHERE s.cat_id =".$r['id'])->result_array();
		   ++$i;
	    }
	    return $rr;

     }

	/************** below 3 functions to repeat   *******************/
    //for insert data to tables
	public function addDatatoTable($data,$table_name)
	 {
	  $this->db->insert($table_name,$data);
	  $last_id=$this->db->insert_id();
	  if($last_id > 0){
		 return $last_id;
	  }
	  else{
	   return false;
	   }
	 }

	 //delete data from tables
	 function delete_data($id,$tbl_name)
     {
		  if($this->db->delete($tbl_name, array('id' => $id))) return true;
		  else return false;
     }

	 //update data from tables
	 function get_data_with_type($col_key,$col_value,$table_name,$select)
     {
		 $this->db->select($select,FALSE);
		  $this->db->where(array($col_key=>$col_value));
          $query = $this->db->get($table_name);
          return $query->result_array();

     }

     function get_all_data($table_name)
     {
          return $this->db->get($table_name)->result_array();

     }

     function get_single_data($where,$table_name,$select)
     {
		 $this->db->select($select);
		  $this->db->where($where);
          $query = $this->db->get($table_name);
          return $query->row_array();

     }

	 //update data from tables
	 function get_data_with_type1($where,$table_name,$select)
     {
		 $this->db->select($select);
		  $this->db->where($where);
          $query = $this->db->get($table_name);
          return $query->result_array();

     }

	 /************** above 3 functions to repeat   *******************/

	 //get id of user using phone_no
	 public function get_user_id($tel_no,$code)
	 {
		$sql = "select u.id from users as u INNER JOIN patient_tbl as a ON a.user_id = u.id WHERE u.phoneno ='".$tel_no."' and a.country_code = '".$code."'";
          $query = $this->db->query($sql);
		$res=$query->row_array();
		return $res['id'];
	 }


	  //get clinic and doctor in english version
	 public function get_all_clinics_using_services($lang,$services_id )
	 {
		 $count = count(explode(',',$services_id));
		  $upload_path=base_url()."public/uploads/";
		if($lang=='E'){
		  $sql = "select u.id,u.clinic_name,u.clinic_type,u.phoneno,u.fax,l.address,l.district,u.introduction, u.service_start_time, u.service_end_time,CONCAT('".$upload_path."', picture ) as picture  from users as u INNER JOIN locations as l ON l.user_id = u.id WHERE u.type ='medical' and u.id  IN (select clinic_id from services_with_clinics where service_id IN (".$services_id.")  GROUP BY clinic_id HAVING COUNT(*) = ".$count.")";
	  }else{
		 if($lang == 'T')
        {  $field = "(CASE WHEN l.address_t = '' THEN l.address ELSE l.address_t END)         as      address,(CASE WHEN l.district_t = '' THEN l.district ELSE l.district_t END) as district ";
			   $tbl_name = 'users_traditional';
		   }
		  else {$field = "(CASE WHEN l.address_s = '' THEN l.address ELSE l.address_s END)  as address,(CASE WHEN l.district_s = '' THEN l.district ELSE l.district_s END) as district " ;
			  $tbl_name = 'users_simplified';
		  }
		  $sql = "select u.id,CASE WHEN o.clinic_name = '' THEN u.clinic_name ELSE o.clinic_name END as clinic_name, CASE WHEN o.clinic_type = '' THEN u.clinic_type ELSE o.clinic_type END as clinic_type, CASE WHEN o.introduction = '' THEN u.introduction ELSE o.introduction END as introduction,u.phoneno,u.fax,".$field .", u.service_start_time, u.service_end_time,CONCAT('".$upload_path."', picture ) as picture  from users as u INNER JOIN ".$tbl_name." as o on u.id = o.user_id INNER JOIN locations as l ON l.user_id = u.id WHERE u.type ='medical' and u.id  IN (select clinic_id from services_with_clinics where service_id IN (".$services_id.")  GROUP BY clinic_id HAVING COUNT(*) = ".$count.")";
	  }
        $query = $this->db->query($sql);
		return $query->result_array();
	 }


	 //get clinic and doctor in english version
	 public function get_all_clinics($type)
	 {
		  $upload_path=base_url()."public/uploads/";
		if($type=='D'){
		  $sql = "select u.id ,u.fname,u.lname,u.clinic_name,u.phoneno,u.introduction, u.education,u.service_start_time, u.service_end_time,CASE WHEN u.picture IS NULL or u.picture = ''
		THEN CONCAT('".$upload_path."dummy.png',u.picture)
		ELSE CONCAT('".$upload_path."',u.picture)
		END AS picture from users as u WHERE u.type ='doctor' GROUP BY u.id";
	  }else{
		  $sql = "select u.id,u.clinic_name,u.clinic_type,u.phoneno,u.fax,l.address,l.district,u.introduction, u.service_start_time, u.service_end_time,CASE WHEN u.picture IS NULL or u.picture = ''
		THEN CONCAT('".$upload_path."dummy.png',u.picture)
		ELSE CONCAT('".$upload_path."',u.picture)
		END AS picture from users as u INNER JOIN locations as l ON l.user_id = u.id WHERE u.type ='medical'";
	  }
    $query = $this->db->query($sql);
    //echo $this->db->last_query();
    //exit;
		return $query->result_array();
	 }

	 //get clinic and doctor in simplied and traditionalchinese version
	 public function get_all_clinics_other($type,$tbl_name)
	 {
		  $upload_path=base_url()."public/uploads/";
		if($type=='D'){
		  $sql = "select u.id ,CASE WHEN o.fname = '' THEN u.fname ELSE o.fname END AS fname, CASE WHEN o.lname = '' THEN u.lname ELSE o.lname END AS lname, CASE WHEN o.clinic_name = '' THEN u.clinic_name ELSE o.clinic_name END AS clinic_name, CASE WHEN o.introduction = '' THEN u.introduction ELSE o.introduction END AS introduction, CASE WHEN o.education = '' THEN u.education ELSE o.education END AS education,u.phoneno,u.service_start_time, u.service_end_time,CASE WHEN u.picture IS NULL or u.picture = ''
		THEN CONCAT('".$upload_path."dummy.png',u.picture)
		ELSE CONCAT('".$upload_path."',u.picture)
		END AS picture  from users as u INNER JOIN ".$tbl_name." as o on u.id = o.user_id WHERE u.type ='doctor' GROUP BY u.id";
	  }else{
		  if($tbl_name == 'users_traditional') $field = "(CASE WHEN l.address_t = '' THEN l.address ELSE l.address_t END)  as address,(CASE WHEN l.district_t = '' THEN l.district ELSE l.district_t END) as district ";
		  else $field = "(CASE WHEN l.address_s = '' THEN l.address ELSE l.address_s END)  as address,(CASE WHEN l.district_s = '' THEN l.district ELSE l.district_s END) as district " ;
		  $sql = "select u.id,CASE WHEN o.clinic_name = '' THEN u.clinic_name ELSE o.clinic_name END as clinic_name, CASE WHEN o.clinic_type = '' THEN u.clinic_type ELSE o.clinic_type END as clinic_type, CASE WHEN o.introduction = '' THEN u.introduction ELSE o.introduction END as introduction,u.phoneno,u.fax,".$field .", u.service_start_time, u.service_end_time,CASE WHEN u.picture IS NULL or u.picture = ''
		THEN CONCAT('".$upload_path."dummy.png',u.picture)
		ELSE CONCAT('".$upload_path."',u.picture)
		END AS picture  from users as u INNER JOIN ".$tbl_name." as o on u.id = o.user_id INNER JOIN locations as l ON l.user_id = u.id WHERE u.type ='medical'";
	  }
        $query = $this->db->query($sql);
		return $query->result_array();
	 }


	 //get the locations using lat and long
	 public function get_nonavailable_date_by_loc($user_id,$type)
	 {
	      $sql = "select a.nondate,   ".$user_id." as loc_id from users as u INNER JOIN nonavailable_dates as a ON a.user_id = u.id WHERE (u.id ='".$user_id."' OR u.id = 1 ) and u.type IN ('".$type."','admin') and a.nondate >= CURDATE()";
          $query = $this->db->query($sql);
          return $query->result_array();
	 }

	//update unique number for forgot password
	public function update_forgot($tel_no,$code,$data)
	 {
	 $user_id = $this->get_user_id($tel_no,$code);
	  $this->db->where('user_id',$user_id);
	 $this->db->update('patient_tbl',array('random_number'=>$data));
	 return 1;
	 }

	//update unique number for change phone number
	public function update_rand_no($user_id,$data)
	 {
	  $this->db->where('user_id',$user_id);
	 $this->db->update('patient_tbl',array('random_number'=>$data));
	 return 1;
	 }


	 //check user who change password
	 function check_random_number($tel_no , $code,$random_number){
		 $user_id = $this->get_user_id($tel_no,$code);
		$this->db->where(array('user_id'=>$user_id,'random_number'=>$random_number));
		$query = $this->db->get('patient_tbl');
		$res=$query->row_array();
		if($query->num_rows()==0){
			return 0;
		}
        else{
			return $res['user_id'];
		}
	}

	 /*** confirm unique code for change phone number ****/
	 function check_phone_ran_number($user_id , $unique_code){
		$this->db->where(array('user_id'=>$user_id,'random_number'=>$unique_code));
		$query = $this->db->get('patient_tbl');
		$res=$query->row_array();
		if($query->num_rows()==0){
			return 0;
		}
        else{
			return $res['user_id'];
		}
	}

	//update new password
     public function update_new_password($user_id,$data)
	 {
	  $this->db->where('id',$user_id);
		 if($this->db->update('users',array('password'=>md5($data)))){
		 return 1;
		 }
	 }
	//update new phone number
     public function update_new_phnumber($user_id,$data)
	 {
	     $this->db->where('id',$user_id);
		 $this->db->update('users',array('phoneno'=>$data['phoneno']));
		  $this->db->where('user_id',$user_id);
		 $this->db->update('patient_tbl',array('country_code'=>$data['country_code']));
		 return 1;
	 }
	   public function verifyEmail($user_id)
	 {
	     $this->db->where('id',$user_id);
		 $this->db->update('users',array('status'=>1));
		 return 1;
	 }



     // get booked start_time and end time
	 function get_time_slots($user_id,$booking_date,$type)
     {
		 if($type == 'medical'){
		    $sql = "select a.booking_s_time,a.booking_e_time,u.service_start_time,u.service_end_time from appointments as a INNER JOIN users as u ON a.clinic_id = u.id WHERE a.clinic_id =".$user_id." and a.booking_date = '".$booking_date."'";
		}else{
			$sql = "select a.booking_s_time,a.booking_e_time,u.service_start_time,u.service_end_time from appointments as a INNER JOIN users as u ON a.doc_id = u.id WHERE a.doc_id =".$user_id." and a.booking_date = '".$booking_date."'";
		}
          $query = $this->db->query($sql);
          $res = $query->result_array();
          if(!empty($res)){
			//  print_r($res);die;
			  return $res;
		  }else{
			   $sql = "select @booking_s_time := '00:00:00' as booking_s_time,@booking_e_time := '00:00:00' as booking_e_time,u.service_start_time,u.service_end_time from users as u WHERE u.id =".$user_id."";
			  $query = $this->db->query($sql);
			  return $query->result_array();
		  }
     }


     // get all authorized data
	 function get_all_authorized_doctors($user_id)
     {
		 $upload_path=base_url()."public/uploads/";
		  $sql = "select a.doc_id,a.id,u.fname,u.lname, u.clinic_name,u.clinic_type,u.phoneno,l.address, l.district,u.introduction,u.education,TIME_FORMAT(u.service_start_time,'%H:%i') as service_start_time,TIME_FORMAT(u.service_end_time,'%H:%i') as service_end_time,CASE WHEN u.picture IS NULL or u.picture = ''
		THEN CONCAT('',u.picture)
		ELSE CONCAT('".$upload_path."',u.picture)
		END AS picture from authorized_doctors as a INNER JOIN users as u ON a.doc_id = u.id  INNER JOIN locations as l on l.user_id = u.id WHERE a.user_id =".$user_id." group by u.id";
          $query = $this->db->query($sql);
          return $query->result_array();
     }

     // get all appointments
	 function get_appointments($user_id)
     {
		  $sql = "select CONCAT(u.fname ,' ', u.lname) as doctor_name,a.id as appointment_id,CASE WHEN l.address IS NULL THEN '' ELSE l.address END AS address, a.booking_date,a.booking_s_time,a.booking_e_time,p.amount from appointments as a INNER JOIN users as u ON a.doc_id = u.id LEFT JOIN locations as l ON a.loc_id = l.id Left JOIN payment as p ON p.appointment_id = a.id WHERE a.user_id =".$user_id." and a.doc_id!=0 and a.paid ='y' GROUP BY a.id   ORDER BY a.booking_date desc";
          $query = $this->db->query($sql);
          $result['doctors'] = $query->result_array();

          $sql1 = "select u.clinic_name,a.id as appointment_id,l.address ,a.booking_date,a.booking_s_time,a.booking_e_time from appointments as a INNER JOIN users as u ON a.clinic_id = u.id  INNER JOIN locations as l ON a.clinic_id = l.user_id  WHERE a.user_id =".$user_id." and a.clinic_id!=0  and a.paid ='y'  ORDER BY a.booking_date desc";
          $query1 = $this->db->query($sql1);
          $result['packages'] = $query1->result_array();
          $i = 0;
          foreach($result['packages'] as $p){
				 $items = $this->db->query("select  CASE WHEN pa.service_id != 0 THEN IFNULL(s.service_name,'') ELSE IFNULL(p.package_name,'') END AS name, pa.amount from payment as pa Left JOIN services as s ON pa.service_id = s.id
                 LEFT JOIN packages as p ON pa.package_id = p.id WHERE pa.appointment_id =".$p['appointment_id']." and pa.user_id = ".$user_id)->result_array();
                 $result['packages'][$i]['items'] = $items;
			++$i;
		  }
          return $result;
     }


     function get_einformation(){
		  $upload_path=base_url()."public/uploads/others/";
		 $sql = "select a.title,a.content,a.type,a.id,DATE_FORMAT(a.created ,'%c/%d/%y') as created,a.uploader_name ,CONCAT('".$upload_path."', a.image ) as user_image,CONCAT('".$upload_path."', a.e_image ) as content_image from einformation as a ORDER BY a.created desc";
         $query = $this->db->query($sql);
         return $query->result_array();
	 }

     function get_einformation1($tbl_name){
		 $upload_path=base_url()."public/uploads/others/";
		 $sql = "select CASE WHEN t.title = '' THEN a.title ELSE t.title END as title, CASE WHEN t.content = '' THEN a.content ELSE t.content END as content,a.type,t.einfo_id as id,DATE_FORMAT(a.created ,'%c/%d/%y') as created, t.uploader_name,CONCAT('".$upload_path."', a.image ) as user_image,CONCAT('".$upload_path."', a.e_image ) as content_image from einformation as a  INNER JOIN ".$tbl_name." as t on a.id = t.einfo_id ORDER BY a.created desc";
         $query = $this->db->query($sql);
         return $query->result_array();
	 }
	 function searchDoctorMedical($data)
     {
		 $result=array();
		 $upload_path=base_url()."public/uploads/";
		  if($data['type'] == 'T'){ $field = "CASE WHEN t.fname = '' THEN u.fname ELSE t.fname END AS fname, CASE WHEN t.lname = '' THEN u.lname ELSE t.lname END AS lname, CASE WHEN t.clinic_name = '' THEN u.clinic_name ELSE t.clinic_name END AS clinic_name, CASE WHEN t.introduction = '' THEN u.education ELSE t.introduction END AS education, CASE WHEN t.education = '' THEN u.education ELSE t.education END AS education";

			  $field1 = "CASE WHEN t.clinic_name = '' THEN u.clinic_name ELSE t.clinic_name END AS clinic_name,CASE WHEN t.clinic_type = '' THEN u.clinic_type ELSE t.clinic_type END AS clinic_type, CASE WHEN t.introduction = '' THEN u.introduction ELSE t.introduction END AS introduction";
		  }

		  else if($data['type'] == 'S'){  $field = "CASE WHEN s.fname = '' THEN u.fname ELSE s.fname END AS fname, CASE WHEN s.lname = '' THEN u.lname ELSE s.lname END AS lname, CASE WHEN s.clinic_name = '' THEN u.clinic_name ELSE s.clinic_name END AS clinic_name, CASE WHEN s.introduction = '' THEN u.education ELSE s.introduction END AS education, CASE WHEN s.education = '' THEN u.education ELSE s.education END AS education";

			  $field1 = "CASE WHEN s.clinic_name = '' THEN u.clinic_name ELSE s.clinic_name END AS clinic_name,CASE WHEN s.clinic_type = '' THEN u.clinic_type ELSE s.clinic_type END AS clinic_type, CASE WHEN s.introduction = '' THEN u.introduction ELSE s.introduction END AS introduction";
		  }

		  else{ $field = "u.fname,u.lname,u.clinic_name,u.introduction,u.education " ;
			  $field1 = "u.clinic_name,u.clinic_type,u.introduction" ;
		  }

		$doctors = $this->db->query("SELECT u.id,".$field.",u.phoneno,u.service_start_time,u.service_end_time,CASE WHEN u.picture IS NULL or u.picture = ''
		THEN CONCAT('',u.picture)
		ELSE CONCAT('$upload_path',u.picture)
		END AS picture,l.address,l.district,l.lat,l.long FROM users AS u INNER JOIN users_simplified as s ON s.user_id = u.id INNER JOIN users_traditional as t ON t.user_id = u.id INNER JOIN locations as l ON l.user_id = u.id WHERE u.type ='doctor' AND LOWER(u.fname) LIKE LOWER('%".$data['name']."%') OR LOWER(u.lname) LIKE LOWER('%".$data['name']."%') OR LOWER(s.fname) LIKE LOWER('%".$data['name']."%') OR LOWER(s.lname) LIKE LOWER('%".$data['name']."%') OR LOWER(t.fname) LIKE LOWER('%".$data['name']."%') OR LOWER(t.lname) LIKE LOWER('%".$data['name']."%') or LOWER(concat(u.fname,' ',u.lname)) like LOWER('%".$data['name']."%') or LOWER(concat(s.fname,' ',s.lname)) like LOWER('%".$data['name']."%') or LOWER(concat(t.fname,' ',t.lname)) like LOWER('%".$data['name']."%') GROUP BY u.id")->result_array();

		$clinic=$this->db->query("SELECT u.id,".$field1.",u.fax,u.phoneno,u.service_start_time,u.service_end_time,CASE WHEN u.picture IS NULL or u.picture = ''
		THEN CONCAT('',u.picture)
		ELSE CONCAT('$upload_path',u.picture)
		END AS picture,l.address,l.district,l.lat,l.long FROM users AS u INNER JOIN users_simplified as s ON s.user_id = u.id INNER JOIN users_traditional as t ON t.user_id = u.id INNER JOIN locations as l ON l.user_id = u.id WHERE u.type ='medical' AND LOWER(u.clinic_name) LIKE LOWER('%".$data['name']."%') OR LOWER(t.clinic_name) LIKE LOWER('%".$data['name']."%') OR LOWER(s.clinic_name) LIKE LOWER('%".$data['name']."%') GROUP BY u.id")->result_array();

		$result['doctors']=$doctors;
		$result['clinic']=$clinic;
		return $result;
	 }
	 function getReports()
     {
		 $result=array();
		$result['analysis_reports']=$this->db->query("SELECT id as report_id,cat_name as report_name, cat_sim as report_sim ,cat_tra as report_tra  FROM reports_cat WHERE type='A'")->result_array();
		$result['medical_reports']=$this->db->query("SELECT id as report_id,cat_name as report_name, cat_sim as report_sim ,cat_tra as report_tra FROM reports_cat WHERE type='M'")->result_array();
		 return $result;
	 }

	 function getAllReports($data)
     {
		$result=array();
		$upload_path=base_url()."public/uploads/reports/";
		//print_r($data);
		if(($data['ios_cat_id'] != '' || $data['ios_cat_id'] != 0 ) && $data['ios_multi'] == 'y'){
		       // $rri = explode(',',$data['ios_cat_id']);
               //  print_r($rri);
		       // foreach($rri as $ii){
					$wher .= " and r.report_type IN (".$data['ios_cat_id'].")" ;
				//}
				$result['all_reports']=$this->db->query("SELECT r.id as report_id,r.report_number,r.r_date as report_date,rc.cat_name as image_equipment,r.item,r.translate,CONCAT('$upload_path', r.report_file ) as report_file,CONCAT('$upload_path', tr.report_file ) as translated_file,pp.report_id as translate_status  FROM reports as r INNER JOIN reports_cat as rc   ON rc.id=r.report_type LEFT JOIN translated_reports as tr   ON tr.report_id = r.id LEFT JOIN payment as pp ON pp.report_id = r.id and pp.translate ='N' WHERE r.user_id='".$data['user_id']."' ".$wher)->result_array();

				$result['translated_reports']=$this->db->query("SELECT r.id as report_id,r.report_number,r.r_date as report_date,rc.cat_name as image_equipment,r.item,r.translate,CONCAT('$upload_path', r.report_file ) as report_file,CONCAT('$upload_path', tr.report_file ) as translated_file,pp.report_id as translate_status  FROM reports as r INNER JOIN reports_cat as rc   ON rc.id=r.report_type LEFT JOIN translated_reports as tr   ON tr.report_id = r.id LEFT JOIN payment as pp ON pp.report_id = r.id and pp.translate ='N' WHERE r.user_id='".$data['user_id']."' AND r.translate='Y' ".$wher)->result_array();
				// echo '1';
		    // echo $this->db->last_query();
				// exit;
		}else{
			if($data['cat_id']==0){
				$result['all_reports']=$this->db->query("SELECT r.id as report_id,r.report_number,r.r_date as report_date,rc.cat_name as image_equipment,r.item,r.translate,CONCAT('$upload_path', r.report_file ) as report_file,CONCAT('$upload_path', tr.report_file ) as translated_file,pp.report_id as translate_status  FROM reports as r INNER JOIN reports_cat as rc   ON rc.id=r.report_type LEFT JOIN translated_reports as tr   ON tr.report_id = r.id LEFT JOIN payment as pp ON pp.report_id = r.id and pp.translate ='N' WHERE r.user_id='".$data['user_id']."'")->result_array();
				$result['translated_reports']=$this->db->query("SELECT r.id as report_id,r.report_number,r.r_date as report_date,rc.cat_name as image_equipment,r.item,r.translate,CONCAT('$upload_path', r.report_file ) as report_file,CONCAT('$upload_path', tr.report_file ) as translated_file,pp.report_id as translate_status  FROM reports as r INNER JOIN reports_cat as rc   ON rc.id=r.report_type LEFT JOIN translated_reports as tr   ON tr.report_id = r.id LEFT JOIN payment as pp ON pp.report_id = r.id and pp.translate ='N' WHERE r.user_id='".$data['user_id']."' AND r.translate='Y'")->result_array();
					
				// exit;
			}else{
				$arr=explode(",",$data['cat_id']);
				$condition =" ";
				foreach ($arr as $key => $value) {
					# code...
					if($key==0){
						$condition='("'.$value;
					}else{
						$condition=$condition.'","'.$value;
					}

				}
				$condition=$condition.'")';
			//print_r($condition);exit;
				$result['all_reports']=$this->db->query("SELECT r.id as report_id,r.report_number,r.r_date as report_date,rc.cat_name as image_equipment,r.item,r.translate,CONCAT('$upload_path', r.report_file ) as report_file,CONCAT('$upload_path', tr.report_file ) as translated_file,pp.report_id as translate_status  FROM reports as r INNER JOIN reports_cat as rc   ON rc.id=r.report_type LEFT JOIN translated_reports as tr   ON tr.report_id = r.id LEFT JOIN payment as pp ON pp.report_id = r.id and pp.translate ='N' WHERE r.user_id='".$data['user_id']."' and r.report_type IN $condition ")->result_array();

				$result['translated_reports']=$this->db->query("SELECT r.id as report_id,r.report_number,r.r_date as report_date,rc.cat_name as image_equipment,r.item,r.translate,CONCAT('$upload_path', r.report_file ) as report_file,CONCAT('$upload_path', tr.report_file ) as translated_file,pp.report_id as translate_status  FROM reports as r INNER JOIN reports_cat as rc   ON rc.id=r.report_type LEFT JOIN translated_reports as tr   ON tr.report_id = r.id LEFT JOIN payment as pp ON pp.report_id = r.id and pp.translate ='N' WHERE r.user_id='".$data['user_id']."' AND r.translate='Y' and r.report_type IN $condition")->result_array();

				// exit;
			}
		}
		return $result;
	 }

	 function requestTranslate($data)
     {
         $content = $this->db->query("select content from other_options WHERE id = 5")->row_array();
         $price = $content['content'];
		 $translation_data=array();
		 $reports=explode(",",$data['report_id']);
		 $lang=explode(",",$data['language']);
		 for($i=0;$i<count($reports);$i++)
		 {
			 $translation_data['user_id']=$data['user_id'];
			 $translation_data['report_id']=$reports[$i];
			 $translation_data['language']=$lang[$i];
			 $translation_data['price']=$price;
			 $translation_data['created']=date('Y-m-d');
			 $this->db->insert('translate_request',$translation_data);
		 }
		 return $this->db->insert_id();
	 }

	 function shoping_list($user_id)
     {
		  $sql = "select a.id as request_id, a.report_id,a.language,a.created,r.report_number,a.price,t.cat_name as report_name from translate_request as a INNER JOIN reports as r ON a.user_id = r.user_id  INNER JOIN reports_cat as t on t.id = r.report_type WHERE a.report_id != 0 and a.user_id =".$user_id ." group by a.id order by a.created desc";
          $query = $this->db->query($sql);
          $data['reports'] = $query->result_array();

          $sql1 = "select a.id as request_id,a.service_id,a.package_id, a.appointment_id,a.price,a.created,
           CASE WHEN a.service_id != 0 THEN s.service_name WHEN a.package_id != 0 THEN p.package_name
            ELSE 'Doctor Appointment' END AS name
           from translate_request as a Left JOIN services as s ON a.service_id = s.id
          LEFT JOIN packages as p ON a.package_id = p.id
            WHERE a.report_id = 0 and a.user_id =".$user_id ." group by a.id order by a.created desc";
          $query1 = $this->db->query($sql1);
          $data['appointments'] = $query1->result_array();
          return $data;
	 }

	 public function update_data($where,$data,$tbl_name)
	 {
	  $this->db->where($where);
	 $this->db->update($tbl_name,$data);
	 return 1;
	 }

	 //delete data from tables
	 function delete_trans_request($user_id,$report_id)
     {
		  $this->db->delete('translate_request', array('user_id' => $user_id,'id' => $report_id));
     }

     function getEinfoFilters()
     {
		return $this->db->query("SELECT id as cat_id,cat_name, CASE WHEN cat_sim = '' THEN cat_name ELSE cat_sim END as cat_sim  ,CASE WHEN cat_tra = '' THEN cat_name ELSE cat_tra END as cat_tra FROM einfo_filters")->result_array();

	 }
     function get_transaction_record($user_id)
     {
		$result['reports'] = $this->db->query("SELECT p.id,p.transaction_id,p.amount,p.create_time,rc.cat_name,r.report_number from payment as p INNER JOIN reports as r ON p.report_id = r.id  INNER JOIN reports_cat as rc ON rc.id = r.report_type where p.user_id = ".$user_id." and report_id !='0' order by p.create_time desc")->result_array();
		 $sql1 = "select a.id as payment_id,a.transaction_id,a.amount,a.create_time,
           CASE WHEN a.service_id != 0 THEN s.service_name WHEN a.package_id != 0 THEN p.package_name
            ELSE 'Doctor Appointment' END AS name
           from payment as a Left JOIN services as s ON a.service_id = s.id
          LEFT JOIN packages as p ON a.package_id = p.id
            WHERE a.report_id = 0 and a.user_id =".$user_id ." group by a.id order by a.create_time desc";
          $query1 = $this->db->query($sql1);
          $result['appointments'] = $query1->result_array();
          return $result;

	 }

     function get_doc_medical($type)
     {
		 if($type == 'S') {$field = "(CASE WHEN o.fname = '' THEN u.fname ELSE o.fname END)  as fname,(CASE WHEN o.lname = '' THEN u.lname ELSE o.lname END) as lname,(CASE WHEN o.clinic_name = '' THEN u.clinic_name ELSE o.clinic_name END) as clinic_name ";
		  $sql = "select u.id, ".$field."  from users as u INNER JOIN users_simplified as o on u.id = o.user_id WHERE u.type ='medical' OR u.type = 'doctor'";
		 }
		 else if($type == 'T'){ $field = "(CASE WHEN o.fname = '' THEN u.fname ELSE o.fname END)  as fname,(CASE WHEN o.lname = '' THEN u.lname ELSE o.lname END) as lname,(CASE WHEN o.clinic_name = '' THEN u.clinic_name ELSE o.clinic_name END) as clinic_name ";
		  $sql = "select u.id, ".$field."  from users as u INNER JOIN users_traditional as o on u.id = o.user_id WHERE u.type ='medical' OR u.type = 'doctor'";
		 }
		 else{ $field = "u.fname,u.lname,u.clinic_name" ;
		$sql = "select u.id, ".$field."  from users as u WHERE u.type ='medical' OR u.type = 'doctor'";
		 }

        $query = $this->db->query($sql);
		return $query->result_array();

	 }


	 function delete_appointment($id){
		 $query = $this->db->query("select service_id,package_id,appointment_id  from translate_request WHERE id =".$id." and report_id =0");
		 $res = $query->row_array() ;
		// print_r($res);
		 if(!empty($res)){
			if($res['package_id'] != 0){
				 $query1 = $this->db->query("select package_id from appointments WHERE id =".$res['appointment_id']);
		         $res1 = $query1->row_array() ;
		         $pac_id1  = explode(',',$res1['package_id']);
		         foreach ($pac_id1 as $key => $tag_name) {
					if((int)$tag_name == (int)$res['package_id']) {
						unset($pac_id1[$key]);
					}
				}
				 $pac_id1 = implode(',',$pac_id1);
				 $datah['package_id'] = $pac_id1;
			}
			if($res['service_id'] != 0){
				 $query2 = $this->db->query("select services_id from appointments WHERE id =".$res['appointment_id']);
		         $res2 = $query2->row_array() ;
		         $pac_id2  = explode(',',$res2['services_id']);
		         foreach ($pac_id2 as $key => $tag_name) {
					if((int)$tag_name == (int)$res['service_id']) {
						unset($pac_id2[$key]);
					}
				}
				$pac_id2 = implode(',',$pac_id2);
				 $datah['services_id'] = $pac_id2;
		    }


             if($datah){
			   $this->db->where(array('id'=>$res['appointment_id']));
			   $this->db->update('appointments',$datah);
		   }
		     $query3 = $this->db->query("select services_id,package_id from appointments WHERE id =".$res['appointment_id']);
		     $res3 = $query3->row_array() ;
		     if(($res3['package_id']=='' || $res3['package_id']==0) && ($res3['services_id']==0 || $res3['services_id']=='')){
				 $this->db->delete('appointments', array('id' => $res['appointment_id']));
			 }

		 }
	 }

}
