<?php
class account_model extends CI_Model {

	function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function get_user($usr, $pwd)
     {
          $sql = "select * from doctors where email = '" . $usr . "' and password = '" .$pwd. "' and status = 'active'";
          $query = $this->db->query($sql);
          return $query->num_rows();

     }
	function get_user_email($email)
     {
         
        $this -> db -> select('email, status,first_name,last_name,doc_id');
   $this -> db -> from('doctors');
   $this -> db -> where('email', $email);
   $this -> db -> where('status', 'active');
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return $query->row_array();
   }
   else
   {
     return false;
   }
     }

     
     public function update_docter_pass($id)
	  {
	 $this->db->where('doc_id',$id);
	 $data = array(
	 'password' => $this->input->post('password'),
	 );
	 return $this->db->update('doctors', $data);

	  }
	  public function create_docter() {
	   $time  = time();
	    $data = array(
		'email' => $this->input->post('email'),
		'password' => $this->input->post('password'),
		'first_name' => $this->input->post('firstname'),
		'last_name' => $this->input->post('lastname'),
		'practice_name' => $this->input->post('practicename'),
		'office_address' => $this->input->post('officeaddress'),
		'office_city' => $this->input->post('city'),
		'office_state' => $this->input->post('state'),
		'phone' => $this->input->post('phone'),
		'fax' => $this->input->post('fax'),
		'NPI_number' => $this->input->post('npiNumber'),
		'specialty' => $this->input->post('specialty'),
		'medical_school' => $this->input->post('medicalschool'),
		'fellowship_training' => $this->input->post('fellowship'),
		'fellowship_training_type' => $this->input->post('typeFellowship'),
		'cme' => $this->input->post('cme'),
		'created' => $time,
		'status' => 'suspended'
	);

	return $this->db->insert('doctors', $data);
	}
	
	public function mail_exists($key){
		$this->db->where('email',$key);
		$query = $this->db->get('doctors');
		if ($query->num_rows() > 0){
			return false;
		}
		else{
			return true;
		}
    }
	
	public function update_docter($email)
	  {
	 $this->db->where('doc_id',$email);
	 $data = array(
	 'status' => 'active',
	 );
	 return $this->db->update('doctors', $data);

	  }
}
	

	
