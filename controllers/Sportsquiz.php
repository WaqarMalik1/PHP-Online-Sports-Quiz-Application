<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sportsquiz extends CI_Controller {
	/*

	This controller is used to route to Sports Quiz page where the quiz starts, user can navigate the questions one by one, answer is validated once the user has submitted the answer
	*/

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('sportsquiz');
	}
}
