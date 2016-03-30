<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 *Controller to route to Index page.
	 */
	public function index()
	{
		$this->load->helper('url');
		$this->load->view('index');
	}
}
