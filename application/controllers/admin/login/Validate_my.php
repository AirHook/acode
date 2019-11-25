<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		// lets check for status of webspace and account
		$this->load->library('users/admin_user_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/sales_user_details');
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// load form validation
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		// if validation errors...
		if ($this->form_validation->run() == FALSE)
		{
			// let us remember the page being accessed other than index
			if ($this->session->flashdata('access_uri')) $this->session->set_flashdata('access_uri', $this->session->flashdata('access_uri'));

			// set flash message
			$this->session->set_flashdata('invalid', TRUE);

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

			// validate user
			if (
				! $this->_validate_admin()
				&& ! $this->_validate_vendor()
				&& ! $this->_validate_sales()
			)
			{
				// set flash message
				$this->session->set_flashdata('invalid', TRUE);

				// redirect user back to login page
				redirect($this->config->slash_item('admin_folder').'login');
			}

			if ($this->_validate_admin())
			{
				// send user to respective page...
				redirect(($this->session->flashdata('access_uri') ?: $this->config->slash_item('admin_folder').'dashboard'));
			}

			if ($this->_validate_vendor())
			{
				// send user to respective page...
				redirect(($this->session->flashdata('access_uri') ?: 'my_account/vendors/orders'));
			}

			if ($this->_validate_sales())
			{
				// send user to respective page...
				redirect(($this->session->flashdata('access_uri') ?: 'my_account/sales'));
			}
		}
	}

	// ----------------------------------------------------------------------

	private function _validate_admin()
	{
		// if user it not authenticated...
		if (
			! $this->admin_user_details->initialize(
				array(
					'admin_name' => $this->input->post('username'),
					'admin_password' => $this->input->post('password')
				)
			)
		)
		{
			// invalid credentials
			// destroy sales user session if any and reset class to initial state
			$this->admin_user_details->unset_session();
			$this->admin_user_details->set_initial_state();

			return FALSE;
		}

		// authenticate satellite site admin access
		if ($this->admin_user_details->account_id != 0)
		{
			if ($this->admin_user_details->webspace_id != $this->webspace_details->id)
			{
				return FALSE;
			}
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

		return TRUE;
	}

	// ----------------------------------------------------------------------

	private function _validate_vendor()
	{
		// if user it not authenticated...
		if (
			! $this->vendor_user_details->initialize(
				array(
					'vendor_email' => $this->input->post('username'),
					'password' => $this->input->post('password')
				)
			)
		)
		{
			// invalid credentials
			// destroy sales user session if any and reset class to initial state
			$this->vendor_user_details->unset_session();
			$this->vendor_user_details->set_initial_state();

			return FALSE;
		}

		// set session data
		// new feature using Admin User Details class
		$this->vendor_user_details->set_session();

		// set the session lapse time if it has not been set
		if ( ! $this->session->userdata('vendor_login_time'))
		{
			$this->session->set_userdata('vendor_login_time', @time());
		}

		// let us notify admin/dev of login
		//if (ENVIRONMENT !== 'development')
		//$this->_notify_admin();

		return TRUE;
	}

	// ----------------------------------------------------------------------

	private function _validate_sales()
	{
		// if user it not authenticated...
		if (
			! $this->sales_user_details->initialize(
				array(
					'admin_sales_email' => $this->input->post('username'),
					'admin_sales_password' => $this->input->post('password')
				)
			)
		)
		{
			// invalid credentials
			// destroy sales user session if any and reset class to initial state
			$this->sales_user_details->unset_session();
			$this->sales_user_details->set_initial_state();

			return FALSE;
		}

		// set session data
		$this->sales_user_details->set_session();

		// set the session lapse time if it has not been set
		if ( ! $this->session->userdata('sales_login_time'))
		{
			$this->session->set_userdata('sales_login_time', @time());
		}

		// let us notify admin/dev of login
		//if (ENVIRONMENT !== 'development')
		//$this->_notify_admin();

		return TRUE;
	}

	// ----------------------------------------------------------------------

}
