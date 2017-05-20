<?php

class HOME extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
	}
	
	 /*
	 * cretor:-
	 * function:-
	 * date:-
	 * description:-
	 */
	 function index()
	 {
		redirect('admin');

		   
	 }
	 
	 
}
