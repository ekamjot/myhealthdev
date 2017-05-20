<?php
class home_model extends CI_Model {

	function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }
   public function get_docter($email)
   {
	$query = $this->db->get_where('doctors', array('email' => $email));
	return $query->row_array();
   }
	  public function update_docter($mail) {
	    $data = array(
		'first_name' => $this->input->post('firstname'),
		'last_name' => $this->input->post('lastname'),
		'practice_name' => $this->input->post('practicename'),
		'office_address' => $this->input->post('officeaddress'),
		'office_city' => $this->input->post('city'),
		'office_state' => $this->input->post('state'),
		'phone' => $this->input->post('phone'),
		'fax' => $this->input->post('fax'),
		'NPI_number' => $this->input->post('npiNumber'),
		'specialty' => $this->input->post('speciality'),
		'medical_school' => $this->input->post('medicalschool'),
		'fellowship_training' => $this->input->post('fellowship'),
		'fellowship_training_type' => $this->input->post('typeFellowship'),
		'cme' => $this->input->post('cme'),
	);

	$this->db->where('email', $mail);
    return $this->db->update('doctors', $data); 
	}
}
	

	
