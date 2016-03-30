<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	/**
	This controller is used to route to Administrator login page where the username and password is entered
	 */

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper(array('form'));
		$this->load->view('admin_index');
	}


}
