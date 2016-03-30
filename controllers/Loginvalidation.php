<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
This class is used to validate the username and password entered by the user.
*/
class Loginvalidation extends CI_Controller {



	function __construct()
	{
	parent::__construct();
	//Constructor to load the model where all the database related functions are available
	$this->load->model('Model');
	}
	/* 
	Function where the validation of username and password for admin happens
	*/
	function index()
	{		
		//get username
		$username = $this->input->post('username');
		//get password
		$password = $this->input->post('password');
		//query to check whether username and password is correct
		$query="select username, id from adminaccount where username='".$username."' and password = '".$password."'"; 
		$validation_response = $this->Model->fetch_resultset_data($query);
		$sess_array = array();
		//if there is a result from database then it means the username and password is correct
		if($validation_response)
		{
		foreach($validation_response as $data)
		{
		//user  information stored in array
		$sess_array = array(
		'id' => $data->id,
		'username' => $data->username
		);
		//user information stored in array is now stored in session which will be checked in admin home page
		$this->session->set_userdata('adminlogininfo', $sess_array);
		//on successful validation login status is true
		$loginstatus=true;

		}
		}
		else
		{
		//if username/password is invalid then loginstatus is set to false
		$loginstatus=false;
		}

		if($loginstatus == false)
		{
		//if the username , password is invalid it is routed to admin index page where the user can enter the username and password
		$this->load->view('admin_index');
		}
		else
		{
		//if the username and password is correct it will redirect to admin home page where all the sports questions are displayed
		$this->load->view('admin_home');
		}

	}
	//when home button is clicked, this function routes to admin home page from any other admin pages
	function home()
	{
		$this->load->view('admin_home');
	}
}
?>