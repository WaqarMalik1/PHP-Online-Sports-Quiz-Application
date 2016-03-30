<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	/*
	This class is used to log out of the application where the session variable stored while login (adminlogininfo) is unset and redireted to administrator login page
	*/
	public function index()
	{
		$this->session->unset_userdata('adminlogininfo');
		$this->session->sess_destroy();
		redirect('administrator','refresh');
		
	}
	

}
