<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forget_password extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// lets check for status of webspace and account
		$this->load->library('users/admin_user_details');
    }
	
	// ----------------------------------------------------------------------
	
	public function index()
	{
		// load form validation
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Username', 'trim|valid_email|required|callback_validate_email');

		// if validation errors...
		if ($this->form_validation->run() == FALSE)
		{
			// let us remember the page being accessed other than index
			if ($this->session->flashdata('access_uri')) $this->session->set_flashdata('access_uri', $this->session->flashdata('access_uri'));
			
			// set flash message
			$this->session->set_flashdata('invalid_email', TRUE);
			
			// redirect login page
			redirect($this->config->slash_item('admin_folder').'login');
		}
		else
		{
			// let us remember username if Remember checkbox is checked
			if ($this->input->post('remember-at-admin'))
			{
				$this->session->set_userdata('remember-at-admin-username', $this->input->post('username'));
				$this->session->set_userdata('remember-at-admin', 'checked="checked"');
			}
			else
			{
				$this->session->unset_userdata('remember-at-admin-username');
				$this->session->unset_userdata('remember-at-admin');
			}

			// if user it not authenticated...
			if ( ! $this->admin_user_details->initialize(array('admin_name' => $this->input->post('username'), 'admin_password' => $this->input->post('password'))))
			{
				// invalid credentials
				// destroy sales user session if any
				$this->admin_user_details->unset_session();
			
				// set flash message
				$this->session->set_flashdata('invalid', TRUE);
				
				// redirect user back to login page
				redirect($this->config->slash_item('admin_folder').'login');
			}
			
			// set session data
			// new feature using Admin User Details class
			$this->admin_user_details->set_session();
			
			// set the session lapse time if it has not been set
			if ( ! $this->session->userdata('admin_login_time'))
			{
				$this->session->set_userdata('admin_login_time', @time());
			}
			
			// let us notify admin/dev of login
			//if (ENVIRONMENT !== 'development')
			//$this->_notify_admin();
			
			// send user to respective page...
			redirect(($this->session->flashdata('access_uri') ?: $this->config->slash_item('admin_folder').'dashboard'));
		}
	}
	
	// ----------------------------------------------------------------------
	
	function validate_email($email)
	{
		if ( ! $this->admin_user_details->initialize(array('admin_name' => $this->input->post('username'))))
		{
			// invalid email
			$this->form_validation->set_message('validate_email', 'The {field} is an invalid email.');
			return FALSE;
		}
		else return TRUE;
	}
	
	// ----------------------------------------------------------------------
	
}
